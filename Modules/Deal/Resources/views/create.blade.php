<?php
$user = Auth::user();
$api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('content')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" rel='nofollow' href="https://cdn.syncfusion.com/ej2/material.css" /> 
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

                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </div>
                <div id="app">
                    <createdeal auth={{Auth::id()}}/>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('push_scripts')
<script src="{{mix('js/app.js')}}"></script>

</script>
@endpush