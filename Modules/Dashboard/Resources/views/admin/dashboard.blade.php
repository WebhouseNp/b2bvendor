@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($totalSales) }}</h3>
                    <p>Total Sales</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-bag text-aqua"></i>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Total Sales</p>
                    <h2>{{ formatted_price($totalSales) }}</h2>
                </div>
            </div> -->
        </div>
        <div class="col-md-4 mb-4">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($salesFromOnlinePayment) }}</h3>
                    <p>Sales from Online Payment</p>
                </div>
                <div class="icon">
                    <i class="fa fa-google-wallet text-green"></i>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Sales from Online Payment</p>
                    <h2>{{ formatted_price($salesFromOnlinePayment) }}</h2>
                </div>
            </div> -->
        </div>
        <div class="col-md-4 mb-4">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($salesFromCOD) }}</h3>
                    <p>Sales from COD</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money text-gold"></i>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Sales from COD</p>
                    <h2>{{ formatted_price($salesFromCOD) }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-4">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($receivableFromVendors) }}</h3>
                    <p>Receivable Amount From Vendors</p>
                </div>
                <div class="icon">
                    <i class="fa fa-credit-card text-red"></i>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Receivable Amount From Vendors</p>
                    <h2>{{ formatted_price($receivableFromVendors) }}</h2>
                </div>
            </div> -->
        </div>


        <div class="col-md-4 mb-4">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($payableToVendors) }}</h3>
                    <p>Payable Amount From Vendors</p>
                </div>
                <div class="icon">
                    <i class="fa fa-credit-card text-gold"></i>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Payable Amount To Vendors</p>
                    <h2>{{ formatted_price($payableToVendors) }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-4">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ $totalActiveProductsCount }}</h3>
                    <p>Active Products</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes text-aqua"></i>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Active Products</p>
                    <h2>{{ $totalActiveProductsCount }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-green text-white"><i class="fa fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Vendors</span>
                    <span class="info-box-number">{{ $totalActiveVendors }}</span>
                </div>
            </div>

            <!-- <div class="card">
                <div class="card-body">
                    <p> Active Vendors</p>
                    <h2>{{ $totalActiveVendors }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-info-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vendor Requests</span>
                    <span class="info-box-number">{{ $totalNewVendors }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p> Vendor Requests</p>
                    <h2>{{ $totalNewVendors }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-users text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Customers</span>
                    <span class="info-box-number">{{ $totalCustomers }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Customers</p>
                    <h2>{{ $totalCustomers }}</h2>
                </div>
            </div> -->
        </div>
    </div>


    <div class="row">
        <div class="col-md-7">
            <x-charts.sales-chart-tile></x-charts.sales-chart-tile>
        </div>
        <div class="col-md-5">
            <x-charts.payment-type-pie-chart-tile></x-charts.payment-type-pie-chart-tile>
        </div>
    </div>

    <div class="my-4"></div>

    <x-dashboard.latest-orders-tile></x-dashboard.latest-orders-tile>
</div>
@endsection

@section('scripts')

@endsection