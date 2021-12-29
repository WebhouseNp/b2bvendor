@extends('layouts.admin')
@section('page_title') {{ (@$country_info) ? "Update" : "Add"}} Country @endsection

@section('content')

<div class="page-heading">
    <h1 class="page-title"> Country</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> {{ ($country_info) ? "Update" : "Add"}} Country</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($country_info) ? "Update" : "Add"}} Country</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('country.index')}}">All Country</a>
            </div>
        </div>
    </div>

    @if(@$country_info == null)
    <form class="form form-responsive form-horizontal" action="{{route('country.store')}}" enctype="multipart/form-data"
        method="post">
        @else
        <form class="form form-responsive form-horizontal" action="{{route('country.update', $country_info->id)}}"
            enctype="multipart/form-data" method="post">
            <input type="hidden" name="_method" value="PUT">
            @endif
            {{csrf_field()}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-12">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Country Information</div>
                                </div>
                                <div class="ibox-body">

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <label><strong>Conntry Name</strong></label>
                                            <input class="form-control" type="text"
                                                value="{{ (@$country_info->name) ?  @$country_info->name: old('name')}}"
                                                name="name" placeholder="Country Name here">

                                            @if($errors->has('name'))
                                            <div class="error alert-danger">{{$errors->first('name')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="ibox">
                                <div class="ibox-body">
                                    <div class="form-group">
                                        <label> Upload Flag [image size: width: 750px, height: 472px ] </label>
                                        <input class="form-control" type="file" name="flag" id="image"
                                            accept="image/*" onchange="showThumbnail(this);">
                                            <div id="wrapper" class="mt-2">
                                                <div id="image-holder">
                                                @if(@$country_info->flag)
                                                <img src="{{asset('uploads/Country/'.@$country_info->flag)}}" alt="" height="120px" width="120px">
                                                @endif
                                                </div>
                                            </div>
                                        @if($errors->has('flag'))
                                        <div class="error alert-danger">{{$errors->first('flag')}}</div>
                                        @endif
                                    </div>
                                    
                                    <div class="check-list">
                                        <label class="ui-checkbox ui-checkbox-primary">
                                            <input name="publish" id="publish" type="checkbox" {{@$country_info->publish == 1 ? 'checked' : ''}}>
                                            <span class="input-span"></span>Publish</label>
                                    </div>
                                    @if($errors->has('publish'))
                                    <span class=" alert-danger">{{$errors->first('publish')}}</span>
                                    @endif
                                    <br>
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

@endsection
@section('scripts')

<script>
    function showThumbnail(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e){
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }


</script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="{{asset('/assets/admin/js/laravel-file-manager-ck-editor.js')}}"></script>
<script>
    Ckeditor('description', 250);
</script>

@endsection