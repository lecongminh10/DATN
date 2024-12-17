@extends('admin.layouts.app')

@section('title')
    Danh Sách Đơn Hàng
@endsection
@section('libray_css')
    <!-- Sweet Alert css-->
    <link href="{{ asset('theme/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection


@section('content')

<?php
if (!function_exists('isStatus')) {
    function isStatus($status)
    {
        switch ($status) {
            case "Chờ xác nhận":
                return '<span class="badge bg-secondary-subtle text-secondary text-uppercase">' . $status . '</span>';
            case "Đã xác nhận":
                return '<span class="badge bg-success-subtle text-success text-uppercase">' . $status . '</span>';
            case "Đang giao":
                return '<span class="badge bg-primary-subtle text-primary  text-uppercase">' . $status . '</span>';
            case "Hoàn thành":
                return '<span class="badge bg-info-subtle text-info text-uppercase">' . $status . '</span>';
            case "Hàng thất lạc":
                return '<span class="badge bg-danger-subtle text-danger text-uppercase">' . $status . '</span>';
            case "Đã hủy":
                return '<span class="badge bg-warning-subtle text-warning  text-uppercase">' . $status . '</span>';
            default:
                return '<span class="badge bg-warning-subtle text-warning text-uppercase">Unknown</span>';
        }
    }
} ?>


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Đơn hàng</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí </a></li>
                                <li class="breadcrumb-item active">Đơn hàng</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="orderList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Đơn hàng</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <button id="deleteSelected" class="btn btn-soft-danger d-none"><i class="ri-delete-bin-5-fill fs-16 align-bottom"></i></button>
                                        <a href="{{ route('admin.orders.listTrashOrder') }}" class="btn btn-warning"><i class="ri-delete-bin-5-fill fs-16 align-bottom"></i> Thùng rác</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form action="{{ route('admin.orders.listOrder') }}" method="GET">
                                @csrf
                                <div class="row g-3">
                                    <!-- Search -->
                                    <div class="col-xxl-5 col-sm-6">
                                        <div class="search-box">
                                            <input type="text" name="search" class="form-control search" placeholder="Tìm kiểm ..." value="{{ request('search') }}">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <!-- Date Filter -->
                                    <div class="col-xxl-2 col-sm-6">
                                        <div>
                                            <input type="text" name="date" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y" id="demo-datepicker" placeholder="Chọn ngày" value="{{ request('date') }}">
                                        </div>
                                    </div>
                                    <!-- Status Filter -->
                                    <div class="col-xxl-2 col-sm-4">
                                        <div>
                                            <select class="form-control" name="status" data-choices data-choices-search-false id="idStatus">
                                                <option class="bg-light" value="" disabled>Trạng thái</option>
                                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                                <option value="Chờ xác nhận" {{ request('status') == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                                                <option value="Đã xác nhận" {{ request('status') == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                                                <option value="Đang giao" {{ request('status') == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
                                                <option value="Hoàn thành" {{ request('status') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                                <option value="Hàng thất lạc" {{ request('status') == 'Hàng thất lạc' ? 'selected' : '' }}>Hàng thất lạc</option>
                                                <option value="Đã hủy" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <!-- Payment Filter -->
                                    <div class="col-xxl-2 col-sm-4">
                                        <div>
                                            <select class="form-control" name="payment" data-choices data-choices-search-false id="idPayment">
                                                <option value="" disabled>Select Payment</option>
                                                <option value="all" {{ request('payment') == 'all' ? 'selected' : '' }}>All</option>
                                                <option value="1" {{ request('payment') == '1' ? 'selected' : '' }}>Stripe</option>
                                                <option value="2" {{ request('payment') == '2' ? 'selected' : '' }}>Paypal</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <!-- Filter Button -->
                                    <div class="col-xxl-1 col-sm-4">
                                        <div>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ri-equalizer-fill fs-13 align-bottom"></i> Tìm
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link active py-3" data-bs-toggle="tab" id="All" href="#all" role="tab" aria-selected="true">
                                            <i class="ri-store-2-fill me-1 align-bottom"></i> All Orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link py-3" data-bs-toggle="tab" id="Chờ xác nhận" href="#choxacnhan" role="tab" aria-selected="false">
                                            <i class="ri-file-list-3-line me-1 align-bottom"></i> Chờ xác nhận
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link py-3" data-bs-toggle="tab" id="Đã xác nhận" href="#daxacnhan" role="tab" aria-selected="false">
                                            <i class="ri-checkbox-line me-1 align-bottom"></i> Đã xác nhận
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link py-3" data-bs-toggle="tab" id="Đang giao" href="#danggiao" role="tab" aria-selected="false">
                                            <i class="ri-truck-line me-1 align-bottom"></i> Đang giao
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link py-3" data-bs-toggle="tab" id="Hoàn thành" href="#hoanthanh" role="tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Hoàn thành
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link py-3" data-bs-toggle="tab" id="Hàng thất lạc" href="#hangthatlac" role="tab" aria-selected="false">
                                            <i class="ri-spam-3-line me-1 align-bottom"></i> Hàng thất lạc
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-menu nav-link py-3" data-bs-toggle="tab" id="Đã hủy" href="#dahuy" role="tab" aria-selected="false">
                                            <i class="ri-close-circle-line me-1 align-bottom"></i> Đã hủy
                                        </a>
                                    </li>
                                </ul>

                                <div class="table-responsive table-card mb-1">
                                    <table class="table table-nowrap align-middle" id="orderTable">
                                        <thead class="text-muted table-light">
                                            <tr class="text-uppercase">
                                                <th scope="col" style="width: 25px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll" value="0">
                                                    </div>
                                                </th>
                                                <th data-sort="stt">STT</th>
                                                <th data-sort="customer_email">Khách hàng </th>
                                                <th data-sort="code">Mã</th>
                                                <th data-sort="total_price">Tổng giá</th>
                                                <th data-sort="payment">Phương thức thanh toán</th>
                                                {{-- <th data-sort="transport">Mã giao dịch</th> --}}
                                                <th data-sort="status">Trạng thái</th>
                                                <th data-sort="created_at">Ngày mua</th>
                                                <th data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach($orders as $key => $order)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="checkAll" value="{{$order->id}}">
                                                    </div>
                                                </th>
                                                <td class="stt">{{ $key + 1 }}</td>
                                                <td class="customer_email">{{ $order->user->email }}</td>
                                                <td class="code">{{ $order->code }}</td>
                                                <td class="total_price">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                                                <td class="payment">
                                                    @if ($order->payment && $order->payment->paymentGateway)
                                                        {{ $order->payment->paymentGateway->name }}
                                                    @else
                                                        <span class="text-muted">Không có </span>
                                                    @endif
                                                </td>
                                                {{-- <td class="transport">{{ $order->tracking_number }}</td> --}}
                                                <td class="status">{!! isStatus($order->status) !!}</td>
                                                <td class="created_at">{{ $order->created_at->format('H:i d-m-Y') }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('admin.orders.orderDetail', $order->id )}}" class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item edit">
                                                            <button data-id="{{ $order->code }}" data-bs-toggle="modal" data-bs-target="#showModalEdit" class="btn text-primary d-inline-block edit-item-btn">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder" data-id="{{ $order->id }}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="noresult" style="display: none">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">Không tìm thấy đơn hàng nào </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev {{ $orders->onFirstPage() ? 'disabled' : '' }}" href="{{ $orders->previousPageUrl() }}">
                                            Trước
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0">
                                            @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                                <li class="page-item {{ $i === $orders->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor
                                        </ul>
                                        <a class="page-item pagination-next {{ $orders->hasMorePages() ? '' : 'disabled' }}" href="{{ $orders->nextPageUrl() }}">
                                            Sau
                                        </a>
                                    </div>
                                </div>

                            <div class="modal fade" id="showModalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="modalEditLabel">Cập nhật</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form  method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="idOrder" />

                                                <div class="mb-3">
                                                    <label for="code" class="form-label">Mã </label>
                                                    <input type="text" name="code" id="idCode" class=" form-control" disabled  />
                                                </div>

                                                <div class="mb-3">
                                                    <label for="customername-field" class="form-label">Khách hàng </label>
                                                    <input type="text" name="customerName" id="customerName" class="form-control" disabled  />
                                                </div>

                                                <div class="mb-3">
                                                    <label for="date-field" class="form-label">Ngày tạo</label>
                                                    <input type="text" id="date" name="date" class="form-control" data-provider="flatpickr" required data-date-format="d-m-Y" data-enable-time disabled />
                                                </div>
                                                <div>
                                                    <label for="delivered-status" class="form-label">Trạng thái</label>
                                                    <select class="form-control" name="status" data-choices data-choices-search-false id="idStatusEdit" data-current-status="">
                                                        <option value="Chờ xác nhận">Chờ xác nhận</option>
                                                        <option value="Đã xác nhận">Đã xác nhận</option>
                                                        <option value="Đang giao">Đang giao</option>
                                                        <option value="Hoàn thành">Hoàn thành</option>
                                                        <option value="Hàng thất lạc">Hàng thất lạc</option>
                                                        <option value="Đã hủy">Đã hủy</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-success" id="edit-btn">Lưu</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal delete-->
                            <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>Bạn muốn chuyển vào thùng rác</h4>
                                                <p class="text-muted fs-15 mb-4">Khi bạn chuyển vào thùng rác bạn vẫn có thể khôi phục lại!</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal">
                                                        <i class="ri-close-line me-1 align-middle"></i> Đóng
                                                    </button>
                                                    <button class="btn btn-danger" id="delete-record">Đúng , Tôi muốn xóa </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->

                            <!-- Modal delete-->
                            <div class="modal fade flip" id="deleteManyOrder" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>Bạn muốn chuyển các đơn hàng đã chọn vào thùng rác</h4>
                                                <p class="text-muted fs-15 mb-4">Khi bạn chuyển vào thùng rác bạn vẫn có thể khôi phục lại!</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal">
                                                        <i class="ri-close-line me-1 align-middle"></i> Đóng
                                                    </button>
                                                    <button class="btn btn-danger" id="deleteManyrecord">Đúng , Tôi muốn xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->


                            <!-- Modal Cập nhật thành công -->
                            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="successModalLabel">Thông báo </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="modal-body">

                                        </div>
                                        <div class="modal-footer">
                                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> --}}
                                            <button type="button" class="btn btn-primary" id="reloadEdit">Quay về</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End modal -->

                            {{-- Modal thông báo xóa mềm --}}
                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Xóa thành công</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Đơn hàng đã được chuyển vào thùng rác!
                                        </div>
                                        <div class="modal-footer">
                                            {{-- <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"> Close</button> --}}
                                            <button type="button" class="btn btn-primary" id="reloadDelete">Quay lại</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end modal--}}

                        </div>
                    </div>

                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>

    @endsection



@section('script_libray')
    <!-- list.js min js -->
     <script src="{{ asset('theme/assets/libs/list.js/list.min.js') }}"></script>

   <!--list pagination js-->
    <script src="{{ asset('theme/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- ecommerce-order init js -->
    <script src="{{ asset('theme/assets/js/pages/ecommerce-order.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('theme/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@endsection
@section('scripte_logic')
    <script>
    $(document).ready(function() {
    $('#demo-datepicker').flatpickr({
        dateFormat: "d-m-Y",
        onClose: function(selectedDates, dateStr, instance) {
            SearchByDate(selectedDates[0]);
        }
    });

    function SearchByDate(selectedDate) {
        if (selectedDate) {
            var formattedDate = formatDate(selectedDate);

            $.ajax({
                url: "{{ route('admin.orders.listOrder') }}",
                type: 'GET',
                data: {
                    date: formattedDate
                },
                success: function(response) {
                    renderOrderList(response.orders);
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        }
    }

    function formatDate(date) {
        var d = new Date(date);
        var year = d.getFullYear();
        var month = String(d.getMonth() + 1).padStart(2, '0');
        var day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});

function loadOrders(status) {
    const search = document.getElementById('searchInput').value;
    const date = document.getElementById('dateInput').value;

    // Tạo URL cho yêu cầu
    let url = `/admin/orders?status=${status}&search=${search}&date=${date}`;

    // Gọi API để lấy dữ liệu
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('orderTable').innerHTML = html;
        })
        .catch(error => console.error('Error fetching orders:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    // Hàm hiển thị đơn hàng vào bảng
    function renderOrders(orders) {
        let orderTableBody = document.querySelector('#orderTable tbody');
        orderTableBody.innerHTML = '';
        orders.forEach((order, index) => {
            orderTableBody.innerHTML += `
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                        </div>
                    </th>
                    <td class="stt">${index + 1}</td>
                    <td class="customer_email">${order.user.email}</td>
                    <td class="code">${order.code}</td>
                    <td class="total_price">${order.total_price}</td>
                    <td class="payment">${order.payment.paymentGateway.name}</td>
                    <td class="transport">${order.tracking_number}</td>
                    <td class="status">${getStatusHtml(order.status)}</td>
                    <td class="created_at">${formatDate(order.created_at)}</td>

                    <td>
                        <ul class="list-inline hstack gap-2 mb-0">
                            <li class="list-inline-item">
                                <a href="order-detail/${order.id}" class="text-primary d-inline-block">
                                    <i class="ri-eye-fill fs-16"></i>
                                </a>
                            </li>
                            <li class="list-inline-item edit">
                                <button data-id="${order.code}" data-bs-toggle="modal" data-bs-target="#showModalEdit" class="btn text-primary d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                </button>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder" data-id="${order.id}">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            `;
        });
    }

    // Format ngày
    function formatDate(dateString) {
    let date = new Date(dateString);
    let day = String(date.getDate()).padStart(2, '0');
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let year = date.getFullYear();

    return `${day}-${month}-${year}`;
    }

    // Đổi màu status ở js
    function getStatusHtml(status) {
    switch (status) {
        case "Chờ xác nhận":
            return '<span class="badge bg-secondary-subtle text-secondary text-uppercase">' + status + '</span>';
        case "Đã xác nhận":
            return '<span class="badge bg-success-subtle text-success text-uppercase">' + status + '</span>';
        case "Đang giao":
            return '<span class="badge bg-primary-subtle text-primary text-uppercase">' + status + '</span>';
        case "Hoàn thành":
            return '<span class="badge bg-info-subtle text-info text-uppercase">' + status + '</span>';
        case "Hàng thất lạc":
            return '<span class="badge bg-danger-subtle text-danger text-uppercase">' + status + '</span>';
        case "Đã hủy":
            return '<span class="badge bg-warning-subtle text-warning text-uppercase">' + status + '</span>';
        default:
            return '<span class="badge bg-warning-subtle text-warning text-uppercase">Unknown</span>';
        }
    }

    // Gửi yêu cầu Ajax để lấy danh sách đơn hàng theo status
    function fetchOrdersByStatus(status) {
        $.getJSON('/storage/orders.json')
            .done(function(data) {
                let filteredOrders = data.filter(order => order.status === status || status === 'All');
                renderOrders(filteredOrders);
            })
            .fail(function(jqxhr, textStatus, error) {
                console.error('Error loading orders JSON file:', textStatus, error);
                console.error('Response:', jqxhr.responseText);
            });
    }

    // Bắt sự kiện khi nhấp tab
    document.querySelectorAll('.nav-menu').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            let status = this.id; // Lấy status từ ID của tab
            fetchOrdersByStatus(status);
        });
    });
});




var modalEdit = document.getElementById('showModalEdit');
modalEdit.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var idOrder = button.getAttribute('data-id');

    let url = "{{ route('admin.orders.orderEdit', ':code') }}";
    url = url.replace(':code', idOrder);

    fetch(url, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    .then((response) => response.json())
    .then((data) => {     
        document.querySelector('#idOrder').value = data.id;
        document.querySelector('#idCode').value = data.code;
        document.querySelector('#customerName').value = data.user.email;
        document.querySelector('#date').value = new Date(data.created_at).toLocaleDateString('en-GB');
        document.querySelector('#idStatusEdit').value = data.status;
        // const statusSelect = document.querySelector('#idStatusEdit');
        
        // statusSelect.setAttribute('data-current-status', data.status);

        Array.from(statusSelect.options).forEach(option => {
            option.selected = (option.value === data.status);
        });

        // document.querySelector('#payment').value = data.payment.paymentGateway.name;
    })
    .catch((error) => {
        console.error('Error fetching order details:', error);
    });
});

// Cập nhật status
$(document).ready(function() {
    $('#showModalEdit').on('show.bs.modal', function() {
});

    $('#edit-btn').on('click', function(e) {
        e.preventDefault();
        var orderId = $('#idOrder').val();
        var status = $('#idStatusEdit').val();

        if (!status) {
            alert('Vui lòng chọn trạng thái!');
            return;
        }

        $.ajax({
            url: "{{ route('admin.orders.updateOrder', '') }}/" + orderId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                $('#showModalEdit').hide();

               var modal_body = document.getElementById("modal-body");

                $('#successModal').modal('show');
                if(response.status){
                    modal_body.innerHTML="Cập nhật trạng thái thành công"
                }else{
                    modal_body.innerHTML="<p class='text-danger'>Cập nhật không thành công !</p>"
                }

            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                alert('Có lỗi xảy ra trong quá trình cập nhật!');
            }
        });

        document.getElementById('reloadEdit').addEventListener('click', function() {
            location.reload();
        });
    });
});


// Xóa mềm 1
$(document).ready(function() {
    var orderId;

    $('#deleteOrder').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        orderId = button.data('id');
    });

    $('#delete-record').on('click', function(e) {
        e.preventDefault();


        $.ajax({
            url: 'soft-delete/' + orderId,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
            $('#deleteModal').modal('show');
            $('#deleteOrder').modal('hide');
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
            alert('Có lỗi xảy ra trong quá trình xóa đơn hàng!');
        }
        });

        document.getElementById('reloadDelete').addEventListener('click', function() {
            location.reload();
        });
    });
});

// Xóa mềm nhiều
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const deleteSelectedButton = document.getElementById('deleteSelected');
    const deleteManyRecordButton = document.getElementById('deleteManyrecord');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;

            if (checkedCount >= 1) {
                deleteSelectedButton.classList.remove('d-none');
            } else {
                deleteSelectedButton.classList.add('d-none');
            }
        });
    });

    // Khi nhấn nút "Xóa"
    deleteSelectedButton.addEventListener('click', function() {
        $('#deleteManyOrder').modal('show');
    });

    deleteManyRecordButton.addEventListener('click', function() {
        let selectedIds = [];
        $('input[type="checkbox"]:checked').each(function() {
            selectedIds.push($(this).val());
        });

        $.ajax({
            url: 'multi-soft-delete',
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            contentType: 'application/json',
            data: JSON.stringify({
                ids: selectedIds,
                action: 'soft_delete'
            }),
            success: function(response) {
                $('#deleteManyOrder').modal('hide');

                $('#deleteModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Có lỗi xảy ra trong quá trình xóa!');
            }
        });
    });

    document.getElementById('reloadDelete').addEventListener('click', function() {
        location.reload();
    });
});


</script>
@endsection
