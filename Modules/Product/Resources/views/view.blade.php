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
                                    <div id="category"></div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"> Product Type</th>
                                <td>
                                    <div style="display:inline-block; width:100px" class="badge {{ $product->type=='is_top' ? 'bg-primary' : 'badge-success' }} text-capitalize">
                                        {{ $product->status == 'is_top' ? 'Top Product' : 'New Arrival' }}
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
                                <th scope="row">Description</th>
                                <td>
                                    <div id="description">{!!$product->description!!}</div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">Color</th>
                                <td>
                                    <div id="description">{{$product->overview->colors}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Size</th>
                                <td>
                                    <div id="description">{{$product->overview->size}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Payment Mode</th>
                                <td>
                                    <div id="description">{{$product->overview->payment_mode}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Country of Origin</th>
                                <td>
                                    <div id="description">{{$product->overview->country_of_origin}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Warranty</th>
                                <td>
                                    <div id="description">{{$product->overview->warranty}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Feature</th>
                                <td>
                                    <div id="description">{{$product->overview->feature}}</div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Use</th>
                                <td>
                                    <div id="description">{{$product->overview->use}}</div>
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
@section('scripts')
<!-- <script>
    $(document).ready(function() {
        var id = <?php echo $id; ?>;
        var api_token = '<?php echo $api_token; ?>';

        function viewproduct(id) {
            $.ajax({
                type: "get",
                url: "/api/view-product",
                data: {
                    id: id
                },
                headers: {
                    Authorization: "Bearer " + api_token
                },
                success: function(response) {
                    console.log(response.data)
                    document.getElementById('title').innerHTML = response.data.title;
                    document.getElementById('slug').innerHTML = response.data.slug;
                    if(response.data.is_top == 1){
						document.getElementById('is_top').innerHTML = '<span class="label label-success">Yes</span>';
					}
					else if(response.data.is_top == 0){
						document.getElementById('is_top').innerHTML = '<span class="label label-danger">No</span>';
					}
                    if(response.data.is_new_arrival == 1){
						document.getElementById('is_new_arrival').innerHTML = '<span class="label label-success">Yes</span>';
					}
					else if(response.data.is_new_arrival == 0){
						document.getElementById('is_new_arrival').innerHTML = '<span class="label label-danger">No</span>';
					}
                    // document.getElementById('price').innerHTML = response.data.price;
                    // document.getElementById('discount').innerHTML = response.data.discount;
                    // document.getElementById('moq').innerHTML = response.data.moq;
                    document.getElementById('category').innerHTML = response.data.category.name;
                    if (response.data.shipping_charge) {
                        document.getElementById('shipping_charge').innerHTML = response.data
                            .shipping_charge;
                    }
                    if (response.data.unit) {
                        document.getElementById('unit').innerHTML = response.data.unit;
                    }
                    //  document.getElementById('offer').innerHTML = response.data.offer.title;
                    //  document.getElementById('brand').innerHTML = response.data.brand.title;

                    document.getElementById('highlight').innerHTML = response.data.highlight;
                    document.getElementById('description').innerHTML = response.data.description;
                    document.getElementById('type').innerHTML = response.data.type;
                    if (response.data.status == 'active') {
                        document.getElementById('status').innerHTML =
                            '<span class="label label-success">Active</span>';
                    } else if (response.data.status == 'inactive') {
                        document.getElementById('status').innerHTML =
                            '<span class="label label-danger">Inactive</span>';
                    }
                    document.getElementById('image').innerHTML =
                        '<img width="150" height="150" src="<?php echo URL::to('/') . '/images/thumbnail/'; ?>' + response.data
                        .image + '">';
                }
            });
        }
        viewproduct(id);
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script> -->

@endsection