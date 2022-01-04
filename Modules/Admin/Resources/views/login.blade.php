@extends('layouts.app')

@section('content')
<div class="content pt-4">
    <div class="brand">
        <p class="link text-capitalize">Welcome<br> to <a class="link" href="/">B2B </a></p>
    </div>
    <form action="/admin/login" method="POST">
        @csrf
        <h2 class="login-title">Admin Log in</h2>

        @error('login')
        <div class="border py-2 px-3 rounded text-danger mb-2" style="background-color: #ffd6d6; border-color: #ff8c97!important;">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group">
            <div class="input-group-icon right">
                <div class="input-icon"><i class="fa fa-envelope"></i></div>
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="input-group-icon right">
                <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info btn-block">Login</button>
        </div>
    </form>
</div>
@endsection
