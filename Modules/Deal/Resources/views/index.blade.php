
<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
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
            <div class="ibox-title">All Deals</div>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Deal Expire At</th>
                        <th>Vendor</th>
                        <th>Customer</th>
                        <th>Generate Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if($deals->count())
                    @foreach($deals as $data)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->expire_at->toDateTimeString() }}</td>
                        <td>{{@$data->vendor->name}}</td>
                        <td>{{@$data->user->name}}</td>
                        <td>
                        </td>
                        <td>
                            <a title="Edit" class="btn btn-primary btn-sm" href="{{route('deals.edit',$data->id)}}">
                                <i class="fa fa-edit"></i>
                            </a> 
                            <button class="btn btn-danger delete" onclick="return confirm('Do You want to delete this product??') && deleteDeal(this,'{{ $data->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
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
<script>
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
       
    });


    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })

    
    function deleteDeal(el,id) {
       
        var api_token = '<?php echo $api_token; ?>';
      
        let url = "/api/deals/" + id;
            $.ajax({ 
                type: "post", 
                url: url, 
                data:{
                    _method: 'delete'
                },
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
                        $(el).closest('tr').remove()
                }
            }); 
            return true;
          } 
</script>

@endsection