@extends('layouts.admin')
@section('page_title')View Vendor Products @endsection

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
            <div class="ibox-title"> Vendor Products</div>
        </div>
    </div>
</div>
<div class="row">
    @foreach($user->products as $product) 
    <div class="col-md-4">
        <img src="{{asset('/images/listing/'.$product->image)}}" alt="No Image" class="rounded" width="150" height="150"> 
        <div class="">
            <strong>{{ucfirst($product->title)}}</strong>
            <div>
                Description:: {!!$product->highlight!!}
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection