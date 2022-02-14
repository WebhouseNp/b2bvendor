<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderList'])
            ->latest()
            ->paginate();

        return view('order::index', compact('orders'));
    }

    // not being used right now
    public function updateOrderStatus(Request $request)
    {
        $order = OrderList::where('id', $request->order_id)->first();
        if ($order) {
            $order['order_status'] = $request->status;
        }
        $product = $order->product;
        $user = User::where('id', auth()->user()->id)->first();
        $order_data = [
            'product_name' => $product->title,
            'status' => $request->status,
            'name' => $user->name
        ];
        $success  = $order->save();
        Mail::send('email.order-notice-status', $order_data, function ($message) use ($order, $user) {
            $message->to($user->email, 'Admin');
            $message->subject('Order Placed Notice Status for ' . 'b2b');
        });
        if ($success) {
            return response()->json(['status' => 'successful', 'message' => 'Order updated successfully.', 'data' => $order]);
        }
    }

    public function show(Order $order)
    {
        $order->load([
            'packages' => function ($query) {
                // we only load the order list which belongs to logged in vendor
                $query->when(auth()->user()->hasRole('vendor'), function ($query) {
                    return $query->where('vendor_user_id', auth()->id());
                });
            },
            // since orderlist is already loaded and constrained
            // it won't load order list again
            'packages.orderLists.product:id,title,slug',
            'packages.vendorShop',
            'customer:id,name,email',
            'billingAddress',
            'shippingAddress'
        ]);

        if (auth()->user()->hasRole('vendor')) {
            $package = $order->packages->first();
            $subTotalPrice = $package->orderLists->sum->subtotal_price;
            $totalShippingPrice = $package->orderLists->sum->shipping_charge;
            $totalPrice = $package->orderLists->sum->total_price;
        } else {
            $subTotalPrice = $order->subtotal_price;
            $totalShippingPrice = $order->shipping_charge;
            $totalPrice = $order->total_price;
        }

        return view('order::show', compact([
            'order',
            'subTotalPrice',
            'totalShippingPrice',
            'totalPrice'
        ]));
    }

    public function update(Request $request, Order $order)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $request->validate([
            'order_status' => ['required', Rule::in(config('constants.order_statuses')), Rule::notIn([$order->status])],
            'update_silently' => 'nullable'
        ]);

        try {
            DB::beginTransaction();
            $order->update(['status' => $request->status]);

            if (!$request->filled('update_silently')) {
                if ($order->status == 'cancelled') {
                    // send email to customer
                    Mail::to($order->customer->email)->send(new \App\Mail\OrderCancelledEmail($order));
                    // send email to vendors
                    foreach ($order->packages as $package) {
                        Mail::to($package->vendorUser->email)->send(new \App\Mail\OrderCancelledEmailToVedor($order));
                    }
                }

                if ($order->status == 'refunded') {
                    // send email to customer
                    Mail::to($order->customer->email)->send(new \App\Mail\OrderRefundedEmail($order));
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::commit();
            report($ex);
            return redirect()->back()->with('error', 'Something went wrong while processing your request.');
        }

        return redirect()->back()->with('success', 'Order status changed successfully.');
    }
}
