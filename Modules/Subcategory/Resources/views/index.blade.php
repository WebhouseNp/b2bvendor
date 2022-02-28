@extends('layouts.admin')
@section('page_title') All Sub Categories @endsection
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="page-heading">
    <h1 class="page-title"> Sub Categories</h1>
</div>
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Sub Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('subcategory.create')}}">New Sub Category</a>
            </div>
        </div>

        <div class="ibox-body">
        <table class="table table-striped table-responsive table-bordered table-hover" id="example1" cellspacing="0">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>In Homepage</th>
                    <th>Total Products</th>
                    @if( auth()->user()->hasRole('vendor'))
                    <th>Publish</th>
                    @endif
                    @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                    <th>Change Status</th>
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $key=>$detail)

                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$detail->name}}</td>
                    <td>
                        @if($detail->image)
                        <img class="img-fluid rounded" src="{{ $detail->imageUrl('thumbnail') }}" style="width: 3rem;">
                        @else
                        <p>N/A</p>
                        @endif
                    </td>
                    <td>{{$detail->category->name}}</td>
                    <td>{{$detail->is_featured==1? 'Yes':'No'}}</td>
                    <td>{{count($detail->products)}}</td>
                    @if( auth()->user()->hasRole('vendor'))
                    <td>
                        <div style="display:inline-block; width:100px" class="badge  {{ $detail->publish==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                            {{ $detail->publish == 1 ? 'Published' : 'Not Published' }}
                        </div>
                    </td>
                    @endif
                    @if( auth()->user()->hasAnyRole('super_admin|admin'))
                    <td>
                        <input type="checkbox" class="SubcategoryStatus btn btn-success btn-sm" rel="{{$detail->id}}" data-toggle="toggle" data-on="Publish" data-off="Unpublish" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($detail->publish == 1) checked @endif>
                    </td>
                    <td>
                        <a title="view" class="btn btn-success btn-sm" href="{{route('subcategory.view',$detail->id)}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a title="Edit" class="btn btn-primary btn-sm" href="{{route('subcategory.edit',$detail->id)}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger delete" onclick="return confirm('Do You want to delete this sub-category??') && deleteSubcategory(this,'{{ $detail->id }}')" class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="3">No Records </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example1').DataTable({
            pageLength: 25,
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [-1, -2]
            }]
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

<script >
    function subcategories(){
        $.ajax({
		  type:'GET',
		  url:'/api/getsubcategories',
		  success:function(response) {
			$('#appendCategory').html(response.html)
            $("#example1").DataTable();
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    // subcategories()

    function deleteSubcategory(el,id) {
        let url = "/api/deletesubcategory/" + id;
        
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
            // window.location.href = "/admin/category";
        }
        }); 
    } 

  </script>

<script>
  $(function() {
    $('.SubcategoryStatus').change(function() {
        var subcat_id = $(this).attr('rel');
        if($(this).prop("checked")==true){
            $.ajax({
                method:"POST",
                url : '/api/subcategory/'+ subcat_id +'/publish',
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
                    url : '/api/subcategory/'+ subcat_id +'/unpublish',
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
    })
  })
</script>

@endsection