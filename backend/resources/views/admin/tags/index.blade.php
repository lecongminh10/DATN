@extends('admin.layouts.app')

@section('title')
    Danh Sách Thẻ
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'thẻ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thẻ', 'url' => '#'],
                ],
            ])

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <a href="{{ route('admin.tags.index') }}">
                                            <h5 class="card-title mb-0">Danh sách thẻ</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (session('success'))
                            <div class="w-full alert alert-success " style="margin-bottom: 20px">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card-body border-bottom-dashed border-bottom">
                            <form method="GET" action="{{ route('admin.tags.index') }}" id="search-form">
                                <div class="row g-3">
                                    <div class="col-xl-3">
                                        <div class="search-box">
                                            <input type="text" class="form-control search" name="search"
                                                placeholder="Nhập từ khóa tìm kiếm..."
                                                value="{{ request()->input('search') }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xl-5">
                                        <div class="row g-3">
                                            <div class="col-sm-3">
                                                <div>
                                                    <!-- Nút Filters bây giờ là nút submit của form tìm kiếm -->
                                                    <button type="submit" form="search-form" class="btn btn-primary">
                                                        <i class="ri-equalizer-fill me-2 align-bottom"></i>Tìm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row g-4 d-flex justify-content-end">
                                            <div class="col-sm-auto">
                                                <button class="btn btn-soft-danger me-2" id="deleteMultipleBtn" style="display: none;">
                                                    <i class="ri-delete-bin-5-fill  align-bottom"></i>
                                                </button>
                                                <a href="{{ route('admin.tags.create') }}" class="btn btn-success me-2 add-btn"
                                                    id="create-btn"><i class="ri-add-line align-bottom"></i> Thêm mới</a>
                                                <a href="{{ route('admin.tags.deleted') }}" class="btn btn-warning">
                                                    <i class="ri-delete-bin-2-line align-bottom"></i> Thùng rác
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle" id="carriersTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th data-sort="carrier_name">Tên thẻ</th>
                                                <th data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        @foreach ($tags as $key => $value)
                                            <tbody class="list form-check-all">
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $value->id }}">
                                                        </div>
                                                    </th>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="carrier_name">{{ $value->name }}</td>
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-itvalueem edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Edit">
                                                                <a href="{{ route('admin.tags.edit', $value->id) }}"
                                                                    class="text-primary d-inline-block edit-item-btn">
                                                                    <i class="ri-pencil-fill fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <button class="btn btn-link text-danger p-0" title="Xóa"
                                                                onclick="confirmDelete('{{ $value->id }}', '{{ $value->name }}')">
                                                                <i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            </button>
                                                            <form id="deleteForm-{{ $value->id }}"
                                                                action="{{ route('admin.tags.destroy', $value->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                    <div class="results-info ms-3">
                                        <p class="pagination mb-0">
                                            Hiển thị
                                            {{ $tags->firstItem() }}
                                            đến
                                            {{ $tags->lastItem() }}
                                            của
                                            {{ $tags->total() }}
                                            kết quả
                                        </p>
                                    </div>
                                    <div class="pagination-wrap me-3">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                @if ($tags->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Previous</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $tags->previousPageUrl() }}"
                                                            aria-label="Previous">
                                                            Previous
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($tags->links()->elements as $element)
                                                    @if (is_string($element))
                                                        <li class="page-item disabled">
                                                            <span class="page-link">{{ $element }}</span>
                                                        </li>
                                                    @endif

                                                    @if (is_array($element))
                                                        @foreach ($element as $page => $url)
                                                            @if ($page == $tags->currentPage())
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

                                                @if ($tags->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $tags->nextPageUrl() }}"
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

                                {{-- modal --}}
                                <div class="modal fade flip" id="deleteModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                    colors="primary:#405189,secondary:#f06548"
                                                    style="width:90px;height:90px"></lord-icon>
                                                <div class="mt-4 text-center">
                                                    <h4 id="modalTitle">Bạn có chắc chắn muốn xóa thẻ này?
                                                    </h4>
                                                    <p class="text-muted fs-14 mb-4" id="modalName"></p>
                                                    <div class="hstack gap-2 justify-content-center remove mt-3">
                                                        <button
                                                            class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                                                            id="deleteRecord-close" data-bs-dismiss="modal">
                                                            <i class="ri-close-line me-1 align-middle"></i> Đóng
                                                        </button>
                                                        <button class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script_libray')
    <!-- Nạp jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        function filterData() {
            // Tìm form cần submit
            const form = document.querySelector('.search-box form');

            // Nếu tìm thấy form, submit
            if (form) {
                form.submit();
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const modalTitle = document.getElementById('modalTitle');
            const modalName = document.getElementById('modalName');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            // Kiểm tra checkbox và hiển thị/ẩn nút xóa nhiều
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'inline-block' : 'none';
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });

            // Thêm sự kiện cho checkbox "Chọn tất cả"
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'inline-block' : 'none';
            });

            // Thêm sự kiện click cho nút xóa nhiều
            deleteMultipleBtn.addEventListener('click', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một thẻ để xóa.');
                    return;
                }

                // Hiển thị danh sách các thẻ được chọn trong modal
                modalTitle.innerText = 'Bạn có chắc chắn muốn xóa những thẻ này?';

                // Hiển thị modal
                deleteModal.show();

                // Xử lý khi xác nhận xóa
                confirmDeleteBtn.onclick = function() {
                    const action = 'soft_delete_tags';

                    $.ajax({
                        url: `{{ route('admin.tags.deleteMultiple') }}`,
                        method: 'POST',
                        data: {
                            ids: selectedIds,
                            action: action,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Hiển thị thông báo từ server
                            if (response.message) {
                                $('#messageBox').text(response.message).show().fadeOut(
                                5000); // Hiển thị thông báo và ẩn sau 5 giây
                            }
                            location.reload(); // Reload trang sau khi xử lý xong
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            let errorMessage = 'Có lỗi xảy ra';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = 'Có lỗi xảy ra: ' + xhr.responseJSON.message;
                            } else {
                                errorMessage = 'Có lỗi xảy ra: ' + xhr.statusText;
                            }
                            $('#messageBox').text(errorMessage).show().fadeOut(
                            5000); // Hiển thị thông báo lỗi và ẩn sau 5 giây
                        }
                    });
                    deleteModal.hide();
                };


            });
        });

        function confirmDelete(nameId, name) {
            document.getElementById('modalName').innerText = `Thẻ: ${name}`;
            const deleteBtn = document.getElementById('confirmDeleteBtn');

            deleteBtn.onclick = function() {
                document.getElementById(`deleteForm-${nameId}`).submit();
            };

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
