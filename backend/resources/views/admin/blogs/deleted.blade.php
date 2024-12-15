@extends('admin.layouts.app')

@section('content')
    <style>
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Chiều cao tối thiểu bằng chiều cao của màn hình */
            margin: 0 auto;
            /* Căn giữa ngang */
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Bài viết ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Bài viết', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="customerList">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title mb-0"><a class="text-dark" href="">Danh sách đã
                                                        xóa</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-3">
                                                <form method="GET" action="{{ route('admin.blogs.listTrash') }}">
                                                    <input type="text" class="form-control search" name="search"
                                                        placeholder="Nhập từ khóa tìm kiếm..."
                                                        value="{{ request()->input('search') }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="listjs-table" id="customerList">
                                    <div class="card-header border-0 mt-2">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h1 class="card-title fw-semibold mb-0"></h1>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-soft-danger ms-2" id="deleteMultipleBtn"
                                                    style="display: none;">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </button>

                                                <a href="{{ route('admin.blogs.index') }}"
                                                    class="btn btn-soft-primary ms-2">
                                                    <i class="ri-home-6-fill"></i>Trang list
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (session('success'))
                                        <div class="w-full alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="table-responsive table-card mt-2 mb-1">
                                        <table
                                            class="table table-bordered table-hover table-striped align-middle table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                                value="option">
                                                        </div>
                                                    </th>
                                                    <th>Stt</th>
                                                    <th>Tiêu đề bài viết</th>
                                                    <th>Ảnh đại diện</th>
                                                    <th>Ngày xóa</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($data as $index => $item)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="{{ $item->id }}">
                                                            </div>
                                                        </th>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->title }}</td>
                                                        <td class="text-center"> <!-- Căn giữa nội dung -->
                                                            <div
                                                                style="width: 50px; height: 50px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                                <img src="{{ Storage::url($item->thumbnail) }}"
                                                                    style="width: 100%; height: 100%; object-fit: cover;"
                                                                    alt="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ $item->deleted_at instanceof \Carbon\Carbon ? $item->deleted_at->format('d-m-Y H:i:s') : '' }}
                                                        </td>




                                                        <td>
                                                            <form id="restoreForm-{{ $item->id }}"
                                                                action="{{ route('admin.blogs.restore', $item->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('PATCH')

                                                                <!-- Nút Button để mở Modal -->
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-item-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#restoreModal-{{ $item->id }}">
                                                                    Khôi phục
                                                                </button>

                                                                <!-- Modal xác nhận khôi phục -->
                                                                <div class="modal fade"
                                                                    id="restoreModal-{{ $item->id }}" tabindex="-1"
                                                                    aria-labelledby="restoreModalLabel-{{ $item->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="restoreModalLabel-{{ $item->id }}">
                                                                                    Xác nhận khôi phục</h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Bạn có chắc chắn muốn khôi phục bài viết này
                                                                                không?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                                <!-- Nút gửi form khôi phục -->
                                                                                <button type="submit"
                                                                                    class="btn btn-info">Khôi phục</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>


                                                            <form action="{{ route('admin.blogs.hardDelete', $item->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')



                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#confirmDeleteModal"
                                                                    data-id="{{ $item->id }}"
                                                                    class="btn btn-sm btn-danger remove-item-btn">
                                                                    Xóa vĩnh viễn
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="results-info ms-3">
                                <p class="pagination mb-0">
                                    Showing
                                    {{ $data->firstItem() }}
                                    to
                                    {{ $data->lastItem() }}
                                    of
                                    {{ $data->total() }}
                                    results
                                </p>
                            </div>
                            <div class="pagination-wrap me-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if ($data->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $data->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    Previous
                                                </a>
                                            </li>
                                        @endif
                                        @foreach ($data->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <span class="page-link">{{ $element }}</span>
                                                </li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $data->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @if ($data->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $data->nextPageUrl() }}"
                                                    aria-label="Next">
                                                    Next
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end row -->
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa dữ liệu này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal xác nhận khôi phục -->
@endsection
@section('script_libray')
    <!-- Nạp jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll');
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById(
                'confirmDeleteModal')); // Khởi tạo modal
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn'); // Nút Xóa trong modal

            let selectedIds = []; // Biến lưu ID đã chọn

            // Kiểm tra checkbox và hiển thị/ẩn nút xóa nhiều
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'block' : 'none';
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });

            // Checkbox "Chọn tất cả"
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'block' : 'none';
            });

            // Nút xóa nhiều - Hiển thị modal xác nhận
            deleteMultipleBtn.addEventListener('click', function() {
                selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một thuộc tính để xóa.');
                    return;
                }

                // Hiển thị modal xác nhận
                confirmDeleteModal.show();
            });

            // Nút Xóa trong modal
            confirmDeleteBtn.addEventListener('click', function() {
                const action = 'soft_delete_attribute';

                // Gửi request AJAX
                $.ajax({
                    url: `{{ route('admin.attributes.deleteMultiple') }}`,
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: action,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr); // Hiển thị thông tin lỗi chi tiết
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                        } else {
                            alert('Có lỗi xảy ra: ' + xhr.statusText);
                        }
                    }
                });

                // Ẩn modal sau khi thực thi
                confirmDeleteModal.hide();
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const restoreModal = new bootstrap.Modal(document.getElementById('restoreModal'));
            const confirmRestoreBtn = document.getElementById("confirmRestoreBtn");
            let restoreId = null;

            // Khi nút "Khôi phục" trong modal được nhấn
            document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#restoreModal"]').forEach(
                button => {
                    button.addEventListener('click', function() {
                        restoreId = this.getAttribute('data-id');
                        console.log('ID mục cần khôi phục:', restoreId); // Kiểm tra ID có đúng không
                    });
                });

            // Khi nhấn nút "Khôi phục" trong modal
            if (confirmRestoreBtn) {
                confirmRestoreBtn.addEventListener("click", function() {
                    if (restoreId) {
                        // Cập nhật lại URL form với ID cần khôi phục
                        const form = document.getElementById('restoreForm');
                        form.action = `{{ route('admin.blogs.restore', '') }}/${restoreId}`;

                        // Submit form sau khi xác nhận
                        form.submit();

                        // Đóng modal
                        restoreModal.hide();
                    } else {
                        alert("Không có mục nào để khôi phục.");
                    }
                });
            }
        });
    </script>
    
@endsection
