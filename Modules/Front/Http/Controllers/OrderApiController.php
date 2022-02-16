<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Front\Transformers\AddressResource;
use Modules\Order\Entities\Order;

class OrderApiController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderList')
            ->when(request()->filled('status'), function ($query) {
                switch (request('status')) {
                    case 'unpaid':
                        return $query->where('payment_status', 'pending');
                        break;
                    case 'processing':
                        return $query->where('status', 'pending')
                            ->orWhere('status', 'processing')
                            ->orWhere('status', 'shipped');
                        break;
                    case 'delivered':
                        return $query->where('status', 'completed');
                        break;
                    case 'cancelled':
                        return $query->where('status', 'cancelled');
                        break;
                    default:
                        return $query->where('status', request('status'));
                        break;
                }
            })
            ->latest()
            ->paginate();

        return $orders;
    }

    public function show(Order $order)
    {
        // TOOD::authorize

        $order->loadMissing(['packages.orderLists.product:id,title,image', 'packages.vendorShop:id,user_id,shop_name', 'shippingAddress', 'billingAddress']);

        $order->packages->map(function ($package) {
            $package->status_number = get_package_status_number($package->status);
            $package->sold_by = $package->vendorShop->shop_name;
            unset($package->vendorShop);
            $package->orderLists->map(function ($orderList) {
                $orderList['product_image_url'] = $orderList->product ? $orderList->product->imageUrl('thumbnail') : 'no_image';
                unset($orderList->product);
                return $orderList;
            });
            return $package;
        });

        $order->status_number = get_order_status_number($order->status);
        // $order['shipping_address'] = new AddressResource($order->shippingAddress);
        // $order->billing_address = AddressResource::make($order->shippingAddress);

        return $order;
    }
}
