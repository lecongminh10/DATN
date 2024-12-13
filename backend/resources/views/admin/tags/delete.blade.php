@extends('admin.layouts.app')

@section('title')
    Thùng Rác
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Thẻ ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thẻ', 'url' => '#']
                ]
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
                                                        href="{{ route('admin.tags.deleted') }}">Thùng rác</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-3">
                                                <form method="GET" action="{{ route('admin.tags.deleted') }}">
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
                                                </div> 
                                                <div class="col-3 ms-3">
                                                    <button type="button" class="btn btn-primary w-100"
                                                        onclick="filterData();">
                                                        <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
                                                    </button>
                                                </div> --}}
                                            </div>
                                            <div class="col-xl-6 d-flex justify-content-end align-items-center">
                                                <div class="">
                                                    <button class="btn btn-soft-danger me-1" id="deleteMultipleBtn"
                                                        style="display: none;">
                                                        <i class="ri-delete-bin-5-fill"></i>
                                                    </button>
                                                    <a href="{{ route('admin.tags.index') }}"
                                                        class="btn btn-primary">Quay lại
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive table-card mt-2 mb-1">
                                    <table class="table table-bordered table-hover table-striped align-middle table-nowrap">
                                        <thead class="table-light">
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
                                        <tbody class="list form-check-all">
                                            @foreach ($tags as $item)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                    </th>
                                                    <td>{{ $item->id }}</td>
                                                    <td class="carrier_name">{{ $item->name }}</td>

                                                    <td>
                                                        <form action="{{ route('admin.tags.restore', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button
                                                                onclick="return confirm('Bạn có chắc muốn khôi phục không?')"
                                                                type="submit"
                                                                class="btn btn-sm btn-info edit-item-btn">Khôi
                                                                phục</button>
                                                        </form>
                                                        <form action="{{ route('admin.tags.hardDelete', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                onclick="return confirm('Bạn có chắc chắn xóa vĩnh viễn không?')"
                                                                type="submit"
                                                                class="btn btn-sm btn-danger remove-item-btn">Xóa
                                                                vĩnh viễn</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt2 mb-3">
                            <div class="results-info ms-3">
                                <p class="pagination mb-0">
                                    Showing
                                    {{ $tags->firstItem() }}
                                    to
                                    {{ $tags->lastItem() }}
                                    of
                                    {{ $tags->total() }}
                                    results
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
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end row -->
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
            var url = "{{ route('admin.tags.deleted') }}";
            if (status) {
                url += `?status=${status}`;
            }
            window.location.href = url;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll');
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
                deleteMultipleBtn.style.display = checkAll.checked ? 'inline-block' :
                    'none';
            });
            // Thêm sự kiện click cho nút xóa nhều
            deleteMultipleBtn.addEventListener('click', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một thuộc tính để xóa.');
                    return;
                }

                const action = 'hard_delete_carrier';
                if (confirm('Bạn có chắc chắn muốn xóa những thuộc tính đã chọn không?')) {
                    $.ajax({
                        url: `{{ route('admin.tags.deleteMultiple') }}`,
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
                            console.log(xhr);
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                            } else {
                                alert('Có lỗi xảy ra: ' + xhr.statusText);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
