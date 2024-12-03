@extends('admin.layouts.app')

@section('title')
    Danh sách đơn hàng
@endsection
@section('style_css')
    <style>
        .description {
            display: block;
            max-height: 100px;
            overflow-y: auto;
            word-wrap: break-word;
            white-space: normal;
        }
        /* Cấu hình cho modal body */
        .modal-body {
            max-height: 400px; /* Giới hạn chiều cao của modal body */
            /* overflow-y: auto;  Hiển thị thanh cuộn dọc khi nội dung quá dài */
            word-wrap: break-word;  /* Cắt từ dài để xuống dòng */
            white-space: normal;    /* Đảm bảo nội dung có thể xuống dòng */
        }

        .text-reason {
            display: block;
            max-height: 150px; /* Chiều cao tối đa */
            overflow-y: scroll; /* Hiển thị thanh cuộn dọc */
            white-space: normal; /* Cho phép văn bản xuống dòng */
            word-wrap: break-word; /* Chia từ khi cần thiết */
            padding-right: 10px; /* Để tránh chữ dính vào thanh cuộn */
        }

        /* Tùy chỉnh thanh cuộn cho các trình duyệt Webkit (Chrome, Safari, Opera) */
        .text-reason::-webkit-scrollbar {
            width: 8px; /* Độ rộng thanh cuộn */
        }

        .text-reason::-webkit-scrollbar-track {
            background: #f1f1f1; /* Màu nền của thanh cuộn */
            border-radius: 10px;
        }

        .text-reason::-webkit-scrollbar-thumb {
            background: #888; /* Màu của thanh cuộn */
            border-radius: 10px;
        }

        .text-reason::-webkit-scrollbar-thumb:hover {
            background: #555; /* Màu khi hover vào thanh cuộn */
        }

        /* Tùy chỉnh cho Firefox */
        .text-reason {
            scrollbar-width: thin; /* Độ rộng thanh cuộn */
            scrollbar-color: #888 #f1f1f1; /* Màu thanh cuộn và nền */
        }

        #image-preview-container img {
            width: 100%; /* Chiếm hết chiều rộng của col */
            height: auto; /* Duy trì tỷ lệ */
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Danh mục ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Danh mục', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="mb-sm-0">Hoàn trả </h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('refunds.index') }}" method="GET" class="row mb-4">
                                <div class="col-md-5">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tìm kiếm theo mã đơn hàng, tên người dùng, trạng thái..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="requested_at" class="form-control" 
                                           value="{{ request('requested_at') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">-- Tất cả trạng thái --</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Bị từ chối</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                </div>
                            </form>

                            <table class="table table-bordered">

                                <thead>

                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Mã đơn hàng</th>
                                        <th scope="col">Tên người dùng</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Số tiền hoàn trả</th>
                                        <th scope="col">Ngày yêu cầu</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($refunds as $refund)
                                        <tr>
                                            <td>{{ $refund->id }}</td>
                                            <td>{{ $refund->order->code ?? '-' }}</td>
                                            <td>{{ $refund->user->username ?? '-' }}</td>
                                            <td>{{ $refund->quantity }}</td>
                                            <td>{{ number_format($refund->amount, 0, ',', '.') }} ₫</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $refund->requested_at, 'Asia/Ho_Chi_Minh')->format('H:i:s d-m-Y') }}</td>
                                            <td>
                                                @switch($refund->status)
                                                    @case('pending')
                                                        Đang chờ
                                                        @break
                                                    @case('approved')
                                                        Đã duyệt
                                                        @break
                                                    @case('rejected')
                                                        Bị từ chối
                                                        @break
                                                    @case('completed')
                                                        Hoàn thành
                                                        @break
                                                    @default
                                                        Chưa xác định
                                                @endswitch
                                            </td>
                                            <td>
                                                <button data-bs-id="{{ $refund->id }}" data-bs-status="{{ $refund->status }}" 
                                                    type="button" class="btn btn-primary" data-bs-toggle="modal" 
                                                    data-bs-target="#refundModal">Cập nhật</button>
                                                    <button 
                                                        data-bs-id="{{ $refund->id }}" 
                                                        data-bs-reason="{{ strip_tags($refund->reason) }}" 
                                                        data-bs-images='@json($refund->image ? array_map(fn($image) => asset("storage/$image"), is_array($refund->image) ? $refund->image : json_decode($refund->image, true)) : [])'
                                                        type="button" 
                                                        class="btn btn-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#reason">
                                                        Lý do
                                                    </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Không tìm thấy kết quả</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Thay đổi trạng thái</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="refund-form" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control">
                            <option value="pending">Đang chờ</option>
                            <option value="approved">Đã duyệt</option>
                            <option value="rejected">Bị từ chối</option>
                            <option value="completed">Hoàn thành</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="submit-refund">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reason" tabindex="-1" aria-labelledby="reasonLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reasonLabel">Lý do hoàn trả</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Lý do:</strong></p>
                    <span class="text-reason"></span> <!-- Lý do hoàn trả sẽ được thêm vào đây -->
    
                    <hr>
                    <p><strong>Ảnh minh chứng:</strong></p>
                    <div id="image-preview-container" class="row gx-2 gy-2"></div> <!-- Ảnh nhỏ sẽ được hiển thị tại đây -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_libray')
@endsection

@section('scripte_logic')
<script>
    // Khi nhấn nút "Cập nhật"
    document.querySelectorAll('button[data-bs-target="#refundModal"]').forEach(button => {
        button.addEventListener('click', function () {
            const refundId = this.getAttribute('data-bs-id'); // Lấy ID từ data-bs-id
            const refundStatus = this.getAttribute('data-bs-status'); // Lấy trạng thái từ data-bs-status

            const form = document.getElementById('refund-form'); // Form trong modal
            const statusDropdown = form.querySelector('select[name="status"]'); // Dropdown trạng thái

            // Cập nhật action của form với đúng ID
            form.action = `/refunds/${refundId}`;

            // Gán giá trị trạng thái vào dropdown
            statusDropdown.value = refundStatus;
        });
    });

    document.getElementById('submit-refund').addEventListener('click', function () {
        const form = document.getElementById('refund-form');
        if (form) {
            form.submit(); // Gửi form
        }
    });

    // Lắng nghe sự kiện click vào nút "Lý do"
    document.querySelectorAll('button[data-bs-target="#reason"]').forEach(button => {
        button.addEventListener('click', function () {
            // Lấy dữ liệu từ thuộc tính data-bs
            const reason = this.getAttribute('data-bs-reason');
            const images = JSON.parse(this.getAttribute('data-bs-images') || '[]'); // Chuyển chuỗi JSON thành mảng

            // Hiển thị lý do hoàn trả
            document.querySelector('#reason .modal-body .text-reason').textContent = reason;

            // Hiển thị danh sách ảnh
            const imageContainer = document.querySelector('#reason .modal-body #image-preview-container');
            imageContainer.innerHTML = ''; // Xóa nội dung cũ

            // Duyệt qua danh sách ảnh và tạo các thẻ img
            images.forEach(imageUrl => {
                const imgDiv = document.createElement('div');
                imgDiv.classList.add('col-4'); // Chia 3 cột

                const img = document.createElement('img');
                img.src = imageUrl; // Đường dẫn ảnh từ database
                img.alt = "Ảnh minh chứng";
                img.classList.add('img-thumbnail');

                imgDiv.appendChild(img);
                imageContainer.appendChild(imgDiv);
            });
        });
    });
</script>
@endsection
