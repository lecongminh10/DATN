@extends('admin.auth.layouts.app')
@section('title')
    Đăng nhập Admin
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="p-lg-5 p-4 auth-one-bg h-100">
                            <div class="bg-overlay"></div>
                            <div class="position-relative h-100 d-flex flex-column">
                                <div class="mb-4">
                                    <a href="/auth/admin/login" class="d-block" style="position: absolute; top:0px ; left:0px">
                                        <img src="{{ asset('logo.png') }}" alt="" height="170" width="270">
                                    </a>
                                </div>
                                <div class="mt-auto">
                                    <div class="mb-3">
                                        {{-- <i class="ri-double-quotes-l display-4 text-success"></i> --}}
                                    </div>

                                    <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                            <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <div class="carousel-inner text-center text-white-50 pb-5">
                                            <div class="carousel-item active">
                                                <p class="fs-15 fst-italic">Chào mừng bạn quay trở lại</p>
                                            </div>
                                            <div class="carousel-item">
                                                <p class="fs-15 fst-italic">"Website bán thiết bị công nghệ ZonMart"</p>
                                            </div>
                                            <div class="carousel-item">
                                                <p class="fs-15 fst-italic">"Xin mời bạn đăng nhập"</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-lg-6">
                        <div class="p-lg-5 p-4">
                            <div>
                                <h5 class="text-primary">Chào mừng quay trở lại</h5>
                            </div>

                            <div class="mt-4">
                                <form action="{{route('auth.login')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="Nhập email">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="action" value="admin">
                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="{{route('password.request')}}" class="text-muted">Quên mật khẩu ?</a>
                                        </div>
                                        <label class="form-label" for="password-input">Mật khẩu</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu" id="password-input" name="password">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                           @enderror
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Nhớ mật khẩu</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->
</div>
@endsection