@extends('admin.layouts.app')

@section('title')
    Danh Sách Trang
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
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <a href="{{ route('admin.pages.index') }}">
                                            <h5 class="card-title mb-0">Danh sách trang</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.pages.create') }}" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Import</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom-dashed border-bottom">
                            <form method="GET" action="{{ route('admin.pages.index') }}" id="search-form">
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
                                                <button class="btn btn-danger" id="deleteMultipleBtn" style="display: none;"
                                                    data-bs-toggle="modal" data-bs-target="#deleteMultipleModal">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </button>
                                                <a href="{{ route('admin.pages.create') }}"
                                                    class="btn btn-success me-2 add-btn" id="create-btn"><i
                                                        class="ri-add-line align-bottom "></i> Thêm mới</a>
                                                <a href="{{ route('admin.pages.deleted') }}" class="btn btn-warning">
                                                    <i class="ri-delete-bin-2-line align-bottom"></i> Thùng rác
                                                </a>
                                            </div>
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
                                                <th data-sort="carrier_name"> Tên</th>
                                                <th data-sort="api_url">Liên kết cố định</th>
                                                <th data-sort="api_token">Mô tả</th>
                                                <th data-sort="phone">Nội dung</th>
                                                <th data-sort="email">Trạng thái</th>
                                                {{-- <th data-sort="is_active">Bản mẫu</th> --}}
                                                {{-- <th data-sort="is_active">seo_title</th>
                                                <th data-sort="is_active">seo_description</th> --}}
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
                                                    <td class="permalink"><a
                                                            href="{{ $item->permalink }}">{{ $item->permalink }}</a></td>
                                                    <td class="description">{{ $item->description }}</td>
                                                    <td class="content">{{ $item->content }}</td>
                                                    <td class="is_active">
                                                        <span
                                                            class="badge {{ $item->is_active == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase">
                                                            {{ $item->is_active == 1 ? 'active' : 'inactive' }}
                                                        </span>
                                                    </td>
                                                    {{-- <td class="template">{{ $item->template }}</td> --}}
                                                    {{-- <td class="seo_title">{{ $item->seo_title }}</td>
                                                    <td class="seo_description">{{ $item->seo_description }}</td> --}}
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Edit">
                                                                <a href="{{ route('admin.pages.edit', $item->id) }}"
                                                                    class="text-primary d-inline-block edit-item-btn">
                                                                    <i class="ri-pencil-fill fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Delete">
                                                                <button type="button"
                                                                    class="btn text-danger remove-item-btn"
                                                                    data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                                    data-bs-target="#deletePageModal">
                                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                </button>
                                                            </li>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <div class="modal fade" id="deletePageModal" tabindex="-1" aria-labelledby="deletePageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePageModalLabel">Xóa Trang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa trang này?
                    <form id="delete-page-form" method="POST">
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
    <div class="modal fade" id="deleteMultipleModal" tabindex="-1" aria-labelledby="deleteMultipleModalLabel"
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
        function filterData() {
            var status = document.getElementById('idStatus').value;
            var url = "{{ route('admin.pages.index') }}";
            if (status) {
                url += `?status=${status}`;
            }
            window.location.href = url;
        }
    </script>
    <script>
        //Tìm kiếm
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
            const deleteButtons = document.querySelectorAll('.remove-item-btn'); // Select all delete buttons
            const modal = document.getElementById('deletePageModal'); // Modal for confirmation
            const deleteForm = document.getElementById('delete-page-form'); // The form inside the modal
            const confirmButton = document.getElementById('confirm-delete'); // The confirm button

            // Loop through all delete buttons to attach event listeners
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id'); // Get the ID of the page to delete
                    const actionUrl =
                        `/admin/pages/${itemId}`; // Construct the URL for the delete action
                    deleteForm.setAttribute('action', actionUrl); // Set the form action dynamically
                });
            });

            // Handle form submission on clicking the confirm delete button
            confirmButton.addEventListener('click', function() {
                deleteForm.submit(); // Submit the form to perform the delete action
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll');
            const deleteMultipleModal = new bootstrap.Modal(document.getElementById(
                'deleteMultipleModal')); // Modal for multiple deletion
            const confirmDeleteMultipleBtn = document.getElementById(
                'confirm-delete-multiple');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'inline-block' : 'none';
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });

            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'inline-block' : 'none';
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

                deleteMultipleModal.show();
                deleteMultipleModal.selectedIds = selectedIds;
            });

            confirmDeleteMultipleBtn.addEventListener('click', function() {
                const selectedIds = deleteMultipleModal.selectedIds;

                $.ajax({
                    url: '{{ route('admin.pages.deleteMultiple') }}',
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: 'soft_delete_pages',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert('Các trang đã được xóa thành công!');
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
