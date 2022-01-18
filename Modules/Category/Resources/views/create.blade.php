@extends('layouts.admin')
@section('content')
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create Category</div>
        </div>
        
    <div class="ibox-body" id="validation-errors">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
    </div>
    <div class="ibox-body" style="">
        <form id="category-create-form">
            <div class="form-group ">
                <label>Category Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter name">
            </div>

            <div class="row form-group">
                <label for="" class="col-sm-3">Is Featured Category ? :</label>
                <div class="col-sm-1">
                    <label class="ui-checkbox ui-checkbox-warning">
                        <input type="checkbox" name="is_featured" id="is_featured">
                        <span class="input-span"></span>Yes
                    </label>
                </div>
                <label class="col-lg-8">
                    <span class="alert-warning">
                        *Remember: This will allow to display in 'Best Our Collections Section
                        in homepage.'
                    </span>
                </label>
            </div>


            <div class="row form-group">
                <label for="" class="col-sm-3">Include In Main Menu:</label>
                <div class="col-sm-1">
                    <label class="ui-checkbox ui-checkbox-warning">
                        <input type="checkbox" name="include_in_main_menu" id="include_in_main_menu">
                        <span class="input-span"></span>Yes
                    </label>
                </div>
                <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                        menu if this is not a Top Menu Category.</span></label>
            </div>

            <div class="row form-group">
                <label for="" class="col-sm-3">Allow Sub category:</label>
                <div class="col-sm-1">
                    <label class="ui-checkbox ui-checkbox-warning">
                        <input type="checkbox" name="does_contain_sub_category" id="does_contain_sub_category">
                        <span class="input-span"></span>Yes
                    </label>
                </div>
                <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                        menu if this doesnot have sub category.</span></label>
            </div>

            <div class="row form-group">
                <label for="" class="col-sm-3">Is Hot Category:</label>
                <div class="col-sm-1">
                    <label class="ui-checkbox ui-checkbox-warning">
                        <input type="checkbox" name="hot_category" id="hot_category">
                        <span class="input-span"></span>Yes
                    </label>
                </div>
                <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                        menu if this is not a Hot Category.</span></label>
            </div>


            <div class="row form-group col-md-6">
                <label>Upload Category Image </label>
                <input class="form-control" name="image" type="file" id="fileUpload">
                <div id="wrapper" class="mt-2">
                    <div id="image-holder">
                    </div>
                </div>
            </div>
            @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
            <div class="check-list">
                <label class="ui-checkbox ui-checkbox-primary">
                    <input name="publish" id="publish" type="checkbox">
                    <span class="input-span"></span>Publish</label>
            </div>
            @endif
            <br>
            <div class="form-group">
                <input onclick="submitCategoryNow();" type="button" name="save" value="save" id="blog_submit" class="btn btn-success">
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
@include('dashboard::admin.layouts._partials.imagepreview')
<script>
      function submitCategoryNow()
    {
        var categoryCreateForm = document.getElementById("category-create-form");
        var formData = new FormData(categoryCreateForm);  
      $.ajax({
        type:'POST',
        url: "/api/createcategory",
        data: formData,
        enctype: 'multipart/form-data',
        cache:false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response.data);
            if(response.status == 'successful')
            {
            window.location.href = "/admin/category";
            var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div'); 
            } 
            else(response.status=='unsuccessful' ) 
            { 
              var validation_errors=JSON.stringify(response.data); 
              var response=JSON.parse(validation_errors);
              $('#validation-errors').html(''); 
              $.each( response, function( key, value) {
                 $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
                 }); 
            }
           }
      });
    }
</script>

@endpush


