<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Deal\Entities\Deal;
use Modules\Front\Http\Requests\CheckoutRequest;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request)
    {
        try {
            DB::beginTransaction();

            // store the order along with order list, shipping address and billing address
            if ($request->isDealCheckout()) {
                $deal = Deal::with('dealProducts')->findOrFail($request->deal_id);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'amount' => $deal->totalPrice(),
                'deal_id' => $request->deal_id,
                'status' => 'New',
                'payment_status' => 'pending',
                'payment_type' => 'cash_on_delivery',
            ]);

            if ($request->isDealCheckout()) {
                foreach ($deal->dealProducts as $dealProduct) {
                    OrderList::create([
                        'order_id' => $order->id,
                        'vendor_user_id' => $deal->vendor_user_id,
                        'product_id' => $dealProduct->product_id,
                        'quantity' => $dealProduct->product_qty,
                        'unit_price' => $dealProduct->unit_price,
                        'subtotal_price' => $dealProduct->totalPrice(),
                    ]);
                }
            }

            // save the billing and shipping address
            $order->billingAddress()->create($request->billingAddress());
            $order->shippingAddress()->create($request->shippingAddress());

            // after response store update or create the customer's address
            // send email to vendors, admin and customer
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger("An error occured while checkout.");
            report($e);

            return response()->json([
                'message' => 'Something went wrong while processing your order.',
            ], 500);
        }

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ], 200);
    }
}
