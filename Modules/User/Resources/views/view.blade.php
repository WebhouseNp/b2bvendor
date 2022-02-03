@extends('layouts.admin')
@section('page_title')View Vendor Info @endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title"> Vendor Details</div>

        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <a href="{{asset('images/listing/'.$vendor->vendor->image)}}" target="_adimage">
                    <img src="{{asset('images/listing/'.$vendor->vendor->image)}}" alt="No Image" class="rounded">
                </a>
            </div>

            <div class="col-md-8">
                <div class="card profile-card border-0 bg-transparent">
                    <div class="card-body">
                        <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                        <h4 class="profile-card-subtitle"><strong>Category:</strong> {{ $vendor->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</h4>
                        <h4 class="profile-card-subtitle"><strong>Email:</strong> {{$vendor->vendor->company_email}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Address:</strong> {{$vendor->vendor->company_address}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Country:</strong> {{$vendor->vendor->country->name}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Phone:</strong> {{$vendor->vendor->phone_number}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Status:</strong> {{ucfirst($vendor->vendor_type)}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Product Category:</strong> @foreach($vendor->vendor->product_category as $cat)
                            {{$cat}}
                            @endforeach</h4>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label class="profile-card-subtitle">
                                    <strong>Vendor status</strong>
                                </label>
                                <select name="vendor_type" id="vendor_status" class="form-control ">
                                    <option value="new" @if ($vendor->vendor_type=="new"){{"selected"}} @endif>New</option>
                                    <option value="approved" @if ($vendor->vendor_type=="approved"){{"selected"}} @endif>Approved</option>
                                    <option value="suspended" @if ($vendor->vendor_type=="suspended"){{"selected"}} @endif>Suspended</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label class="d-block profile-card-subtitle" style="visibility:hidden">save</label>
                                <button type="button" id="submitVendorStatus" class="btn btn-success "><span class="fa fa-send"> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="row">-->
<!--    <div class="col-md-4">-->
<!--        <a href="{{asset('/images/listing/img-1626175748.PNG')}}" target="_adimage">-->
<!--            <img src="{{asset('/images/listing/img-1626175748.PNG')}}" alt="No Image" class="rounded" width="300" height="300">-->
<!--        </a> -->
<!--    </div>-->
<!--    <div class="col-md-6">-->
<!--        <div class="page-content fade-in-up">-->
<!--            <div class="ibox">-->
<!--                <div class="ibox-head">-->
<!--                    <div class="ibox-title"> {{ucfirst($vendor->vendor->shop_name)}}</div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!-- <div class="row"> -->
<!--        <div class="col-md-4">-->
<!--            <div class="page-content fade-in-up">-->
<!--                <label for="">Category::</label>-->
<!--                <div class="ibox">-->
<!--                    <div class="ibox-head">-->
<!--                        <div class="ibox-title"> {{ $vendor->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div> -->
<!--        <div class="col-md-4">-->
<!--            <div class="page-content fade-in-up">-->
<!--                <label for="">Email::</label>-->
<!--                <div class="ibox">-->
<!--                    <div class="ibox-head">-->
<!--                        <div class="ibox-title"> {{$vendor->email}}</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-md-4">-->
<!--            <div class="page-content fade-in-up">-->
<!--                <label for="">Phone Number::</label>-->
<!--                <div class="ibox">-->
<!--                    <div class="ibox-head">-->
<!--                        <div class="ibox-title"> {{$vendor->phone_num}}</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!-- </div> -->
<!--</div>-->

<!--<div class="row">-->
<!--    <div class="col-lg-6 col-sm-12 form-group">-->
<!--        <label>Vendor status</label>-->
<!--        <select name="vendor_type" id="vendor_status" class="form-control ">-->
<!-- <option value="new" >New</option> -->
<!--            <option value="new" @if ($vendor->vendor_type=="new"){{"selected"}} @endif>New</option>-->
<!--            <option value="approved" @if ($vendor->vendor_type=="approved"){{"selected"}} @endif>Approved</option>-->
<!--            <option value="suspended" @if ($vendor->vendor_type=="suspended"){{"selected"}} @endif>Suspended</option>-->
<!-- <option value="approved" >Approve</option>
<!--            <option value="suspended" >Suspend</option> -->
<!--        </select>-->
<!--    </div>-->
<!--    <div class="col-lg-6 col-sm-12 form-group">-->
<!--        <button type="button" id="submitVendorStatus" class="btn btn-success "><span class="fa fa-send"> Save</button>-->
<!--    </div>-->
<!--</div> -->

<div class="row mt-5">
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-user icon-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="{{route('vendor.getVendorProfile',$vendor->username)}}" target="_blank">
                                Profile
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('vendor.getVendorProfile',$vendor->username)}}" target="_blank">
                        <i class="fa fa-refresh"></i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>


        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title">-->
        <!--                <a href="{{route('vendor.getVendorProfile',$vendor->username)}}" target="_blank">-->

        <!--                    Profile -->
        <!--                </a> -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-bar-chart icon-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="#" target="_blank">
                                Sales Report
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="#" target="_blank">
                        <i class="fa fa-refresh"></i>
                        View Report
                    </a>
                </div>
            </div>
        </div>
        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title">-->
        <!--                <a href="" target="_blank"> Sales Report -->
        <!--                </a> -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-product-hunt icon-danger"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="{{route('vendor.getVendorProducts',$vendor->username)}}" target="_blank">
                                Products
                            </a>
                            <span class="card-category-count">
                                : {{count($vendor->products)}}
                            </span>
                        </p>

                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('vendor.getVendorProducts',$vendor->username)}}" target="_blank">
                        <i class="fa fa-refresh"></i>
                        View Products
                    </a>
                </div>
            </div>
        </div>
        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title"> {{count($vendor->products)}}-->
        <!--                <a href="{{route('vendor.getVendorProducts',$vendor->username)}}" target="_blank"> Products -->
        <!--                </a> -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>

    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-bar-chart icon-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="{{route('vendor.getReport',$vendor->id)}} target=" _blank">Report</a>
                        </p>

                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('vendor.getReport',$vendor->id)}} target=" _blank">
                        <i class="fa fa-refresh"></i>
                        View Reports
                    </a>
                </div>
            </div>
        </div>
        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title"> -->
        <!--            <a href="{{route('vendor.getReport',$vendor->id)}}" target="_blank">Report </a>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-money icon-info"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a target="_blank">
                                Total Sales
                            </a>
                        </p>
                        <span class="card-category-count">
                        </span>

                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a>
                        <i class="fa fa-refresh"></i>
                        Updated
                    </a>
                </div>
            </div>
        </div>

        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title"> -->
        <!--                 Total Sales:: -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-money icon-info"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a target="_blank">
                                Paid Amount
                            </a>
                        </p>
                        <span class="card-category-count">
                        </span>

                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a>
                        <i class="fa fa-refresh"></i>
                        Updated
                    </a>
                </div>
            </div>
        </div>
        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title"> -->
        <!--                 Paid Amount:: Rs. -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-money icon-info"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a target="_blank">
                                Due Amount
                            </a>
                        </p>
                        <span class="card-category-count">
                        </span>

                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a>
                        <i class="fa fa-refresh"></i>
                        Updated
                    </a>
                </div>
            </div>
        </div>
        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title"> -->
        <!--                 Due Amount:: -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    <div class="col-md-12 mx-auto">
        <div class="pay-card text-right">
            <span class="btn changeStatus" data-vendor_id="{{$vendor->id}}">
                Pay Now
            </span>
        </div>
        <!--<div class="page-content fade-in-up">-->
        <!--    <div class="ibox">-->
        <!--        <div class="ibox-head">-->
        <!--            <div class="ibox-title"> -->
        <!--                <span class="btn btn-rounded btn-sm changeStatus" data-vendor_id="{{$vendor->id}}">-->
        <!--                    Pay Now-->
        <!--                </span>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>

</div>

<!-- Modal -->
@include('dashboard::admin.modals.paynowmodal')
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.message').fadeOut(3000);
        $('.delete').submit(function(e) {
            e.preventDefault();
            var message = confirm('Are you sure to delete');
            if (message) {
                this.submit();
            }
            return;
        });
        $('#submitVendorStatus').on('click', function() {
            var status = $('#vendor_status').val();
            var vendor_id = <?php echo $vendor->id ?>;
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



    });

    $(function() {
        $("#example1").DataTable();
    });

    function orders() {

        $.ajax({
            type: 'GET',
            url: '/api/getorders',

            success: function(response) {
                $('#appendOrder').html(response.html)
            },
            error: function(error) {
                $('#notification-bar').text('An error occurred');
            }
        });
    }

    orders()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.message').fadeOut(3000);
        $('.delete').submit(function(e) {
            e.preventDefault();
            var message = confirm('Are you sure to delete');
            if (message) {
                this.submit();
            }
            return;
        });


        $('body').on('click', '.changeStatus', function(e) {
            debugger
            var vendor_id = $(this).data('vendor_id');
            $('#paynowModal').modal('show');
            $('#create-category-form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "/api/createdue",
                    // headers: {
                    //     Authorization: "Bearer " + api_token
                    // },
                    type: "POST",
                    data: formData,
                    enctype: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'successful') {
                            html_options = '';
                            html_options += "<option value='" + response.data.id + "'>" + response.data.name + "</option>";
                            $('#category_id').append(html_options);
                            $('#paynowModal').modal('hide');
                            var modal_title = "Success";
                            modal_title = modal_title.fontcolor('green');
                            $('#popup-modal-body').append(response.message);
                            $('#popup-modal-title').append(modal_title);
                            $('#popup-modal-btn').addClass('btn-success');
                            $("#popupModal").modal('show');
                            location.reload();
                        }

                    }
                });

            });

            // }
        })






    });
</script>

@endsection