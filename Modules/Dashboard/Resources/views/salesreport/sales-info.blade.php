@extends('layouts.admin')
@section('page_title') Sales Report @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Sales Report</div>
        </div>

        <table class="table table-striped table-responsive table-hover dt-responsive display" id="example-table" cellspacing="0" style="width:100%">
            <thead>
                <tr class="border-0">
                    <th>S.N</th>
                    <th>Order</th>
                    @if( auth()->user()->hasAnyRole('super_admin|admin'))
                    <th>Vendor</th>
                    @endif
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Date</th>
                    
                </tr>
            </thead>
            <tbody id="sortable">
            @forelse ($details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$detail->order->id}}</td>
                    @if( auth()->user()->hasAnyRole('super_admin|admin'))
                    <td>{{ $detail->vendorUser->name }}</td>
                    @endif
                    <td>{{$detail->total_price}}</td>
                    <td>{{$detail->order->payment_status}}</td>
                    <td>
                        <div>{{ $detail->order->created_at->format('d M, Y')}}</div>
                        <div>{{ date('g:i A', strtotime($detail->order->created_at)) }}</div>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="42">No Categories found </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection