@extends('layouts.admin')
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All vendors</div>
        </div>
        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-responsive-sm table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>User Name</th>
                        <th>Vendor Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Vendor Status</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($vendors as $key=>$data)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->user->name}}</td>
                        <td>{{@$data->shop_name}}</td>
                        <td>{{$data->user->email}}</td>
                        <td>{{$data->user->phone_num}}</td>
                        <td><span class="btn btn-sm {{vendorStatus($data->user->vendor_type) }} ">{{ ucfirst($data->user->vendor_type) }}</span></td>
                        <td>
                            <a title="View Profile" class="btn btn-info btn-sm" href="{{route('vendor.view',$data->user->id)}}"> <i class="fa fa-eye"></i>
                                View Profile
                            </a>

                        </td>
                    </tr>

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
                <h3 id="popup-modal-title" class="modal-title">
                    </h5>
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
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            html: html_error,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            // position: 'top-end',
            type: 'success',
            title: 'Done',
            html: message,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('body').on('click', '.changeStatus', function(e) {
            var vendor_id = $(this).data('vendor_id');
            $.ajax({
                url: '/api/getVendorStatus',
                method: "POST",
                data: {
                    vendor_id: vendor_id,
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    if (response.status == false) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        var html_options = "<option value=''>select any one</option>";
                        $('#vendorstatusModal').modal('show');
                        document.getElementById('vendor_status').value = response.data.vendor_type;
                    }
                }
            })
            $('#submitVendorStatus').on('click', function() {
                var status = $('#vendor_status').val();
                $.ajax({
                    url: '/api/changeVendorStatus',
                    method: "POST",
                    data: {
                        vendor_id: vendor_id,
                        vendor_type: status,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(response) {
                        if (response.status == false) {
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

            })
            return;
        })
    });
</script>

@endsection