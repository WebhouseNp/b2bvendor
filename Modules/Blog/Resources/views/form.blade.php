@extends('layouts.admin')
@section('page_title') {{ (@$updateMode) ? "Update" : "Add"}} Blog @endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title"> Blog</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> {{ ($updateMode) ? "Update" : "Add"}} Blog</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($updateMode) ? "Update" : "Add"}} Blog</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('blog.index')}}">All Blog</a>
            </div>
        </div>
    </div>

    <form class="form form-responsive form-horizontal" action="{{ $updateMode ? route('blog.update', $blog->id) : route('blog.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        @if($updateMode)
        @method('PUT')
        {{-- <input type="hidden" name="_method" value="PUT"> --}}
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Blog Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Blog Title *</strong></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" name="title" placeholder="Blog Title here">
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Blog Author *</strong></label>
                                        <input type="text" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $blog->author) }}" name="author" placeholder="Blog author here">
                                        @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label for=""><strong>Short Description</strong></label>
                                        <textarea name="short_description" id="short_description" rows="3" class="form-control" placeholder="short Description here" style="resize:none;">{{ $blog->short_description }}</textarea>
                                        @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label for=""><strong>Description</strong></label>
                                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="short Description here" style="resize:none;">{{ $blog->description }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="form-group">
                                    <label> Upload Image [image size: width: 750px, height: 472px ] </label>
                                    <input type="file" name="image" id="image" class="form-control @error('imahe') is-invalid @enderror" accept="image/*" onchange="showThumbnail(this);">
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                            @if($updateMode)
                                            <img src="{{ $blog->imageUrl() }}" height="120px" width="120px">
                                            @endif
                                        </div>
                                    </div>
                                    @error('image')
                                    <div class="invalid-feedback">{{$errors->first('image')}}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="check-list">
                                        <label class="ui-checkbox ui-checkbox-primary">
                                            <input name="is_active" id="is_active" type="checkbox" @if(old('is_active',$blog->is_active)) checked @endif>
                                            <span class="input-span"></span>Is Active</label>
                                    </div>
                                    @error('is_active')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit"><span class="fa fa-send mr-2"></span>Save</button>
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
<?php
$name = ['description'];
?>
@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach
<script>
    function showThumbnail(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e) {
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endpush