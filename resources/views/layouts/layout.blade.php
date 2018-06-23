<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('ui/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendor/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendor/chartist/css/chartist-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/vendor/toastr/toastr.min.css') }}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('ui/css/main.css') }}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{ asset('ui/css/demo.css') }}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('ui/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('ui/img/favicon.png') }}">
    <!-- layui css -->
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    @section('header')

    @show
</head>
<body>
<!-- Modal -->
<div class="modal fade" id="modalBlock" tabindex="-1" role="dialog" aria-labelledby="modalBlock">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id=""></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default onCancel" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary onSure" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{--mask--}}
<div class="mask">
    <div class="loading-icon">
        <div class="lds-css ng-scope">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
    </div>
</div>
<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="brand">
            <a href="{{ url('/home') }}"><img src="{{ asset('ui/img/logo-dark.png') }}" alt="Klorofil Logo" class="img-responsive logo"></a>
        </div>
        <div class="container-fluid">
            {{--<form class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" value="" class="form-control" placeholder="Search dashboard...">
                    <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
                </div>
            </form>--}}
            <div id="navbar-menu">

                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="lnr lnr-alarm"></i>
                            <span class="badge bg-danger">5</span>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
                            <li><a href="#" class="more">See all notifications</a></li>
                        </ul>
                    </li>
                    {{--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Basic Use</a></li>
                        </ul>
                    </li>--}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('ui/img/user.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href=""><i class="lnr lnr-user"></i> <span>我的资料</span></a></li>
                            <li><a href=""><i class="lnr lnr-envelope"></i> <span>我的消息</span></a></li>
                            <li><a href=""><i class="lnr lnr-cog"></i> <span>设置</span></a></li>
                            <li><a href=""><i class="lnr lnr-exit"></i> <span>注销</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <li><a href="{{ url('/') }}" class="{{ $active == 'home' ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>首页</span></a></li>
                    <li><a href="{{ url('/Manages/members/index') }}" class="{{ $active == 'user' ? 'active' : '' }}"><i class="lnr lnr-user"></i> <span>用户管理</span></a></li>
                    <li><a href="{{ url('/Manages/coupons/index') }}" class="{{ $active == 'coupon' ? 'active' : '' }}"><i class="lnr lnr-bookmark"></i> <span>优惠券管理</span></a></li>
                    <li><a href="{{ url('/Manages/orders/index') }}" class="{{ $active == 'order' ? 'active' : '' }}"><i class="lnr lnr-cart"></i> <span>订单管理</span></a></li>
                    <li>
                        <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages" class="collapse ">
                            <ul class="nav">
                                <li><a href="page-profile.html" class="">Profile</a></li>
                                <li><a href="page-login.html" class="">zhuxiao</a></li>
                                <li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- END LEFT SIDEBAR -->
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                @section('content');

                @show
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
    <footer>
        <div class="container-fluid">
            <p class="copyright">Copyright &copy; 2018.Company name All rights reserved.</p>
        </div>
    </footer>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="{{ asset('ui/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('ui/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('ui/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('ui/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('ui/vendor/chartist/js/chartist.min.js') }}"></script>
<script src="{{ asset('ui/vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('ui/scripts/klorofil-common.js') }}"></script>
<script src="{{ asset('layui/layui.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    app.onPreLoading();
    app.onFullSwitch();
</script>
@section('footer')
@show
</body>

</html>
