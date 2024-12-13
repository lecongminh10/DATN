@extends('admin.layouts.app')
@section('libray_css')
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="mt-3 mt-lg-0">
                                        <form action="javascript:void(0);">
                                            <div class="row g-3 mb-0 align-items-center">
                                                {{-- <div class="col-sm-auto">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control border-0 dash-filter-picker shadow">
                                                        <div class="input-group-text bg-primary border-primary text-white">
                                                            <i class="ri-calendar-2-line"></i>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <!--end col-->
                                                <div class="col-auto">
                                                    <a href="{{ route('admin.products.addProduct') }}"
                                                        class="btn btn-soft-success"><i
                                                            class="ri-add-circle-line align-middle me-1"></i>
                                                        Thêm mới sản phẩm</a>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                </div><!-- end card header -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Tổng giá trị đơn hàng
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class=""></i>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span>{{ number_format($totalOrderPrice, 0) }}</span> đ
                                                </h4>
                                                <a href="{{ route('admin.orders.listOrder') }}"
                                                    class="text-decoration-underline">
                                                    Xem chi tiết tất cả đơn hàng
                                                </a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="bx bx-dollar-circle text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Tổng đơn hàng
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-danger fs-14 mb-0">
                                                    <i class=""></i>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span>{{ $totalOrders }}</span> Đơn hàng
                                                </h4>
                                                <a href="{{ route('admin.orders.listOrder') }}"
                                                    class="text-decoration-underline">
                                                    Xem chi tiết tất cả đơn hàng
                                                </a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                                    <i class="bx bx-shopping-bag text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Khách hàng
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class=""></i>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span>{{ number_format($totalCustomers) }}</span> Tài khoản
                                                </h4>
                                                <a href="{{ route('admin.users.index') }}"
                                                    class="text-decoration-underline">Xem tất cả tài khoản</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                    <i class="bx bx-user-circle text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Tổng số sản phẩm
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class=""></i>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span>{{ $totalProducts }}</span>
                                                </h4>
                                                <a href="{{ route('admin.products.listProduct') }}"
                                                    class="text-decoration-underline">
                                                    Xem chi tiết
                                                </a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                    <i class="bx bx-package text-primary"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Biểu đồ tổng quát</h4>
                                    </div><!-- end card header -->

                                    <div class="card-header p-0 border-0 bg-light-subtle">
                                        <div class="row g-0 text-center">
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span>{{ $totalOrders }}</span></h5>
                                                    <p class="text-muted mb-0">Đơn hàng</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1">
                                                        <span>{{ number_format($totalOrderPrice, 0) }}</span> đ
                                                    </h5>
                                                    <p class="text-muted mb-0">Doanh thu</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span>{{ number_format($totalProducts, 0) }}</span>
                                                    </h5>
                                                    <p class="text-muted mb-0">Sản phẩm</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span>{{ $totalCustomers }}</span></h5>
                                                    <p class="text-muted mb-0">Khách hàng</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                    <div class="card-body p-0 pb-2">
                                        <div class="w-100">
                                            <div id="combined_chart" data-colors='["#4CAF50", "#F44336", "#2196F3"]'
                                                class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 pb-2">
                                        <div class="mt-3 text-center">
                                            <span class="badge" style="background-color: #6C63FF; color: white;">Doanh
                                                thu</span>
                                        </div>
                                        <div class="w-100">
                                            <div id="revenue_chart" data-colors='["#6C63FF"]' class="apex-charts"
                                                dir="ltr"></div>
                                        </div>
                                        <!-- Ghi chú màu -->
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Sản phẩm bán chạy</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Tên</th>
                                                        <th>Giá</th>
                                                        <th>Đơn hàng</th>
                                                        <th>Hàng hóa trong kho</th>
                                                        <th>Tổng bán</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($bestSellingProducts->isEmpty())
                                                        <tr>
                                                            <td colspan="5">Không có sản phẩm nào bán chạy.</td>
                                                        </tr>
                                                    @else
                                                        @foreach ($bestSellingProducts as $orderItem)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                            <img src="{{ Storage::url($orderItem->product->getMainImage()->image_gallery ?? 'default-image.jpg') }}"
                                                                                alt="Product Image"
                                                                                class="img-fluid d-block" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-14 my-1">
                                                                                <a href="{{ route('admin.products.showProduct', $orderItem->product->id) }}"
                                                                                    class="text-reset">{{ $orderItem->product->name }}</a>
                                                                            </h5>
                                                                            <span class="text-muted">
                                                                                {{ $orderItem->product->created_at ? $orderItem->product->created_at->format('d M Y') : 'N/A' }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ number_format($orderItem->product->price_regular) }}
                                                                        đ
                                                                    </h5>

                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ $orderItem->total_quantity }}
                                                                    </h5>

                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ $orderItem->product->stock }}</h5>

                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ number_format($orderItem->product->price_regular * $orderItem->total_quantity) }}
                                                                        đ
                                                                    </h5>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div
                                            class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                            <div class="col-sm">
                                                <div class="text-muted">
                                                    Showing <span
                                                        class="fw-semibold">{{ $bestSellingProducts->firstItem() }}</span>
                                                    to <span
                                                        class="fw-semibold">{{ $bestSellingProducts->lastItem() }}</span>
                                                    of <span
                                                        class="fw-semibold">{{ $bestSellingProducts->total() }}</span>
                                                    Results
                                                </div>
                                            </div>
                                            <div class="col-sm-auto mt-3 mt-sm-0">
                                                <ul
                                                    class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                                                    <li
                                                        class="page-item {{ $bestSellingProducts->onFirstPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $bestSellingProducts->previousPageUrl() }}"
                                                            class="page-link">←</a>
                                                    </li>

                                                    @foreach ($bestSellingProducts->getUrlRange(1, $bestSellingProducts->lastPage()) as $page => $url)
                                                        <li
                                                            class="page-item {{ $page == $bestSellingProducts->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $url }}"
                                                                class="page-link">{{ $page }}</a>
                                                        </li>
                                                    @endforeach
                                                    <li
                                                        class="page-item {{ $bestSellingProducts->hasMorePages() ? '' : 'disabled' }}">
                                                        <a href="{{ $bestSellingProducts->nextPageUrl() }}"
                                                            class="page-link">→</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end .h-100-->
                </div> <!-- end col -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
@endsection
@section('script_libray')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- apexcharts -->
    <script src="{{ asset('theme/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection
@section('scripte_logic')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Biểu đồ tổng số sản phẩm, khách hàng và đơn hàng
            var combinedOptions = {
                chart: {
                    height: 350,
                    type: 'line'
                },
                series: [{
                        name: 'Sản phẩm',
                        data: @json(array_values($monthlyProducts))
                    },
                    {
                        name: 'Khách hàng',
                        data: @json(array_values($monthlyCustomers))
                    },
                    {
                        name: 'Đơn hàng',
                        data: @json(array_values($monthlyOrders))
                    }
                ],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ]
                },
                colors: ['#4CAF50', '#F44336', '#2196F3'],
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 4
                },
                legend: {
                    position: 'top'
                }
            };

            var combinedChart = new ApexCharts(document.querySelector("#combined_chart"), combinedOptions);
            combinedChart.render();

            var revenueOptions = {
                chart: {
                    height: 350,
                    type: 'line'
                },
                series: [{
                    name: 'Doanh thu',
                    data: @json(array_values($monthlyRevenue))
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ]
                },
                colors: ['#6C63FF'],
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 4
                },
                legend: {
                    position: 'top'
                }
            };

            var revenueChart = new ApexCharts(document.querySelector("#revenue_chart"), revenueOptions);
            revenueChart.render();
        });
    </script>
@endsection
