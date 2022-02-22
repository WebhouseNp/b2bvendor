@extends('layouts.admin')
@section('page_title') {{ (@$updateMode) ? "Update" : "Add"}} Partner @endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title"> Partner</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> {{ ($updateMode) ? "Update" : "Add"}} Partner</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($updateMode) ? "Update" : "Add"}} Partner</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('partner.index')}}">All Partner</a>
            </div>
        </div>
    </div>

    <form class="form form-responsive form-horizontal" action="{{ $updateMode ? route('partner.update', $partner->id) : route('partner.store') }}" enctype="multipart/form-data" method="POST">
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
                                <div class="ibox-title">Partner Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Partner's Name *</strong></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $partner->name) }}" name="name" placeholder="partner Name here">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label class="form-label">Partner Type:</label>
                                        <select name="partner_type_id" class="form-control">
                                            <option value="">Please Select Type</option>
                                            @foreach ($partnerTypes as $type)
                                            <option value="{{ $type->id }}" @if(old('partner_type_id', $partner->partner_type_id) == $type->id) selected @endif>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
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
                                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="showThumbnail(this);">
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                            @if($updateMode)
                                            <img src="{{ $partner->imageUrl() }}" height="120px" width="120px">
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
                                            <input name="publish" id="publish" type="checkbox" @if(old('publish',$partner->publish)) checked @endif>
                                            <span class="input-span"></span>Publish</label>
                                    </div>
                                    @error('publish')
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
@section('scripts')

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
@endsection