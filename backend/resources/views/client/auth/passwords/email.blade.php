@extends('auth.layouts.app')
@section('title' , 'Xác nhận mật khẩu')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">{{__('app.lables.forgetPassword')}}</h5>
                    <p class="text-muted">Đặt lại mật khẩu</p>

                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>
                </div>

                <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                    {{__('app.titleResetEmail')}}
                </div>
                <div class="p-2">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">{{__('app.lables.emailadress')}}</label>
                            <input type="email" class="form-control" id="email" placeholder="{{__('app.lables.emailplaceholder')}}" name="email">
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success w-100" type="submit">{{__('app.buttoms.sendresetlink')}}</button>
                        </div>
                    </form><!-- end form -->
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <p class="mb-0">Đợi đã, tôi nhớ mật khẩu của mình...  <a href="{{route('login')}}" class="fw-semibold text-primary text-decoration-underline"> Nhấn vào đây </a> </p>
        </div>

    </div>
</div>
@endsection
