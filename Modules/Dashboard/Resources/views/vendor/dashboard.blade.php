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
                    <p>Remaining Payable Amount To Admin</p>
                    <h2>{{ formatted_price($payableToAdmin) }}</h2>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <p>Remaining Receivable Amount From Admin</p>
                    <h2>{{ formatted_price($reveivableFromAdmin) }}</h2>
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

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless table-responsive">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="category_row{{ $order->id }}">
                        <td> #{{ $order->id }}</td>
                        <td>{{ $order->customer->name ?? '' }}</td>
                        <td>
                            <div>{{ $order->created_at->format('d M, Y') }}</div>
                            <div>{{ date('g:i A', strtotime($order->created_at)) }}</div>
                        </td>
                        <td>{{ formatted_price($order->total_price) }}</td>
                        <td>
                            <span class="text-capitalize">{{ $order->payment_type}}</span>
                            <span class="{{ $order->isPaid() ? 'text-success' : 'text-danger' }} text-capitalize">({{ $order->payment_status }})</span>
                        </td>
                        <td><span style="display:inline-block; width:100px" class="badge badge-primary">{{ ucfirst($order->status) }}</span></td>
                        <td class="text-right">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-link text-primary"><i class="fa fa-eye mr-1"></i> View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="42" class="text-center">
                            You do not have any order yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
