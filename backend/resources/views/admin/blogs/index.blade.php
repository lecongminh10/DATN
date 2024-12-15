@extends('admin.layouts.app')
@section('title')
    Danh sách bài viết
@endsection
@section('content')
    <style>
        .content-ellipsis {
            max-width: 200px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

        }

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
                'title' => 'Bài viết',
                'breadcrumb' => [
                    // ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
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
                                                <h5 class="card-title "><a class="text-dark"
                                                        href="{{ route('admin.blogs.index') }}">Danh sách </a></h5>
                                            </div>
                                        </div>

                                        <div class="col-sm-auto">
                                            <div class="search-box mb-2">
                                                <form method="GET" action="{{ route('admin.blogs.index') }}">
                                                    @csrf
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
                                    <div class="card-header border-0 mt-1">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h1 class="card-title fw-semibold mb-0"></h1>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-soft-danger me-2" id="deleteMultipleBtn"
                                                    style="display: none;">
                                                    <i class="ri-delete-bin-5-fill align-bottom"></i>
                                                </button>
                                                <a href="{{ route('admin.blogs.listTrash') }}" class="btn btn-warning">
                                                    <i class="ri-delete-bin-5-line align-bottom me-1"></i> Thùng rác
                                                </a>

                                                <a class="btn btn-success add-btn ms-2"
                                                    href="{{ route('admin.blogs.create') }}">
                                                    <i class="ri-add-line align-bottom "></i> Thêm mới
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (session('success'))
                                        <div class="w-full alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="table-responsive table-card mt-1">
                                        <table class="table align-middle">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                                value="option">
                                                        </div>
                                                    </th>
                                                    <th>STT</th>
                                                    <th>Ảnh đại diện</th>
                                                    <th>Tiêu đề</th>
                                                    <th>Nội dung</th>
                                                    <th>Tác giả</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Trạng thái</th>
                                                    <th class="text-center">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($blogs as $index => $item)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="{{ $item->id }}">
                                                            </div>
                                                        </th>
                                                        <td>{{ $index + 1 }}</td>

                                                        <td class="text-center"> <!-- Căn giữa nội dung -->
                                                            <div
                                                                style="width: 50px; height: 50px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                                <img src="{{ Storage::url($item->thumbnail) }}"
                                                                    style="width: 100%; height: 100%; object-fit: cover;"
                                                                    alt="">
                                                            </div>
                                                        </td>
                                                        <td class="title-ellipsis">
                                                            <a href="{{ route('admin.blogs.show', $item->id) }}"
                                                                class="dropdown-item">
                                                                {{ $item->title }}
                                                            </a>
                                                        </td>
                                                        <td class="content-ellipsis">
                                                            {{ $item->content }}
                                                        </td>
                                                        <td>
                                                            {{ optional($item->user)->username ?? 'N/A' }}
                                                        </td>

                                                        <td>{{ $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : '' }}
                                                        </td>
                                                        <td>
                                                            @if ($item->is_published == 1)
                                                                <span class="badge bg-success">Đã xuất bản</span>
                                                            @elseif ($item->is_published == 0)
                                                                <span class="badge bg-warning text-dark">Chưa xuất
                                                                    bản</span>
                                                            @elseif ($item->is_published == 2)
                                                                <span class="badge bg-secondary">Bản nháp</span>
                                                            @else
                                                                <span class="badge bg-danger">Trạng thái không xác
                                                                    định</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <div class="dropdown d-inline-block">
                                                                    <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill align-middle"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="{{ route('admin.blogs.show', $item->id) }}"
                                                                                class="dropdown-item"><i
                                                                                    class="ri-eye-fill align-bottom me-2 fs-16"></i>
                                                                                Xem</a></li>
                                                                        <li><a href="{{ route('admin.blogs.edit', $item->id) }}"
                                                                                class="dropdown-item edit-item-btn"><i
                                                                                    class="ri-pencil-fill fs-16 align-bottom me-2"></i>
                                                                                Sửa</a></li>
                                                                        <li>
                                                                            <!-- Form Xóa -->
                                                                            {{-- <form
                                                                                action="{{ route('admin.blogs.destroy', $item->id) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE') --}}
                                                                                <!-- Nút Button để mở Modal -->
                                                                                <button type="button"
                                                                                        class="dropdown-item text-danger"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#blogsDeleteModal"
                                                                                        data-id="{{ $item->id }}">
                                                                                    <i class="ri-delete-bin-5-fill fs-16 align-bottom me-2"></i> Xóa
                                                                                </button>

                                                                            {{-- </form> --}}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <div class="results-info ms-3">
                                <p class="pagination mb-0">
                                    Showing
                                    {{ $blogs->firstItem() }}
                                    to
                                    {{ $blogs->lastItem() }}
                                    of
                                    {{ $blogs->total() }}
                                    results
                                </p>
                            </div>
                            <div class="pagination-wrap me-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if ($blogs->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $blogs->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    Previous
                                                </a>
                                            </li>
                                        @endif
                                        @foreach ($blogs->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <span class="page-link">{{ $element }}</span>
                                                </li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $blogs->currentPage())
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
                                        @if ($blogs->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $blogs->nextPageUrl() }}"
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
    <!-- Modal xóa nhiều -->
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

    <!-- Modal xóa 1 -->

    <div class="modal fade" id="blogsDeleteModal" tabindex="-1" aria-labelledby="blogsDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogsDeleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa dữ liệu này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script_libray')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        document.getElementById('search-input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const query = this.value;
                window.location.href = `/search?query=${encodeURIComponent(query)}`;
            }
        });
    </script>

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
                const action = 'soft_delete_blog'; // Modify this as per the action for blogs

                // Gửi request AJAX
                $.ajax({
                    url: `{{ route('admin.blogs.deleteMultiple') }}`, // Update URL to point to blog deletion
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: action,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response.message); // Show the success message
                        location.reload(); // Reload the page after successful deletion
                    },
                    error: function(xhr) {
                        console.log(xhr); // Show detailed error information
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                        } else {
                            alert('Có lỗi xảy ra: ' + xhr.statusText);
                        }
                    }
                });

                // Hide the modal after performing the action
                confirmDeleteModal.hide();
            });

        });
    </script>

    <script>
        let blogIdToDelete = null;

        // Lắng nghe sự kiện khi người dùng nhấn nút "Xóa" trong modal
        $('.dropdown-item.text-danger').on('click', function() {
            // Lưu ID của bài viết cần xóa
            blogIdToDelete = $(this).data('id');
        });

        // Lắng nghe sự kiện khi người dùng nhấn nút "Xóa" trong modal confirm
        $('#confirm-delete-btn').on('click', function() {
            if (blogIdToDelete !== null) {
                // Gửi AJAX request để xóa bài viết
                $.ajax({
                    url: '/blogs/' + blogIdToDelete,  // URL đến route xóa bài viết
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'  // Thêm CSRF token vào request
                    },
                    success: function(response) {
                        // Nếu xóa thành công, đóng modal và thông báo
                        $('#blogsDeleteModal').modal('hide');
                        alert('Bài viết đã được xóa thành công');
                        location.reload();  // Reload lại trang để cập nhật danh sách
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có
                        alert('Không thể xóa bài viết. Vui lòng thử lại.');
                    }
                });
            }
        });

    </script>
@endsection
