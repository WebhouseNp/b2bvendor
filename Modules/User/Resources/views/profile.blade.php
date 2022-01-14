@extends('layouts.admin')
@section('page_title')View Vendor Info @endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title"> Vendor</div>

        </div>
    </div>

    
        <form class="form form-responsive form-horizontal" action=""
            enctype="multipart/form-data" method="post">

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-12" id="get__print">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Vendor Information</div>
                                    <div class="ibox-tools">
                                    </div>
                                </div>
                                <div class="ibox-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Category</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->category}}" name="name" placeholder="Name"
                                            disabled>
                                    </div> 
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Shop Name</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->shop_name}}" name="name" placeholder="Name"
                                            disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->email}}" name="name" placeholder="Email"
                                            disabled>

                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Phone No</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->phone_num}}"
                                            name="phone" placeholder="Product phone Here" disabled>
                                        
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Representative Name</label>
                                        <input class="form-control" type="text" value="{{$vendor->vendor->representative_name}}"
                                            name="order_id" placeholder="Product order_id Here" disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Company Address</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->company_address}}"
                                            name="city" placeholder="Product city Here" disabled>
                                        
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Product Category</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->product_category}}"
                                            name="city" placeholder="Product city Here" disabled>
                                        
                                    </div>
                                    

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Name On Card</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->name_on_card}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>ID Card Number</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->id_card_number}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>category commission</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->category_commission}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>percentage</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->percentage}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>bank_name</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->bank_name}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>account_number</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->account_number}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>name_on_bank_acc</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->name_on_bank_acc}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>paypal_id</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->paypal_id}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>store_location</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->store_location}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>store_contact_number</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->store_contact_number}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>status</label>
                                        <input class="form-control" type="text"
                                            value="{{$vendor->vendor->status==1?'Active':'Inactive'}}"
                                            name="city"  disabled>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Vendor status</label>
                                        <select name="vendor_type" id="vendor_status" class="form-control ">
                                            <!-- <option value="new" >New</option> -->
                                            <option value="new" @if ($vendor->vendor_type=="new"){{"selected"}} @endif>New</option>
                                            <option value="approved" @if ($vendor->vendor_type=="approved"){{"selected"}} @endif>Approved</option>
                                            <option value="suspended" @if ($vendor->vendor_type=="suspended"){{"selected"}} @endif>Suspended</option>
                                            <!-- <option value="approved" >Approve</option>
                                            <option value="suspended" >Suspend</option> -->
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <button type="button" id="submitVendorStatus" class="btn btn-success "><span class="fa fa-send"> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
</div>
</form>
<!-- <button class="btn btn-sm print__button btn-primary">Print</button> -->

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
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
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
            $('#submitVendorStatus').on('click', function(){
            var status = $('#vendor_status').val();
            var vendor_id = <?php echo $vendor->id ?>;
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
        })
    
       
       
    });

    $(function () {
        $("#example1").DataTable();
    });

    function orders(){
        
        $.ajax({
		  type:'GET',
		  url:'/api/getorders',
		  
		  success:function(response) {
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

@endsection