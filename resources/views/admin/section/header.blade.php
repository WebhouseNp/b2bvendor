<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="shortcut icon" rel="icon" href="{{asset('/assets/front/images/icon.png')}}" type="image/gif" />
    <title> @yield('page_title') | {{ config('app.name') }}</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{asset('/assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/admin/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
<link href="{{asset('/assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('/assets/admin/css/main.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/admin/css/BsMultiSelect.bs4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/assets/admin/css/style.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <!-- PAGE LEVEL STYLES-->
    @yield('styles')
    <style>
             .title-label {
                font-size: 0.9rem;
                color: gray;
                margin-bottom: 0;
            }
    </style>

    <script src="{{asset('/assets/admin/vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">

        <header class="header">
            <div class="page-brand">
                <a class="link" href="#">
                    <span class="brand">
                        @if(auth()->user()->hasAnyRole('admin|super_admin'))
                        {{ auth()->user()->name }}
                        @else
                        {{ auth()->user()->vendor->shop_name }}
                        @endif
                    </span>
                    <span class="brand-mini text-nowrap">
                        @if(auth()->user()->hasAnyRole('admin|super_admin'))
                        {{ auth()->user()->name }}
                        @else
                        {{ auth()->user()->vendor->shop_name }}
                        @endif
                    </span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <h4><strong>Welcome,</strong>
                @if(auth()->user()->hasRole('vendor'))
                   <strong> {{ auth()->user()->vendor->shop_name }} </strong> 
                @endif
                </h4>
                <button class="btn btn-primary" onclick="location.href=' {{ config('constants.customer_app_url') . '/suppliers/' . auth()->user()->id }}'" >View Store</button>
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="{{asset('/assets/admin/images/admin-avatar.png')}}" />
                            <span>{{ is_alternative_login() ? alt_usr()->name : Auth::user()->name }}</span><i class="fa fa-angle-down m-l-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a class="dropdown-item" href="{{route('change.password')}}">
                                    <i class="fa fa-cog"></i>Change Password
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
