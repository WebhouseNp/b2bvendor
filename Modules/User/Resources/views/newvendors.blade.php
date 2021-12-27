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
    <!-- <h1 class="page-title">Add users</h1> -->
    <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All News</li>
    </ol> -->
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All New vendors</div>
            
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Category</th>
                        <th>Vendor Status</th>
                        <!-- <th>Publish</th> -->
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($r as $t)
                    @foreach($t as $key=>$data)

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->phone_num}}</td>
                        <td></td>
                        <td><span class="btn btn-rounded btn-sm {{orderProccess($data->vendor_type) }} changeStatus"
                                data-status="{{$data->vendor_type}}" data-vendor_id="{{$data->id}}"
                                style="cursor: pointer;"> Change vendor status</span></td>
                        <!-- <td>{{$data->publish == 1 ? 'Published' : 'Not Published'}}</td> -->
                        <td>
                        <a title="Edit" class="btn btn-primary btn-sm" href="{{route('vendor.view',$data->id)}}">
                            <i class="fa fa-eye"></i>
                        </a>

                        </td>
                    </tr>
                    @php($i++)
                    @endforeach
                    @endforeach
                    
                </tbody>

            </table>
        </div>
    </div>

</div>
<!-- Modal -->
@include('dashboard::admin.modals.vendorstatusmodal')
<div class="modal" id="popupModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
        <h3 id="popup-modal-title" class="modal-title"></h5>
      </div>
			<div class="modal-body">
				<div style="text-align: center;" id="popup-modal-body"></div>
			</div>
			<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<!-- <script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script> -->
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<!-- <script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script> -->
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
<!-- <script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script> -->
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<!-- <script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script> -->

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
            var vendor_id = $(this).data('vendor_id');
            $('#vendorstatusModal').modal('show');
            $('#submitVendorStatus').on('click', function(){
            var status = $('#vendor_status').val();
            // var message=confirm('Are you sure you want to Approve this Vendor??');
        // if(message){
        //     e.preventDefault();
            $.ajax({
                url:'/api/changeVendorStatus',
                method:"POST",
                data:{
                    vendor_id : vendor_id,
                    vendor_type : status,
                    _token: "{{csrf_token()}}"
                },
                success : function(response){
                    if (response.status == false ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        $('#appendOrder').empty();
                        $('#appendOrder').html(response.html);

                        DataSuccessInDatabase(response.message);
                        location.reload();
                    }
                }
            })
            
        // }
    })
        return;
        })
    
       
       
    });

  </script>

@endsection