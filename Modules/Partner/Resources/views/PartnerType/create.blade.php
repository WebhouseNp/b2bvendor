@extends('layouts.admin')
@section('page_title') {{ (@$updateMode) ? "Update" : "Add"}} Partner Type @endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title"> Partner</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> {{ ($updateMode) ? "Update" : "Add"}} Partner Type</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($updateMode) ? "Update" : "Add"}} Partner Type</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('partner-type.index')}}">All Partner Type</a>
            </div>
        </div>
    </div>

    <form class="form form-responsive form-horizontal" action="{{ $updateMode ? route('partner-type.update', $partner->id) : route('partner-type.store') }}" enctype="multipart/form-data" method="POST">
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
                                <div class="ibox-title">Partner Type Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Name *</strong></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $partner->name) }}" name="name" placeholder="partner Name here">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Position *</strong></label>
                                        <input type="number" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $partner->position) }}" name="position" placeholder=" Position here">
                                        @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group check-list">
                                        <label class="ui-checkbox ui-checkbox-primary">
                                            <input name="publish" id="publish" type="checkbox" @if(old('publish',$partner->publish)) checked @endif>
                                            <span class="input-span"></span>Publish</label>
                                    </div>
                                    <br>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <div class="col text-center">
                                            <button class="btn btn-success" type="submit"><span class="fa fa-send mr-2"></span>Save</button>
                                        </div>
                                    </div>
                                    
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
