<?php

namespace Modules\Order\Http\Controllers;

use App\Jobs\ReleasePaymentJob;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderLists', 'customer'])
            ->latest()
            ->paginate();

        return view('order::index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load([
            'orderLists.product:id,title,slug',
            'vendor',
            'customer:id,name,email',
            'billingAddress',
            'shippingAddress'
        ]);

        $subTotalPrice = $order->subtotal_price;
        $totalShippingPrice = $order->shipping_charge;
        $totalPrice = $order->total_price;

        $orderStatuses = config('constants.order_statuses');

        if (auth()->user()->hasRole('vendor')) {
            $orderStatuses = array_diff($orderStatuses, ['cancelled', 'refunded']);
        }

        return view('order::show', compact([
            'order',
            'subTotalPrice',
            'totalShippingPrice',
            'totalPrice',
            'orderStatuses'
        ]));
    }

    public function update(Request $request, Order $order)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin|vendor'), 403);
        // if vendor, also check if order belongs to him

        $orderStatuses = config('constants.order_statuses');
        if(auth()->user()->hasRole('vendor')) {
            $orderStatuses = array_diff($orderStatuses, ['cancelled', 'refunded']);
        }

        $request->validate([
            'status' => ['required', Rule::in($orderStatuses), Rule::notIn([$order->status])],
            'update_silently' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $order->update(['status' => $request->status]);

            if (!$request->filled('update_silently')) {
                if ($order->status == 'refunded') {
                    // send email to customer
                    Mail::to($order->customer->email)->send(new \App\Mail\OrderRefundedEmail($order));
                } else {
                    Mail::to($order->customer->email)->send(new \App\Mail\OrderStatusChanged($order));
                }

                // send email to vendor in case of cancellation
                if ($order->status == 'cancelled') {
                    Mail::to($order->vendor->user->email)->send(new \App\Mail\OrderCancelledEmailToVedor($order));
                }
            }

            if ($order->status == 'completed') {
                ReleasePaymentJob::dispatch($order);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);
            return redirect()->back()->with('error', 'Something went wrong while processing your request.');
        }

        return redirect()->back()->with('success', 'Order status changed successfully. New status is ' . $order->status);
    }
}
