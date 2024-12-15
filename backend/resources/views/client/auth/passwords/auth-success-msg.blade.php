@extends('client.auth.layouts.app')
@section('title' , 'Xác nhận mật khẩu')
@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{ route('users.indexClient') }}" class="d-inline-block auth-logo">
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
                            <div class="card-body p-4 text-center">
                                <div class="avatar-lg mx-auto mt-2">
                                    <div class="avatar-title bg-light text-success display-3 rounded-circle">
                                        <i class="ri-checkbox-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <h4>{{$title}}!</h4>
                                    <p class="text-muted mx-4">{{$messages}}.</p>
                                    <div class="mt-4">
                                        <a href="{{route('client.login')}}" class="btn btn-success w-100">Đăng nhập</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
@endsection