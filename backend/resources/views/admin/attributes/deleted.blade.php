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
                                                <h5 class="card-title mb-0 "><a class="text-dark"
                                                        href="{{ route('admin.attributes.attributeshortdeleted') }}">Danh sách đã xóa</a>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-3">
                                                <form method="GET" action="{{ route('admin.attributes.attributeshortdeleted') }}">
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
                                    <div class="card-header border-0 mt-2">
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
                                                    <i class="ri-add-box-fill"></i> Thêm
                                                </a>
                                                <a href="{{ route('admin.attributes.index') }}"
                                                    class="btn btn-soft-primary ms-2">
                                                    <i class="ri-home-6-fill"></i>Quay lại
                                                </a>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <th>Tên thuộc tính</th>
                                                    <th>Người xóa</th>
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
                                                        <td>{{ $item->attribute_name }}</td>
                                                        @php
                                                            $deletedByUser = $users->firstWhere(
                                                                'id',
                                                                $item->deleted_by,
                                                            );
                                                        @endphp
                                                        @if ($deletedByUser)
                                                            <td>{{ $deletedByUser->username }}</td>
                                                        @else
                                                            <td>Unknown</td>
                                                        @endif
                                                        <td>{{ $item->deleted_at ? $item->deleted_at->format('H:i d-m-Y') : '' }}
                                                        </td>

                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-info edit-item-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#restoreAttributesModal"
                                                                data-id="{{ $item->id }}">
                                                                Khôi phục
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#hardDeleteAttributesModal"
                                                                data-id="{{ $item->id }}">
                                                                Xóa
                                                            </button>
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
                                                <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
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
    <div class="modal fade" id="restoreAttributesModal" tabindex="-1" aria-labelledby="restoreAttributesModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreAttributesModalLabel">Khôi phục Thuộc Tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn khôi phục thuộc tính này?
                    <form id="restore-attribute-form" method="POST">
                        @csrf
                        @method('PATCH')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-info" id="confirm-restore">Khôi phục</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hardDeleteAttributesModal" tabindex="-1" aria-labelledby="hardDeleteAttributesModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hardDeleteAttributesModalLabel">Xóa Vĩnh Viễn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa vĩnh viễn thuộc tính này?
                    <form id="hard-delete-attribute-form" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirm-hard-delete">Xóa </button>
                </div>
            </div>
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
@endsection
@section('script_libray')
    <!-- Nạp jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const restoreButtons = document.querySelectorAll('.edit-item-btn');
            const restoreForm = document.getElementById('restore-attribute-form');
            const confirmRestoreButton = document.getElementById('confirm-restore');

            restoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const actionUrl = `/admin/attributes/restore/${itemId}`;
                    restoreForm.setAttribute('action', actionUrl);
                });
            });

            confirmRestoreButton.addEventListener('click', function() {
                restoreForm.submit();
            });

            const hardDeleteButtons = document.querySelectorAll('.remove-item-btn');
            const hardDeleteForm = document.getElementById('hard-delete-attribute-form');
            const confirmHardDeleteButton = document.getElementById('confirm-hard-delete');

            hardDeleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const actionUrl = `/admin/attributes/${itemId}/hard-delete`;
                    hardDeleteForm.setAttribute('action', actionUrl);
                });
            });

            confirmHardDeleteButton.addEventListener('click', function() {
                hardDeleteForm.submit();
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
                        action: 'hard_delete_attribute',
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
