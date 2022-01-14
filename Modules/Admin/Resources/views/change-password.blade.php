@extends('layouts.admin')

@section('page_title', 'Edit password')

@section('content')


<div class="page-content fade-in-up">
   <div class="row">
      <div class="col-md-12">
         <div class="ibox">
            <div class="ibox-head">
               <div class="ibox-title">Edit password</div>

               <div class="ibox-tools">
               </div>
            </div>
            <div class="col-6 col-md-9">
               @if(session('message'))
                  <div class="alert alert-success">{{session('message')}}</div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
               @endif

               @if(session('error'))
                  <div class="alert alert-danger">{{session('error')}}</div>
               @endif
            </div>
            <div class="ibox-body" style="">
               <form method="post" action="{{route('update.password')}}"
                  enctype="multipart/form-data">
                  @csrf

                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>Old Password</label>
                            <input type="password" class="form-control" name="old_password" value=""
                            placeholder="Enter Old Password">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="new_password" value=""
                            placeholder="Enter New Password">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" value=""
                            placeholder="Enter Password Again">
                        </div>

                    </div>

                  <br>

                  <div class="form-group">
                     <button class="btn btn-primary" type="submit">Update Password</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

   </div>



</div>

@endsection
@push('scripts')
@endpush