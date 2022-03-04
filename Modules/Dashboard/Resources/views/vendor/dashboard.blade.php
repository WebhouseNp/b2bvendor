@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-info">
                    <i class="fa fa-bar-chart text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Sales</span>
                    <span class="info-box-number">{{ formatted_price($totalSales) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-success">
                    <i class="fa fa-google-wallet text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales from Online Payment</span>
                    <span class="info-box-number">{{ formatted_price($salesFromOnlinePayment) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning text-white">
                    <i class="fa fa-credit-card"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales from COD</span>
                    <span class="info-box-number">{{ formatted_price($salesFromCOD) }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-box">
                <span class="info-box-icon bg-red text-white">
                    <i class="fa fa-money"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Payable Amount To Admin</span>
                    <span class="info-box-number">{{ formatted_price($payableToAdmin) }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-success text-white">
                    <i class="fa fa-money"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Receivable Amount From Admin</span>
                    <span class="info-box-number d-md-flex">
                        <div>{{ formatted_price($reveivableFromAdmin) }}</div>
                        <div class="ml-auto">
                            <button id="js-request-payment-btn" class="btn btn-primary btn-sm border-0">Request Payment</button>
                        </div>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-info">
                    <i class="fa fa-cubes text-white"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Products</span>
                    <span class="info-box-number">{{ $totalActiveProductsCount }}</span>
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

@push('push_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#js-request-payment-btn').click(function () {
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Requesting...');
                $(this).prop('disabled', true);
                $.ajax({
                    url: '{{ route('request-payment') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Sent',
                            text: 'Your request for payment has been sent successfully.',
                        });
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong while sending your request. Please try again later.',
                        });
                    },
                    complete: function () {
                        $('#js-request-payment-btn').html('Request Payment');
                        $('#js-request-payment-btn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush