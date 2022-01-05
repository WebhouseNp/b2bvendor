<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Products @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
<style>
    .outofstock {
  background-color: #f3083b;
}
    </style>
@section('content')

<div class="page-heading">
    <h1 class="page-title"> Products</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All Products</li>
    </ol>
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Products</div>
        </div>


        <div class="ibox-body">
        <table class="table table-bordered table-hover" id="example-table" cellspacing="0"
                width="100%">
                <thead>
                    <tr class="border-0">
                        <th>SN</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>User</th>
                        <!-- <th>Categories</th>
                        <th>Sub Categories</th> -->
                        <th>Stock Quantity</th>
                        <th>Product Images</th>
                        <th>Price</th>
                        <th> Discount</th>
                        
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody id="sortable">
                @forelse ($products as $key=>$detail)

                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        @if($detail->image)
                            <img src="{{asset('images/listing/'.$detail->image)}}">
                        @else
                        <p>N/A</p>
                        @endif
			        </td>
                    <td>{{$detail->title}}</td>
                    <td>{{$detail->user->name}}</td>
                    <!-- <td>{{$detail->category->name}}</td>
                    <td>
                    @foreach($detail->category->subcategory as $subcategory)
                        {{$subcategory->name}}
                    @endforeach
                    </td> -->
                    
                    <td>{{$detail->quantity}}</td>
                    <td>
                                <a href="{{route('product.images',$detail->id)}}" class="btn btn-primary"><i
                                        class="fa fa-edit"></i></a>
                            </td>
                    
                    <td>NPR. {{ number_format($detail->price)}}</td>
                    <td>
                        @if($detail->discount)
                        {{  $detail->discount}}
                        @endif
    
                    </td>

                    <td>{{$detail->status=='active'? 'Active':'Inactive'}}</td>
                    <!-- <td>
                    <button class="btn btn-primary delete" onclick="approveProduct({{ $detail->id }})"  class="btn btn-primary" style="display:inline"><i class="fa fa-check"></i></button>
                    <button class="btn btn-danger delete" onclick="cancelProduct({{ $detail->id }})"  class="btn btn-danger" style="display:inline"><i class="fa fa-remove"></i></button>
                    <a title="view" class="btn btn-success btn-sm" href="{{route('product.view',$detail->id)}}" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td> -->
                    <td>
                        <a title="view" class="btn btn-success btn-sm" href="{{route('product.view',$detail->id)}}">
                            <i class="fa fa-eye"></i>
                        </a> 

                        <a title="Edit" class="btn btn-primary btn-sm" href="{{route('product.edit',$detail->id)}}">
                            <i class="fa fa-edit"></i>
                        </a> 
                        <button class="btn btn-danger delete" onclick="deleteProduct(this,'{{ $detail->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8">No Products Yet </td>
                    </tr>
                @endforelse



                </tbody>

            </table>
        </div>
    </div>

</div>
<!-- Modal -->
@include('dashboard::admin.modals.approvalnotemodal')
@endsection

@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
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
<script >
  	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
       $('.message').fadeOut(3000);
       $('.delete').submit(function(e){
        e.preventDefault();
        var message=confirm('Are you sure to delete');
        if(message){
          this.submit();
        }
        return;
       });
       
    });

    $(function () {
        $("#example1").DataTable();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function deleteProduct(id) {
        var api_token = '<?php echo $api_token; ?>';
        var message=confirm('Do You want to delete this product??');
        if(message){
            $.ajax({ 
                type: "post", 
                url:"{{route('api.deleteproduct')}}", 
                data:{id:id},
                headers: {
                    Authorization: "Bearer " + api_token
                    },
                success: function(response)
                    {
                    console.log(response.message)
                    var validation_errors = JSON.stringify(response.message);
                        $('#validation-errors').html('');
                        $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
                        DataSuccessInDatabase(response.message);
                        location.reload();
                }
            }); 
        }
        return;
          }  
        
          function approveProduct(id) {
            var api_token = '<?php echo $api_token; ?>';
            var message=confirm('Do You want to approve this product??');
        if(message){
            $.ajax({ 
                type: "post", 
                url:"{{route('api.approveproduct')}}", 
                data:{id:id},
                headers: {
                    Authorization: "Bearer " + api_token
                    },
                success: function(response) {
                    console.log(response.message)
                    var validation_errors = JSON.stringify(response.message);
                        $('#validation-errors').html('');
                        $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
                        DataSuccessInDatabase(response.message);
                        window.location.href = "/admin/product";
                }
            }); 
        }
        return;
          } 

            function cancelProduct(id) {
                var api_token = '<?php echo $api_token; ?>';
                var message=confirm('Do You want to reject this product??');
                if(message){
                    $('#nonapprovalnoteModal').modal('show');
                    $('#submitnonapprovalnote').on('click', function(){
                        var non_approval_note = $('#non_approval_note').val();
                        $.ajax({
                            url:'/api/nonapprovalnote',
                            method:"POST",
                            data:{
                                id:id,
                                non_approval_note:non_approval_note,
                                _token: "{{csrf_token()}}"
                            },
                            success : function(response){
                                if (response.status == 'false' ) {
                                    FailedResponseFromDatabase(response.message);
                                }
                                if (response.status == 'true') {
                                    DataSuccessInDatabase(response.message);
                                    location.reload();
                                }
                            }
                        })
                    })
                }
                return;
            } 

  </script>
 
@endsection