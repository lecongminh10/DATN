@extends('client.auth.layouts.app')
@section('title', 'Xác nhận mật khẩu')
@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Xác nhận mật khẩu</h5>
                        <p class="text-muted">Đặt lại mật khẩu</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                                @if (session('waiting_time'))
                                    <br> Bạn có thể gửi lại yêu cầu sau <span
                                        id="countdown">{{ session('waiting_time') }}</span> giây.
                                @endif
                            </div>
                        @endif
                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c"
                            class="avatar-xl"></lord-icon>
                    </div>

                    <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                        Nhập email của bạn và hướng dẫn sẽ được gửi cho bạn!
                    </div>
                    <div class="p-2">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Nhập email"
                                    name="email">
                            </div>

                            <div class="text-center mt-4">
                                <div class="text-center mt-4">
                                    <button id="sendResetLinkBtn" class="btn btn-success w-100" type="submit"
                                        @if (session('waiting_time')) disabled @endif>Đặt lại mật khẩu</button>
                                </div>
                            </div>
                        </form><!-- end form -->
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Đợi đã, tôi nhớ mật khẩu của mình...  <a href="{{ route('client.login') }}"
                        class="fw-semibold text-primary text-decoration-underline"> Nhấn vào đây </a> </p>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let countdownElement = document.getElementById('countdown');
            let resetButton = document.getElementById('sendResetLinkBtn');

            if (countdownElement) {
                let countdownValue = parseInt(countdownElement.innerText);

                let countdownInterval = setInterval(function() {    
                    countdownValue--;
                    countdownElement.innerText = countdownValue;
                    if (countdownValue <= 0) {
                        clearInterval(countdownInterval);
                        resetButton.removeAttribute('disabled');
                        countdownElement.parentElement.style.display = 'none';
                    }
                }, 1000);
            }
        });
    </script>

@endsection
