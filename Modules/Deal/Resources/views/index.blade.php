
<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Deals</div>
            @if (auth()->user()->hasRole('vendor'))
            <div>
                <a href="{{ route('deals.create') }}" class="btn btn-success">Create New</a>
            </div>
            @endif
        </div>

        <div class="ibox-body">
            <table class="table table-responsive table-bordered" id="example-table" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Customer</th>
                        <th>Vendor</th>
                        <th>Completed</th>
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
                        <td>{{ $data->completed_at ? 'Yes' : 'No' }}</td>
                        <td>{{ $data->expire_at->toDateTimeString() }} 
                            <span>
                                @if ($data->isAvailable())
                                <i class="fa fa-check text-success"></i> 
                                @else
                                <i class="fa fa-times text-danger"></i></span>
                                @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-link ml-0 pl-0" onclick="copyLink(this)" data-link="{{ config('constants.customer_app_url') . '/deals/' . $data->id }}" title="Click to copy">
                                <i class="fa fa-clone"></i>
                                <span>Click to copy</span>
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{route('deals.show',$data->id)}}" title="view">
                                <i class="fa fa-eye"></i>
                            </a> 
                            @if (auth()->user()->hasRole('vendor'))
                            <a class="btn btn-primary btn-sm" href="{{route('deals.edit',$data->id)}}" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a> 
                            <button class="btn btn-danger btn-sm delete" onclick="return confirm('Are you sure to delete this deal?') && deleteDeal(this,'{{ $data->id }}')"  class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i></button>
                            @endif
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