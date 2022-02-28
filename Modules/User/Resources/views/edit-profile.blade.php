@extends('layouts.admin')
@section('page_title')Edit Vendor Info @endsection
@section('content')
@include('admin.section.notifications')
@if($errors->any())
<div class="alert alert-danger">
    <p><strong>Opps Something went wrong</strong></p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>Edit Profile</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    {{-- <div class="card-header p-2"> --}}
                        <x-profile></x-profile>
                    {{-- </div> --}}
                    <div class="ibox-body">
                        <div class="tab-content" id="component-1-content">
                            <div class="tab-pane fade show active" id="component-1-1" role="tabpanel" aria-labelledby="component-1-1">

                                <form method="post" action="{{route('updateVendorProfile',$user->vendor->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')

                                    <div class="ibox-body">
                                        <div class="row">
                                            <div class="col-md-5">
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

                                            <div class="col-md-7">

                                                <h3 class="profile-card-title">{{ucfirst($user->vendor->shop_name)}}</h3>
                                                <h4 class="profile-card-subtitle"><strong>Category:</strong> {{ $user->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Email:</strong>
                                                    <input class="form-control form-control-sm" type="text" value="{{$user->vendor->company_email}}" name="company_email" placeholder="Company Email Here ">
                                                </h4>
                                                <h4 class="profile-card-subtitle"><strong>Address:</strong> {{$user->vendor->company_address}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Country:</strong> {{$user->vendor->country->name}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Plan:</strong> {{ $user->vendor->plan=="basic_plan" ? 'Basic Plan' :$user->vendor->plan=="premium_plan" ? 'Premium Plan': 'Standard Plan' }}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Phone:</strong> {{$user->vendor->phone_number}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Status:</strong> {{ucfirst($user->vendor_type)}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Business Type:</strong> {{ucfirst($user->vendor->business_type)}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Product Category:</strong>
                                                    @foreach($user->vendor->categories as $cat)
                                                    @if(!$loop->last)
                                                    {{ $cat->name }},
                                                    @endif
                                                    @if($loop->last)
                                                    {{ $cat->name }}
                                                    @endif
                                                    @endforeach
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-12 col-sm-12 form-group">
                                                <button type="submit" class="btn btn-success "><span class="fa fa-send"> Update Profile</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane fade" id="component-1-2" role="tabpanel" aria-labelledby="component-1-2">
                                <form method="post" action="{{route('updateVendorDesc',$user->vendor->id)}}" enctype="multipart/form-data">
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
                                <form method="post" action="{{route('updateUserDesc',$user->vendor->id)}}" enctype="multipart/form-data">
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
                                                <input class="form-control" type="text" value="{{$user->email}}" name="email" placeholder="Enter your Email Address" disabled>
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
                                <form method="post" action="{{route('updateVendorBankDetails',$user->vendor->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="ibox-body">
                                        <div class="row">
                                            <div class="col-lg-8 col-sm-12 form-group">
                                                <label><strong>Bank Name </strong></label>
                                                <input class="form-control" type="text" value="{{$user->vendor->bank_name}}" name="bank_name" placeholder="Enter Bank Name Here" @if($user->vendor->bank_name) disabled @endif>
                                            </div>
                                            <div class="col-lg-8 col-sm-12 form-group">
                                                <label><strong>Branch Name </strong></label>
                                                <input class="form-control" type="text" value="{{$user->vendor->branch_name}}" name="branch_name" placeholder="Enter Branch Name Here" @if($user->vendor->branch_name) disabled @endif>
                                            </div>
                                            <div class="col-lg-8 col-sm-12 form-group">
                                                <label><strong>Account Number </strong> </label>
                                                <input class="form-control" type="text" value="{{$user->vendor->account_number}}" name="account_number" placeholder="Enter your Account Number" @if($user->vendor->account_number) disabled @endif>
                                            </div>
                                            <div class="col-lg-8 col-sm-12 form-group">
                                                <label><strong> Account Holder's Name</strong></label>
                                                <input class="form-control" type="text" value="{{$user->vendor->name_on_bank_acc}}" name="name_on_bank_acc" placeholder="Enter your Name on Bank Account" @if($user->vendor->name_on_bank_acc) disabled @endif>
                                            </div>
                                            <div class="col-md-5">
                                                <label><strong> Upload Cheque Image with All Bank Detail Shown Clearly </strong> </label>
                                                <input class="form-control" name="bank_info_image" type="file" id="imageUpload" @if($user->vendor->bank_info_image) disabled @endif>
                                                <br>
                                                <div id="wrapper" class="mt-2">
                                                    <div id="bank-info-image-holder">
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
                        <div class=" bg-light text-center">
                            <h5>Note: Please Contact Admin to update uneditable Information!</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <div class="page-content fade-in-up">
    <div class="ibox">
        <x-profile></x-profile>
        <div class="tab-content" id="component-1-content">
            <div class="tab-pane fade show active" id="component-1-1" role="tabpanel" aria-labelledby="component-1-1">

                <form method="post" action="{{route('updateVendorProfile',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    <div class="ibox-body">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
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

                                    <div class="col-md-7">
                                        <div class="card profile-card border-0 bg-transparent">
                                            <div class="card-body">
                                                <h3 class="profile-card-title">{{ucfirst($user->vendor->shop_name)}}</h3>
                                                <h4 class="profile-card-subtitle"><strong>Category:</strong> {{ $user->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Email:</strong>
                                                    <input class="form-control form-control-sm" type="text" value="{{$user->vendor->company_email}}" name="company_email" placeholder="Company Email Here ">
                                                </h4>
                                                <h4 class="profile-card-subtitle"><strong>Address:</strong> {{$user->vendor->company_address}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Country:</strong> {{$user->vendor->country->name}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Plan:</strong> {{ $user->vendor->plan=="basic_plan" ? 'Basic Plan' :$user->vendor->plan=="premium_plan" ? 'Premium Plan': 'Standard Plan' }}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Phone:</strong> {{$user->vendor->phone_number}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Status:</strong> {{ucfirst($user->vendor_type)}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Business Type:</strong> {{ucfirst($user->vendor->business_type)}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Product Category:</strong>
                                                    @foreach($user->vendor->categories as $cat)
                                                    @if(!$loop->last)
                                                    {{ $cat->name }},
                                                    @endif
                                                    @if($loop->last)
                                                    {{ $cat->name }}
                                                    @endif
                                                    @endforeach
                                                </h4>
                                            </div>
                                        </div>
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
                <form method="post" action="{{route('updateVendorDesc',$user->vendor->id)}}" enctype="multipart/form-data">
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
                <form method="post" action="{{route('updateUserDesc',$user->vendor->id)}}" enctype="multipart/form-data">
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
                                <input class="form-control" type="text" value="{{$user->email}}" name="email" placeholder="Enter your Email Address" disabled>
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
                <form method="post" action="{{route('updateVendorBankDetails',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Bank Name </strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->bank_name}}" name="bank_name" placeholder="Enter Bank Name Here" @if($user->vendor->bank_name) disabled @endif>
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Branch Name </strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->branch_name}}" name="branch_name" placeholder="Enter Branch Name Here" @if($user->vendor->branch_name) disabled @endif>
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Account Number </strong> </label>
                                <input class="form-control" type="text" value="{{$user->vendor->account_number}}" name="account_number" placeholder="Enter your Account Number" @if($user->vendor->account_number) disabled @endif>
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong> Account Holder's Name</strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->name_on_bank_acc}}" name="name_on_bank_acc" placeholder="Enter your Name on Bank Account" @if($user->vendor->name_on_bank_acc) disabled @endif>
                            </div>
                            <div class="col-md-5">
                                <label><strong> Upload Cheque Image with All Bank Detail Shown Clearly </strong> </label>
                                <input class="form-control" name="bank_info_image" type="file" id="imageUpload" @if($user->vendor->bank_info_image) disabled @endif>
                                <br>
                                <div id="wrapper" class="mt-2">
                                    <div id="bank-info-image-holder">
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
        <div class=" bg-light text-center">
            <h5>Note:: Please Contact Admin to update uneditable Information!</h5>
        </div>
    </div>
</div> -->

@endsection

@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => 'description'])
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