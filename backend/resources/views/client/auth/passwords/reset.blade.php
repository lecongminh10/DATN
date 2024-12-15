@extends('client.auth.layouts.app')
@section('title', 'Đặt lại mật khẩu')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center text-white-50">
                <div>
                    <a href="index.html" class="d-inline-block auth-logo">
                        <img src="{{asset('logo/zonmart.png')}}" alt="" width="150px" height="150">
                    </a>
                </div>
                {{-- <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p> --}}
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Đặt lại mật khẩu</h5>
                        <p class="text-muted">Mật khẩu mới của bạn phải khác với mật khẩu đã sử dụng trước đó..</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="p-2">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input id="email" type="hidden"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ $email ?? old('email') }}">
                            <div class="mb-3">
                                <label class="form-label" for="password-input">Mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" name="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror"  placeholder="Nhập mật khẩu" id="password-input" aria-describedby="passwordInput" >
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                <div id="passwordInput" class="form-text">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                     @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="confirm-password-input">Xác nhận mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"  placeholder="Nhập lại mật khẩu" id="confirm-password-input" name="password_confirmation" >
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="confirm-password-input"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                <label class="form-check-label" for="auth-remember-check">Nhớ mật khẩu</label>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Đặt lại mật khẩu</button>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Đợi đã, tôi nhớ mật khẩu của mình... <a href="{{route('client.login')}}" class="fw-semibold text-primary text-decoration-underline"> Nhấn vào đây </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->
</div>
@endsection
