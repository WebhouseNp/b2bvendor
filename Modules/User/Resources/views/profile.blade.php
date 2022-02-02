@extends('layouts.admin')
@section('page_title')Edit Vendor Info @endsection
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <ul class="nav nav-tabs lavalamp" id="component-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#component-1-1" role="tab" aria-controls="component-1-1" aria-selected="true"><strong>Business Information</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-2" role="tab" aria-controls="component-1-2" aria-selected="false"><strong>About Company </strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-3" role="tab" aria-controls="component-1-3" aria-selected="false"><strong>User Information </strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-4" role="tab" aria-controls="component-1-4" aria-selected="false"><strong>Bank Details </strong></a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="component-1-content">
            <div class="tab-pane fade show active" id="component-1-1" role="tabpanel" aria-labelledby="component-1-1">

                <form method="post" action="{{route('vendor.updateVendorDetails',$user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    <div class="ibox-body">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><strong>Update Profile Image</strong> </label>
                                        <input id="fileUpload" class="form-control" value="" name="image" type="file">
                                        <br>
                                        <div id="wrapper" class="mt-2">
                                            <div id="image-holder">
                                                @if($user->vendor->image)
                                                <img src="{{asset('images/listing/'.$user->vendor->image)}}" alt="No Image" class="rounded">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Shop Name</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->shop_name}}" name="shop_name" placeholder="Enter Shop Name Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Company Email</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->company_email}}" name="company_email" placeholder="Enter Company Email Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Company Address</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->company_address}}" name="company_address" placeholder="Enter Company Address Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Phone Number</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->phone_number}}" name="phone_number" placeholder="Enter Phone Number Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="country_id">Country: </label>
                                        <select class="form-control select_group" id="country_id" name="country_id" style="width: 100%">
                                            @foreach($countries as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="business_type">Business Type: </label>
                                        <select class="form-control select_group" id="business_type" name="business_type" style="width: 100%">
                                            @foreach(config('constants.business_type') as $item)
                                            <option value="{{$item}}">
                                                {{ucfirst($item)}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="plan">Plan: </label>
                                        <select class="form-control select_group" id="plan" name="plan" style="width: 100%">
                                            <option value="standard_plan" @if ($user->vendor->plan=="standard_plan"){{"selected"}} @endif>Standard Plan </option>
                                            <option value="premium_plan" @if ($user->vendor->plan=="premium_plan"){{"selected"}} @endif>Premium Plan </option>
                                            <option value="basic_plan" @if ($user->vendor->plan=="basic_plan"){{"selected"}} @endif>Basic Plan </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="category">Select Category: </label>
                                        <select class="form-control select_group" id="category" name="category" style="width: 100%">
                                            <option value="local_seller" @if ($user->vendor->category=="local_seller"){{"selected"}} @endif>Local Seller </option>
                                            <option value="international_seller" @if ($user->vendor->category=="international_seller"){{"selected"}} @endif>International Seller </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label for="category_id">Category: </label><span> multiple select</span>
                                        <select class="form-control select_group" id="category_id" name="product_category[]" multiple style="width: 100%">
                                            @foreach($categories as $item)
                                            <option value="{{$item->name}}">
                                                {{$item->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><span class="fa fa-send"> Update Profile</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="tab-pane fade" id="component-1-2" role="tabpanel" aria-labelledby="component-1-2">
                <form method="post" action="{{route('vendor.updateVendorDescription',$user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group">
                                <label><strong>Description</strong></label>
                                <textarea name="description" id="description" rows="5" placeholder="description Here" class="form-control" style="resize: none;">{{@$user->vendor->description}} </textarea>
                            </div>

                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><span class="fa fa-send"> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="component-1-3" role="tabpanel" aria-labelledby="component-1-3">
                <form method="post" action="{{route('vendor.updateUserDesc',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Name</strong> </label>
                                <input class="form-control" type="text" value="{{$user->name}}" name="name" placeholder="Enter Name Here">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Email</strong> </label>
                                <input class="form-control" type="text" value="{{$user->email}}" name="email" placeholder="Enter your Email Address">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Designation</strong></label>
                                <input class="form-control" type="text" value="{{$user->designation}}" name="designation" placeholder="Enter your Designation Here">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Contact Number</strong></label>
                                <input class="form-control" type="text" value="{{$user->phone_num}}" name="phone_num" placeholder="Enter your Phone Number">
                            </div>


                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><span class="fa fa-send"> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="component-1-4" role="tabpanel" aria-labelledby="component-1-4">
                <form method="post" action="{{route('vendor.updateVendorBankDetails',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong> Name </strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->bank_name}}" name="bank_name" placeholder="Enter Bank Name Here">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Account Number </strong> </label>
                                <input class="form-control" type="text" value="{{$user->vendor->account_number}}" name="account_number" placeholder="Enter your Account Number">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong> Name On Bank Account </strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->name_on_bank_acc}}" name="name_on_bank_acc" placeholder="Enter your Name on Bank Account">
                            </div>
                            <div class="col-md-5">
                                <label><strong> Upload Image </strong> </label>
                                <input id="fileUpload" class="form-control" value="" name="bank_info_image" type="file">
                                <br>
                                <div id="wrapper" class="mt-2">
                                    <div id="image-holder">
                                        @if($user->vendor->bank_info_image)
                                        <img src="{{asset('images/listing/'.$user->vendor->bank_info_image)}}" alt="No Image" class="rounded">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><span class="fa fa-send"> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => 'description'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category_id').select2();

        $('#category_id option[selected]').remove();
    });
</script>
<script>
    $(document).ready(function() {

        $("#imageUpload").on('change', function() {

            if (typeof(FileReader) != "undefined") {

                var image_holder = $("#bank-info-image-holder");

                $("#bank-info-image-holder").children().remove();

                var reader = new FileReader();
                reader.onload = function(e) {

                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image",
                        "width": '100%',
                        "height": '50%'
                    }).appendTo(image_holder);

                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                alert("This browser does not support FileReader.");
            }
        });

    });
</script>
@endpush