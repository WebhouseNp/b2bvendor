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

<!-- <div class="page-heading">
    <h1 class="page-title"> Products</h1>
    @include('admin.section.notifications')
</div> -->
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Products</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('product.create')}}">New Product</a>
            </div>
        </div>
        <div class="ibox-body" id="appendProduct">
        </div>
    </div>
</div>
 
@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
<script >
    function products(){
        var api_token = '<?php echo $api_token; ?>';
        $.ajax({
		  type:'GET',
		  url:'/api/allproducts',
		  headers: {
            Authorization: "Bearer " + api_token
        },
    
		  success:function(response) {
              console.log(response.data)
              if(response.data){
                $('#appendProduct').html(response.html)
                $("#example-table").DataTable();
                }
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    products()

    function deleteProduct(el,id) {
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
                        $(el).closest('tr').remove()
                }
            }); 
        }
        return;
          }  

  </script>
 
@endsection