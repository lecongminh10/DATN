@extends('admin.layouts.app')

@section('title')
    Thùng Rác
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Trang ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Trang', 'url' => '#'],
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
                                                        href="{{ route('admin.pages.deleted') }}">Thùng Rác</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-3">
                                                <form method="GET" action="{{ route('admin.pages.deleted') }}">
                                                    <input type="text" class="form-control search" name="search"
                                                        placeholder="Nhập từ khóa tìm kiếm..."
                                                        value="{{ request()->input('search') }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row g-3">
                                            <div class="col-xl-6 d-flex align-items-center">
                                                {{-- <div class="col-6">
                                                    <select class="form-select" aria-label=".form-select-sm example"
                                                        id="idStatus">
                                                        <option value="" selected>All</option>
                                                        <option value="active"
                                                            {{ request()->get('status') == 'active' ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="inactive"
                                                            {{ request()->get('status') == 'inactive' ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                </div> --}}
                                                {{-- <div class="col-3 ms-3">
                                                    <button type="button" class="btn btn-primary w-100"
                                                        onclick="filterData();">
                                                        <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
                                                    </button>
                                                </div> --}}
                                            </div>
                                            <div class="col-xl-6 d-flex justify-content-end align-items-center">
                                                <div class="d-flex flex-wrap align-items-start gap-2">
                                                    <button class="btn btn-danger" id="deleteMultipleBtn"
                                                        style="display: none;" data-bs-toggle="modal"
                                                        data-bs-target="#ModaldeleteMultiple">
                                                        <i class="ri-delete-bin-5-fill"></i>
                                                    </button>
                                                    <a href="{{ route('admin.pages.index') }}"
                                                        class="btn btn-primary">Quay lại
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if (session('success'))
                                    <div class="w-full alert alert-success " style="margin-bottom: 20px">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <br>
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
                                                <th data-sort="carrier_name"> Tên</th>
                                                <th data-sort="api_url">Liên kết cố định</th>
                                                <th data-sort="api_token">Mô tả</th>
                                                <th data-sort="phone">Nội dung</th>
                                                <th data-sort="email">Trạng thái</th>
                                                <th data-sort="is_active">Người xóa</th>
                                                <th data-sort="is_active">Thời gian xóa</th>
                                                {{-- <th data-sort="is_active">seo_description</th> --}}
                                                <th data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        @foreach ($pages as $item)
                                            <tbody class="list form-check-all">
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                    </th>
                                                    <td>{{ $item->id }}</td>
                                                    <td class="name">{{ $item->name }}</td>
                                                    <td class="permalink">{{ $item->permalink }}</td>
                                                    <td class="description">{{ $item->description }}</td>
                                                    <td class="content">{{ $item->content }}</td>
                                                    <td class="is_active">
                                                        <span
                                                            class="badge {{ $item->status == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase">
                                                            {{ $item->status == 1 ? 'active' : 'inactive' }}
                                                        </span>
                                                    </td>
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
                                                    <td class="seo_title">{{ $item->deleted_at }}</td>
                                                    {{-- <td class="seo_description">{{ $item->seo_description }}</td> --}}
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info edit-item-btn"
                                                            data-bs-toggle="modal" data-bs-target="#restorePagesModal"
                                                            data-id="{{ $item->id }}">
                                                            Khôi phục
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn"
                                                            data-bs-toggle="modal" data-bs-target="#hardDeletePagesModal"
                                                            data-id="{{ $item->id }}">
                                                            Xóa
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt2 mb-3">
                            <div class="results-info ms-3">
                                <p class="pagination mb-0">
                                    Showing
                                    {{ $pages->firstItem() }}
                                    to
                                    {{ $pages->lastItem() }}
                                    of
                                    {{ $pages->total() }}
                                    results
                                </p>
                            </div>
                            <div class="pagination-wrap me-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if ($pages->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pages->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    Previous
                                                </a>
                                            </li>
                                        @endif

                                        @foreach ($pages->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <span class="page-link">{{ $element }}</span>
                                                </li>
                                            @endif

                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $pages->currentPage())
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

                                        @if ($pages->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pages->nextPageUrl() }}"
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
                </div>
            </div><!-- end card -->
        </div>
        <!-- end row -->
    </div>
    </div>
    <div class="modal fade" id="restorePagesModal" tabindex="-1" aria-labelledby="restorePagesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restorePagesModalLabel">Khôi phục Trang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn khôi phục trang này?
                    <form id="restore-page-form" method="POST">
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
    <div class="modal fade" id="hardDeletePagesModal" tabindex="-1" aria-labelledby="hardDeletePagesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hardDeletePagesModalLabel">Xóa Vĩnh Viễn Trang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa vĩnh viễn trang này?
                    <form id="hard-delete-page-form" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirm-hard-delete">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModaldeleteMultiple" tabindex="-1" aria-labelledby="deleteMultipleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMultipleModalLabel">Xóa Nhiều Trang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa các trang đã chọn?
                    <form id="delete-multiple-pages-form" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
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
        // Bộ Lọc
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search-input').addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        window.location.href = `/search?query=${encodeURIComponent(query)}`;
                    }
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const restoreButtons = document.querySelectorAll('.edit-item-btn');
            const restoreForm = document.getElementById('restore-page-form');
            const confirmRestoreButton = document.getElementById('confirm-restore');

            restoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pageId = this.getAttribute('data-id');
                    const actionUrl = `/admin/pages/restore/${pageId}`;
                    restoreForm.setAttribute('action', actionUrl);
                });
            });

            confirmRestoreButton.addEventListener('click', function() {
                restoreForm.submit();
            });

            const hardDeleteButtons = document.querySelectorAll('.remove-item-btn');
            const hardDeleteForm = document.getElementById('hard-delete-page-form');
            const confirmHardDeleteButton = document.getElementById('confirm-hard-delete');

            hardDeleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pageId = this.getAttribute('data-id');
                    const actionUrl = `/admin/pages/${pageId}/hard-delete`;
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
            const checkAll = document.getElementById('checkAll');
            const deleteMultipleModal = new bootstrap.Modal(document.getElementById('ModaldeleteMultiple'), {
                backdrop: 'static',
                keyboard: false
            });
            const confirmDeleteMultipleBtn = document.getElementById('confirm-delete-multiple');
            const cancelDeleteMultipleBtn = document.getElementById('cancel-delete-multiple');

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
                deleteMultipleBtn.style.display = checkAll.checked ? 'block' : 'none';
            });

            deleteMultipleBtn.addEventListener('click', function() {
                event.preventDefault();
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một trang để xóa.');
                    return;
                }

                deleteMultipleModal.selectedIds = selectedIds;
                deleteMultipleModal.show();
            });

            confirmDeleteMultipleBtn.addEventListener('click', function(event) {
                const selectedIds = deleteMultipleModal.selectedIds;
                $.ajax({
                    url: `{{ route('admin.pages.deleteMultiple') }}`,
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: 'hard_delete_pages',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        deleteMultipleModal.hide();
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
            });

            cancelDeleteMultipleBtn.addEventListener('click', function() {
                deleteMultipleModal.hide();
            });
        });
    </script>
@endsection
