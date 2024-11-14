@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Coupons</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">App</a></li>
                                <li class="breadcrumb-item active">Coupons</li>
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
                            <div id="couponList">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title mb-0 "><a class="text-dark"
                                                        href="{{ route('admin.coupons.deleted') }}">Danh Sách Coupon
                                                        Đã Xóa</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-3">
                                                <form method="GET" action="{{ route('admin.coupons.deleted') }}">
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
                                            <form id="filterForm" class="row g-3">
                                                <div class="col-md-2">
                                                    <select class="form-select" aria-label=".form-select-sm example"
                                                        id="idStatus" name="status">
                                                        <option value=""
                                                            {{ request()->get('status') == '' ? 'selected' : '' }}>Select
                                                            Status</option>
                                                        <option value="1"
                                                            {{ request()->get('status') == '1' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="0"
                                                            {{ request()->get('status') == '0' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select id="idAppliesTo" name="applies_to" class="form-select">
                                                        <option value=""
                                                            {{ request()->get('applies_to') == '' ? 'selected' : '' }}>
                                                            Applies To</option>
                                                        <option value="product"
                                                            {{ request()->get('applies_to') == 'product' ? 'selected' : '' }}>
                                                            Products</option>
                                                        <option value="category"
                                                            {{ request()->get('applies_to') == 'category' ? 'selected' : '' }}>
                                                            Categories</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select id="idDiscountType" name="discount_type" class="form-select">
                                                        <option value=""
                                                            {{ request()->get('discount_type') == '' ? 'selected' : '' }}>
                                                            Discount Type</option>
                                                        <option value="percentage"
                                                            {{ request()->get('discount_type') == 'percentage' ? 'selected' : '' }}>
                                                            Percentage</option>
                                                        <option value="fixed_amount"
                                                            {{ request()->get('discount_type') == 'fixed_amount' ? 'selected' : '' }}>
                                                            Fixed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="btn-group w-100" role="group" aria-label="Filter buttons">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="filterData();">
                                                            <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="clearFilters();">
                                                            <i class="ri-close-circle-fill me-2 align-bottom"></i>Clear
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-xl-4 d-flex justify-content-end align-items-center">
                                                <div class="">
                                                    <button class="btn btn-soft-danger me-1 ms-2" id="deleteMultipleBtn"
                                                        style="display: none;">
                                                        <i class="ri-delete-bin-5-fill"></i>
                                                    </button>
                                                    <a class="btn btn-success add-btn me-1"
                                                        href="{{ route('admin.coupons.create') }}">
                                                        <i class="ri-add-box-fill"></i> Thêm
                                                    </a>
                                                    <a href="{{ route('admin.coupons.index') }}"
                                                        class="btn btn-soft-primary">
                                                        <i class="ri-home-6-fill"></i>
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
                                                <th data-sort="code">Mã Coupon</th>
                                                <th data-sort="description">Mô Tả</th>
                                                <th data-sort="discountType">Loại Giảm Giá</th>
                                                <th data-sort="discountValue">Giá Trị Giảm Giá</th>
                                                <th data-sort="minOrderValue">Giá Trị Đơn Hàng Tối Thiểu</th>
                                                <th data-sort="is_active">Trạng Thái</th>
                                                <th data-sort="created_at">Ngày Tạo</th>
                                                <th data-sort="updated_at">Cập Nhật</th>
                                                <th data-sort="action">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="chk_child" value="{{ $item->id }}">
                                                        </div>
                                                    </th>
                                                    <td>{{ $item->id }}</td>
                                                    <td class="coupon_code">
                                                        <a href="javascript:void(0);" class="dropdown-item view-coupon"
                                                            data-id="{{ $item->id }}">
                                                            {{ $item->code }}
                                                        </a>
                                                    </td>
                                                    <td class="description">{{ $item->description }}</td>
                                                    <td class="discountType">{{ $item->discount_type }}</td>
                                                    <td class="discountValue">{{ $item->discount_value }}</td>
                                                    <td class="minOrderValue">{{ $item->min_order_value }}</td>
                                                    <td class="is_active">
                                                        <span
                                                            class="badge {{ $item->is_active == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase">
                                                            {{ $item->is_active == 1 ? 'active' : 'inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                                    <td>{{ $item->updated_at->format('d-m-Y H:i:s') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.coupons.restore', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button
                                                                onclick="return confirm('Bạn có chắc muốn khôi phục không?')"
                                                                type="submit"
                                                                class="btn btn-sm btn-info edit-item-btn">Khôi
                                                                phục</button>
                                                        </form>
                                                        <form action="{{ route('admin.coupons.hardDelete', $item->id) }}"
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
                                    <div class="modal fade" id="viewCouponModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light p-3">
                                                    <h5 class="modal-title" id="viewCouponModalLabel">Chi Tiết Coupon</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <table class="table">
                                                                <thead >
                                                                    <tr>
                                                                        <th title="Tiêu đề thông tin"
                                                                            class="font-weight-bold">
                                                                            Thông Tin</th>
                                                                        <th title="Giá trị tương ứng"
                                                                            class="font-weight-bold">Giá
                                                                            Trị</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td title="Đối tượng áp dụng mã giảm giá này">
                                                                            <strong>Áp
                                                                                Dụng Cho:</strong></td>
                                                                        <td id="AppliesTo"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td title="Thông tin liên quan"><strong>Thông Tin Liên
                                                                                Quan:</strong></td>
                                                                        <td id="RelatedInfo"></td>
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
                                                                        <td>
                                                                            <div data-simplebar
                                                                                data-simplebar-auto-hide="false"
                                                                                style="max-height: 100px;" class="px-2">
                                                                                <p id="description"></p>
    
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            title="Loại giảm giá (ví dụ: phần trăm hoặc số tiền)">
                                                                            <strong>Loại Giảm Giá:</strong>
                                                                        </td>
                                                                        <td id="discount_Type"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td title="Giá trị giảm giá, ví dụ: 20%"><strong>Giá
                                                                                Trị
                                                                                Giảm Giá:</strong></td>
                                                                        <td id="discountValue"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            title="Giá trị giảm giá tối đa có thể được áp dụng">
                                                                            <strong>Giảm Giá Tối Đa:</strong>
                                                                        </td>
                                                                        <td id="maxDiscount"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            title="Giá trị đơn hàng tối thiểu để áp dụng giảm giá">
                                                                            <strong>Giá Trị Đơn Hàng Tối Thiểu:</strong>
                                                                        </td>
                                                                        <td id="minOrderValue"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class=" col-6">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th title="Tiêu đề thông tin"
                                                                            class="font-weight-bold">
                                                                            Thông Tin</th>
                                                                        <th title="Giá trị tương ứng"
                                                                            class="font-weight-bold">Giá
                                                                            Trị</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
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
                                                                        <td
                                                                            title="Cho phép gộp nhiều mã giảm giá với nhau không">
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
                                                    </div>
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
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt2 mb-3">
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
                                                <span class="page-link">Trước</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $data->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    Trước
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
                                                <a class="page-link" href="{{ $data->nextPageUrl() }}"
                                                    aria-label="Next">
                                                    Tiếp theo
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Tiếp theo</span>
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
@endsection
@section('script_libray')
    <!-- Nạp jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        //Bộ lọc
        function filterData() {
            let status = document.getElementById('idStatus').value;
            let appliesTo = document.getElementById('idAppliesTo').value;
            let discountType = document.getElementById('idDiscountType').value;
            let filterUrl = '/listsotfdeleted?';

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
            window.location.href = '/listsotfdeleted';
        }
    </script>
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện click trên nút "View"
            $(document).on('click', '.view-coupon', function() {
                var couponId = $(this).data('id');
                $.ajax({
                    url: '/admin/coupons/showsotfdelete/' + couponId,
                    type: 'GET',
                    success: function(response) {
                        console.log(response); // Kiểm tra phản hồi từ API
                        var coupon = response.coupon;
                        if (coupon) {
                            $('#AppliesTo').text(coupon.applies_to || 'N/A');
                            $('#code').text(coupon.code || 'N/A');
                            $('#description').text(coupon.description || 'N/A');
                            $('#discountType').text(coupon.discount_type || 'N/A');
                            $('#discountValue').text(coupon.discount_value || 'N/A');
                            $('#maxDiscount').text(coupon.max_discount_amount || 'N/A');
                            $('#minOrderValue').text(coupon.min_order_value || 'N/A');
                            $('#startDate').text(coupon.start_date || 'N/A');
                            $('#endDate').text(coupon.end_date || 'N/A');
                            $('#usageLimit').text(coupon.usage_limit || 'N/A');
                            $('#perUserLimit').text(coupon.per_user_limit || 'N/A');
                            $('#isActive').text(coupon.is_active ? 'Yes' : 'No')
                                .removeClass('text-success text-danger')
                                .addClass(coupon.is_active ? 'text-success' : 'text-danger');

                            $('#isStackable').text(coupon.is_stackable ? 'Yes' : 'No')
                                .removeClass('text-success text-danger')
                                .addClass(coupon.is_stackable ? 'text-success' : 'text-danger');

                            $('#eligibleUsersOnly').text(coupon.eligible_users_only ? 'Yes' :
                                    'No')
                                .removeClass('text-success text-danger')
                                .addClass(coupon.eligible_users_only ? 'text-success' :
                                    'text-danger');

                            $('#viewCouponModal').modal('show');
                        } else {
                            alert('Coupon data not found');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Error: ' + (xhr.responseJSON?.error || 'Something went wrong'));
                    }
                });
            });
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
                const action = 'hard_delete_coupon';
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
