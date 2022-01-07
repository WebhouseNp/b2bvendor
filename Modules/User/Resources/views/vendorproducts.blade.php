@extends('layouts.admin')
@section('page_title')View Vendor Products @endsection

@section('content')

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
        <img src="{{asset('/images/thumbnail/'.$product->image)}}" alt="No Image" class="rounded" width="150" height="150"> 
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