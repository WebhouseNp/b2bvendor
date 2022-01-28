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
        <div class="ibox-body">
            <table class="table table-responsive table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr class="border-0">
                        <th>S.N</th>
                        <th>Source</th>
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <th>Vendor</th>
                        @endif
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('orders.show', $detail->order) }}">
                                #{{$detail->order->id}}
                            </a>
                        </td>
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <td class="text-capitalize">{{ $detail->vendorUser->name }}</td>
                        @endif
                        <td>{{ formatted_price($detail->total_price) }}</td>
                        <td>
                            <div class="badge {{ $detail->order->isPaid() ? 'bg-success' : 'badge-danger' }}">{{ ucfirst($detail->order->payment_status) }}</div>
                        </td>
                        <td>
                            <div>{{ $detail->order->created_at->format('d M, Y') }}</div>
                            <div>{{ date('g:i A', strtotime($detail->order->created_at)) }}</div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No Report found </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $details->links() }}
        </div>
    </div>
</div>
@endsection