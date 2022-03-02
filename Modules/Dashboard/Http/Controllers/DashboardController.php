<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Dashboard\Service\DashboardService;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Transaction;
use Modules\Product\Entities\Product;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        if (auth()->user()->hasRole('vendor')) {
            return $this->vendorDashboard();
        }
        return $this->adminDashboard();
    }

    protected function adminDashboard()
    {
        $title = 'Dashboard';
        $totalSales = $this->dashboardService->getTotalSales();
        $salesFromOnlinePayment = $this->dashboardService->getSalesFromOnlinePayment();
        $salesFromCOD = $this->dashboardService->getSalesFromCOD();

        $receivableFromVendors = Transaction::where('is_cod', true)->whereNull('settled_at')->sum('amount');
        $payableToVendors = Transaction::onlyOnlinePayments()
        ->whereIn('id', function($query) {
            $query->select(\DB::raw('MAX(id) FROM transactions GROUP BY vendor_id'));
        })
        ->sum('running_balance');

        $totalActiveProductsCount = Product::active()->count();

        return view('dashboard::admin.dashboard', [
            'title' => $title,
            'totalSales' => $totalSales,
            'salesFromOnlinePayment' => $salesFromOnlinePayment,
            'salesFromCOD' => $salesFromCOD,
            'payableToVendors' => $payableToVendors,
            'receivableFromVendors' => $receivableFromVendors,
            'totalActiveProductsCount' => $totalActiveProductsCount,
        ]);
    }

    protected function vendorDashboard()
    {
        $title = 'Dashboard';
        $vendor = auth()->user()->vendor;
        $totalSales = $this->dashboardService->getTotalSales();
        $salesFromOnlinePayment = $this->dashboardService->getSalesFromOnlinePayment();
        $salesFromCOD = $this->dashboardService->getSalesFromCOD();

        $payableToAdmin = Transaction::where('vendor_id', $vendor->id)->where('is_cod', true)->whereNull('settled_at')->sum('amount');
        $lastTransaction = Transaction::where('vendor_id', $vendor->id)->latest('id')->first();
        $reveivableFromAdmin =  $lastTransaction ? $lastTransaction->running_balance : 0;

        $totalActiveProductsCount = Product::where('vendor_id', $vendor->id)->active()->count();

        return view('dashboard::vendor.dashboard', [
            'title' => $title,
            'totalSales' => $totalSales,
            'salesFromOnlinePayment' => $salesFromOnlinePayment,
            'salesFromCOD' => $salesFromCOD,
            'payableToAdmin' => $payableToAdmin,
            'reveivableFromAdmin' => $reveivableFromAdmin,
            'totalActiveProductsCount' => $totalActiveProductsCount,
        ]);
    }
}
