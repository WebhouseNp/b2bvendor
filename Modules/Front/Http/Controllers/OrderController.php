<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderList')
        ->when(request()->filled('status'), function($query) {
            return $query->where('status', request('status'));
        })
            ->latest()
            ->paginate();

        return $orders;
    }
}
