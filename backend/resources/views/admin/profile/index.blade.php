@extends('admin.layouts.app')

@section('title')
    Thông tin hồ sơ
@endsection
@section('content')
    <div class="page-content">
        <div id="layout-wrapper">
            <div class="container-fluid">
                @include('admin.layouts.component.page-header', [
                    'title' => 'Hồ sơ ',
                    'breadcrumb' => [
                        ['name' => 'Hồ sơ', 'url' => 'javascript: void(0);'],
                        ['name' => 'Thông tin', 'url' => '#'],
                    ],
                ])

                <!-- ========== App Menu ========== -->
                <!-- Left Sidebar End -->
                <!-- Vertical Overlay-->
                <div class="vertical-overlay"></div>

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->

                <div class="main-content">

                    <div>
                        <div class="container-fluid">
                            <div class="profile-foreground position-relative mx-n4 mt-n4">
                                <div class="profile-wid-bg">
                                    <img src="" alt="" class="profile-wid-img" />
                                </div>
                            </div>
                            <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
                                <div class="row g-4">
                                    <div class="col-auto">
                                        <div class="avatar-lg">
                                            <img src="{{ Storage::url($user->profile_picture) }}" class="rounded-circle avatar-x2 img-thumbnail user-profile-image" alt="user-profile-image" >
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col">
    <div class="p-2">
        <h3 class="text-white mb-1">{{ $user->username }}</h3>
        <p class="text-white text-opacity-75">Chủ sở hữu & Người sáng lập</p>
        <div class="hstack text-white-50 gap-1">
            <div class="me-2">
                <i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>
                Hà Nội
            </div>
           
        </div>
    </div>
</div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <div class="d-flex profile-wrapper">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1"
                                                role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link fs-14 active" data-bs-toggle="tab"
                                                        href="#overview-tab" role="tab">
                                                        <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                                            class="d-none d-md-inline-block">Tổng quan</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="flex-shrink-0">
                                                <a href="{{route('admin.profile.edit')}}" class="btn btn-success"><i
                                                        class="ri-edit-box-line align-bottom"></i> Sửa hồ sơ</a>
                                            </div>
                                        </div>
                                        <!-- Tab panes -->
                                        <div class="tab-content pt-4 text-muted">
                                            <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-xxl-3">
                                                        

                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">Thông tin</h5>
                                                                <div class="table-responsive">
                                                                    <table class="table table-borderless mb-0">
                                                                        <tbody style="font-size: 12px">
                                                                            <tr>
                                                                                <th class="ps-0" scope="row">Họ tên :</th>
                                                                                <td class="text-muted">{{$user->username}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="ps-0" scope="row">Điện thoại :
                                                                                </th>
                                                                                <td class="text-muted">{{$user->phone_number}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="ps-0" scope="row">E-mail :
                                                                                </th>
                                                                                <td class="text-muted">{{$user->email}}
                                                                                </td>
                                                                            </tr>
                                                                             <tr>
                                                                                <th class="ps-0" scope="row">Giới tính :
                                                                                </th>
                                                                                <td class="text-muted">{{$user->gender}}
                                                                                </td>
                                                                            </tr>
                                                                             <tr>
                                                                                <th class="ps-0" scope="row">Sinh nhật :
                                                                                </th>
                                                                                <td class="text-muted">{{$user->date_of_birth}}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div><!-- end card body -->
                                                        </div><!-- end card -->

                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-4">Portfolio</h5>
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    <div>
                                                                        <a href="javascript:void(0);"
                                                                            class="avatar-xs d-block">
                                                                            <span
                                                                                class="avatar-title rounded-circle fs-16 bg-body text-body">
                                                                                <i class="ri-github-fill"></i>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="javascript:void(0);"
                                                                            class="avatar-xs d-block">
                                                                            <span
                                                                                class="avatar-title rounded-circle fs-16 bg-primary">
                                                                                <i class="ri-global-fill"></i>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="javascript:void(0);"
                                                                            class="avatar-xs d-block">
                                                                            <span
                                                                                class="avatar-title rounded-circle fs-16 bg-success">
                                                                                <i class="ri-dribbble-fill"></i>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="javascript:void(0);"
                                                                            class="avatar-xs d-block">
                                                                            <span
                                                                                class="avatar-title rounded-circle fs-16 bg-danger">
                                                                                <i class="ri-pinterest-fill"></i>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div><!-- end card body -->
                                                        </div><!-- end card -->


                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-xxl-9">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">About</h5>
                                                                <p>Xin chào, tôi là quản trị viên</p>
                                                                <p>Bạn luôn muốn đảm bảo rằng các phông chữ của mình kết hợp tốt với nhau và cố gắng hạn chế số lượng phông chữ bạn sử dụng ở mức ba hoặc ít hơn. Hãy thử nghiệm và chơi đùa với các phông chữ mà bạn đã có trong phần mềm bạn đang làm việc với các trang web phông chữ uy tín. Đây có thể là mẹo thường gặp nhất mà tôi nhận được từ các nhà thiết kế mà tôi đã nói chuyện. Họ rất khuyến khích bạn sử dụng các phông chữ khác nhau trong một thiết kế, nhưng đừng phóng đại và đi quá xa.</p>
                                                                <!--end row-->
                                                            </div>
                                                            <!--end card-body-->
                                                        </div><!-- end card -->

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    
                                                                    
                                                                    </div><!-- end card body -->
                                                                </div><!-- end card -->
                                                            </div><!-- end col -->
                                                        </div><!-- end row -->

                                                       

                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                            <!--end tab-pane-->
                                        </div>
                                        <!--end tab-content-->
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                        </div><!-- container-fluid -->
                    </div><!-- End Page-content -->

                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> © Velzon.
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end d-none d-sm-block">
                                        Design & Develop by Themesbrand
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div><!-- end main content-->

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
                    data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                    <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
                </div>
            </div>

            <!-- JAVASCRIPT -->
            <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/libs/simplebar/simplebar.min.js"></script>
            <script src="assets/libs/node-waves/waves.min.js"></script>
            <script src="assets/libs/feather-icons/feather.min.js"></script>
            <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
            <script src="assets/js/plugins.js"></script>

            <!-- swiper js -->
            <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

            <!-- profile init js -->
            <script src="assets/js/pages/profile.init.js"></script>

            <!-- App js -->
            <script src="assets/js/app.js"></script>
            </body>

            </html>
