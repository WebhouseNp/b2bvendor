<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
}
