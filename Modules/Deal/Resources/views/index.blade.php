@extends('layouts.admin')
@push('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />

<style media="screen">
    .adjust-delete-button {
        margin-top: -28px;
        margin-left: 37px;
    }
</style>
@endpush
@section('content')

<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Deals</div>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Deal Expire At</th>
                        <th>Vendor</th>
                        <th>Customer</th>
                        <th>Products/Quantity/Unit Price</th>
                    </tr>
                </thead>
                <tbody>

                    @if($deals->count())
                    @foreach($deals as $key => $data)

                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->expire_at}}</td>
                        <td>{{@$data->vendor->name}}</td>
                        <td>{{@$data->user->name}}</td>
                        <td>
                        @foreach($data->deal_products as $key => $deal_product)
                        {{++$key}}. {{$deal_product->product_info->title}}/{{$deal_product->product_qty}}/{{$deal_product->unit_price}} <br>
                        @endforeach
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any data yet.
                        </td>
                    </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
@endsection