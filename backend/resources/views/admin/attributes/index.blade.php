@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Thuộc tính ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thuộc tính', 'url' => '#'],
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
                                                        href="{{ route('admin.attributes.index') }}">Danh sách</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-2">
                                                <form method="GET" action="{{ route('admin.attributes.index') }}">
                                                    <input type="text" class="form-control search" name="search"
                                                        placeholder="Nhập từ khóa tìm kiếm..."
                                                        value="{{ request()->input('search') }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (session('success'))
                                <div class="w-full alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                                <div class="listjs-table" id="customerList">
                                    <div class="card-header border-0 mt-1">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h1 class="card-title fw-semibold mb-0"></h1>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-soft-danger ms-2" id="deleteMultipleBtn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteMultipleModal"
                                                    style="display: none;">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </button>
                                                <a class="btn btn-success add-btn ms-2"
                                                    href="{{ route('admin.attributes.create') }}">
                                                    <i class="ri-add-line"></i> Thêm mới
                                                </a>
                                                <a href="{{ route('admin.attributes.attributeshortdeleted') }}"
                                                    class="btn btn-warning ms-2">
                                                    <i class="ri-delete-bin-2-line"></i>Thùng rác
                                                </a>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <th>Stt</th>
                                                    <th>Tên </th>
                                                    <th>Mô tả </th>
                                                    <th>Ngày tạo</th>
                                                    <th>Ngày Sửa</th>
                                                    <th class="text-center">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($attributes as $index => $item)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="{{ $item->id }}">
                                                            </div>
                                                        </th>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.attributes.show', $item->id) }}"
                                                                class="dropdown-item">
                                                                {{ $item->attribute_name }}</a>

                                                        </td>
                                                        <td>{{ $item->description }}</td>
                                                        {{-- <td>
                                                            @foreach ($item->attributeValues as $value)
                                                                <a href="{{ route('admin.attributes.show', $item->id) }}"
                                                                    class="badge bg-primary text-decoration-none me-2 p-2 fs-8">
                                                                    {{ $value->attribute_value }}
                                                                </a>
                                                            @endforeach
                                                        </td> --}}
                                                        <td>{{ $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : '' }}
                                                        </td>
                                                        <td>{{ $item->updated_at ? $item->updated_at->format('d-m-Y H:i:s') : '' }}
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
                                                                        <li><a href="{{ route('admin.attributes.show', $item->id) }}"
                                                                                class="dropdown-item"><i
                                                                                    class="ri-eye-fill align-bottom me-2 fs-16"></i>
                                                                                Xem</a></li>
                                                                        <li><a href="{{ route('admin.attributes.edit', $item->id) }}"
                                                                                class="dropdown-item edit-item-btn"><i
                                                                                    class="ri-pencil-fill fs-16 align-bottom me-2"></i>
                                                                                Sửa</a></li>
                                                                        <li>
                                                                            <button type="button"
                                                                                class="dropdown-item remove-item-btn"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#deleteAttributesModal"
                                                                                data-id="{{ $item->id }}">
                                                                                <i
                                                                                    class="ri-delete-bin-5-fill fs-16 align-bottom me-2"></i>
                                                                                Xóa
                                                                            </button>
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
                        @include('admin.components.pagination', ['data' => $attributes])
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end row -->
        </div>
    </div>
    <div class="modal fade" id="deleteMultipleModal" tabindex="-1" aria-labelledby="deleteMultipleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMultipleModalLabel">Xóa Nhiều Thuộc Tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa các thuộc tính đã chọn không?
                    <form id="delete-multiple-attributes-form" method="POST">
                        <!-- Nội dung form sẽ được thêm động trong JavaScript -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-multiple">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAttributesModal" tabindex="-1" aria-labelledby="deleteAttributesModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAttributesModalLabel">Xóa Thuộc Tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa thuộc tính này?
                    <form id="delete-attribute-form" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
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
        document.getElementById('search-input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const query = this.value;
                window.location.href = `/search?query=${encodeURIComponent(query)}`;
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.remove-item-btn');
            const modal = document.getElementById('deleteAttributesModal');
            const deleteForm = document.getElementById('delete-attribute-form');
            const confirmButton = document.getElementById('confirm-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const actionUrl = `/admin/attributes/${itemId}`;
                    deleteForm.setAttribute('action', actionUrl);
                });
            });

            confirmButton.addEventListener('click', function() {
                deleteForm.submit();
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll'); // Checkbox "Chọn tất cả"
            const deleteMultipleModal = new bootstrap.Modal(document.getElementById(
                'deleteMultipleModal')); // Modal
            const confirmDeleteMultipleBtn = document.getElementById(
                'confirm-delete-multiple'); // Nút xác nhận xóa trong modal

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'block' : 'none';
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });

            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'block' :
                    'none';
            });

            deleteMultipleBtn.addEventListener('click', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một thuộc tính để xóa.');
                    return;
                }

                deleteMultipleModal.show();

                deleteMultipleModal.selectedIds = selectedIds;
            });

            confirmDeleteMultipleBtn.addEventListener('click', function() {
                const selectedIds = deleteMultipleModal.selectedIds;

                $.ajax({
                    url: `{{ route('admin.attributes.deleteMultiple') }}`,
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: 'soft_delete_attribute',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert('Các thuộc tính đã được xóa thành công!');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                        } else {
                            alert('Có lỗi xảy ra: ' + xhr.statusText);
                        }
                    }
                });
                deleteMultipleModal.hide();
            });
        });
    </script>
@endsection
