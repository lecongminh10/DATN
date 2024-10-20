@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">App</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
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
                                                        href="{{ route('admin.products.index') }}">Products List</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-2">
                                                <form method="GET" action="{{ route('admin.products.index') }}">
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
                                                <button class="btn btn-soft-danger" id="deleteMultipleBtn"
                                                    style="display: none;">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </button>
                                                <a class="btn btn-success add-btn ms-2"
                                                    href="{{ route('admin.products.create') }}">
                                                    <i class="ri-add-box-fill"></i> Thêm
                                                </a>
                                                <a href="{{ route('admin.products.deleted1') }}"
                                                    class="btn btn-soft-danger ms-2">
                                                    <i class="ri-delete-bin-2-line"></i>Thùng rác
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-card mt-1">
                                        <table
                                            class="table align-middle">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                                value="option">
                                                        </div>
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Products</th>
                                                    <th>Products Description</th>
                                                    <th>Created_at</th>
                                                    <th>Updated_at</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($products as $item)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="{{ $item->id }}">
                                                            </div>
                                                        </th>
                                                        <td>{{ $item->id }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.products.show', $item->id) }}"
                                                                class="dropdown-item">
                                                                {{ $item->name }}</a>

                                                        </td>
                                                        <td>{{ $item->short_description }}</td>
                                                        
                                                        <td>{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                                        <td>{{ $item->updated_at->format('d-m-Y H:i:s') }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <div class="dropdown d-inline-block">
                                                                    <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill align-middle"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="{{ route('admin.products.show', $item->id) }}"
                                                                                class="dropdown-item"><i
                                                                                    class="ri-eye-fill align-bottom me-2 fs-16"></i>
                                                                                View</a></li>
                                                                        <li><a href="{{ route('admin.products.edit', $item->id) }}"
                                                                                class="dropdown-item edit-item-btn"><i
                                                                                    class="ri-pencil-fill fs-16 align-bottom me-2"></i>
                                                                                Edit</a></li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('admin.products.destroy', $item->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button
                                                                                    onclick="return confirm('Bạn có chắc chắn không?')"
                                                                                    type="submit"
                                                                                    class="dropdown-item remove-item-btn">
                                                                                    <i
                                                                                        class="ri-delete-bin-5-fill fs-16 align-bottom me-2"></i>
                                                                                    Delete
                                                                                </button>
                                                                            </form>
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
                                    {{ $products->firstItem() }}
                                    to
                                    {{ $products->lastItem() }}
                                    of
                                    {{ $products->total() }}
                                    results
                                </p>
                            </div>
                            <div class="pagination-wrap me-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if ($products->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                                    Previous
                                                </a>
                                            </li>
                                        @endif
                                        @foreach ($products->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <span class="page-link">{{ $element }}</span>
                                                </li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $products->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach                       
                                        @if ($products->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
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
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll'); // Checkbox "Chọn tất cả"

            // Kiểm tra checkbox và hiển thị/ẩn nút xóa nhiều
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'block' : 'none';
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });

            // Thêm sự kiện cho checkbox "Chọn tất cả"
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'block' :
                    'none'; // Hiển thị/ẩn nút xóa nhiều
            });

            // Thêm sự kiện click cho nút xóa nhiều
            deleteMultipleBtn.addEventListener('click', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một thuộc tính để xóa.');
                    return;
                }

                const action = 'soft_delete_product';
                if (confirm('Bạn có chắc chắn muốn xóa những thuộc tính đã chọn không?')) {
                    $.ajax({
                        url: `{{ route('admin.products.deleteMultiple') }}`,
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
                }
            });
        });
    </script>
@endsection