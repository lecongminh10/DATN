<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Theme/sbrand" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('theme/assets/images/favicon.ico') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('theme/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('theme/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('theme/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('libray_css')
    @yield('style_css')
    <style>
        .empty-notification-elem{
            display: none;
        }
    </style>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.header')
        <!-- ========== App Menu ========== -->
        @include('admin.layouts.menu')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <div class="main-content">

            @yield('content')
            <!-- End Page-content -->

            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme/-settings-offcanvas" aria-controls="theme/-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>

    <!-- Theme/ Settings -->
    @include('admin.settings.index')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('theme/assets/js/plugins.js') }}"></script>

    @yield('script_libray')
    @yield('scripte_logic')
    <!-- App js -->
    <script src="{{ asset('theme/assets/js/app.js') }}"></script>
    @vite('resources/js/app.js')
    <script type="module">
            let count = 0;
            let countTotal= 0;
            const userIdAdmin = @json(Auth::check() ? Auth::user()->id : null);
            const counNotification = document.getElementById('counNotification');
            const totalNotification = document.getElementById('totalNotification');
            Echo.private('notification_message')
                .listen('NotificationMessage', (e) => {
                    const notificationContainer = document.querySelector('#messages-tab .pe-2');
                    if (e) {
                        count += 1;
                        countTotal +=1;
                        counNotification.innerHTML= count;
                        totalNotification.innerHTML=countTotal;
                    }
                    displayMessage(e ,notificationContainer)
                })
                .listen('OrderPlaced', (e) => {
                    const notificationContainer = document.querySelector('#alerts-tab .pe-2');
                    if (e) {
                        count += 1;
                        countTotal +=1;
                        counNotification.innerHTML= count;
                        totalNotification.innerHTML=countTotal;
                    }
                    displayMessage(e ,notificationContainer)
                });
            function displayMessage(e , notificationContainer) {
                    if (e !== null && e.sender && e.sender.id !== userIdAdmin) {
                        // Tạo thông báo HTML
                        const notificationHTML = `
                            <div class="text-reset notification-item d-block dropdown-item">
                                <div class="d-flex">
                                    <img src="{{ Storage::url('${e.sender.profile_picture}') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="flex-grow-1">
                                        <a href="#!" class="stretched-link">
                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">${e.sender.username}</h6>
                                        </a>
                                        <div class="fs-13 text-muted">
                                            <p class="mb-1">${e.message}</p>
                                        </div>
                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                            <span><i class="mdi mdi-clock-outline"></i> ${formatDateTime(new Date())}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `;
                        const allNotiTab = document.querySelector('#all-noti-tab .pe-2');
                              allNotiTab.innerHTML = notificationHTML + allNotiTab.innerHTML;

                        notificationContainer.innerHTML = notificationHTML + notificationContainer.innerHTML;
                    }
                }

                function formatDateTime(dateTime) {
                    const date = new Date(dateTime);

                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');

                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();

                    return `${hours}:${minutes}, ${day}-${month}-${year}`;
                }
    </script>
</body>

</html>
