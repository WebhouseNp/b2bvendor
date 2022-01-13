
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
            <div>
                <a href="{{ route('deals.create') }}" class="btn btn-success">Create New</a>
            </div>
        </div>

        <div class="ibox-body">
            <table class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Customer</th>
                        <th>Vendor</th>
                        <th>Deal Expire At</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if($deals->count())
                    @foreach($deals as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{@$data->user->name}}</td>
                        <td>{{@$data->vendor->name}}</td>
                        <td>{{ $data->expire_at->toDateTimeString() }}</td>
                        <td>
                            <button type="button" class="btn btn-link ml-0 pl-0" onclick="copyLink(this)" data-link="{{ config('constants.customer_app_url') . '/deals/' . $data->id }}" title="Click to copy">
                                <i class="fa fa-clone"></i>
                                <span>Click to copy</span>
                            </button>
                        </td>
                        <td>
                            <a title="Edit" class="btn btn-primary btn-sm" href="{{route('deals.edit',$data->id)}}">
                                <i class="fa fa-edit"></i>
                            </a> 
                            <button class="btn btn-danger btn-sm delete" onclick="return confirm('Do You want to delete this product??') && deleteDeal(this,'{{ $data->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
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
    function copyLink(el)
    {
        navigator.clipboard.writeText(el.dataset.link).then(function () {
            Swal.fire({
                type: 'success',
                title: 'Linked copied',
                toast: true,
                position: 'top-end',
                timer: 3000
            })
        }, function () {
            console.log('Failure to copy. Check permissions for clipboard');
            Swal.fire({
                type: 'error',
                title: 'Sorry link could not be copied',
                toast: true,
                position: 'top-end'
            })
        });
    }

    
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