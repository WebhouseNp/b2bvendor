@extends('layouts.admin')
@section('page_title')View Vendor Info @endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title"> {{ucfirst($vendor->vendor->shop_name)}} Profile Details</div>

        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <a href="{{asset('/images/listing/'.$vendor->vendor->image)}}" target="_adimage">
                    <img src="{{asset('images/listing/'.$vendor->vendor->image)}}" alt="No Image" class="rounded" >
                </a> 
            </div>
            
            <div class="col-md-8">
                <div class="card profile-card border-0 bg-transparent">
                    <div class="card-body">
                        <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                        <h4 class="profile-card-subtitle"><strong>Category:</strong> {{ $vendor->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</h4>
                        <h4 class="profile-card-subtitle"><strong>Email:</strong> {{$vendor->email}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Plan:</strong> {{ $vendor->vendor->plan=="basic_plan" ? 'Basic Plan' :$vendor->vendor->plan=="premium_plan" ? 'Premium Plan': 'Standard Plan' }}</h4>
                        <h4 class="profile-card-subtitle"><strong>Phone:</strong> {{$vendor->vendor->phone_number}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Address:</strong> {{$vendor->vendor->company_address}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Status:</strong> {{ucfirst($vendor->vendor_type)}}</h4>
                        <h4 class="profile-card-subtitle"><strong>Type of Product Sale:</strong> {{ucfirst($vendor->vendor->product_category)}}</h4>
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