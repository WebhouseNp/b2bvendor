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
                        <th><span style="background-color: #d9e7e7;">Products</span> / 
                        <span style="background-color: #b4d7d7;">Quantity</span> / 
                        <span style="background-color: #ed9494;">Unit Price</span></th>
                        <th>Action</th>
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
                        {{++$key}}. <span style="background-color: #d9e7e7;">{{$deal_product->product_info->title}} </span> /
                                    <span style="background-color: #b4d7d7;margin-left: 18px;">{{$deal_product->product_qty}}</span> /
                                    <span style="background-color: #ed9494;margin-left: 18px;">{{$deal_product->unit_price}}</span><br><br>
                        @endforeach
                        </td>
                        <td>
                            <a title="Edit" class="btn btn-primary btn-sm" href="{{route('deals.edit',$data->id)}}">
                                <i class="fa fa-edit"></i>
                            </a> 
                            <button class="btn btn-danger delete" onclick="deleteBrand({{ $data->id }})"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
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