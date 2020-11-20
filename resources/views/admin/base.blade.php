<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Farmer 5.0 - @section('title') Admin @show </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ url('css') }}/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('css') }}/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('css') }}/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('css') }}/green.css?v={{time()}}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ url('css') }}/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url('css') }}/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url('css') }}/daterangepicker.css" rel="stylesheet">

    <!-- Toastr -->
    <link href="{{ url('css') }}/toastr.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ url('css') }}/custom.min.css" rel="stylesheet">

    <!-- Custom Personal Style -->
    <link href="{{ url('css') }}/main.css" rel="stylesheet">

    <!-- Date picker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132961921-1"></script>

    @yield('css')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Farmer 5.0 </span></a>
                </div>

                <div class="clearfix"></div>

                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{url('images')}}/circled-user-male-skin-type-1-2.png" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Hi ,</span>
                        <h2>Admin</h2>
                    </div>
                </div>
                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section active">
                        <h3>Chức năng</h3>
                        <ul class="nav side-menu">
                            <li>
                                <a href="{{route('website.home.index')}}"><i class="fa fa-home"></i> Admin </a>
                            </li>
                            <li>
                                <a href="{{route('admin.user.list')}}"><i class="fa fa-user"></i> Users</a>
                            </li>
                            <li>
                                <a href="{{route('admin.domain.list')}}"><i class="fa fa-globe"></i> Domains</a>
                            </li>
                            <li>
                                <a href="{{route('admin.email.list')}}"><i class="fa fa-envelope"></i> Email</a>
                            </li>
                            <li>
                                <a href="{{route('admin.admin.list')}}"><i class="fa fa-user"></i> Admin List</a>
                            </li>
                            <li>
                                <a href="{{route('admin.action-profile.list')}}"><i class="fa fa-user"></i>Action Profile</a>
                            </li>
                            <li>
                                <a href="{{route('admin.friend.list')}}"><i class="fa fa-users"></i>Friend Profile</a>
                            </li>
                            <li>
                                <a href="{{route('admin.clone-facebook.cloneFacebook')}}"><i class="fa fa-facebook"></i>Clones</a>
                            </li>
                            <li>
                                <a href="{{route('admin.group-info.list')}}"><i class="fa fa-facebook"></i>CloneInfo</a>
                            </li>
                            <li>
                                <a href="{{route('admin.token-facebook')}}"><i class="fa fa-facebook"></i>Tokens</a>
                            </li>
                            <li>
                                <a href="{{route('admin.device.list')}}"><i class="fa fa-adjust"></i> Devices</a>
                            </li>
                            <li>
                                <a href="{{route('admin.group.list')}}"><i class="fa fa-users"></i> Group Profile</a>
                            </li>
                            <li>
                                <a href="{{route('admin.page.list')}}"><i class="fa fa-file"></i>Pages</a>
                            </li>
                            <li>
                                <a href="{{route('admin.setting.form')}}"><i class="fa fa-gear"></i>Settings</a>
                            </li>
                            <li>
                                <a href="{{route('admin.package.list')}}"><i class="fa fa-gift"></i>pakages</a>
                            </li>
                            <li>
                                <a href="{{route('website.transaction.index')}}"><i class="fa fa-money"></i>Nạp tiền</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{url('images')}}/circled-user-male-skin-type-1-2.png">
                                Phạm Văn Nam
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->



    @section('main')


        @show


        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<script src="{{ url('js') }}/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{ url('js') }}/bootstrap.min.js"></script>
<script src="{{ url('js') }}/custom.min.js"></script>
<script src="{{ url('js') }}/toastr.min.js"></script>
<script src="{{ url('js') }}/tab.js?v={{time()}}"></script>
@yield('js')

</body>
</html>
