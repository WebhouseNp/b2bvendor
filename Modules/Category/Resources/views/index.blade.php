@extends('layouts.admin')
@section('page_title') All Categories @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="page-heading">
    <h1 class="page-title"> Categories</h1>
    @include('admin.section.notifications')
</div>
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('category.create')}}">Add Category</a>
            </div>
        </div>

        <div class="ibox-body table-responsive" id="validation-errors">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
        {{-- <div class="ibox-body" id="appendCategory"></div> --}}
        <table class="table table-striped table-hover dt-responsive display nowrap" id="example-table" cellspacing="0">
            <thead>
                <tr class="border-0">
                    <th>S.N</th>
                    <th>Name</td>
                    <th>Image</td>
                    <th>Include in main menu</td>
                    <th>Hot Category</td>
                    <th>Featured</td>
                    <th>Contain Subcategory</td>
                    @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                    <th>Publish</th>
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody id="sortable">
                @forelse ($details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->name }}</td>
                    <td>
                        @if($detail->image)
                        <img class="img-fluid rounded" src="{{ $detail->imageUrl('thumbnail') }}" style="width: 3rem;">
                        @else
                        <p>N/A</p>
                        @endif
                    </td>
                    <td>{{ $detail->include_in_main_menu == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $detail->hot_category == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $detail->is_featured == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $detail->does_contain_sub_category == 1 ? 'Yes' : 'No' }}</td>
                    @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                    <td>
                        <input type="checkbox" class="CategoryStatus btn btn-success btn-sm" rel="{{$detail->id}}"
                            data-toggle="toggle" data-on="Publish" data-off="Unpublish" data-onstyle="success" data-offstyle="danger" data-size="mini"
                            @if($detail->publish == 1) checked @endif>
                    </td>
                    @endif
                    @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                    <td class="text-nowrap">
                        <a title="view" class="btn btn-success btn-sm" href="{{ route('category.view',$detail->id) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('category.edit',$detail->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-category" onclick="return confirm('Do You want to delete this category??') && deleteCategory(this,'{{ $detail->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="42">No Categories found </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 15,
            "responsive": true,
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
<script type="text/javascript">
    $(function() {
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

    
            // Fetch categories
    function categories(){
        $.ajax({
		  type:'GET',
		  url:'/api/all-categories',
          success:function(response) {
			$('#appendCategory').html(response.html)
            $("#example-table").DataTable();
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    // load the categories
    // categories();
});

function deleteCategory(el,id) {
     let url = "/api/deletecategory/" + id;
     $.ajax({ 
        type: "post", 
        url: url, 
        data:{
            _method: 'delete'
        },
        success: function(response) {
            var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            $(el).closest('tr').remove()
        }
     }); 
 } 

 //category publish/unpublish
$(".CategoryStatus").change(function(){
    var category_id = $(this).attr('rel');
        if($(this).prop("checked")==true){
            $.ajax({
                method:"POST",
                url : '/api/category/'+ category_id +'/publish',
                data : {
                _method: "put"
                },
                success : function(response){
                    if (response.status == 'false' ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == 'true') {
                        DataSuccessInDatabase(response.message);
                    }
                }
            });
        }else{
                $.ajax({
                    method:"POST",
                    url : '/api/category/'+ category_id +'/unpublish',
                    data : {
                        _method: "delete"
                    },
                    success : function(response){
                        if (response.status == 'false' ) {
                            FailedResponseFromDatabase(response.message);
                        }
                        if (response.status == 'true') {
                            DataSuccessInDatabase(response.message);
                        }
                    }
                });
            }
});
</script>
@endsection