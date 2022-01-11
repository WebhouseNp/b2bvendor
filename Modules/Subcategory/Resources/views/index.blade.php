@extends('layouts.admin')
@section('page_title') All Sub Categories @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    <h1 class="page-title"> Sub Categories</h1>
    @include('admin.section.notifications')
</div>
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Sub Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('subcategory.create')}}">New Sub Category</a>
            </div>
        </div>

        <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
        <!-- <div class="ibox-body" id="appendCategory">
            
        </div> -->
        <table class="table table-striped table-bordered table-hover" id="example1" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Include in main menu</th>
                        <th>Featured</th>
                        <th>Category</th>
                        <th>Publish</th>
                        <th>Action</th>
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
                <td>{{$detail->include_in_main_menu==1? 'Yes':'No'}}</td>
                <td>{{$detail->is_featured==1? 'Yes':'No'}}</td>
                <td>{{$detail->category->name}}</td>
                <td>{{$detail->publish==1? 'Published':'Not published'}}</td>
                <td>
                <a title="view" class="btn btn-success btn-sm" href="{{route('subcategory.view',$detail->id)}}">
                    <i class="fa fa-eye"></i>
                </a> 
                <a title="Edit" class="btn btn-primary btn-sm" href="{{route('subcategory.edit',$detail->id)}}">
                    <i class="fa fa-edit"></i>
                </a> 
                <button class="btn btn-danger delete" onclick="return confirm('Do You want to delete this sub-category??') && deleteSubcategory(this,'{{ $detail->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>

                </td>
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


@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example1').DataTable({
            pageLength: 2,
        });
    })
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

    subcategories()

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

@endsection