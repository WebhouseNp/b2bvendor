@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-info">
                    <i class="fa fa-bar-chart text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Sales</span>
                    <span class="info-box-number">{{ formatted_price($totalSales) }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Total Sales</p>
                    <h2>{{ formatted_price($totalSales) }}</h2>
                </div>
            </div> -->
        </div>
        <div class="col-md-4 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-success">
                    <i class="fa fa-google-wallet text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales from Online Payment</span>
                    <span class="info-box-number">{{ formatted_price($salesFromOnlinePayment) }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Sales from Online Payment</p>
                    <h2>{{ formatted_price($salesFromOnlinePayment) }}</h2>
                </div>
            </div> -->
        </div>
        <div class="col-md-4 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning text-white">
                    <i class="fa fa-credit-card"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales from COD</span>
                    <span class="info-box-number">{{ formatted_price($salesFromCOD) }}</span>
                </div>
            </div>
            
            <!-- <div class="card">
                <div class="card-body">
                    <p>Sales from COD</p>
                    <h2>{{ formatted_price($salesFromCOD) }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-red text-white">
                    <i class="fa fa-money"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Payable Amount To Admin</span>
                    <span class="info-box-number">{{ formatted_price($payableToAdmin) }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Remaining Payable Amount To Admin</p>
                    <h2>{{ formatted_price($payableToAdmin) }}</h2>
                </div>
            </div> -->
        </div>


        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-success text-white">
                    <i class="fa fa-money"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Receivable Amount From Admin</span>
                    <span class="info-box-number">{{ formatted_price($reveivableFromAdmin) }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Remaining Receivable Amount From Admin</p>
                    <h2>{{ formatted_price($reveivableFromAdmin) }}</h2>
                </div>
            </div> -->
        </div>

        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-info">
                    <i class="fa fa-cubes text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Active Products</span>
                    <span class="info-box-number">{{ $totalActiveProductsCount }}</span>
                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <p>Total Active Products</p>
                    <h2>{{ $totalActiveProductsCount }}</h2>
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
