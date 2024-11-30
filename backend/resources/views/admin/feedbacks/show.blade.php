@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <style>
            .card-body {
                padding: 1.5rem;
                /* Ensure proper spacing inside the card */
            }

            textarea.form-control {
                resize: vertical;
                /* Allow the admin reply textarea to be resized vertically */
            }

            .form-select {
                padding: 0.75rem;
                /* Adjust padding to make the dropdown appear consistent */
            }

            .mb-3 {
                margin-bottom: 1rem;
                /* Ensure spacing between form elements */
            }

            .card {
                margin-bottom: 1rem;
                /* Add margin between cards */
            }

            .row>.col-lg-8,
            .row>.col-lg-4 {
                margin-bottom: 1.5rem;
                /* Add margin between columns for spacing */
            }

            .scrollable {
                max-height: 100px;
                /* Giới hạn chiều cao của khung */
                overflow-y: scroll;
                /* Hiển thị thanh cuộn dọc */
                padding: 10px;
                /* Khoảng cách bên trong */
                border: 1px solid #ccc;
                /* Đường viền */
                border-radius: 5px;
                /* Bo góc */
                background-color: #f9f9f9;
                /* Màu nền */
                box-sizing: border-box;
                /* Đảm bảo padding không làm thay đổi kích thước */
            }

            /* Tùy chỉnh thanh cuộn */
            .scrollable::-webkit-scrollbar {
                width: 8px;
                /* Chiều rộng của thanh cuộn */
            }

            .scrollable::-webkit-scrollbar-thumb {
                background-color: #888;
                /* Màu của phần kéo */
                border-radius: 4px;
                /* Bo góc */
            }

            .scrollable::-webkit-scrollbar-thumb:hover {
                background-color: #555;
                /* Màu khi di chuột qua */
            }
        </style>
        <div class="container-fluid">
            <!-- Breadcrumb -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Chi tiết phản hồi',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => route('admin.dashboard')],
                    ['name' => 'Phản hồi', 'url' => route('admin.feedbacks.index')],
                    ['name' => 'Chi tiết phản hồi', 'url' => '#'],
                ],
            ])

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin liên lạc</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Họ & tên:</strong> {{ $feedback->full_name }}</p>
                                    <p><strong>Email:</strong> {{ $feedback->email }}</p>
                                    <p><strong>Điện thoại:</strong> {{ $feedback->phone_number }}</p>
                                    <p><strong>Thời gian:</strong> {{ $feedback->date_submitted }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Địa chỉ:</strong> {{ $feedback->address ?? 'N/A' }}</p>
                                    <p><strong>Loại Phản Hồi:</strong> {{ $feedback->feedback_type }}</p>
                                    <p><strong>Chủ Đề:</strong> {{ $feedback->subject }}</p>
                                    <p><strong>Đánh giá:</strong> {{ $feedback->rating ?? 'N/A' }} / 5</p>
                                    <!-- Display rating -->
                                </div>
                            </div>
                            <hr>
                            <h5 class="card-title">Nội dung</h5>
                            {{-- <p class="p">{{ $feedback->message }}</p> --}}
                            <div class="scrollable">
                                <p>{{ $feedback->message }}</p>
                            </div>

                            @if ($feedback->attachment_url)
                                <div class="mb-3">
                                    <strong>Hình ảnh đính kèm:</strong>
                                    <img src="{{ asset('storage/' . $feedback->attachment_url) }}" alt="Attachment"
                                        class="img-fluid" width="30%" />
                                </div>
                            @else
                                <p class="text-muted">Không có hình ảnh đính kèm.</p>
                            @endif

                        </div>
                    </div>

                    <!-- Admin Response Section -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Trả lời</h5>
                            <hr>
                            @if ($feedback->admin_response)
                                <p><strong>Phản hồi:</strong></p>
                                <p>{{ $feedback->admin_response }}</p>
                                <p><strong>Thời gian:</strong>
                                    {{ \Carbon\Carbon::parse($feedback->response_date)->format('d-m-Y H:i:s') }}</p>
                            @else
                                <p class="text-muted">Chưa có phản hồi nào !</p>
                            @endif


                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Xuất bản</h5>
                            <!-- Form to update the status -->
                            <form method="POST"
                                action="{{ route('admin.feedbacks.updateStatus', $feedback->feedback_id) }}">
                                @csrf
                                @method('PATCH') <!-- Correct method for updating -->

                                <div class="mb-3">
                                    <label for="response" class="form-label">Phản hồi của quản trị viên</label>
                                    <textarea id="response" name="response" class="form-control" rows="3">{{ $feedback->admin_response }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="Chưa xử lý"
                                            {{ $feedback->status == 'Chưa xử lý' ? 'selected' : '' }}>Chưa xử lý</option>
                                        <option value="Đang xử lý"
                                            {{ $feedback->status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="Đã xử lý" {{ $feedback->status == 'Đã xử lý' ? 'selected' : '' }}>Đã
                                            xử lý</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Lưu & Thoát</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
