<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Edit Category</div>

          <div class="ibox-tools">

          </div>
        </div>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
        @endif
        
    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

        <div class="ibox-body" style="">
          <form id="category-update-form">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter name">
            </div>

            <div class="row form-group">
              <label for="" class="col-sm-3">Is Featured Category ? :</label>
              <div class="col-sm-1">
                  <label class="ui-checkbox ui-checkbox-warning">
                      <input type="checkbox" name="is_featured"  id="is_featured"
                          >
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
                      <input type="checkbox" name="include_in_main_menu"  id="include_in_main_menu"
                          >
                      <span class="input-span"></span>Yes
                  </label>
              </div>
              <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                      menu if this is not a Top Menu Category.</span></label>
          </div>

          <div class="row form-group">
              <label for="" class="col-sm-3">contain Sub category:</label>
              <div class="col-sm-1">
                  <label class="ui-checkbox ui-checkbox-warning">
                      <input type="checkbox" name="does_contain_sub_category"  id="does_contain_sub_category"
                          >
                      <span class="input-span"></span>Yes
                  </label>
              </div>
              <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                      menu if this doesnot have sub category.</span></label>
          </div>

            
          <div class="row form-group col-md-6">
            <label>Image </label>
            <input class="form-control"  name="image"
                type="file" id="fileUpload">
                <div id="wrapper" class="mt-2">
                    <div id="image-holder">
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



@endsection

@push('push_scripts')

@include('dashboard::admin.layouts._partials.imagepreview')

@endpush

@push('push_scripts')
<script>
	$(document).ready(function (e) {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#category-update-form').submit(function(e) {
        var id = "<?php echo $id; ?>";
        var api_token = '<?php echo $api_token; ?>';
        e.preventDefault();
  
  var formData = new FormData(this);
  formData.append('id', id);
  $.ajax({
        type:'POST',
        url: "/api/updatecategory",
        data: formData,
        enctype: 'multipart/form-data',
        cache:false,
        contentType: false,
        processData: false,
        headers: {
            Authorization: "Bearer " + api_token
        },
        success:function(response){
            console.log(response.data);
            if(response.status == 'successful'){
              window.location.href = "/admin/category";
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
<script> 
 $(document).ready(function(){
     var id = <?php echo $id; ?>;
     var api_token = '<?php echo $api_token; ?>';
            function editcategory(id){
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/editcategory", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
           success: function(response) {
          $('#name').append(response.data.name).val();
               console.log(response.data.publish)
               document.getElementById('name').value = response.data.name;
               if (response.data.publish == '1') {
						document.getElementById('publish').checked = true;
					} else {
						document.getElementById('publish').checked = false;
					}
                      
                    if(response.data.is_featured == '1'){
						document.getElementById('is_featured').checked = true;
					}
					else if(response.data.is_featured == '0'){
                        document.getElementById('is_featured').checked = false;
					}
                    if(response.data.does_contain_sub_category == '1'){
                        document.getElementById('does_contain_sub_category').checked = true;
					}
					else if(response.data.does_contain_sub_category == '0'){
                        document.getElementById('does_contain_sub_category').checked = false;
					}
                    if(response.data.include_in_main_menu == '1'){
                        document.getElementById('include_in_main_menu').checked = true;
					}
					else if(response.data.include_in_main_menu == '0'){
                        document.getElementById('include_in_main_menu').checked = false;
					} 
                    document.getElementById('image-holder').innerHTML = '<img width="150" height="150" src="<?php echo URL::to('/').'/images/thumbnail/'; ?>'+response.data.image+'">';        

        //    location.reload();
           }
       });
            }
            editcategory(id);
          });
 

</script>

@endpush


