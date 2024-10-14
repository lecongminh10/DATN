@extends('admin.layouts.app')
@section('styleCss')
    <style>
        .table td,
        .table th {
            padding: 15px;
            /* Thay đổi giá trị padding theo nhu cầu */
        }

        .text-overflow {
            max-width: 300px;
            /* Đặt chiều rộng tối đa cho ô */
            white-space: nowrap;
            /* Không xuống dòng */
            overflow: hidden;
            /* Ẩn phần văn bản ngoài chiều rộng tối đa */
            text-overflow: ellipsis;
            /* Thêm dấu ba chấm khi cắt bớt */
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Khuyến mãi ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Khuyến mãi', 'url' => '#']
                ]
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="couponList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <a href="{{ route('admin.coupons.index') }}">
                                            <h5 class="card-title mb-0">Danh Sách Mã Giảm Giá</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button class="btn btn-soft-danger" id="deleteMultipleBtn" style="display: none;">
                                            <i class="ri-delete-bin-5-fill"></i>
                                        </button>
                                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-success add-btn"
                                            id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Thêm Mã Giảm
                                            Giá</a>
                                        <a href="" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Nhập</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom-dashed border-bottom">
                            <form>
                                <div class="row g-3">
                                    <div class="col-xl-4">
                                        <div class="search-box">
                                            <form method="GET" action="{{ route('admin.coupons.index') }}">
                                                <input type="text" class="form-control search" name="search"
                                                    placeholder="Nhập từ khóa tìm kiếm..."
                                                    value="{{ request()->input('search') }}">
                                                <i class="ri-search-line search-icon"></i>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="row g-4 d-flex justify-content-end">
                                            <div class="col-sm-auto">
                                                <a href="{{ route('admin.coupons.deleted') }}" class="btn btn-soft-danger">
                                                    <i class="ri-delete-bin-2-line"></i>Thùng rác
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="">
                                            <form id="filterForm" class="row g-3">
                                                <div class="col-md-4">
                                                    <select class="form-select" aria-label=".form-select-sm example"
                                                        id="idStatus" name="status">
                                                        <option value=""
                                                            {{ request()->get('status') == '' ? 'selected' : '' }}>Trạng thái</option>
                                                        <option value="1"
                                                            {{ request()->get('status') == '1' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="0"
                                                            {{ request()->get('status') == '0' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select id="appliesTo" name="applies_to" class="form-select">
                                                        <option value=""
                                                            {{ request()->get('applies_to') == '' ? 'selected' : '' }}>
                                                           Áp dụng </option>
                                                        <option value="product"
                                                            {{ request()->get('applies_to') == 'product' ? 'selected' : '' }}>
                                                            Sản phẩm </option>
                                                        <option value="category"
                                                            {{ request()->get('applies_to') == 'category' ? 'selected' : '' }}>
                                                            Danh mục</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select id="discountType" name="discount_type" class="form-select">
                                                        <option value=""
                                                            {{ request()->get('discount_type') == '' ? 'selected' : '' }}>
                                                            Loại mã</option>
                                                        <option value="percentage"
                                                            {{ request()->get('discount_type') == 'percentage' ? 'selected' : '' }}>
                                                            Phần trăm</option>
                                                        <option value="fixed_amount"
                                                            {{ request()->get('discount_type') == 'fixed_amount' ? 'selected' : '' }}>
                                                            Số tiền cố định</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="btn-group w-100" role="group" aria-label="Filter buttons">
                                            <button type="button" class="btn btn-primary" onclick="filterData();">
                                                <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
                                            </button>
                                            <button type="button" class="btn btn-secondary" onclick="clearFilters();">
                                                <i class="ri-close-circle-fill me-2 align-bottom"></i>Clear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle" id="couponsTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th class="coupon_code">Mã Giảm Giá</th>
                                                <th class="applies_to">Phạm Vi</th>
                                                <th class="discount_type">Loại Giảm Giá</th>
                                                <th class="discount_value">Giá Trị Giảm Giá</th>
                                                <th class="start_date">Ngày Bắt Đầu</th>
                                                <th class="end_date">Ngày Kết Thúc</th>
                                                <th class="is_active">Trạng Thái</th>
                                                <th class="text-center">Hành Động</th>
                                            </tr>
                                        </thead>
                                        @foreach ($coupons as $item)
                                            <tbody class="list form-check-all">
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="chk_child" value="{{ $item->id }}">
                                                        </div>
                                                    </th>
                                                    <td>{{ $item->id }}</td>
                                                    <td class="coupon_code"><a href="javascript:void(0);"
                                                            class="dropdown-item view-coupon"
                                                            data-id="{{ $item->id }}">
                                                            {{ $item->code }}
                                                        </a></td>
                                                    <td class="applies_to">{{ $item->applies_to }}</td>
                                                    <td class="discount_type">{{ $item->discount_type }}</td>
                                                    <td class="discount_value">{{ $item->discount_value }}</td>
                                                    <td class="start_date">{{ $item->start_date }}</td>
                                                    <td class="end_date">{{ $item->end_date }}</td>
                                                    <td class="is_active">
                                                        <span
                                                            class="badge {{ $item->is_active == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase">
                                                            {{ $item->is_active == 1 ? 'active' : 'inactive' }}
                                                        </span>
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
                                                                    <li>
                                                                        <a href="javascript:void(0);"
                                                                            class="dropdown-item view-coupon"
                                                                            data-id="{{ $item->id }}">
                                                                            <i
                                                                                class="ri-eye-fill align-bottom me-2 fs-16"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route('admin.coupons.edit', $item->id) }}"
                                                                            class="dropdown-item edit-item-btn">
                                                                            <i
                                                                                class="ri-pencil-fill fs-16 align-bottom me-2"></i>
                                                                            Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('admin.coupons.destroy', $item->id) }}"
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
                                            </tbody>
                                        @endforeach
                                    </table>
                                    <!-- Modal to view coupon details -->
                                    <div class="modal fade" id="viewCouponModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light p-3">
                                                    <h5 class="modal-title" id="viewCouponModalLabel">Chi Tiết Coupon</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th title="Tiêu đề thông tin" class="font-weight-bold">
                                                                    Thông Tin</th>
                                                                <th title="Giá trị tương ứng" class="font-weight-bold">Giá
                                                                    Trị</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td title="Đối tượng áp dụng mã giảm giá này"><strong>Áp
                                                                        Dụng Cho:</strong></td>
                                                                <td id="AppliesTo"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Mã của coupon hoặc mã giảm giá">
                                                                    <strong>Mã:</strong>
                                                                </td>
                                                                <td id="code"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Mô tả ngắn gọn về ưu đãi"><strong>Mô
                                                                        Tả:</strong></td>
                                                                <td><div data-simplebar data-simplebar-auto-hide="false" style="max-height: 100px;" class="px-2">
                                                                    <p id="description"></p>
                                                        
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Loại giảm giá (ví dụ: phần trăm hoặc số tiền)">
                                                                    <strong>Loại Giảm Giá:</strong>
                                                                </td>
                                                                <td id="discount_Type"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Giá trị giảm giá, ví dụ: 20%"><strong>Giá Trị
                                                                        Giảm Giá:</strong></td>
                                                                <td id="discountValue"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Giá trị giảm giá tối đa có thể được áp dụng">
                                                                    <strong>Giảm Giá Tối Đa:</strong>
                                                                </td>
                                                                <td id="maxDiscount"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Giá trị đơn hàng tối thiểu để áp dụng giảm giá">
                                                                    <strong>Giá Trị Đơn Hàng Tối Thiểu:</strong>
                                                                </td>
                                                                <td id="minOrderValue"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Ngày bắt đầu hiệu lực của mã giảm giá">
                                                                    <strong>Ngày Bắt Đầu:</strong>
                                                                </td>
                                                                <td id="startDate"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Ngày kết thúc hiệu lực của mã giảm giá">
                                                                    <strong>Ngày Kết Thúc:</strong>
                                                                </td>
                                                                <td id="endDate"></td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    title="Giới hạn tổng số lần mã giảm giá có thể được sử dụng">
                                                                    <strong>Giới Hạn Sử Dụng:</strong>
                                                                </td>
                                                                <td id="usageLimit"></td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    title="Số lượng tối đa mã giảm giá mỗi người dùng có thể sử dụng">
                                                                    <strong>Giới Hạn Mỗi Người Dùng:</strong>
                                                                </td>
                                                                <td id="perUserLimit"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Trạng thái kích hoạt của mã giảm giá">
                                                                    <strong>Đang Kích Hoạt:</strong>
                                                                </td>
                                                                <td id="isActive"></td>
                                                            </tr>
                                                            <tr>
                                                                <td title="Cho phép gộp nhiều mã giảm giá với nhau không">
                                                                    <strong>Có Thể Gộp:</strong>
                                                                </td>
                                                                <td id="isStackable"></td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    title="Liệu mã giảm giá chỉ áp dụng cho người dùng đủ điều kiện không">
                                                                    <strong>Người Dùng Đủ Điều Kiện:</strong>
                                                                </td>
                                                                <td id="eligibleUsersOnly"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="{{ route('admin.coupons.index') }}"
                                                            class="btn btn-danger bg-gradient waves-effect waves-light"
                                                            data-bs-dismiss="modal">Đóng</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                    <div class="results-info ms-3">
                                        <p class="pagination mb-0">
                                            Showing
                                            {{ $coupons->firstItem() }}
                                            to
                                            {{ $coupons->lastItem() }}
                                            of
                                            {{ $coupons->total() }}
                                            results
                                        </p>
                                    </div>
                                    <div class="pagination-wrap me-3">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                @if ($coupons->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Previous</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $coupons->previousPageUrl() }} "
                                                            aria-label="Previous">
                                                            Previous
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($coupons->links()->elements as $element)
                                                    @if (is_string($element))
                                                        <li class="page-item disabled">
                                                            <span class="page-link">{{ $element }}</span>
                                                        </li>
                                                    @endif

                                                    @if (is_array($element))
                                                        @foreach ($element as $page => $url)
                                                            @if ($page == $coupons->currentPage())
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

                                                @if ($coupons->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $coupons->nextPageUrl() }}"
                                                            aria-label="Next">Next</a>
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
                </div> <!-- end col -->
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
        // Bộ lọc
        function filterData() {
            let status = document.getElementById('idStatus').value;
            let appliesTo = document.getElementById('appliesTo').value;
            let discountType = document.getElementById('discountType').value;

            let filterUrl = '/admin/coupons?'; // Khai báo filterUrl

            if (status !== '') {
                filterUrl += 'status=' + status + '&';
            }
            if (appliesTo !== '') {
                filterUrl += 'applies_to=' + appliesTo + '&';
            }
            if (discountType !== '') {
                filterUrl += 'discount_type=' + discountType + '&';
            }
            filterUrl = filterUrl.slice(0, -1);

            window.location.href = filterUrl;
        }

        function clearFilters() {
            // Chuyển hướng đến URL không có tham số bộ lọc
            window.location.href = '/admin/coupons';
        }
    </script>
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện click trên nút "View (Xem chi tiết)"
            $(document).on('click', '.view-coupon', function() {
                var couponId = $(this).data('id');

                $.ajax({
                    url: '/admin/coupons/' + couponId,
                    type: 'GET',
                    success: function(response) {
                        var coupon = response.coupon;
                        updateCouponInfo(coupon);
                        $('#viewCouponModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Error: ' + (xhr.responseJSON?.error || 'Something went wrong'));
                    }
                });
            });

            // Hàm cập nhật thông tin mã giảm giá
            function updateCouponInfo(coupon) {
                $('#AppliesTo').text(coupon.applies_to || 'N/A');
                $('#code').text(coupon.code || 'N/A');
                $('#description').text(coupon.description || 'N/A');
                $('#discount_Type').text(coupon.discount_type || 'N/A');
                $('#discountValue').text(coupon.discount_value || 'N/A');
                $('#maxDiscount').text(coupon.max_discount_amount || 'N/A');
                $('#minOrderValue').text(coupon.min_order_value || 'N/A');
                $('#startDate').text(coupon.start_date ? new Date(coupon.start_date).toLocaleString() : 'N/A');
                $('#endDate').text(coupon.end_date ? new Date(coupon.end_date).toLocaleString() : 'N/A');
                $('#usageLimit').text(coupon.usage_limit || 'N/A');
                $('#perUserLimit').text(coupon.per_user_limit || 'N/A');

                // Cập nhật trạng thái hoạt động
                updateStatus('#isActive', coupon.is_active);
                // Cập nhật tính chất có thể dùng chung
                updateStatus('#isStackable', coupon.is_stackable);
                // Cập nhật tính chất chỉ dành cho một số người dùng
                updateStatus('#eligibleUsersOnly', coupon.eligible_users_only);
            }

            function updateStatus(selector, value) {
                $(selector).text(value ? 'Yes' : 'No')
                    .removeClass('text-success text-danger')
                    .addClass(value ? 'text-success' : 'text-danger');
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

                const action = 'soft_delete_coupon';
                if (confirm('Bạn có chắc chắn muốn xóa những thuộc tính đã chọn không?')) {
                    $.ajax({
                        url: `{{ route('admin.coupons.deleteMultiple') }}`,
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
