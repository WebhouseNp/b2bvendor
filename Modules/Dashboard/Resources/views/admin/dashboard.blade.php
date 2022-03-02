@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Total Sales</p>
                    <h2>{{ formatted_price($totalSales) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Sales from Online Payment</p>
                    <h2>{{ formatted_price($salesFromOnlinePayment) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Sales from COD</p>
                    <h2>{{ formatted_price($salesFromCOD) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Receivable Amount From Vendors</p>
                    <h2>{{ formatted_price($receivableFromVendors) }}</h2>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Payable Amount To Vendors</p>
                    <h2>{{ formatted_price($payableToVendors) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Total Active Products</p>
                    <h2>{{ $totalActiveProductsCount }}</h2>
                </div>
            </div>
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
