@extends('layouts.admin')
@section('page_title')  Product @endsection

@section('styles')
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" /> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css" rel="stylesheet" /> -->
<!-- <link href="{{asset('/assets/admin/tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" /> -->

@endsection


@section('content')

<div class="page-heading">
    <h1 class="page-title"> Product</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item">  Product</li>
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

    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
    <form id="product-create-form">
        
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
                                            <input class="form-control" type="text"
                                                
                                                name="title" placeholder="Product Title Here">

                                            
                                        </div>
                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <label><strong>Category</strong></label>
                                            
                                            <div class="input-group">
                                                <select name="category_id" id="category_id" class="form-control">
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-success" onClick="addcategory()" type="button"><i class="fa fa-plus"></i></button>
                                                
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 form-group d-none" id="sub_cat_div">
                                            <label><strong>Sub Category</strong></label>
               
                                            <select class="form-control " id="subcategory_id" name="subcategory_id">
                          
                        
                                            </select>
                                        </div>

                                        

                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <label><strong>Offer</strong></label>
                                            <select name="offer_id" id="offer_id" class="form-control">
                                                
                                            </select>


                                            
                                        </div>
                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <label><strong>Brand</strong></label>
                                            <select name="brand_id" id="brand_id" class="form-control">

                                                
                                            </select>

                                            
                                        </div>
                                        
                                        
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> Price</strong></label>
                                        <input class="form-control" type="text" id="price_box"
                                            value=""
                                            name="price" placeholder="Product Price">

                                       
                                    </div>
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> Discount</strong></label>
                                        <input class="form-control" type="text" id="discount_bx"
                                            
                                            name="discount" placeholder="discount">

                                       
                                    </div>
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> Stock Quantity</strong></label>
                                        <input class="form-control" type="text" 
                                            
                                            name="quantity" placeholder="stock">

                                        
                                    </div>
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> MOQ</strong></label>
                                        <input class="form-control" type="text" id="moq" name="moq"
                                            value=""
                                            name="price" placeholder="Minimum Order Quantity">

                                       
                                    </div>

                                    <div class="col-lg-4 col-sm-12 form-group">
                                    <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                        <input type="checkbox" id="essential" name="essential" value="1"
                                            >
                                        <span class="input-span"></span><strong>Essential</strong>
                                    </label>
                                </div>
                                <div class="col-lg-4 col-sm-12 form-group">
                                    <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                        <input type="checkbox" id="best_seller" name="best_seller" value="1"
                                            >
                                        <span class="input-span"></span><strong>Best Seller</strong>
                                    </label>
                                </div>
                                </div>
                            <div class="row">
                                
                                <div class="col-lg-4 col-sm-12 form-group">
                                    <label for="">Type</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="top" >Top Product</option>
                                        <option value="new" >New Arrivals</option>
                                        <option value="hot" >Hot Categories</option>
                                        <option value="whole_sale" >Sasto Wholesale</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>

                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12">
                                  <label for="title"><h5 class="mb-0">Choose Product Type</h5></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" aria-label="title" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                                            <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            
                            <!-- <div class="row">
                                <div class="col-md-12 mb-3 ">
                                    <label for=""><h5 class="mb-0">Choose Product Type</h5></label>
                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <input type="radio" class="product-value" name="product_type" id="standard-product" value="standard_product" checked>  Standard Product
                                        <input type="radio" class="product-value" name="product_type" id="variant-product" value="variant_product">  Variant Product
                                    </div>
                                </div>
                            </div> -->
                            
                            <!-- <div class="row standard">

                                                
                            </div>
                            <div class="mb-3 bg-white rounded p-3 " >
                                <div id="addvariantsection" class="row d-none" >
                                    <div class="col-5">
                                        <h5>Add Product Variants</h5>
                                    </div>
                                    <div class="col-7">
                                        <div onClick="addproductvariant()">Add PRoduct Variant</div>
                                        
                                        <!-- <button class="btn btn-primary pull-right " onClick="addproductvariant()"><i
                                         class="fa fa-plus"></i> Add Product Variant</button> -->
                                    <!-- <span   class="btn btn-primary btn-sm pull-right" id="addproductvariant" ><i
                                         class="fa fa-plus"></i>Add Product Variant</span> -->
                                        <!-- <button class="btn btn-primary pull-right addproductvariant" >Add Product Variant</button> -->
                                    <!-- </div>
                                </div> -->
                                <!-- <div class="row variant">

                                </div> -->

                                                
                            <!-- </div> --> 
                            

                        </div>
                    </div>
                     <div class="ibox">
                        <div class="ibox-body">
                            <h5>Descriptions</h5>
                            <div class="row">

                                <div class="col-lg-12 col-sm-12 form-group">
                                    <label><strong>Product Highlights</strong></label>
                                    <textarea name="highlight" id="highlight" rows="5"
                                        placeholder="Product Highlights Here" class="form-control"
                                        style="resize: none;"></textarea>
                                   
                                </div>


                                <div class="col-lg-12 col-sm-12 form-group">
                                    <label><strong>Description</strong></label>
                                    <textarea name="description" id="description" rows="5"
                                        placeholder="description Here" class="form-control"
                                        style="resize: none;"></textarea>
                                    
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
                                        <textarea name="meta_title" id="meta_title" rows="3" class="form-control"
                                            placeholder="Meta Title"
                                            style="resize:none;"></textarea>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for=""><strong>Meta Description</strong></label>
                                        <textarea name="meta_description" id="meta_description" rows="3"
                                            class="form-control" placeholder="Meta Description here"
                                            style="resize:none;"></textarea>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for=""><strong>Keyword</strong></label>
                                        <textarea name="keyword" id="keyword" rows="3" class="form-control"
                                            placeholder="Meta Keyword here"
                                            style="resize:none;"></textarea>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for=""><strong>Meta Keyphrase</strong></label>
                                        <textarea name="meta_keyphrase" id="meta_keyphrase" rows="3"
                                            class="form-control" placeholder="Meta Keyphrase here"
                                            style="resize:none;"></textarea>
                                       
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
                                <label> Upload Main Banner [image size: width: 720px, height: 1080px] </label>
                                <!-- <input class="form-control" type="file" name="image" id="image" accept="image/*"
                                    onchange="showThumbnail(this);"> -->
                                    <input class="form-control"  name="image" type="file" id="fileUpload">
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                        </div>
                                    </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="status" >Status: </label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit"> <span class="fa fa-send"></span>
                                    Save</button>
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
        <h3 id="popup-modal-title" class="modal-title"></h5>
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
$name = ['meta_description','description','highlight'];
 ?>
@push('push_scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script type="text/javascript" src="{{asset('/assets/admin/tagsinput/bootstrap-tagsinput.js')}}"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.js"></script> -->

@include('dashboard::admin.layouts._partials.imagepreview')

@foreach($name as $data)
  @include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach

@endpush

@section('scripts')

<script>
    
function preventAlph(className){
    $(className).keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
}
    var class_name = $('#price_box, #discount_bx');
    preventAlph(class_name);


    function showThumbnail(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e){
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

function FailedResponseFromDatabase(message){
    html_error = "";
    $.each(message, function(index, message){
        html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> '+message+ '</p>';
    });
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        html:html_error ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}

</script>
<script>
$(document).ready(function (e) {
  function brands(){
        
        $.ajax({
		  type:'GET',
		  url:'/api/allbrands',
		  
		  success:function(response) {
              if(response.data){
                    var html_options= "<option value=''>select any one</option>";
                    $.each(response.data, function(index,cat_data){
                        html_options += "<option value='"+cat_data.id+"'>"+cat_data.title+"</option>";
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
$(document).ready(function (e) {

function offers(){
        
        $.ajax({
		  type:'GET',
		  url:'/api/getoffers',
		  
		  success:function(response) {
              if(response.data){
                    var html_options= "<option value=''>select any one</option>";
                    $.each(response.data, function(index,offer_data){
                        html_options += "<option value='"+offer_data.id+"'>"+offer_data.title+"</option>";
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

});
</script>

<script>
$(document).ready(function (e) {

function categories(){
        
        $.ajax({
		  type:'GET',
		  url:'/api/getcategories',
		  
		  success:function(response) {
              if(response.data){
                    var html_options= "<option value=''>select any one</option>";
                    $.each(response.data, function(index,cat_data){
                        html_options += "<option value='"+cat_data.id+"'>"+cat_data.name+"</option>";
                    });
                    $('#category_id').html(html_options);
                }
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    categories()

});
</script>
<!-- <script >
    $(document).ready(function(){
        var productValue = $("input[name='product_type']:checked").val()
        if (productValue === 'standard_product') {
            
                $('.standard').append(
                    `<div class="form-group col-sm-12 col-md-4 other_label"><label  for="other_desc">Purchase Price</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                    <div class="form-group col-sm-12 col-md-4" other_label><label  for="other_desc">Selling price</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                    <div class="form-group col-sm-12 col-md-4" other_label><label  for="other_desc">SKU</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                    <div class="form-group col-sm-12 col-md-4 other_label"><label  for="other_desc">Bar Code</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                    <div class="form-group col-sm-12 col-md-4 other_label"><label  for="other_desc">ReOrder</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                    `
                );
            } 
            $('.product-value').click(function() {
                var productValue = $("input[name='product_type']:checked").val()
                if (productValue === 'standard_product') 
                {
                    $("#addvariantsection").empty();
                    $('.standard').append(
                        `<div class="form-group col-sm-12 col-md-4 other_label"><label  for="other_desc">Purchase Price</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                        <div class="form-group col-sm-12 col-md-4" other_label><label  for="other_desc">Selling price</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                        <div class="form-group col-sm-12 col-md-4" other_label><label  for="other_desc">SKU</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                        <div class="form-group col-sm-12 col-md-4 other_label"><label  for="other_desc">Bar Code</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                        <div class="form-group col-sm-12 col-md-4 other_label"><label  for="other_desc">ReOrder</label><input type="text" class="form-control other_class"  name="other_desc" value="" ></div>
                        `
                    );
                }
                if (productValue === 'variant_product') {
                    $(".standard").empty();
                //    var attr =  $('#addvariantsection').removeClass('d-none');
                //    console.log(attr.html())

                    // $('.variant').append(
                    //     '<label class="other_label" for="other_desc">Others Description</label><input type="text" class="form-control other_class"  name="other_desc" placeholder="Please Specify ..." value=" " >'
                    // );
                    $.ajax({
		  type:'GET',
		  url:'/api/getproductattributes',
		  
		  success:function(response) {
              if(response.data){
                    // var html_options = `<div class="row">
                    //                 <div class="col-5">
                    //                     <h5>Add Product Variants</h5>
                    //                 </div>
                    //                 <div class="col-7">
                    //                     <a href="#"  class="btn btn-primary btn-sm pull-right addproductvariant" ><i
                    //                     class="fa fa-plus"></i>Add Product Variant</a>
                    //                     <button class="btn btn-success addStock" >+</button>
                    //                 </div>
                    //             </div>
                    //             `;
                    var attr = $('#addvariantsection').removeClass('d-none');
                    var html_options = attr.html();
                    $.each(response.data, function(index,attr_data){
                        html_options += " <div class='form-group col-sm-12'><div class='input-group input-group-lg'>    <label for='title'><h5 class='mb-0'>"+attr_data.title+"</h5></label> <br> <div class='input-group'>    <input type='text' id='inputtags' class='form-control' name="+attr_data.title+" >      <div class='input-group-prepend'><i class='input-group-text fa fa-plus'></i></div>      <div class='input-group-prepend'><i class='input-group-text fa fa-trash'></i></div> </div>   </div></div>"
                    //    html_options += "<div class='form-group col-sm-12 '><label>"+attr_data.title+"</label><input type='text'  value='Amsterdam,Washington,Sydney,Beijing,Cairo' class='form-control inputTags'  name="+attr_data.title+" data-role='tagsinput'  ></div>"
                    });
                    $('#addvariantsection ').html(html_options);

                }
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
                } 

            })
       
         
   });
</script> -->
<script>
    
    
    function addproductvariant(){
        $('#attributeModal').modal('show');
        $('#submitProductAttribute').on('click', function(){
            var title = $('#product_attribute_title').val();
            $.ajax({
                url: "/api/createproductattribute",
                type:"POST",
                data:{
                "_token": "{{ csrf_token() }}",
                title:title,
                },
                success:function(response){
                    if(response.status == 'successful'){
                        $('#attributeModal').modal('hide');
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

    function addcategory(){
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
                type:"POST",
                data:formData,
                enctype: 'multipart/form-data',
                cache:false,
                contentType: false,
                processData: false,
                success:function(response){
                    if(response.status == 'successful'){
                        html_options = '';
                        html_options += "<option value='"+response.data.id+"'>"+response.data.name+"</option>";
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


<script >
            $(document).ready(function(){
 $('#category_id').change(function(e){
     e.preventDefault();
        var category_id = $(this).val();
        if(category_id){
    $.ajax({
        url:"/api/getsubcategory",
        type: "POST",
            data:{
                category_id:category_id
            },
     
      success:function(response){ 
      if(response.data){
        $('#sub_cat_div').removeClass('d-none');

        var html_options= "<option value=''>select any one</option>";
                    $.each(response.data, function(index,subcat_data){
                        html_options += "<option value='"+subcat_data.id+"'>"+subcat_data.name+"</option>";
                    });
                    $('#subcategory_id').html(html_options);
      
      }else{
        $("#subcategory_id").empty();
      }
      if(response.category){
        $('#sub_cat_div').addClass('d-none');
      }
      }
    });
  }else{
    $("#subcategory_id").empty();
  }
   });
   
});
   
</script>

<script>
$(document).ready(function (e) {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#product-create-form').submit(function(e) {
        
        e.preventDefault();
        for (instance in CKEDITOR.instances) 
{
    CKEDITOR.instances[instance].updateElement();
}
        var highlight = $('#highlight').val();
        console.log(highlight)
  
  var formData = new FormData(this);
  $.ajax({
        type:'POST',
        url: "/api/createproduct",
        data: formData,
        enctype: 'multipart/form-data',
        cache:false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response.data);
            if(response.status == 'successful'){
              window.location.href = "/admin/product";
              var validation_errors = JSON.stringify(response.message);
                $('#validation-errors').html('');
                $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
                }  else if(response.status == 'unsuccessful') {
              var validation_errors = JSON.stringify(response.data);
            var response = JSON.parse(validation_errors);
            $('#validation-errors').html('');
            $.each( response, function( key, value) {
            $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
            });
                }
        }
        
       });
   });
   });


</script>

@endsection
