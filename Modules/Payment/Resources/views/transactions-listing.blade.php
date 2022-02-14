@extends('layouts.admin')
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="py-3 px-4">
            <div class="d-flex">
                <div>
                    <h4>{{ $vendor->shop_name }}</h4>
                    <div>{{ $vendor->company_address }}</div>
                    <div>{{ $vendor->company_email }}</div>
                </div>
                <div class="ml-auto">
                    <div>Bank: {{ $vendor->bank_name }}</div>
                    @if ($vendor->branch_name)
                    <div>Branch: {{ $vendor->branch_name }}</div>
                    @endif
                    <div>Alc No.: {{ $vendor->account_number }}</div>
                    <div>Alc Name: {{ $vendor->name_on_bank_acc }}</div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="online-payments-tab" data-toggle="tab" href="#onlinePaymentsTab" role="tab" aria-controls="onlinePaymentsTab" aria-selected="true">Online Transactions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="cod-payments-tab" data-toggle="tab" href="#codPaymentsTab" role="tab" aria-controls="codPaymentsTab" aria-selected="false">COD Transactions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="payment-tab" data-toggle="tab" href="#paymentTab" role="tab" aria-controls="paymentTab" aria-selected="false">Payment</a>
          </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="onlinePaymentsTab" role="tabpanel" aria-labelledby="online-payments-tab">
            @include('payment::partials.transactions-table')
        </div>
        <div class="tab-pane fade" id="codPaymentsTab" role="tabpanel" aria-labelledby="cod-payments-tab">
            @include('payment::partials.cod-transactions-listing')
        </div>
        <div class="tab-pane fade" id="paymentTab" role="tabpanel" aria-labelledby="payment-tab">
            @include('payment::partials.payment-form')
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
@endsection
