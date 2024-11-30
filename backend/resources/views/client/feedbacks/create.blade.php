@extends('client.layouts.app')

@section('style_css')
<style>
    /* Form Container */
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container h1 {
        text-align: center;
        color: #386ce6;
        margin-bottom: 20px;
        font-size: 28px;
        font-weight: bold;
    }

    .form-label {
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 16px;
    }

    .form-control:focus {
        border-color: #386ce6;
        box-shadow: 0 0 5px rgba(56, 108, 230, 0.5);
    }

    .form-control.error {
        border-color: #ff4d4d;
    }

    .form-text {
        font-size: 12px;
        color: #777;
    }

    .btn-primary {
        background-color: #386ce6;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #5a9eff;
    }

    .alert {
        font-size: 14px;
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #e6ffe6;
        color: #2d7d2d;
        border: 1px solid #c2eac2;
    }

    .alert-danger {
        background-color: #ffe6e6;
        color: #7d2d2d;
        border: 1px solid #eac2c2;
    }
</style>
@endsection

@section('content')
<main class="main home">
    <div class="container mb-2">
        <div class="row">
            <div class="col-lg-9">
                <section class="profile-content">
                    <div class="form-container">
                        <h1>Gửi Phản Hồi</h1>

                        <!-- Hiển thị thông báo thành công -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Hiển thị lỗi xác thực -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('feedbacks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ và Tên</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" value="{{ $user->username ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email ?? '' }}" required>
                            </div>

                           
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Số Điện Thoại</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Địa Chỉ</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="feedback_type" class="form-label">Loại Phản Hồi</label>
                                <select name="feedback_type" id="feedback_type" class="form-control" required>
                                    <option value="Góp ý" {{ old('feedback_type') == 'Góp ý' ? 'selected' : '' }}>Góp ý</option>
                                    <option value="Đánh giá" {{ old('feedback_type') == 'Đánh giá' ? 'selected' : '' }}>Đánh giá</option>
                                    <option value="Khiếu nại" {{ old('feedback_type') == 'Khiếu nại' ? 'selected' : '' }}>Khiếu nại</option>
                                    <option value="Cảm nhận" {{ old('feedback_type') == 'Cảm nhận' ? 'selected' : '' }}>Cảm nhận</option>
                                    <option value="Khác" {{ old('feedback_type') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Chủ Đề</label>
                                <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Nội Dung</label>
                                <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="rating" class="form-label">Đánh Giá</label>
                                <select name="rating" id="rating" class="form-control" required>
                                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Rất tệ</option>
                                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Tệ</option>
                                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Bình thường</option>
                                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Tốt</option>
                                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 - Rất tốt</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="attachment_url" class="form-label">Tệp Đính Kèm (Tùy chọn)</label>
                                <input type="file" name="attachment_url" id="attachment_url" class="form-control">
                                <small class="form-text">Chấp nhận các tệp jpg, png, pdf, doc, docx (tối đa 10MB).</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Gửi Phản Hồi</button>
                        </form>
                    </div>
                </section>
            </div>
            @include('client.users.left_menu')
        </div>
    </div>
</main>
@endsection
