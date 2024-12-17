@extends('admin.layouts.app')

@section('title')
    Thùng Rác
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
            @include('admin.layouts.component.page-header', [
                    'title' => 'Đơn hàng',
                    'breadcrumb' => [
                        ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                        ['name' => 'Đơn hàng', 'url' => '#']
                    ]
                ])
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="orderList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Thùng rác</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <button id="restorySelected" class="btn btn-info waves-effect waves-light d-none"><i class="ri-pencil-fill fs-12"></i></button>
                                        <button id="deleteSelected" class="btn btn-soft-danger d-none"><i class="ri-delete-bin-5-fill fs-12"></i></button>
                                        <a href="{{ route('admin.orders.listOrder') }}" class="btn btn-primary"> Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form id="filterForm" action="{{ route('admin.orders.listTrashOrder') }}" method="GET">
                                @csrf
                                <div class="row g-3">
                                    <!-- Search -->
                                    <div class="col-xxl-5 col-sm-6">
                                        <div class="search-box">
                                            <input type="text" name="search" class="form-control search" placeholder="Tìm kiếm ..." value="{{ request('search') }}">
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
                                            <select class="form-control" name="status" id="idStatus">
                                                <option value="" disabled>Status</option>
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
                                    <!-- Filter Button -->
                                    <div class="col-xxl-1 col-sm-4">
                                        <div>
                                            <button id="filterButton" type="submit" class="btn btn-primary w-100">
                                                <i class="ri-equalizer-fill fs-13 align-bottom"></i> Tìm
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
                                                <th data-sort="stt">STT</th>
                                                <th data-sort="customer_email">Khách hàng </th>
                                                <th data-sort="code">Mã</th>
                                                <th data-sort="total_price">Tổng giá</th>
                                                <th data-sort="payment">Phương thức thanh toán</th>
                                                <th data-sort="transport">Mã giao dịch</th>
                                                <th data-sort="status">Trạng thái</th>
                                                <th data-sort="created_at">Ngày mua</th>
                                                <th data-sort="action">Hành động</th>
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
                                            <h5 class="mt-2">Xin lỗi! Không tìm thấy kết quả</h5>
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
                                            <button type="button" class="btn btn-primary" id="reloadRestory">Quay lại</button>
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
                url: "{{ route('admin.orders.listTrashOrder') }}",
                type: 'GET',
                data: {
                    date: formattedDate
                },
                success: function(response) {
                    console.log(response);
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


// Khôi phục
$(document).ready(function() {
    const restoreBtn = $('#restore-record');

    restoreBtn.on('click', function() {
        const orderId = $('.edit-item-btn').data('id'); 
        
        $.ajax({
            url: 'restore/' + orderId,
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
            $('#restoryModal').modal('show');
            $('#showResModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                alert('Có lỗi xảy ra trong quá trình khôi phục đơn hàng!');
            }
        });
        document.getElementById('reloadRestory').addEventListener('click', function() {
            location.reload();
        });
    });
});

// Khôi phục nhiều
$(document).ready(function() {
    const checkboxes = $('input[type="checkbox"]');
    const checkAll = $('#checkAll');
    const restoreSelectedButton = $('#restorySelected');

    checkAll.on('change', function() {
        checkboxes.not(this).prop('checked', this.checked);
        toggleRestoreButton();
    });

    checkboxes.not(checkAll).on('change', function() {
        toggleRestoreButton();
    });

    function toggleRestoreButton() {
        let checkedCount = $('input[type="checkbox"]:checked').length;
        if (checkedCount >= 1) {
            restoreSelectedButton.removeClass('d-none');
        } else {
            restoreSelectedButton.addClass('d-none');
        }
    }
    restoreSelectedButton.on('click', function() {
        $('#showResManyModal').modal('show');
    });

    $('#restoreManyRecord').on('click', function() {
        let selectedIds = [];
        $('input[type="checkbox"]:checked').each(function() {
            const id = $(this).val();
            if (id) {
                selectedIds.push(id);
            }
        });

        if (selectedIds.length === 0) {
            alert('Vui lòng chọn ít nhất một đơn hàng để khôi phục.');
            return;
        }

        $.ajax({
            url: 'restore_selected', 
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                ids: selectedIds
            },
            success: function(response) {
                $('#showResManyModal').modal('hide');
                $('#restoryModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                alert('Có lỗi xảy ra trong quá trình khôi phục!');
            }
        });
    });

    document.getElementById('reloadRestory').addEventListener('click', function() {
        location.reload();
    });
});

// Xóa cứng 1 
$(document).ready(function() {
    var orderId;
    
    $('#deleteOrder').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        orderId = button.data('id');
    });

    $('#delete-record').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'hard-delete/' + orderId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

// Xóa cứng nhiều
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const deleteSelectedButton = document.getElementById('deleteSelected');

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

    // Logic xóa
    deleteSelectedButton.addEventListener('click', function() {
        $('#deleteManyOrder').modal('show');
    });

    document.getElementById('deleteManyOrder').addEventListener('click', function() {

    let selectedIds = [];
    $('input[type="checkbox"]:checked').each(function() {
        const id = $(this).val();
        if (id) {
            selectedIds.push(id);
        }
    });
    // console.log(selectedIds);

    $.ajax({
        url: 'multi-hard-delete',
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        contentType: 'application/json',
        data: JSON.stringify({
            ids: selectedIds,
            action: 'hard_delete'
        }),
        success: function(response) {
            $('#deleteModal').modal('show');
            $('#deleteManyOrder').modal('hide');
        }
    });
    
    document.getElementById('reloadDelete').addEventListener('click', function() {
        location.reload();
    });
});

});

</script>
@endsection