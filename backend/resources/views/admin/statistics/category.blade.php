@extends('admin.layouts.app')
@section('title')
    Thống kê danh mục
@endsection
@section('style_css')
    <style>

    </style>
@endsection
@section('content')
    
        <div class="page-content">
            <div class="card">
                <h1 class="mb-4 mt-4 ms-4">Thống kê danh mục</h1>
                <div class="row ms-4">
                    @foreach ($categories as $category)
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                {{ $category->name }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span>{{ count($category->products) }}</span> Sản phẩm
                                            </h4>
                                            <a href="{{ route('admin.products.listProduct') }}"
                                                class="text-decoration-underline">Xem tất cả sản phẩm</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="bx bx-category text-primary"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-muted mb-1">Sản phẩm bán chạy nhất</p>
                                        @if ($category->products->isNotEmpty())
                                            <h5 class="fs-16 fw-semibold text-success mb-0">
                                                {{ $category->products->sortByDesc('sales_count')->first()->name }}
                                            </h5>
                                        @else
                                            <p class="text-muted mb-0">Chưa có sản phẩm bán chạy</p>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-muted mb-1">Sản phẩm không hoạt động</p>
                                        <h5 class="fs-16 fw-semibold text-danger mb-0">
                                            {{ $category->products->where('is_active', 1)->count() }} sản phẩm
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> <!-- end row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="">
                            <div class="card-body">
                                <h4 class="header-title">Biểu Đồ Thống Kê Số Lượng Sản Phẩm Theo Danh Mục</h4>
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="">
                            <div class="card-body">
                                <h4 class="header-title">Biểu Đồ Thống Kê Sản Phẩm Không Hoạt Động Theo Danh Mục</h4>
                                <canvas id="inactiveProductChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end page-content -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biểu đồ tổng sản phẩm
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($categories as $category)
                        '{{ $category->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Số lượng sản phẩm',
                    data: [
                        @foreach ($categories as $category)
                            {{ count($category->products) }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const ctx2 = document.getElementById('inactiveProductChart').getContext('2d');
        const inactiveProductChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($categories as $category)
                        '{{ $category->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Số lượng sản phẩm không hoạt động',
                    data: [
                        @foreach ($categories as $category)
                            {{ $category->products->where('is_active', 1)->count() }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
