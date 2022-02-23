<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Routing\Controller;

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
        return view('dashboard::vendor.dashboard');
    }
}
