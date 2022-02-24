<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Transaction;
use Modules\Product\Entities\Product;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('vendor')) {
            return $this->vendorDashboard();
        }
        return $this->adminDashboard();
    }

    protected function adminDashboard()
    {
        return view('dashboard::admin.dashboard');
    }

    protected function vendorDashboard()
    {
        $vendor = auth()->user()->vendor;
        $totalSales = Transaction::where('vendor_id', $vendor->id)->where('type', 1)->sum('amount');
        $salesFromOnlinePayment = Transaction::where('vendor_id', $vendor->id)->where('type', 1)->where('is_cod', '!=', true)->sum('amount');
        $salesFromCOD = Transaction::where('vendor_id', $vendor->id)->where('type', 1)->where('is_cod', true)->sum('amount');

        $payableToAdmin = Transaction::where('vendor_id', $vendor->id)->where('is_cod', true)->whereNull('settled_at')->sum('amount');
        $lastTransaction = Transaction::where('vendor_id', $vendor->id)->latest('id')->first();
        $reveivableFromAdmin =  $lastTransaction ? $lastTransaction->running_balance : 0;

        $totalActiveProductsCount = Product::where('user_id' , auth()->user()->id)->active()->count();

        $orders = Order::with(['orderLists'])
            ->latest()
            ->paginate();


        return view('dashboard::vendor.dashboard', [
            'totalSales' => $totalSales,
            'salesFromOnlinePayment' => $salesFromOnlinePayment,
            'salesFromCOD' => $salesFromCOD,
            'payableToAdmin' => $payableToAdmin,
            'reveivableFromAdmin' => $reveivableFromAdmin,
            'totalActiveProductsCount' => $totalActiveProductsCount,
            'orders' => $orders
        ]);
    }
}
