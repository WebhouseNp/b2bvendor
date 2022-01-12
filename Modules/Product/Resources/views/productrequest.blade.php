<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Products @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Products</div>
        </div>
        <div class="px-4">
                <form action="" class="form-inline" method="GET">
                    <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
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
                        <th>Images</th>
                        <th>Price</th>
                        <th> Discount</th>
                        <th>Status</th>
                        <th>Approve</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                
                <tbody id="sortable">
                @forelse ($details as $key=>$detail)

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
                    <td style="text-align: center">
                        <a href="{{route('product.images',$detail->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                    </td>
                    
                    <td>NPR. {{ number_format($detail->price)}}</td>
                    <td>
                        @if($detail->discount)
                        {{  $detail->discount}}
                        @endif
    
                    </td>

                    <td>{{$detail->status=='active'? 'Active':'Inactive'}}</td>
                    <td>
                    <button class="btn btn-primary btn-sm delete" onclick="approveProduct({{ $detail->id }})"  style="border-radius:10%"><i class="fa fa-check"></i></button>
                    <button class="btn btn-danger btn-sm delete" onclick="cancelProduct({{ $detail->id }})"  style="border-radius:10%"><i class="fa fa-remove"></i></button>
                    <a title="view" class="btn btn-success btn-sm" href="{{route('product.view',$detail->id)}}" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8">No Products Yet </td>
                    </tr>
                @endforelse



                </tbody>

            </table>
            {{ $details->links() }}
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
                        location.reload();
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