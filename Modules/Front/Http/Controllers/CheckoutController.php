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
use Modules\Product\Entities\Product;
use YubarajShrestha\NCHL\Facades\Nchl;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request)
    {
        try {
            DB::beginTransaction();

            // store the order along with order list, shipping address and billing address
            if ($request->isDealCheckout()) {
                $deal = Deal::with('dealProducts')->findOrFail($request->deal_id);
                // Validate the deal
                if (!$deal->isAvailable() || (auth::id() != $deal->customer_id)) {
                    return response()->json(['message' => 'Deal is not available'], 404);
                }
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'amount' => $request->checkout_mode == 'deal' ? $deal->totalPrice() : 20000,
                'deal_id' => $request->checkout_mode == 'deal' ? $request->deal_id : null,
                'status' => 'New',
                'payment_status' => 'pending',
                'payment_type' => $request->payment_type,
            ]);

            $orderSubtotalPrice = 0;
            $orderShippingCharge = 0;

            // Handle deal checkout
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
                    $orderSubtotalPrice += $dealProduct->totalPrice();
                }
                // mark the deal as completed
                $deal->markCompleted();
            }
            // Handle cart checkout
            else {
                foreach ($request->cart as $cartItem) {
                    $product = Product::with('ranges')->findOrFail($cartItem['product_id']);
                    $unitPrice = $this->getUnitPriceFromQuantity($product, $cartItem['product_qty']); // get price fron range
                    $subtotalPrice = $unitPrice * $cartItem['product_qty'];
                    OrderList::create([
                        'order_id' => $order->id,
                        'vendor_user_id' => $product->user_id,
                        'product_id' => $product->id,
                        'product_name' => $product->title,
                        'quantity' => $cartItem['product_qty'],
                        'unit_price' => $unitPrice,
                        'subtotal_price' => $subtotalPrice,
                        'shipping_charge' => $product->shipping_charge ?? 0,
                        'total_price' => $subtotalPrice + ($product->shipping_charge ?? 0),
                    ]);
                    $orderSubtotalPrice += $subtotalPrice;
                    $orderShippingCharge += $product->shipping_charge ?? 0;
                }
            }

            // Set the total amount of the order
            $order->update([
                'subtotal_price' => $orderSubtotalPrice,
                'shipping_charge' => $orderShippingCharge,
                'total_price' => $orderSubtotalPrice + $orderShippingCharge,
            ]);

            // save the billing and shipping address
            $order->billingAddress()->create($request->billingAddress());
            $order->shippingAddress()->create($request->shippingAddress());

            // after response store update or create the customer's address
            // send email to vendors, admin and customer

            // process payment
            $nchl = Nchl::__init([
                "txn_id" => $order->id,
                "txn_date" => date('d-m-Y'),
                "txn_amount" => $order->total_price * 100,
                "reference_id" => 'ORD-'. $order->id,
                "remarks" => 'Order #'. $order->id,
                "particulars" => 'Order #'. $order->id,
            ]);

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
            'connectips' => [
                'gateway_url' => $nchl->core->gatewayUrl(),
                'merchant_id' => $nchl->core->getMerchantId(),
                'app_id' => $nchl->core->getAppId(),
                'app_name' => $nchl->core->getAppName(),
                'txn_id' => $nchl->core->getTxnId(),
                'txn_date' => $nchl->core->getTxnDate(),
                'txn_crncy' => $nchl->core->getCurrency(),
                'txn_amt' => $nchl->core->getTxnAmount(),
                'reference_id' => $nchl->core->getReferenceId(),
                'remarks' => $nchl->core->getRemarks(),
                'particulars' => $nchl->core->getParticulars(),
                'token' => $nchl->core->token()
            ] 
        ], 200);
    }

    private function getUnitPriceFromQuantity($product, $quantity)
    {
        // First we sort the product's ranges by min quantity
        $ranges = $product->ranges->sortBy('from')->values()->all();

        // Check if the quantity is between range
        foreach ($ranges as $range) {
            if ($range->from <= $quantity && $range->to >= $quantity) {
                return $range->price;
            }
        }
    }
}
