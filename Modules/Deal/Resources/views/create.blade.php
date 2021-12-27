<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('content')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create Deal</div>

          <div class="ibox-tools">

          </div>
        </div>
        
    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

        <div class="ibox-body" style="">
          <form action="{{route('deals.store')}}" method="POST">
              @csrf
              <input type="hidden" name="vendor_id" value="{{Auth::id()}}">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 form-group">
                        <label><strong>Users</strong></label>
                            <select name="customer_id" id="users" class="form-control">
                                <option value="">Select any one user</option>
                                @foreach($users as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->name}}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 form-group">
                        <label><strong>Expiry Time</strong></label>
                            <input class="form-control" type="time" name="expire_at" placeholder="Expiry Time">
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12 mb-3 ">
                    <label for="">
                        <h6><strong>Select Products</strong></h6>
                    </label>
                    <div class="field_wrapper">
                        <div>
                            <div class="row" style="margin-top:10px">
                                    <div class="col-md-4">
                                        <label for="">
                                        <strong> Product Name</strong>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">
                                            <strong> Product Quantity</strong>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">
                                                <strong> Price Per Unit</strong>
                                        </label>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="product_id[]" id="products" class="form-control" >
                                        <option value="">Select any one product</option>
                                        @foreach($products as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input  type="text"  name="product_qty[]" value="" placeholder="Product Quantity" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <input  type="text"  name="unit_price[]" value="" placeholder="Price per Unit" class="form-control" required>
                                </div>
                                <a href="javascript:void(0);" class="add_button" title="Add field"><img src="{{asset('/images/add-icon.png')}}"/></a>
                                
                            </div>
                        </div>                                                                          
                    </div>
                </div>
            </div>

            <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="publish" id="publish" type="checkbox">
                <span class="input-span"></span>Publish</label>
            </div>

            <br>

            <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>



</div>

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
				<button id="popup-modal-btn" onclick="closeModal('popupModal');" type="button" class="btn">
					OK
				</button>
			</div>
		</div>
	</div>
</div>

@endsection
@push('push_scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#products').select2();
        $('#users').select2();
    });
</script>
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = `<div class="field_wrapper" style="margin-top:10px">
                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="product_id[]" id="products" class="form-control" >
                                        <option value="">Select any one product</option>
                                        @foreach($products as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input  type="text"  name="product_qty[]" value="" placeholder="Product Quantity" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <input  type="text"  name="unit_price[]" value="" placeholder="Price Per Unit" class="form-control" required>
                                </div>
                                <a href="javascript:void(0);" class="remove_button" title="Add field"><img src="{{asset('/images/remove-icon.png')}}"/></a>
                            </div>
                        </div>
                    </div>` ;
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
@endpush


                                              