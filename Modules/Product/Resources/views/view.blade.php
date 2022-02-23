<?php
$user = Auth::user();
$api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') Product Details @endsection
@section('styles')

<link href="{{ asset('/assets/admin/vendors/DataTables/datatables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product Details</div>

                    <div class="ibox-tools">

                    </div>
                </div>

                <div class="ibox-body" style="">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Title</th>
                                <td><span id="title"></span>{{$product->title}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Slug</th>
                                <td>
                                    <div id="slug">{{$product->slug}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Image</th>
                                <td>
                                    @if($product->image)
                                    <img class="rounded" src="{{ $product->imageUrl('thumbnail') }}" style="width: 4rem;">
                                    @else
                                    <p>N/A</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Category</th>
                                <td>
                                    <div id="category">{{$product->productCategory->subcategory->category->name}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Sub Category</th>
                                <td>
                                    <div id="category">{{$product->productCategory->subcategory->name}}</div>
                                </td>
                            </tr>
                            <tr>
                            <th scope="row">Product Category</th>
                                <td>
                                    <div id="category">{{$product->productCategory->name}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Top Product</th>
                                <td>
                                    <div style="display:inline-block; width:100px" class="badge {{ $product->is_top==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                                        {{ $product->is_top == 1 ? 'Yes' : 'No' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"> New Arrival</th>
                                <td>
                                    <div style="display:inline-block; width:100px" class="badge {{ $product->is_new_arrival==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                                        {{ $product->is_new_arrival == 1 ? 'Yes' : 'No' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Shipping Charge</th>
                                <td>
                                    <div id="shipping_charge">{{$product->shipping_charge}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Units</th>
                                <td>
                                    <div id="unit">{{$product->unit}}</div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">Highlights</th>
                                <td>
                                    <div id="description">{!!$product->highlight!!}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Color</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('colors') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Size</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('size') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Payment Mode</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('payment_mode') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Country of Origin</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('country_of_origin') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Brand</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('brand') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Warranty</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('warranty') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Feature</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('feature') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Use</th>
                                <td>
                                    <div id="description">{{ $product->getOverviewData('use') }}</div>
                                </td>
                            </tr>


                            <tr>
                                <th scope="row">Status</th>
                                <td>
                                    <div style="display:inline-block; width:100px" class="badge {{ $product->status==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                                        {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Product Ranges</th>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-4">
                                <label for="">
                                    <strong> Range From</strong>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label for="">
                                    <strong> Range To</strong>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label for="">
                                    <strong> Price</strong>
                                </label>
                            </div>
                        </div>
                        @foreach ($product->ranges as $range)
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-4">
                                <input type="text" name="from[]" value="{{ $range->from }}" placeholder="Range From" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="to[]" value="{{ $range->to }}" placeholder="Range To" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="prices[]" value="{{ $range->price }}" placeholder="Price" class="form-control" disabled>
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

    </div>



</div>
<div class="row">
    @foreach ($product->productimage as $image)
    <div class="m-r-10">
        <a href="{{ asset('/uploads/product/other-image/' . $image->images) }}" target="_adimage">
            <img src="{{ asset('/uploads/product/other-image/' . $image->images) }}" alt="No Image" class="rounded" width="70">
        </a>
    </div>
    @endforeach
</div>
@endsection