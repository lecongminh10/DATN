<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('theme/assets/images/favicon.ico')}}">

    <!-- Layout config Js -->
    <script src="{{asset('theme/assets/js/layout.js')}}')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('theme/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('theme/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('theme/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('theme/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            @yield('content')
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        @include('admin.auth.layouts.footer')
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('theme/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('theme/assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('theme/assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('theme/assets/js/plugins.js')}}"></script>

    <!-- password-addon init -->
    <script src="{{asset('theme/assets/js/pages/password-addon.init.js')}}"></script>
</body>

</html>