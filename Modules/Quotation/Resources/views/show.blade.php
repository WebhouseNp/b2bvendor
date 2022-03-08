@extends('layouts.admin')

@section('page_title')Quotations @endsection

@push('styles')
    <style>
        #quotation-detail-table tr td {
            padding-top: 15px;
            padding-bottom: 15px;
        }
        #quotation-detail-table tr td:first-of-type {
            font-weight: 600;
            color: gray;
        }
        @media screen AND (min-width: 700px) {
            #quotation-detail-table tr td:first-of-type {
                max-width: 5rem;
            }
        }
    </style>
@endpush

@section('content')
<div class="page-content fade-in-up">
    <div class="mb-3">
        <a href="{{ route('quotations.index') }}" class="btn btn-primary border-0">Back to listing</a>
    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Quotation</div>
        </div>
        <div class="ibox-body">
            <table id="quotation-detail-table" class="table table-borderless table-hover table-responsive-sm">
                <tr>
                    <td>Product</td>
                    <td>{{ $quotation->purchase }}</td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td>{{ $quotation->quantity }} {{ $quotation->unit }}</td>
                </tr>
                <tr>
                    <td>Specifications</td>
                    <td>{{ $quotation->specifications }}</td>
                </tr>
                <tr>
                    <td>Requested By</td>
                    <td>
                        <div>{{ $quotation->name }}</div>
                        <div>{{ $quotation->email }}</div>
                        <div>{{ $quotation->mobile_num }}</div>
                    </td>
                </tr>
                <tr>
                    <td>Ship To</td>
                    <td>{{ $quotation->ship_to }}</td>
                </tr>
                <tr>
                    <td>Expected Price</td>
                    <td>{{ $quotation->expected_price }}</td>
                </tr>
                <tr>
                    <td>Expected Delivery Time</td>
                    <td>{{ $quotation->expected_del_time }}</td>
                </tr>
                <tr>
                    <td>Other Contact</td>
                    <td>{{ $quotation->other_contact }}</td>
                </tr>
                <tr>
                    <td>Link</td>
                    <td>{{ $quotation->link }}</td>
                </tr>
                <tr>
                    <td colspan="2">Images</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            @if($quotation->image1)
                            <div class="col-md-3">
                                <img src="{{ asset('storage/'.$quotation->image1) }}" class="img-thumbnail">
                            </div>
                            @endif
                            @if($quotation->image2)
                            <div class="col-md-3">
                                <img src="{{ asset('storage/'.$quotation->image2) }}" class="img-thumbnail">
                            </div>
                            @endif
                            @if($quotation->image3)
                            <div class="col-md-3">
                                <img src="{{ asset('storage/'.$quotation->image3) }}" class="img-thumbnail">
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @if(auth()->user()->hasAnyRole('super_admin|admin'))
                <tr>
                    <td>Forwarded To</td>
                    <td>
                        <ul class="list-group">
                            @foreach($quotation->vendors as $vendor)
                            <li class="list-group-item">
                                {{ $vendor->shop_name}}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('push_scripts')
@endpush
