@extends('layouts.admin')
@section('page_title') All Orders @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    <h1 class="page-title"> Orders</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All Orders</li>
    </ol>
    @include('admin.section.notifications')
</div>

<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Orders</div>
            <div>
            </div>
        </div>
        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Phone</th>
                        <th>Track Number</th>
                        <th>Order placed time</th>
                        <th>Payment Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    @if($orders->count())

                    @foreach($orders as $key => $order_data)

                    <tr class="category_row{{$order_data->id}}">
                        <td> {{$key +1}}</td>
                        <td>{{$order_data->order->user->name ?? '' }}</td>
                        <td>{{Carbon\Carbon::parse($order_data->created_at)->format('Y,M d')}}</td>
                        <td>{{number_format(@$order_data->amount, 2)}}</td>
                        <td>{{$order_data->order->phone}}</td>
                        <td>{{$order_data->order->track_no}}</td>
                        <td>{{ date('g:i a', strtotime($order_data->created_at)) }}</td>

                        <td>{{$order_data->order->payment_type}}</td>
                        <td>
                        <a href="{{route('order.show',$order_data->order->id)}}" data-
                                        class="btn btn-info btn-md"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any Catogory yet.
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
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
<script>
    function FailedResponseFromDatabase(message){
    html_error = "";
    $.each(message, function(index, message){
        html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> '+message+ '</p>';
    });
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        html:html_error ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
function DataSuccessInDatabase(message){
    Swal.fire({
        // position: 'top-end',
        type: 'success',
        title: 'Done',
        html: message ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
</script>
@endsection