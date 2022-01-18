@extends('layouts.admin')
@section('page_title')Edit Vendor Info @endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <ul class="nav nav-tabs lavalamp" id="component-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#component-1-1" role="tab" aria-controls="component-1-1" aria-selected="true"><strong>Basic Profile Details</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-2" role="tab" aria-controls="component-1-2" aria-selected="false"><strong>About Company </strong></a>
                </li>
            </ul>
        </div>
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
                                        <!-- <a href="{{asset('/images/listing/'.$user->vendor->image)}}" target="_adimage">
                                            <img src="{{asset('images/listing/'.$user->vendor->image)}}" alt="No Image" class="rounded" >
                                        </a>  -->
                                        <label>Update Profile Image </label>
                                        <input id="fileUpload" class="form-control" value="" name="image" type="file">
                                        <br>
                                        <div id="wrapper" class="mt-2">
                                            <div id="image-holder">
                                                @if($user->vendor->image)
                                                <img src="{{asset('images/listing/'.$user->vendor->image)}}" alt="No Image" class="rounded" >
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-7">
                                        <div class="card profile-card border-0 bg-transparent">
                                            <div class="card-body">
                                                <h3 class="profile-card-title">{{ucfirst($user->vendor->shop_name)}}</h3>
                                                <h4 class="profile-card-subtitle"><strong>Category:</strong> {{ $user->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Email:</strong> {{$user->email}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Plan:</strong> {{ $user->vendor->plan=="basic_plan" ? 'Basic Plan' :$user->vendor->plan=="premium_plan" ? 'Premium Plan': 'Standard Plan' }}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Phone:</strong> {{$user->vendor->phone_number}}</h4>
                                                <h4 class="profile-card-subtitle"><strong>Status:</strong> {{ucfirst($user->vendor_type)}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <label>Country</label>
                               <select name="country_id" class="form-control">
                                    @foreach ($countries as $slug => $country)
                                    <option value="{{ $country->id }}" {{ $user->vendor->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Shop Name</label>
                                <input class="form-control" type="text"
                                value="{{$user->vendor->shop_name}}" name="shop_name" placeholder="Name"
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
                            <!-- <div class="col-lg-6 col-sm-12 form-group">
                                <label>Product Category</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->product_category}}"
                                    name="product_category" placeholder="Product Category Here" >
                                
                            </div> -->
                            

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
                            <!-- <div class="col-lg-6 col-sm-12 form-group">
                                <label>Category Commission</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->category_commission}}"
                                    name="category_commission"  >
                            </div> -->
                            <!-- <div class="col-lg-6 col-sm-12 form-group">
                                <label>Percentage</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->percentage}}"
                                    name="percentage"  >
                            </div> -->
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Bank Name</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->bank_name}}"
                                    name="bank_name"  >
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Account Number</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->account_number}}"
                                    name="account_number"  >
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Name On Bank Account</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->name_on_bank_acc}}"
                                    name="name_on_bank_acc"  >
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Paypal Id</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->paypal_id}}"
                                    name="paypal_id"  >
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Store Location</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->store_location}}"
                                    name="store_location"  >
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label>Store Contact Number</label>
                                <input class="form-control" type="text"
                                    value="{{$user->vendor->store_contact_number}}"
                                    name="store_contact_number"  >
                            </div>
                            
                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit"  class="btn btn-success "><span class="fa fa-send"> Update Profile</button>
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
                                    <textarea name="description" id="description" rows="5"
                                            placeholder="description Here" class="form-control"
                                            style="resize: none;">{{@$user->vendor->description}} </textarea>
                            </div> 
                            
                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit"  class="btn btn-success "><span class="fa fa-send"> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => 'description'])
@endsection