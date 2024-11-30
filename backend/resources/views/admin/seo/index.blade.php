@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Seo',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Seo', 'url' => '#'],
                ],
            ])

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <a href="{{ route('admin.seo.index') }}">
                                            <h5 class="card-title mb-0">Seo List</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button class="btn btn-soft-danger" id="deleteMultipleBtn" style="display: none;">
                                            <i class="ri-delete-bin-5-fill"></i>
                                        </button>
                                        <a href="{{ route('admin.seo.create') }}" class="btn btn-success add-btn"
                                            id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Add Seo</a>
                                        <a href="{{ route('admin.seo.create') }}" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Import</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom-dashed border-bottom">
                            <form method="GET" action="{{ route('admin.seo.index') }}" id="search-form">
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
                                                    <button type="submit" form="search-form" class="btn btn-primary w-100">
                                                        <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row g-4 d-flex justify-content-end">
                                            <div class="col-sm-auto">
                                                <a href="{{ route('admin.seo.deleted') }}" class="btn btn-soft-danger">
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
                                    <table class="table align-middle" id="seoTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th data-sort="meta_title">Meta Title</th>
                                                <th data-sort="meta_description">Meta Description</th>
                                                <th data-sort="meta_keywords">Meta Keywords</th>
                                                <th data-sort="canonical_url">Canonical URL</th>
                                                <th data-sort="is_active">Trạng thái </th>
                                                <th data-sort="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($seo as $item)
                                                <tr>
                                                    <!-- Checkbox -->
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                    </th>

                                                    <!-- SEO Details -->
                                                    <td>{{ $item->id }}</td>
                                                    <td class="meta_title">{{ $item->meta_title }}</td>
                                                    <td class="meta_description">
                                                        {{ Str::limit($item->meta_description, 50) }}</td>
                                                    <td class="meta_keywords">{{ $item->meta_keywords }}</td>
                                                    <td class="canonical_url">{{ $item->canonical_url }}</td>
                                                    <td class="is_active">{{ ($item->is_active) ? 'Kích hoạt': 'Không kích hoạt ' }}</td>
                                                    <!-- Action Buttons -->
                                                    <td>
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <!-- Product -->
                                                            <li class="list-inline-item">
                                                                <a data-bs-toggle="modal" data-bs-target="#productModal"
                                                                    data-seo-id="{{ $item->id }}"
                                                                    title="Xem sản phẩm liên quan">
                                                                    <i class="ri-eye-fill"></i>
                                                                </a>
                                                            </li>
                                                            <!-- Edit Button -->
                                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Edit">
                                                                <a href="{{ route('admin.seo.edit', $item->id) }}"
                                                                    class="text-primary d-inline-block edit-item-btn">
                                                                    <i class="ri-pencil-fill fs-16"></i>
                                                                </a>
                                                            </li>
                                                            <!-- Delete Button -->
                                                            <li class="list-inline-item">
                                                                <form action="{{ route('admin.seo.destroy', $item->id) }}"
                                                                    method="post" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                                                        type="submit"
                                                                        class="text-danger border-0 bg-transparent p-0">
                                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Modal for Product -->
                                <div class="modal fade" id="productModal" tabindex="-1"
                                    aria-labelledby="productModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="productModalLabel">Các sản phẩm liên quan
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="modal-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Mã</th>
                                                            <th>Tên </th>
                                                            <th>Ảnh đại diện</th>
                                                            <th>Danh mục</th>
                                                            <th>Slug</th>
                                                            <th>Giá gốc</th>
                                                            <th>Giá khuyến mãi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="product-body">
                                                        <!-- Data will be inserted here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                    <div class="results-info ms-3">
                                        <p class="pagination mb-0">
                                            Showing
                                            {{ $seo->firstItem() }}
                                            to
                                            {{ $seo->lastItem() }}
                                            of
                                            {{ $seo->total() }}
                                            results
                                        </p>
                                    </div>
                                    <div class="pagination-wrap me-3">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                @if ($seo->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Previous</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $seo->previousPageUrl() }}"
                                                            aria-label="Previous">
                                                            Previous
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($seo->links()->elements as $element)
                                                    @if (is_string($element))
                                                        <li class="page-item disabled">
                                                            <span class="page-link">{{ $element }}</span>
                                                        </li>
                                                    @endif

                                                    @if (is_array($element))
                                                        @foreach ($element as $page => $url)
                                                            @if ($page == $seo->currentPage())
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

                                                @if ($seo->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $seo->nextPageUrl() }}"
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
        document.addEventListener("DOMContentLoaded", function() {
            $('#productModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var seoId = button.data('seo-id');


                $.ajax({
                    url: `/admin/seo/${seoId}/products`,
                    method: 'GET',
                    success: function(data) {

                        var productBody = $('#product-body');
                        productBody.empty();

                        data.products.forEach(function(product, index) {
                            var row = `<tr>
                        <td>${index + 1}</td>
                        <td>${product.code}</td>
                        <td>${product.name}</td>
                        <td><img src="{{ Storage::url('') }}${product.image_url}" alt="${product.name}" style="width: 50px; height: auto;"></td>
                        <td>
                            ${product.category_id}
                        </td>
                        <td>${product.slug}</td>
                        <td>${product.price_regular}</td>
                        <td>${product.price_sale}</td>
                    </tr>`;
                            productBody.append(row);
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('Có lỗi xảy ra khi tải sản phẩm');
                    }
                });
            });
        });
    </script>
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

                const action = 'soft_delete_seo';
                if (confirm('Bạn có chắc chắn muốn xóa những thuộc tính đã chọn không?')) {
                    $.ajax({
                        url: `{{ route('admin.seo.deleteMultiple') }}`,
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
