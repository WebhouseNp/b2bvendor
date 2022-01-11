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
            <div class="ibox-title">All Approved Products</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('product.create')}}">New Product</a>
            </div>
        </div>
        <div class="ibox-body" id="validation-errors" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
            <div class="px-4">
                <form action="" class="form-inline" method="GET">
                    <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        <div class="ibox-body" id="appendUser">
        @include('product::productsTable')
        </div>
    </div>
</div>
</div>
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