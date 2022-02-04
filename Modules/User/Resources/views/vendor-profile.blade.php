@extends('layouts.admin')
@section('page_title')View Vendor Info @endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title"> Profile Details</div>

        </div>
    </div>
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

                <div class="ibox-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <label><strong> Profile Image</strong> </label>
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                            @if($vendor->vendor->image)
                                            <img src="{{asset('images/listing/'.$vendor->vendor->image)}}" alt="No Image" class="rounded">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="card profile-card border-0 bg-transparent">
                                        <div class="card-body">
                                            <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                                            <h4 class="profile-card-subtitle"><strong>Category:</strong> {{ $vendor->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Email:</strong>{{$vendor->vendor->company_email}}
                                            </h4>
                                            <h4 class="profile-card-subtitle"><strong>Address:</strong> {{$vendor->vendor->company_address}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Country:</strong> {{$vendor->vendor->country->name}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Plan:</strong> {{ $vendor->vendor->plan=="basic_plan" ? 'Basic Plan' :$vendor->vendor->plan=="premium_plan" ? 'Premium Plan': 'Standard Plan' }}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Phone:</strong> {{$vendor->vendor->phone_number}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Status:</strong> {{ucfirst($vendor->vendor_type)}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Business Type:</strong> {{ucfirst($vendor->vendor->business_type)}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Product Category:</strong>

                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="component-1-2" role="tabpanel" aria-labelledby="component-1-2">

                <div class="ibox-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 form-group">
                            {!! $vendor->vendor->description !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="component-1-3" role="tabpanel" aria-labelledby="component-1-3">
                <div class="ibox-body">
                    <div class="card profile-card border-0 bg-transparent">
                        <div class="card-body">
                            <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                            <h4 class="profile-card-subtitle"><strong>Name:</strong> {{ucfirst($vendor->name)}}</h4>
                            <h4 class="profile-card-subtitle"><strong>Email:</strong>{{$vendor->email}}</h4>
                            <h4 class="profile-card-subtitle"><strong>Designation:</strong> {{$vendor->designation}}</h4>
                            <h4 class="profile-card-subtitle"><strong>Contact Number:</strong> {{$vendor->phone_num}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="component-1-4" role="tabpanel" aria-labelledby="component-1-4">
                <div class="ibox-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card profile-card border-0 bg-transparent">
                                <div class="card-body">
                                    <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                                    <h4 class="profile-card-subtitle"><strong>Bank Name:</strong> {{$vendor->vendor->bank_name}}</h4>
                                    <h4 class="profile-card-subtitle"><strong>Branch Name:</strong>{{$vendor->vendor->branch_name}}</h4>
                                    <h4 class="profile-card-subtitle"><strong>Account Number:</strong> {{$vendor->vendor->account_number}}</h4>
                                    <h4 class="profile-card-subtitle"><strong>Account Holder's Name:</strong> {{$vendor->vendor->name_on_bank_acc}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                    @if($vendor->vendor->bank_info_image)
                                    <img src="{{asset('images/listing/'.$vendor->vendor->bank_info_image)}}" alt="No Image" class="rounded">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

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
                            <a href="{{route('editVendorProfile',$vendor->id)}}" target="_blank">
                                Edit Profile
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('editVendorProfile',$vendor->id)}}" target="_blank">
                        <i class="fa fa-refresh"></i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
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
                            <a href="{{route('product.index',['type'=>'approved-products'])}}" target="_blank">
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
                    <a href="{{route('product.index',['type'=>'approved-products'])}}" target="_blank">
                        <i class="fa fa-refresh"></i>
                        View Products
                    </a>
                </div>
            </div>
        </div>
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
    </div>
</div>
@endsection
@section('scripts')
@endsection