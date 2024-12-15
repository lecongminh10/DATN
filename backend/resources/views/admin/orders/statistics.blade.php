@extends('admin.layouts.app')

@section('title')
    Thống kê đơn hàng
@endsection
@section('content')
<div class="page-content">
<div class="container">
    
    <h1 class="mb-4">Thống kê đơn hàng</h1>
    <div class="row">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="mt-3 mt-lg-0" >
                        <form method="GET" action="{{ route('admin.orders.statistics') }}">
                            <div class="form-group">
                                <label style=" width: 260px" for="month">Chọn tháng:</label>
                                <select  name="month" id="month" class="form-control" onchange="this.form.submit()">
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ now()->year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}"
                                            @if ($selectedMonth == now()->year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT)) selected @endif>
                                            Tháng {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng Thu Nhập</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span data-target="{{ number_format($totalEarnings) }}">{{ number_format($totalEarnings) }}</span>đ
                            </h4>
                            <a href="#" class="text-decoration-underline">Tổng thu nhập</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-dollar-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn Hàng Hoàn Thành</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span class="counter-value" data-target="{{ $totalOrders }}">{{ $totalOrders }}</span>
                            </h4>
                            <a href="{{ route('admin.orders.listOrder') }}" class="text-decoration-underline">Xem tất cả đơn hàng </a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-shopping-bag text-info"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn Hàng Thất Lạc</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span class="counter-value" data-target="{{ $totalLostOrders }}">{{ $totalLostOrders }}</span>
                            </h4>
                            <a href="{{ route('admin.orders.listOrder') }}" class="text-decoration-underline">Đơn hàng thất lạc</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-error-circle text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn Hàng Đã Hủy</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span class="counter-value" data-target="{{ $totalCanceledOrders }}">{{ $totalCanceledOrders }}</span>
                            </h4>
                            <a href="{{ route('admin.orders.listOrder') }}" class="text-decoration-underline"> Đơn hàng đã hủy</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger-subtle rounded fs-3">
                                <i class="bx bx-x-circle text-danger"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="page-content">
    <div class="container">
        <h1 class="mb-4">Thống kê đơn hàng</h1>
        <div class="row">

            <!-- Các thống kê khác ở đây... -->

        </div> <!-- end row -->

        <!-- Biểu đồ -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-animate">
                    <div class="card-body">
                        <h4 class="header-title">Biểu Đồ Thống Kê Đơn Hàng</h4>
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div> <!-- end page-content -->
   
<script>
    // Dữ liệu cho biểu đồ
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tổng Thu Nhập', 'Hoàn Thành', 'Thất Lạc', 'Hủy'],
            datasets: [{
                label: 'Số lượng',
                data: [
                    {{ $totalEarnings }},
                    {{ $totalOrders }},
                    {{ $totalLostOrders }},
                    {{ $totalCanceledOrders }}
                ],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection