@extends('client.auth.layouts.app')
@section('title')
    Đăng nhập 
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center text-white-50">
                <div>
                    <a href="{{ route('users.indexClient') }}" class="d-inline-block auth-logo">
                        <img src="{{asset('logo/zonmart.png')}}" alt="" width="150px" height="150">
                    </a>
                </div>
                {{-- <p class="mt-3 fs-15 fw-medium">Đăng nhập</p> --}}
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Chào mừng quay trở lại!</h5>
                        <p class="text-muted">Đăng nhập để tiếp tục đến ZonMart.</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form action="{{route('auth.login')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Nhập email" name="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <input type="hidden" name="action" value="client">
                            <div class="mb-3">
                                <div class="float-end">
                                    <a href="{{route('password.request')}}" class="text-muted">Quên mật khẩu?</a>
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

                            <div class="mt-4 text-center">
                                <div class="signin-other-title">
                                    <h5 class="fs-13 mb-4 title">Đăng nhập bằng</h5>
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
                <p class="mb-0">Bạn chưa có tài khoản ? <a href="{{route('show.register')}}" class="fw-semibold text-primary text-decoration-underline"> Đăng ký </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->
</div>
@endsection