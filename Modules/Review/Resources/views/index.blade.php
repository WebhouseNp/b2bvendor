@extends('layouts.admin')
@push('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />

<style media="screen">
    .adjust-delete-button {
        margin-top: -28px;
        margin-left: 37px;
    }
</style>
@endpush
@section('content')

<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Reviews</div>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full name</th>
                        <th>Rate</th>
                        <th>Review</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if($reviews->count())
                    @foreach($reviews as $key => $data)

                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->rate}}</td>
                        <td>{{$data->reviews}}</td>
                        <td>{{$data->product->title}}</td>
                        <td>{{$data->status == 'publish' ? 'Published' : 'Not Published' }}</td>
                        <td>
                            <span class="btn btn-rounded btn-sm {{orderProccess($data->status) }} changeStatus"
                                data-status="{{$data->status}}" data-review_id="{{$data->id}}"
                                style="cursor: pointer;">{{$data->status == 'publish' ? 'Published' : 'Not Published' }}</span>
                        </td>
                        
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any data yet.
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

       
        $('body').on('click', '.changeStatus' ,function(e){
            var review_id = $(this).data('review_id');
            var status = $(this).data('status');
            if(status == 'unpublish'){
                 $.ajax({
                url:'/api/reviews/'+ review_id +'/publish',
                method:"POST",
                data:{
                    status : status,
                    _token: "{{csrf_token()}}",
                    _method: "put"
                },
                success : function(response){
                    if (response.status == 'false' ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == 'true') {
                        var replace_html = '<span class="btn btn-rounded btn-sm {{orderProccess('+publish+') }} changeStatus" data-status = "'+status+'" data-review_id = "'+review_id+'">published</span>'
                        $('.changeStatus').html(replace_html);
                        DataSuccessInDatabase(response.message);
                        location.reload();
                    }
                }
                })
            } else {
                $.ajax({
                url:'/api/reviews/'+ review_id +'/unpublish',
                method:"POST",
                data:{
                    status : status,
                    _token: "{{csrf_token()}}",
                    _method: "delete"
                },
                success : function(response){
                    if (response.status == 'false' ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == 'true') {
                        var replace_html = '<span class="btn btn-rounded btn-sm {{orderProccess('+unpublish+') }} changeStatus" data-review_id = "'+review_id+'">Unpublished</span>'
                        $('.changeStatus').html(replace_html);
                        DataSuccessInDatabase(response.message);
                        location.reload();
                    }
                }
                })
            }
            
        // })

        return;
        })
        
    
       
       
    });

  </script>

@endsection