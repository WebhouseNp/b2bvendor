@extends('layouts.admin')

@section('page_title') All Orders @endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title"> Orders</h1>
</div>

<div class="page-content fade-in-up">
    <div class="ibox">
        <table class="table table-striped table-responsive table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Placed On</th>
                    <th>Total Amount</th>
                    {{-- <th>Track Number</th> --}}
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="category_row{{ $order->id }}">
                    <td> #{{ $order->id }}</td>
                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                    <td>
                        <div>{{ $order->created_at->format('d M, Y') }}</div>
                        <div>{{ date('g:i A', strtotime($order->created_at)) }}</div>
                    </td>
                    <td>{{ formatted_price($order->total_price) }}</td>
                    {{-- <td>{{ $order->track_no ?? 'N/A' }}</td> --}}
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
@endsection