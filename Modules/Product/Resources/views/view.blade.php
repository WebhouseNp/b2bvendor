<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') Product Details @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
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
      <td><span id="title"></span></td>
    </tr>
	<tr>
      <th scope="row">Slug</th>
      <td><div id="slug"></div></td>
    </tr>
    <tr>
      <th scope="row">Image</th>
      <td><div id="image"></div></td>
    </tr>
    <tr>
      <th scope="row">Category</th>
      <td><div id="category"></div></td>
    </tr>
    <!-- <tr>
      <th scope="row">Brand</th>
      <td><div id="brand"></div></td>
    </tr>
    <tr>
      <th scope="row">Offer</th>
      <td><div id="offer"></div></td>
    </tr> -->
    <tr>
      <th scope="row">Product Type</th>
      <td><div id="type"></div></td>
    </tr>
    <tr>
      <th scope="row">Delivery Charge</th>
      <td><div id="delivery_charge"></div></td>
    </tr>
    <tr>
      <th scope="row">Essential</th>
      <td><div id="essential"></div></td>
    </tr>
    <tr>
      <th scope="row">Best Seller</th>
      <td><div id="best_seller"></div></td>
    </tr>
    <tr>
      <th scope="row">Price</th>
      <td><div id="price"></div></td>
    </tr>
    <tr>
      <th scope="row">Discount</th>
      <td><div id="discount"></div></td>
    </tr>
    <tr>
      <th scope="row">Moq</th>
      <td><div id="moq"></div></td>
    </tr>
    <tr>
      <th scope="row">Highlights</th>
      <td><div id="highlight"></div></td>
    </tr>
    <tr>
      <th scope="row">Description</th>
      <td><div id="description"></div></td>
    </tr>
	<tr>
      <th scope="row">Status</th>
	  <td><span id="status"></span><span style="margin-left: 30px;" id="status"></td>
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
              @foreach($product->ranges as $range)
              <div class="row" style="margin-top:10px">
                <div class="col-md-4">
                    <input  type="text"  name="from[]" value="{{$range->from}}" placeholder="Range From" class="form-control" disabled>
                </div>
                <div class="col-md-4">
                    <input  type="text"  name="to[]" value="{{$range->to}}" placeholder="Range To" class="form-control" disabled>
                </div>
                <div class="col-md-3">
                    <input  type="text"  name="prices[]" value="{{$range->price}}" placeholder="Price" class="form-control" disabled>
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
            @foreach($product->productimage as $image)
            <div class="m-r-10">
                <a href="{{asset('/uploads/product/other-image/'.$image->images)}}"
                    target="_adimage">
                    <img src="{{asset('/uploads/product/other-image/'.$image->images)}}"
                        alt="No Image" class="rounded" width="70">
                </a>
            </div>
            @endforeach
          </div>
            @endsection
    @section('scripts')
    <script> 
    $(document).ready(function(){
		var id = <?php echo $id; ?>;
    var api_token = '<?php echo $api_token; ?>';
            function viewproduct(id){
                $.ajax({ 
           type: "get", 
           url:"/api/view-product", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
           success: function(response) {
               console.log(response.data)
               document.getElementById('title').innerHTML = response.data.title;
               document.getElementById('slug').innerHTML = response.data.slug;
               document.getElementById('price').innerHTML = response.data.price;
               document.getElementById('discount').innerHTML = response.data.discount;
               document.getElementById('moq').innerHTML = response.data.moq;
               document.getElementById('category').innerHTML = response.data.category.name;
               if(response.data.delivery_charge){
                document.getElementById('delivery_charge').innerHTML = response.data.delivery_charge;
               }
                 //  document.getElementById('offer').innerHTML = response.data.offer.title;
              //  document.getElementById('brand').innerHTML = response.data.brand.title;

               document.getElementById('highlight').innerHTML = response.data.highlight;
               document.getElementById('description').innerHTML = response.data.description;
               document.getElementById('type').innerHTML = response.data.type;
			   if(response.data.status == 'active'){
						document.getElementById('status').innerHTML = '<span class="label label-success">Active</span>';
					}
					else if(response.data.status == 'inactive'){
						document.getElementById('status').innerHTML = '<span class="label label-danger">Inactive</span>';
					}  
                    if(response.data.essential == '1'){
						document.getElementById('essential').innerHTML = '<span class="label label-success">Yes</span>';
					}
					else if(response.data.essential == '0'){
						document.getElementById('essential').innerHTML = '<span class="label label-danger">No</span>';
					}
                    if(response.data.best_seller == '1'){
						document.getElementById('best_seller').innerHTML = '<span class="label label-success">Yes</span>';
					}
					else if(response.data.best_seller == '0'){
						document.getElementById('best_seller').innerHTML = '<span class="label label-danger">No</span>';
					}
                    document.getElementById('image').innerHTML = '<img width="150" height="150" src="<?php echo URL::to('/').'/images/thumbnail/'; ?>'+response.data.image+'">';        
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
            </script>

    @endsection


       
 
 

            