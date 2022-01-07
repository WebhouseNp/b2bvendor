<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Admin Users @endsection
@section('content')
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Users</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('user.create')}}">New Users</a>
            </div>
        </div>
        <div class="ibox-body" id="validation-errors" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
        <div class="ibox-body" id="appendUser">
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

<script >
    function users(){
        var api_token = '<?php echo $api_token; ?>';

        $.ajax({
		  type:'GET',
		  url:'/api/getusers',
		  headers: {
            Authorization: "Bearer " + api_token
        },
		  success:function(response) {
			$('#appendUser').html(response.html)
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    users()
    function deleteUser(el,id) {
        var api_token = '<?php echo $api_token; ?>';
        if (!confirm("Are you sure you want to delete?")){
            return false;
        }
            $.ajax({ 
           type: "post", 

           url:"{{route('api.deleteuser')}}", 
           data:{id:id},
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