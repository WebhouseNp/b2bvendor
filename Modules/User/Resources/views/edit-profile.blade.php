@extends('layouts.admin')
@section('page_title')Edit Vendor Info @endsection

@section('content')

<div class="page-heading">
    <h1 class="page-title"> Vendor</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> Vendor</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Vendor Profile</a></li>
                <li><a data-toggle="tab" href="#menu1">Description About Vendor</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="home" class="tab-pane fade active">
                <form method="post" action="{{route('updateVendorProfile',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
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
                                                    <select name="category" id="vendor_status" class="form-control " >
                                                        <option value="local_seller" @if ($user->vendor->category=="local_seller"){{"selected"}} @endif>Local Seller</option>
                                                        <option value="international_seller" @if ($user->vendor->category=="international_seller"){{"selected"}} @endif>International Seller</option>
                                                    </select>
                                                </div> 
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Plan</label>
                                                    <select name="plan" id="vendor_status" class="form-control " >
                                                        <option value="basic_plan" @if ($user->vendor->plan=="basic_plan"){{"selected"}} @endif>Basic Plan</option>
                                                        <option value="premium_plan" @if ($user->vendor->plan=="premium_plan"){{"selected"}} @endif>Premium Plan</option>
                                                        <option value="standard_plan" @if ($user->vendor->plan=="standard_plan"){{"selected"}} @endif>Standard Plan</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Image [max file size: 4MB] </label>
                                                    <input id="fileUpload" class="form-control" value="" name="image" type="file">
                                                    <br>
                                                    <div id="wrapper" class="mt-2">
                                                        <div id="image-holder">
                                                            @if($user->vendor->image)
                                                            <img src="{{asset('images/main/'.$user->vendor->image)}}" alt="" height="120px" width:"120px">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Shop Name</label>
                                                    <input class="form-control" type="text"
                                                    value="{{$user->vendor->shop_name}}" name="shop_name" placeholder="Name"
                                                    >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->email}}" name="email" placeholder="Email" disabled
                                                        >

                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Phone No</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->phone_number}}"
                                                        name="phone_number" placeholder="Product phone Here" >
                                                    
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Representative Name</label>
                                                    <input class="form-control" type="text" value="{{$user->vendor->representative_name}}"
                                                        name="representative_name" placeholder="Product order_id Here" >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Company Address</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->company_address}}"
                                                        name="company_address" placeholder="Company Address Here" >
                                                    
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Product Category</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->product_category}}"
                                                        name="product_category" placeholder="Product Category Here" >
                                                    
                                                </div>
                                                

                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Name On Card</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->name_on_card}}"
                                                        name="name_on_card"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>ID Card Number</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->id_card_number}}"
                                                        name="id_card_number"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>category commission</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->category_commission}}"
                                                        name="category_commission"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>percentage</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->percentage}}"
                                                        name="percentage"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>bank_name</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->bank_name}}"
                                                        name="bank_name"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>account_number</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->account_number}}"
                                                        name="account_number"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>name_on_bank_acc</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->name_on_bank_acc}}"
                                                        name="name_on_bank_acc"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>paypal_id</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->paypal_id}}"
                                                        name="paypal_id"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>store_location</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->store_location}}"
                                                        name="store_location"  >
                                                </div>
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>store_contact_number</label>
                                                    <input class="form-control" type="text"
                                                        value="{{$user->vendor->store_contact_number}}"
                                                        name="store_contact_number"  >
                                                </div>
                                                
                                                <div class="col-lg-6 col-sm-12 form-group">
                                                    <label>Vendor status</label>
                                                    <select name="vendor_type" id="vendor_status" class="form-control " disabled>
                                                        <option value="new" @if ($user->vendor_type=="new"){{"selected"}} @endif>New</option>
                                                        <option value="approved" @if ($user->vendor_type=="approved"){{"selected"}} @endif>Approved</option>
                                                        <option value="suspended" @if ($user->vendor_type=="suspended"){{"selected"}} @endif>Suspended</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 form-group">
                                                    <button type="submit"  class="btn btn-success "><span class="fa fa-send"> Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="menu1" class="tab-pane fade">
                <form method="post" action="{{route('updateVendorProfile',$user->vendor->id)}}" enctype="multipart/form-data">
                </form>
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