@extends('layouts.admin')
@section('page_title') Product @endsection

@section('styles')
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" /> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css" rel="stylesheet" /> -->
<!-- <link href="{{ asset('/assets/admin/tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" /> -->

@endsection


@section('content')

<div class="page-heading">
    <h1 class="page-title"> Product</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> Product</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title"> Product</div>
            <div>
                <a class="btn btn-info btn-md" href="#">All Products</a>
            </div>
        </div>
    </div>

    <div class="ibox-body" id="validation-errors">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </div>
    <form id="product-update-form">

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Product Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Product Title</strong></label>
                                        <input class="form-control" type="text" id="title" name="title" placeholder="Product Title Here">


                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Category</strong></label>

                                        <div class="input-group">
                                            <select name="category_id" id="category_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group d-none" id="sub_cat_div">
                                        <label><strong>Sub Category</strong></label>

                                        <select class="form-control " id="subcategory_id" name="subcategory_id">


                                        </select>
                                    </div>



                                    <!-- <div class="col-lg-12 col-sm-12 form-group">
                                            <label><strong>Offer</strong></label>
                                            <select name="offer_id" id="offer_id" class="form-control">

                                            </select>



                                        </div> -->
                                    <!-- <div class="col-lg-12 col-sm-12 form-group">
                                            <label><strong>Brand</strong></label>
                                            <select name="brand_id" id="brand_id" class="form-control">


                                            </select>


                                        </div> -->


                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Price</strong></label>
                                            <input class="form-control" type="text" id="price" value="" name="price" placeholder="Product Price">


                                        </div> -->
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label for=""><strong>Type</strong></label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="top">Top Product</option>
                                            <option value="new">New Arrivals</option>
                                            <option value="hot">Hot Products</option>
                                            <option value="whole_sale">Sasto Wholesale</option>
                                            <option value="none">None</option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> Discount</strong></label>
                                        <input class="form-control" type="text" id="discount" name="discount" placeholder="discount">
                                    </div> --}}
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> Shipping Charge</strong></label>
                                        <input class="form-control" type="text" id="shipping_charge" name="shipping_charge" value="" placeholder="shipping Charge">
                                    </div>

                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label for="browser"><strong>Choose unit :</strong></label>
                                        <input list="units" class="form-control" name="unit" id="unit">
                                        <datalist id="units">
                                            <option value="pcs">
                                            <option value="kg">
                                            <option value="m">
                                        </datalist>
                                    </div>
                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Stock Quantity</strong></label>
                                            <input class="form-control" type="text" id="quantity" name="quantity" placeholder="stock">


                                        </div> -->
                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> MOQ</strong></label>
                                            <input class="form-control" type="text" id="moq" name="moq" value="" name="price" placeholder="Minimum Order Quantity">


                                        </div> -->

                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                                <input type="checkbox" id="essential" name="essential" value="1">
                                                <span class="input-span"></span><strong>Essential</strong>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 form-group">
                                            <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                                <input type="checkbox" id="best_seller" name="best_seller" value="1">
                                                <span class="input-span"></span><strong>Best Seller</strong>
                                            </label>
                                        </div> -->
                                </div>
                                <!-- <div class="row"> -->

                                <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label for="">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="top">Top Product</option>
                                                <option value="new">New Arrivals</option>
                                                <option value="hot">Hot Categories</option>
                                                <option value="whole_sale">Sasto Wholesale</option>
                                                <option value="none">None</option>
                                            </select>
                                        </div> -->

                                <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Delivery Charge</strong></label>
                                            <input class="form-control" type="text" id="delivery_charge" name="delivery_charge" value="" placeholder="Delivery Charge">
                                        </div> -->
                                <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Shipping Charge</strong></label>
                                            <input class="form-control" type="text" id="shipping_charge" name="shipping_charge" value=""
                                                 placeholder="shipping Charge">
                                        </div> -->

                                <!-- </div> -->

                                <div class="col-lg-12 col-sm-12 form-group">
                                    <div class="col-md-12 mb-3 ">
                                        <label for="">
                                            <h5>Product Ranges</h5>

                                        </label>
                                        <a href="javascript:void(0);" class="add_button pull-right" title="add field"><img src="{{ asset('/images/add-icon.png') }}" /></a>

                                        <div class="field_wrapper">

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
                                                        <input type="text" name="from[]" value="{{ $range->from }}" placeholder="Range From" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="to[]" value="{{ $range->to }}" placeholder="Range To" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="prices[]" value="{{ $range->price }}" placeholder="Price" class="form-control" required>
                                                    </div>
                                                    <a href="javascript:void(0);" class="remove_button" title="remove field"><img src="{{ asset('/images/remove-icon.png') }}" /></a>

                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-body">
                                <h5>Descriptions</h5>
                                <div class="row">

                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Product Highlights</strong></label>
                                        <textarea name="highlight" id="highlight" rows="5" placeholder="Product Highlights Here" class="form-control" style="resize: none;"></textarea>

                                    </div>


                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Description</strong></label>
                                        <textarea name="description" id="description" rows="5" placeholder="description Here" class="form-control" style="resize: none;"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-body">
                                <h5>SEO Tools</h5>
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for=""><strong>Meta Title</strong></label>
                                            <textarea name="meta_title" id="meta_title" rows="3" class="form-control" placeholder="Meta Title" style="resize:none;"></textarea>

                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Meta Description</strong></label>
                                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Meta Description here" style="resize:none;"></textarea>

                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Keyword</strong></label>
                                            <textarea name="keyword" id="keyword" rows="3" class="form-control" placeholder="Meta Keyword here" style="resize:none;"></textarea>

                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Meta Keyphrase</strong></label>
                                            <textarea name="meta_keyphrase" id="meta_keyphrase" rows="3" class="form-control" placeholder="Meta Keyphrase here" style="resize:none;"></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">

                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="form-group">
                                    <label> Upload Main Banner [image size: width: 800px, height: 800px] [image type: jpg, jpeg, png] </label>
                                    <!-- <input class="form-control" type="file" name="image" id="image" accept="image/*"
                                        onchange="showThumbnail(this);"> -->
                                    <input class="form-control" name="image" type="file" id="fileUpload">
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status: </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input onclick="submitProductNow();" type="button" name="save" value="save" id="product_submit" class="btn btn-success">

                                    <!-- <button class="btn btn-success" type="submit"> <span class="fa fa-send"></span>Save</button> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

</div>

<!-- Modal -->
@include('dashboard::admin.modals.attributemodal')
@include('dashboard::admin.modals.categorymodal')

<div class="modal" id="popupModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="popup-modal-title" class="modal-title">
                    </h5>
            </div>
            <div class="modal-body">
                <div style="text-align: center;" id="popup-modal-body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
<?php
$name = ['meta_description', 'description', 'highlight'];
?>
@push('push_scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('/assets/admin/js/sweetalert.js') }}" type="text/javascript"></script>

@include('dashboard::admin.layouts._partials.imagepreview')

@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach

@endpush
@push('push_scripts')
<script>
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message +
                '</p>';
        });
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            html: html_error,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            // position: 'top-end',
            type: 'success',
            title: 'Done',
            html: message,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }

    function addcategory() {
        $('#categoryModal').modal('show');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#create-category-form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "/api/createcategory",
                type: "POST",
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 'successful') {
                        html_options = '';
                        html_options += "<option value='" + response.data.id + "'>" + response.data
                            .name + "</option>";
                        $('#category_id').append(html_options);
                        $('#categoryModal').modal('hide');
                        var modal_title = "Success";
                        modal_title = modal_title.fontcolor('green');
                        $('#popup-modal-body').append(response.message);
                        $('#popup-modal-title').append(modal_title);
                        $('#popup-modal-btn').addClass('btn-success');
                        $("#popupModal").modal('show');
                    }

                }
            });

        });

    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = `<div class="field_wrapper" style="margin-top:10px">
                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input  type="text"  name="from[]" value="" placeholder="Range From" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input  type="text"  name="to[]" value="" placeholder="Range To" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input  type="text"  name="prices[]" value="" placeholder="Price" class="form-control">
                                </div>
                                <a href="javascript:void(0);" class="remove_button" title="Add field"><img src="{{ asset('/images/remove-icon.png') }}"/></a>
                            </div>
                        </div>
                    </div>`;
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>
<script>
    $(document).ready(function(e) {

        function offers() {
            $.ajax({
                type: 'GET',
                url: '/api/getoffers',
                success: function(response) {
                    if (response.data) {
                        var html_options = "";
                        $.each(response.data, function(index, offer_data) {
                            html_options += "<option value='" + offer_data.id + "'>" +
                                offer_data.title + "</option>";
                        });
                        $('#offer_id').html(html_options);
                    }
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }

        offers()

        function brands() {
            $.ajax({
                type: 'GET',
                url: '/api/allbrands',
                success: function(response) {
                    if (response.data) {
                        var html_options = "";
                        $.each(response.data, function(index, cat_data) {
                            html_options += "<option value='" + cat_data.id + "'>" +
                                cat_data.title + "</option>";
                        });
                        $('#brand_id').html(html_options);
                    }
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }

        brands()

    });
</script>
<script>
    $(document).ready(function() {
        var id = <?php echo $id; ?>;

        function editproduct(id) {
            $.ajax({
                type: "get",

                url: "/api/editproduct",
                data: {
                    id: id
                },
                success: function(response) {
                    document.getElementById('title').value = response.data.title;
                    document.getElementById('status').value = response.data.status;
                    document.getElementById('type').value = response.data.type;
                    // document.getElementById('price').value = response.data.price;
                    // document.getElementById('moq').value = response.data.moq;
                    // document.getElementById('discount').value = response.data.discount;
                    CKEDITOR.instances['highlight'].setData(response.data.highlight);
                    CKEDITOR.instances.description.setData(response.data.description);
                    CKEDITOR.instances.meta_description.setData(response.data.meta_description);
                    // document.getElementById('quantity').value = response.data.quantity;
                    // if(response.data.delivery_charge){
                    //     document.getElementById('delivery_charge').value = response.data.delivery_charge;
                    // }
                    if (response.data.shipping_charge) {
                        document.getElementById('shipping_charge').value = response.data
                            .shipping_charge;
                    }
                    if (response.data.unit) {
                        document.getElementById('unit').value = response.data.unit;
                    }
                    document.getElementById('meta_title').value = response.data.meta_title;
                    document.getElementById('meta_description').value = response.data
                        .meta_description;
                    //    document.getElementById('meta_keyword').value = response.data.meta_keyword;
                    document.getElementById('meta_keyphrase').value = response.data.meta_keyphrase;
                    if (response.categories) {
                        var html_options = "<option value='" + response.data.category.id + "'>" +
                            response.data.category.name + "</option>";
                        $.each(response.categories, function(index, cat_data) {
                            if (cat_data.id != response.data.category.id) {
                                html_options += "<option value='" + cat_data.id + "'>" +
                                    cat_data.name + "</option>";
                            }
                            if (cat_data.does_contain_sub_category == 1) {
                                $('#sub_cat_div').removeClass('d-none');
                                var subcat_options = "";

                                $.each(response.subcategory, function(index, subcat_data) {
                                    // var subcat_options= "<option value='"+subcat_data.id+"'>"+subcat_data.name+"</option>";


                                    if (subcat_data.id != 0) {
                                        subcat_options += "<option value='" +
                                            subcat_data.id + "'>" + subcat_data
                                            .name + "</option>";
                                    }

                                });
                                $('#subcategory_id').html(subcat_options);
                            }
                        });
                        $('#category_id').html(html_options);
                    }
                    document.getElementById('image-holder').innerHTML =
                        '<img width="150" height="150" src="<?php echo URL::to('/') . '/images/listing/'; ?>' + response.data
                        .image + '">';

                    //    location.reload();
                }
            });
        }
        // }
        editproduct(id);

    });
</script>
<script>
    function getSubCategory() {
        var category_id = $('#category_id').val();
        if (category_id) {
            $.ajax({
                url: "/api/getsubcategory",
                type: "POST",
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    if (response.data) {
                        $('#sub_cat_div').removeClass('d-none');

                        var html_options = "<option value=''>select any one</option>";
                        $.each(response.data, function(index, subcat_data) {
                            html_options += "<option value='" + subcat_data.id + "'>" + subcat_data
                                .name + "</option>";
                        });
                        $('#subcategory_id').html(html_options);

                    } else {
                        $("#subcategory_id").empty();
                    }
                    if (response.category) {
                        $('#sub_cat_div').addClass('d-none');
                    }
                }
            });
        } else {
            $("#subcategory_id").empty();
        }
    }

    $(document).ready(function() {
        getSubCategory();
        $('#category_id').change(function() {

            getSubCategory();
        });

    });
</script>

<script>
    function submitProductNow() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var id = "<?php echo $id; ?>";
        var productCreateForm = document.getElementById("product-update-form");
        var formData = new FormData(productCreateForm);
        formData.append('id', id);
        $.ajax({
            type: 'POST',
            url: "/api/updateproduct",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'successful') {
                    window.location.href = "/product/approved-products";
                    var validation_errors = JSON.stringify(response.message);
                    $('#validation-errors').html('');
                    $('#validation-errors').append('<div class="alert alert-success">' + validation_errors +
                        '</div');
                } else if (response.status == 'unsuccessful') {
                    var validation_errors = JSON.stringify(response.data);
                    var response = JSON.parse(validation_errors);
                    $('#validation-errors').html('');
                    $.each(response, function(key, value) {
                        $('#validation-errors').append('<div class="alert alert-danger">' + value +
                            '</div');
                    });
                }
            }
        });
    }
</script>
@endpush