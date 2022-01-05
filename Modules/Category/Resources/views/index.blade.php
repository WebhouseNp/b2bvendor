<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Categories @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    <h1 class="page-title"> Categories</h1>
    @include('admin.section.notifications')
</div>
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('category.create')}}">Add Category</a>
            </div>
        </div>

        <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
        <div class="ibox-body" id="appendCategory">
            
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
            pageLength: 2,
        });
    })
    $("#sortable").sortable({
              stop: function(){
                $.map($(this).find('tr'), function(el) {
                  var itemID = el.id;
                  var itemIndex = $(el).index();
                  $.ajax({
                    url:"",
                    method:"post",
                     data: {itemID:itemID, itemIndex: itemIndex},
                    success:function(data){

                    }
                  })
                });
              }
            });
</script>

<script >
    // Fetch categories
    function categories(){
        var api_token = '<?php echo $api_token; ?>';
        $.ajax({
		  type:'GET',
		  url:'/api/all-categories',
		  headers: {
            Authorization: "Bearer " + api_token
        },
		  success:function(response) {
			$('#appendCategory').html(response.html)
            $("#example-table").DataTable();
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    categories();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteCategory(el,id) {
        var api_token = '<?php echo $api_token; ?>';
        let url = "/api/deletecategory/" + id;
        
        $.ajax({ 
        type: "post", 
        url: url, 
        data:{
            _method: 'delete'
        },
        headers: {
            Authorization: "Bearer " + api_token
        },
        success: function(response) {
            var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            $(el).closest('tr').remove()
        }
        }); 
    } 
  </script>
@endsection