@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Vận chuyển ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Vận chuyển', 'url' => '#']
                ]
            ])

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <a href="{{ route('admin.carriers.index') }}">
                                            <h5 class="card-title mb-0">Danh sách nhà vận chuyển</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button class="btn btn-soft-danger" id="deleteMultipleBtn" style="display: none;">
                                            <i class="ri-delete-bin-5-fill"></i>
                                        </button>
                                        <a href="{{ route('admin.carriers.create') }}" class="btn btn-success add-btn"
                                            id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Thêm</a>
                                        <a href="{{ route('admin.carriers.create') }}" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Nhập</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom-dashed border-bottom">
                            <form>
                                <div class="row g-3">
                                    <div class="col-xl-3">
                                        <div class="search-box">
                                            <form method="GET" action="{{ route('admin.carriers.index') }}">
                                                <input type="text" class="form-control search" name="search"
                                                    placeholder="Nhập từ khóa tìm kiếm..."
                                                    value="{{ request()->input('search') }}">
                                                <i class="ri-search-line search-icon"></i>
                                            </form>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xl-5">
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <div>
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
                                            </div>
                                            <div class="col-sm-3">
                                                <div>
                                                    <button type="button" class="btn btn-primary w-100"
                                                        onclick="filterData();">
                                                        <i class="ri-equalizer-fill me-2 align-bottom"></i>Tìm kiếm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row g-4 d-flex justify-content-end">
                                            <div class="col-sm-auto">
                                                <a href="{{ route('admin.carriers.deleted') }}" class="btn btn-soft-danger">
                                                    <i class="ri-delete-bin-2-line"></i>Thùng rác
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
                                                <th data-sort="carrier_name">Tên nhà vận chuyển</th>
                                                <th data-sort="api_url">API URL</th>
                                                <th data-sort="api_token">API Token</th>
                                                <th data-sort="phone">Số điện thoại</th>
                                                <th data-sort="email">Email</th>
                                                <th data-sort="is_active">Trạng thái</th>
                                                <th data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        @foreach ($carrier as $item)
                                            <tbody class="list form-check-all">
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                    </th>
                                                    <td>{{ $item->id }}</td>
                                                    <td class="carrier_name">{{ $item->name }}</td>
                                                    <td class="api_url">{{ $item->api_url }}</td>
                                                    <td class="api_token">{{ $item->api_token }}</td>
                                                    <td class="phone">{{ $item->phone }}</td>
                                                    <td class="email">{{ $item->email }}</td>
                                                    <td class="is_active">
                                                        <span
                                                            class="badge {{ $item->is_active === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase">
                                                            {{ $item->is_active === 'active' ? 'active' : 'inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Edit">
                                                                <a href="{{ route('admin.carriers.edit', $item->id) }}"
                                                                    class="text-primary d-inline-block edit-item-btn">
                                                                    <i class="ri-pencil-fill fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <form
                                                                action="{{ route('admin.carriers.destroy', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button onclick="return confirm('Bạn có chắc chắn không?')"
                                                                    type="submit"
                                                                    style="border: none; background: none; padding: 0; cursor: pointer; color: #F06549;">
                                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                </button>
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
                                            Showing
                                            {{ $carrier->firstItem() }}
                                            to
                                            {{ $carrier->lastItem() }}
                                            of
                                            {{ $carrier->total() }}
                                            results
                                        </p>
                                    </div>
                                    <div class="pagination-wrap me-3">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                @if ($carrier->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Previous</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $carrier->previousPageUrl() }}"
                                                            aria-label="Previous">
                                                            Previous
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($carrier->links()->elements as $element)
                                                    @if (is_string($element))
                                                        <li class="page-item disabled">
                                                            <span class="page-link">{{ $element }}</span>
                                                        </li>
                                                    @endif

                                                    @if (is_array($element))
                                                        @foreach ($element as $page => $url)
                                                            @if ($page == $carrier->currentPage())
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

                                                @if ($carrier->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $carrier->nextPageUrl() }}"
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
            var url = "{{ route('admin.carriers.index') }}";
            if (status) {
                url += `?status=${status}`;
            }
            window.location.href = url;
        }
    </script>
    <script>
        //Tìm kiếm 
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

                const action = 'soft_delete_carrier';
                if (confirm('Bạn có chắc chắn muốn xóa những thuộc tính đã chọn không?')) {
                    $.ajax({
                        url: `{{ route('admin.carriers.deleteMultiple') }}`,
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
