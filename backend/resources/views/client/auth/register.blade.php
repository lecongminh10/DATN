@extends('client.auth.layouts.app')
@section('title')
    Đăng ký
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center text-white-50">
                <div>
                    <a href="{{ route('users.indexClient') }}" class="d-inline-block auth-logo">
                        <img src="{{asset('logo.png')}}" alt="" width="180px" height="150px" style="">
                    </a>
                </div>
                {{-- <p class="mt-3 fs-15 fw-medium">Đăng ký</p> --}}
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Tạo tài khoản mới</h5>
                        <p class="text-muted">Tạo tài khoản ZonMart miễn phí của bạn</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                            @csrf
                        
                            <div class="mb-3">
                                <label for="username" class="form-label">Tài khoản <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Nhập tài khoản" required name="username">
                                @error('username')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" placeholder="Nhập email" required name="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        
                            <div class="mb-3">
                                <label class="form-label" for="password-input">Mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" onpaste="return false" placeholder="Nhập mật khẩu" id="password-input" required name="password" autocomplete="new-password">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="mb-3">
                                <label class="form-label" for="password-confirm">Nhập lại mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input @error('password_confirmation') is-invalid @enderror" onpaste="return false" placeholder="Xác nhận mật khẩu" id="password-confirm" required name="password_confirmation" autocomplete="new-password">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Đăng ký</button>
                            </div>
                        
                            <div class="mt-4 text-center">
                                <div class="signin-other-title">
                                    <h5 class="fs-13 mb-4 title text-muted">Tạo tài khoản với</h5>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><a href="{{ route('auth.facebook') }}"><i class="ri-facebook-fill fs-16" style="color: aliceblue"></i></a></button>
                                    <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><a href="{{ route('auth.google') }}"><i class="ri-google-fill fs-16" style="color: aliceblue"></i></a></button>
                                    <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><a href="{{ route('auth.github') }}"><i class="ri-github-fill fs-16" style="color: aliceblue"></i></a></button>
                                    <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><a href="{{ route('auth.twitter')}}"><i class="ri-twitter-fill fs-16" style="color: aliceblue"></i></a></button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Bạn đã có tài khoản ? <a href="{{route('client.login')}}" class="fw-semibold text-primary text-decoration-underline"> Đăng nhập </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->
</div>
@endsection