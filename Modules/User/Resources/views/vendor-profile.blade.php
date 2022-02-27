@extends('layouts.admin')
@section('page_title')View Vendor Info @endsection

@section('content')
@include('admin.section.notifications')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>Profile Details</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Profile Details</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if($vendor->vendor->image)
                            <img class="profile-user-img img-fluid img-circle" src="{{asset('images/listing/'.$vendor->vendor->image)}}" alt="User profile picture">
                            @endif
                        </div>
                        <h3 class="profile-username text-center">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                        <p class="text-muted text-center">{{ $vendor->vendor->category=="local_seller" ? 'Local Seller' : 'International Seller' }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Sales Report</b> <a class="float-right" href="{{route('salesReport')}}" target="_blank">View</a>
                            </li>
                            <li class="list-group-item">
                                <b>Products</b> <a class="float-right" href="{{route('product.index',['type'=>'all'])}}" >View</a>
                            </li>
                            <li class="list-group-item">
                                <b>Total Sales</b> <a class="float-right" href="{{route('product.index',['type'=>'all'])}}" >View</a>
                            </li>
                        </ul>
                        <a href="{{route('editVendorProfile',$vendor->id)}}" target="_blank" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="ibox">
                    <x-profile></x-profile>
                    <div class="ibox-body">
                        <div class="tab-content" id="component-1-content">
                            <div class="tab-pane fade show active" id="component-1-1" role="tabpanel" aria-labelledby="component-1-1">

                                <div class="row">
                                    <!-- <div class="col-md-5">
                                        <label><strong> Profile Image</strong> </label>
                                        <div id="wrapper" class="mt-2">
                                            <div id="image-holder">
                                                @if($vendor->vendor->image)
                                                <img src="{{asset('images/listing/'.$vendor->vendor->image)}}" alt="No Image" class="rounded">
                                                @endif
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 mb-4">
                                                <label class="title-label">Category</label>
                                                <div class="text-capitalize">{{ Str::replace('_', ' ', $vendor->vendor->category) }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Email</label>
                                                <div>{{ $vendor->vendor->company_email }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Address</label>
                                                <div>{{ $vendor->vendor->company_address }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Country</label>
                                                <div>{{ $vendor->vendor->country->name }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Plan</label>
                                                <div class="text-capitalize">{{ Str::replace('_', ' ', $vendor->vendor->plan) }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Phone</label>
                                                <div>{{ $vendor->vendor->phone_number }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Status</label>
                                                <div>{{ ucfirst($vendor->vendor_type) }}</div>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label class="title-label">Business Type</label>
                                                <div>{{ ucfirst($vendor->vendor->business_type) }}</div>
                                              </div>
                                              <div class="col-md-12 mb-4">
                                                <label class="title-label">Type of Product</label>
                                                <div>
                                                    @foreach($vendor->vendor->categories as $cat)
                                                    {{ $cat->name }}
                                                    @if(!$loop->last)
                                                    <span>,</span>
                                                    @endif
                                                    @endforeach
                                                </div>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="component-1-2" role="tabpanel" aria-labelledby="component-1-2">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        {!! $vendor->vendor->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="component-1-3" role="tabpanel" aria-labelledby="component-1-3">
                                <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                                <h4 class="profile-card-subtitle"><strong>Name:</strong> {{ucfirst($vendor->name)}}</h4>
                                <h4 class="profile-card-subtitle"><strong>Email:</strong>{{$vendor->email}}</h4>
                                <h4 class="profile-card-subtitle"><strong>Designation:</strong> {{$vendor->designation}}</h4>
                                <h4 class="profile-card-subtitle"><strong>Contact Number:</strong> {{$vendor->phone_num}}</h4>

                            </div>
                            <div class="tab-pane fade" id="component-1-4" role="tabpanel" aria-labelledby="component-1-4">
                                <div class="ibox-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                                            <h4 class="profile-card-subtitle"><strong>Bank Name:</strong> {{$vendor->vendor->bank_name}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Branch Name:</strong>{{$vendor->vendor->branch_name}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Account Number:</strong> {{$vendor->vendor->account_number}}</h4>
                                            <h4 class="profile-card-subtitle"><strong>Account Holder's Name:</strong> {{$vendor->vendor->name_on_bank_acc}}</h4>

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
            </div>
        </div>
    </div>
</section>

<!-- <div class="page-content fade-in-up">
    <div class="ibox">
        <x-profile></x-profile>
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
                                                @foreach($vendor->vendor->categories as $cat)
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
</div> -->

<!-- <div class="row mt-5">
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
                            <a href="{{route('salesReport')}}" target="_blank">
                                Sales Report
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('salesReport')}}" target="_blank">
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
                            <a href="{{route('product.index',['type'=>'all'])}}" target="_blank">
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
                    <a href="{{route('product.index',['type'=>'all'])}}" target="_blank">
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
</div> -->
@endsection
@section('scripts')
@endsection