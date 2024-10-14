@extends('admin.layouts.app')

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
                        <h4 class="mb-sm-0">Orders</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Orders Trash </li>
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
                                    <h5 class="card-title mb-0">Order Trash</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <button id="restorySelected" class="btn btn-info waves-effect waves-light d-none"><i class="ri-pencil-fill fs-12"></i></button>
                                        <button id="deleteSelected" class="btn btn-soft-danger d-none"><i class="ri-delete-bin-5-fill fs-16"></i></button>
                                        <a href="{{ route('orders.listOrder') }}" class="btn btn-primary"><i class="las la-arrow-left fs-15"></i> Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form id="filterForm" action="{{ route('orders.listTrashOrder') }}" method="GET">
                                @csrf
                                <div class="row g-3">
                                    <!-- Search -->
                                    <div class="col-xxl-5 col-sm-6">
                                        <div class="search-box">
                                            <input type="text" name="search" class="form-control search" placeholder="Search for order ID, customer, order status or something..." value="{{ request('search') }}">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <!-- Date Filter -->
                                    <div class="col-xxl-2 col-sm-6">
                                        <div>
                                            <input type="text" name="date" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y" id="demo-datepicker" placeholder="Select date" value="{{ request('date') }}">
                                        </div>
                                    </div>
                                    <!-- Status Filter -->
                                    <div class="col-xxl-2 col-sm-4">
                                        <div>
                                            <select class="form-control" name="status" id="idStatus">
                                                <option value="" disabled>Status</option>
                                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                                <option value="Chờ xác nhận" {{ request('status') == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                                                <option value="Đã xác nhận" {{ request('status') == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                                                <option value="Đang giao" {{ request('status') == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
                                                <option value="Hoàn thành" {{ request('status') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                                <option value="Hàng thất lạc" {{ request('status') == 'Hàng thất lạc' ? 'selected' : '' }}>Hàng thất lạc</option>
                                                <option value="Đã hủy" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Filter Button -->
                                    <div class="col-xxl-1 col-sm-4">
                                        <div>
                                            <button id="filterButton" type="submit" class="btn btn-primary w-100">
                                                <i class="ri-equalizer-fill fs-13 align-bottom"></i> Filters
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <div class="table-responsive table-card mb-1 mt-3">
                                    <table class="table table-nowrap align-middle" id="orderTable">
                                        <thead class="text-muted table-light">
                                            <tr class="text-uppercase">
                                                <th scope="col" style="width: 25px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll" value="0">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="customer_email">Customer</th>
                                                <th class="sort" data-sort="code">CODE</th>
                                                <th class="sort" data-sort="total_price">Price total</th>
                                                <th class="sort" data-sort="payment">Payment Method</th>
                                                <th class="sort" data-sort="transport">Transport</th>
                                                <th class="sort" data-sort="status">Status</th>
                                                <th class="sort" data-sort="created_at">Order date</th>
                                                <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach($orderTrash as $key => $order)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="checkoption"  value="{{$order->id}}">
                                                    </div>
                                                </th>
                                                <td class="stt">{{ $key + 1 }}</td>
                                                <td class="customer_email">{{ $order->user->email }}</td>
                                                <td class="code">{{ $order->code }}</td>
                                                <td class="total_price">{{ $order->total_price }}</td>
                                                <td class="payment">
                                                    @if ($order->payment && $order->payment->paymentGateway)
                                                        {{ $order->payment->paymentGateway->name }}
                                                    @else
                                                        <span class="text-muted">No Payment</span>
                                                    @endif
                                                </td>
                                                <td class="transport">{{ $order->tracking_number }}</td>
                                                <td class="status">{!! isStatus($order->status) !!}</td>
                                                <td class="created_at">{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        
                                                        <li class="list-inline-item edit" >
                                                            <a href="#showResModal" data-id="{{ $order->id }}" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a data-id="{{ $order->id }}" class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
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
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev {{ $orderTrash->onFirstPage() ? 'disabled' : '' }}" href="{{ $orderTrash->previousPageUrl() }}">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0">
                                            @for ($i = 1; $i <= $orderTrash->lastPage(); $i++)
                                                <li class="page-item {{ $i === $orderTrash->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $orderTrash->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor
                                        </ul>
                                        <a class="page-item pagination-next {{ $orderTrash->hasMorePages() ? '' : 'disabled' }}" href="{{ $orderTrash->nextPageUrl() }}">
                                            Next
                                        </a>
                                    </div>
                                </div>

                            {{-- Modal khôi phục --}}
                            <div class="modal fade" id="showResModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>Bạn muốn khôi phục lại đơn hàng này?</h4>
                                                <p class="text-muted fs-15 mb-4">Khôi phục đơn hàng của bạn sẽ đưa tất cả thông tin vào cơ sở dữ liệu của chúng tôi.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                    <button class="btn btn-primary" id="restore-record">Yes, Restore it</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End --}}

                            {{-- Modal khôi phục --}}
                            <div class="modal fade" id="showResManyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>Bạn muốn khôi phục lại các đơn hàng này?</h4>
                                                <p class="text-muted fs-15 mb-4">Khôi phục đơn hàng của bạn sẽ đưa tất cả thông tin vào cơ sở dữ liệu của chúng tôi.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                    <button class="btn btn-primary" id="restoreManyRecord">Yes, Restore it</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End --}}

                            <!-- Modal Khôi phục thành công -->
                            <div class="modal fade" id="restoryModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="successModalLabel">Khôi phục thành công</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Đơn hàng đã được khôi phục thành công!
                                        </div>
                                        <div class="modal-footer">
                                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> --}}
                                            <button type="button" class="btn btn-primary" id="reloadRestory">Quay về</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End modal -->

                            <!-- Modal xóa cứng -->
                            <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>Bạn sắp xóa một đơn hàng ?</h4>
                                                <p class="text-muted fs-15 mb-4">Việc xóa đơn hàng của bạn sẽ xóa tất cả thông tin của bạn khỏi cơ sở dữ liệu của chúng tôi.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                    <button class="btn btn-danger" id="delete-record">Yes, Delete It</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->

                            <!-- Modal xóa cứng nhiều -->
                            <div class="modal fade flip" id="deleteManyOrder" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>Bạn sắp xóa nhiều đơn hàng ?</h4>
                                                <p class="text-muted fs-15 mb-4">Việc xóa nhiều đơn hàng của bạn sẽ xóa tất cả thông tin của bạn khỏi cơ sở dữ liệu của chúng tôi.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                                    <button class="btn btn-danger" id="deleteManyRecord">Yes, Delete It</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->

                             {{-- Modal thông báo xóa cứng --}}
                             <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Xóa thành công</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Đơn hàng đã được xóa thành công!
                                        </div>
                                        <div class="modal-footer">
                                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> --}}
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

    <!-- jQuery (nếu chưa có) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
@endsection
    
@section('scripte_logic')
    <script>
$(document).ready(function() {
    // Khởi tạo Flatpickr
    $('#demo-datepicker').flatpickr({
        dateFormat: "d-m-Y", // Định dạng ngày
        onClose: function(selectedDates, dateStr, instance) {
            // Gọi hàm tìm kiếm khi người dùng chọn ngày
            SearchByDate(selectedDates[0]); // Chỉ cần chọn ngày đầu tiên
        }
    });

    // Hàm tìm kiếm theo ngày
    function SearchByDate(selectedDate) {
        if (selectedDate) {
            var formattedDate = formatDate(selectedDate); // Chuyển đổi ngày sang định dạng cần thiết
            
            // Gửi yêu cầu AJAX để tìm kiếm theo ngày
            $.ajax({
                url: "{{ route('orders.listTrashOrder') }}", // Thay đổi URL thành địa chỉ API của bạn
                type: 'GET',
                data: {
                    date: formattedDate // Chỉ gửi một ngày
                },
                success: function(response) {
                    // Xử lý dữ liệu trả về từ server
                    console.log(response);
                    renderOrderList(response.orders); // Gọi hàm renderOrderList để cập nhật giao diện
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        }
    }

    // Hàm chuyển đổi định dạng ngày (ví dụ: 'YYYY-MM-DD')
    function formatDate(date) {
        var d = new Date(date);
        var year = d.getFullYear();
        var month = String(d.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
        var day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});


// Khôi phục
$(document).ready(function() {
    const restoreBtn = $('#restore-record'); // Nút restore trong modal

    // Sự kiện khi nhấn nút "Yes, Restore it"
    restoreBtn.on('click', function() {
        // Lấy ID của đơn hàng cần khôi phục từ data-id
        const orderId = $('.edit-item-btn').data('id'); 
        
        // Gửi yêu cầu AJAX để khôi phục đơn hàng
        $.ajax({
            url: 'restore/' + orderId, // URL cho yêu cầu khôi phục
            type: 'PUT', // Phương thức PUT cho việc khôi phục
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token bảo mật
            },
            success: function(response) {
            // Hiển thị modal thành công
            $('#restoryModal').modal('show'); // Hiển thị modal thành công
            $('#showResModal').modal('hide'); // Ẩn modal xác nhận xóa
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error); // Hiển thị lỗi
                alert('Có lỗi xảy ra trong quá trình khôi phục đơn hàng!');
            }
        });
        // Thêm sự kiện cho nút làm mới trang trong modal
        document.getElementById('reloadRestory').addEventListener('click', function() {
            location.reload(); // Làm mới trang
        });
    });
});

// Hiển nút khôi phục nhiều

$(document).ready(function() {
    const checkboxes = $('input[type="checkbox"]'); // Tất cả các checkbox
    const checkAll = $('#checkAll'); // Checkbox chọn tất cả
    const restoreSelectedButton = $('#restorySelected'); // Nút khôi phục

    // Thêm sự kiện 'change' cho checkbox "Chọn tất cả"
    checkAll.on('change', function() {
        // Nếu checkbox "Chọn tất cả" được chọn, chọn tất cả các checkbox khác
        checkboxes.not(this).prop('checked', this.checked);
        toggleRestoreButton(); // Kiểm tra và hiển thị/ẩn nút khôi phục
    });

    // Thêm sự kiện 'change' cho các checkbox khác
    checkboxes.not(checkAll).on('change', function() {
        toggleRestoreButton(); // Kiểm tra và hiển thị/ẩn nút khôi phục
    });

    // Hàm kiểm tra và hiển thị/ẩn nút khôi phục
    function toggleRestoreButton() {
        let checkedCount = $('input[type="checkbox"]:checked').length; // Đếm số checkbox đã chọn
        if (checkedCount >= 1) {
            restoreSelectedButton.removeClass('d-none'); // Hiển thị nút
        } else {
            restoreSelectedButton.addClass('d-none'); // Ẩn nút
        }
    }

    // Xử lý sự kiện nhấn nút khôi phục
    restoreSelectedButton.on('click', function() {
        // Hiển thị modal xác nhận
        $('#showResManyModal').modal('show');
    });

    // Xử lý sự kiện khôi phục sau khi xác nhận
    $('#restoreManyRecord').on('click', function() {
        let selectedIds = []; // Mảng chứa ID của các đơn hàng đã chọn
        $('input[type="checkbox"]:checked').each(function() {
            const id = $(this).val(); // Lấy giá trị của checkbox
            if (id) { // Kiểm tra nếu giá trị không trống
                selectedIds.push(id); // Thêm ID vào mảng
            }
        });

        // Kiểm tra xem có ID nào được chọn không
        if (selectedIds.length === 0) {
            alert('Vui lòng chọn ít nhất một đơn hàng để khôi phục.');
            return; // Ngăn không gửi yêu cầu nếu không có ID nào được chọn
        }

        // Gửi yêu cầu khôi phục
        $.ajax({
            url: 'restore_selected', // URL cho yêu cầu khôi phục
            type: 'PUT', // Sử dụng phương thức PUT
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Thêm token bảo mật
            },
            data: {
                ids: selectedIds // Danh sách các ID được chọn
            },
            success: function(response) {
                // Ẩn modal xác nhận
                $('#showResManyModal').modal('hide');
                
                // Hiển thị modal thông báo khôi phục thành công
                $('#restoryModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error); // Ghi lại lỗi trong console
                alert('Có lỗi xảy ra trong quá trình khôi phục!');
            }
        });
    });

    // Thêm sự kiện cho nút làm mới trang sau khi khôi phục thành công
    document.getElementById('reloadRestory').addEventListener('click', function() {
        location.reload(); // Làm mới trang
    });
});

// Xóa cứng 1 
$(document).ready(function() {
    var orderId; // Biến để lưu ID đơn hàng
    
    // Khi modal xóa được hiển thị
    $('#deleteOrder').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Lấy nút đã kích hoạt modal
        orderId = button.data('id'); // Lấy ID đơn hàng từ thuộc tính data-id
    });

    // Khi người dùng nhấn nút "Yes, Delete It"
    $('#delete-record').on('click', function(e) {
        e.preventDefault(); // Ngăn hành vi mặc định của nút

        // Gửi yêu cầu AJAX để xóa đơn hàng
        $.ajax({
            url: 'hard-delete/' + orderId, // URL tương ứng với route
            type: 'DELETE', // Phương thức DELETE
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token bảo mật CSRF
            },
            success: function(response) {
                // Hiển thị thông báo thành công
                $('#deleteModal').modal('show'); // Hiển thị modal thành công
                $('#deleteOrder').modal('hide'); // Ẩn modal xác nhận xóa
                
                // Tùy chọn: Làm mới trang sau khi xóa thành công
                document.getElementById('reloadDelete').addEventListener('click', function() {
                    location.reload(); // Làm mới trang
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error); // Hiển thị lỗi trong console
                alert('Có lỗi xảy ra trong quá trình xóa đơn hàng!'); // Hiển thị thông báo lỗi cho người dùng
            }
        });
    });
});

// Xóa cứng nhiều
document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các checkbox
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const deleteSelectedButton = document.getElementById('deleteSelected');

    // Lặp qua từng checkbox và thêm sự kiện 'change'
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Đếm số checkbox được chọn
            let checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;

            // Nếu có ít nhất một checkbox được chọn, hiện nút "Xóa"
            if (checkedCount >= 1) {
                deleteSelectedButton.classList.remove('d-none'); // Hiển thị nút
            } else {
                deleteSelectedButton.classList.add('d-none'); // Ẩn nút nếu không có checkbox nào được chọn
            }
        });
    });

    // Logic xóa

    deleteSelectedButton.addEventListener('click', function() {
        // Hiển thị modal xác nhận
        $('#deleteManyOrder').modal('show');
    });

    document.getElementById('deleteManyOrder').addEventListener('click', function() {
    // Lấy tất cả các checkbox đã được chọn
    let selectedIds = [];
    $('input[type="checkbox"]:checked').each(function() {
        const id = $(this).val(); // Lấy giá trị của checkbox
        if (id) { // Kiểm tra nếu giá trị không trống
            selectedIds.push(id); // Thêm ID vào mảng
        }
    });
    console.log(selectedIds);

    // Gửi yêu cầu xóa mềm nhiều qua AJAX
    $.ajax({
        url: 'multi-hard-delete', // Đảm bảo URL đúng với route đã định nghĩa
        type: 'DELETE', // Phương thức DELETE cho yêu cầu
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token bảo mật Laravel
        },
        contentType: 'application/json',
        data: JSON.stringify({
            ids: selectedIds, // Danh sách các id được chọn
            action: 'hard_delete'
        }),
        success: function(response) {
            // Hiển thị modal thành công
            $('#deleteModal').modal('show'); // Hiển thị modal thành công
            $('#deleteManyOrder').modal('hide'); // Ẩn modal xác nhận xóa
        }
    });
     // Thêm sự kiện cho nút làm mới trang trong modal
    document.getElementById('reloadDelete').addEventListener('click', function() {
        location.reload(); // Làm mới trang
    });
});

});

</script>
@endsection