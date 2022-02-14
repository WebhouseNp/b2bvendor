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
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 col-md-6">
                        <div class="icon">
                            @if($product->image)
                            <img src="{{asset('/images/thumbnail/'.$product->image)}}" alt="No Image" class="rounded" width="150" height="150">
                            @else
                            <div class="icon">
                                <i class="fa fa-product-hunt"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-5 col-md-6">
                        <strong> {{Str::limit($product->title, 100, $end='.......')}} </strong>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a>
                        {{strip_tags(Str::limit($product->highlight, 100, $end='.......'))}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection