@extends('admin.layouts.app')

@section('title')
    Cập nhật hồ sơ
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="page-content">
        <div id="layout-wrapper">
            <div class="container-fluid">
                @include('admin.layouts.component.page-header', [
                    'title' => 'Hồ sơ ',
                    'breadcrumb' => [
                        ['name' => 'Hồ sơ', 'url' => 'javascript: void(0);'],
                        ['name' => 'Cài đặt', 'url' => '#'],
                    ],
                ])

                <!-- removeNotificationModal -->
                <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="NotificationModalbtn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#f7b84b,secondary:#f06548"
                                        style="width:100px;height:100px"></lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>Are you sure ?</h4>
                                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes,
                                        Delete It!</button>
                                </div>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- ========== App Menu ========== -->
                <!-- Left Sidebar End -->
                <!-- Vertical Overlay-->
                <div class="vertical-overlay"></div>

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">

                    <div class="">
                        <div class="container-fluid">

                            <div class="position-relative mx-n4 mt-n4">
                                <div  style='    height:150px' class="profile-wid-bg profile-setting-img">
                                    <img  src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
                                    <div class="overlay-content">
                                        <div class="text-end p-3">
                                            <div class="flex-shrink-0">
                                                <a href="{{route('admin.profile.index')}}" class="btn btn-success"><i
                                                        class="ri-edit-box-line align-bottom"></i> Thông tin hồ sơ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xxl-3">
                                    <div class="card mt-n5">
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                    <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : asset('default-avatar.png') }}"
                                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                                        alt="user-profile-image">
                                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                        <input id="profile-img-file-input" type="file"
                                                            name="profile_picture" class="profile-img-file-input">

                                                    </div>
                                                </div>
                                                <h5 class="fs-16 mb-1">{{ $user->username }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-->
                                    <!--end card-->
                                </div>
                                <!--end col-->
                                <div class="col-xxl-9">
                                    <div class="card mt-xxl-n5">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                                role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                                        role="tab">
                                                        <i class="fas fa-home"></i> Chi tiết cá nhân
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword"
                                                        role="tab">
                                                        <i class="far fa-user"></i> Thay đổi mật khẩu
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                                    <form action="{{ route('admin.profile.update') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="firstnameInput" class="form-label">Họ
                                                                        tên</label>
                                                                    <input type="text" name="username"
                                                                        class="form-control" id="firstnameInput"
                                                                        placeholder="Enter your firstname"
                                                                        value="{{ old('username', $user->username) }}">
                                                                    @error('username')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="phonenumberInput" class="form-label">Số
                                                                        điện thoại</label>
                                                                    <input type="text" name="phone_number"
                                                                        class="form-control" id="phonenumberInput"
                                                                        placeholder="Enter your phone number"
                                                                        value="{{ old('phone_number', $user->phone_number) }}">
                                                                    @error('phone_number')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="emailInput" class="form-label">Địa chỉ
                                                                        email</label>
                                                                    <input type="email" name="email"
                                                                        class="form-control" id="emailInput"
                                                                        placeholder="Enter your email"
                                                                        value="{{ old('email', $user->email) }}">
                                                                    @error('email')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="genderInput" class="form-label">Giới
                                                                        tính</label>
                                                                    <select name="gender" class="form-control"
                                                                        id="genderInput">
                                                                        <option value="male"
                                                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                                                            male</option>
                                                                        <option value="female"
                                                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                                                            female</option>
                                                                    </select>
                                                                    @error('gender')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="dateOfBirthInput" class="form-label">Sinh
                                                                        nhật</label>
                                                                    <input type="date" name="date_of_birth"
                                                                        class="form-control" id="dateOfBirthInput"
                                                                        value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                                                    @error('date_of_birth')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Phần ảnh đại diện nằm bên phải sinh nhật -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="dateOfBirthInput" class="form-label">Ảnh đại diện</label>
                                                                    <input type="file" class="form-control"
                                                                        name="profile_picture" data-allow-reorder="true"
                                                                        data-max-file-size="3MB" data-max-files="1">
                                                                    @if ($user->profile_picture)
                                                                        <img src="{{ Storage::url($user->profile_picture) }}"
                                                                            width="50" height="50"
                                                                            alt="Current Image" style="margin-top: 10px;">
                                                                    @endif
                                                                    @error('profile_picture')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Sửa</button>
                                                                    <a href="{{ route('admin.profile.edit') }}"
                                                                        class="btn btn-soft-success">Hủy</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                                    <form action="{{ route('admin.profile.change.password') }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="row g-2">
                                                            <div class="col-lg-4">
                                                                <div>
                                                                    <label for="oldpasswordInput" class="form-label">Mật
                                                                        khẩu cũ*</label>
                                                                    <input type="password" name="old_password"
                                                                        class="form-control" id="oldpasswordInput"
                                                                        placeholder="Enter current password">
                                                                    @error('old_password')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-4">
                                                                <div>
                                                                    <label for="newpasswordInput" class="form-label">Mật
                                                                        khẩu mới*</label>
                                                                    <input type="password" name="new_password"
                                                                        class="form-control" id="newpasswordInput"
                                                                        placeholder="Enter new password">
                                                                    @error('new_password')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-4">
                                                                <div>
                                                                    <label for="confirmpasswordInput"
                                                                        class="form-label">Xác nhận lại mật khẩu*</label>
                                                                    <input type="password"
                                                                        name="new_password_confirmation"
                                                                        class="form-control" id="confirmpasswordInput"
                                                                        placeholder="Confirm password">
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-12">
                                                                <div class="text-end">
                                                                    <button type="submit" class="btn btn-success">Đổi mật
                                                                        khẩu</button>
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <!--end row-->
                                                    </form>
                                                </div>
                                                <!--end tab-pane-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                        </div>
                        <!-- container-fluid -->
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

            <!-- profile-setting init js -->
            <script src="assets/js/pages/profile-setting.init.js"></script>

            <!-- App js -->
            <script src="assets/js/app.js"></script>
            </body>

            </html>
