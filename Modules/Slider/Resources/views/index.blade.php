@extends('layouts.admin')
@section('page_title') All Slider @endsection
@section('styles')
 
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
 
<div class="page-heading">
    <h1 class="page-title"> Slider</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All sliders</li>
    </ol>
@include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All sliders</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('slider.create')}}">New Slider</a>
            </div>
        </div>
         

        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <td>Image</td>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if($sliders->count())
                    @foreach($sliders as $key => $slider_data)
                     
                    <tr class="category_row{{$slider_data->id}}">
                        <td> {{$key +1}}</td>
                        <td>
                            @if(isset($slider_data->image) && !empty($slider_data->image) && file_exists(public_path().'/images/thumbnail/'.$slider_data->image))
                            <img src="{{asset('/images/thumbnail/'.$slider_data->image)}}" alt="No Image" class=" img img-thumbnail  img-sm rounded" style="max-width: 150px;">
                            @endif
                        </td>
                        
                        <td class="text-capitalize"> {{$slider_data->title}}</td>
                        <td>{{$slider_data->description}}</td>
                        <td> {{$slider_data->status}}</td>
                        <td>
                            <ul class="action_list">
                                <li>
                                    <a href="{{route('slider.edit', $slider_data->id)}}" data- class="btn btn-info btn-md"><i class="fa fa-edit"></i></a>
                                    
                                </li>
              
                                <li>

                                    <form action="{{ route('slider.destroy', $slider_data->id) }}" method="post">
                                        @csrf()
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure you want to delete this Slider?')" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </li>
                             
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any slider image  yet.
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
    $(document).ready(function(){
        $('.category_status').click(function(e){
            e.preventDefault();
            $.ajax({
                method:"POST",
                data:{
                    slider_id : $(this).data('slider_id'),
                    status : $(this).data('status'),
                    _token: "{{csrf_token()}}"
                },
                success : function(response){
                    if (response.status == false ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        DataSuccessInDatabase(response.message);
                    }
                }
            })
        })
    })

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