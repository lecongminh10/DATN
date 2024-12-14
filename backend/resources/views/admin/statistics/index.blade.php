<style>
    #customer_impression_charts {
        height: 400px;
    }
</style>

@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="row">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="mt-3 mt-lg-0">
                                    <form method="GET" action="{{ route('admin.statistics.index') }}">
                                        <div class="form-group">
                                            <label style="width: 260px" for="month">Chọn tháng:</label>
                                            <select name="month" id="month" class="form-control"
                                                onchange="this.form.submit()">
                                                @foreach (range(1, 12) as $month)
                                                    <option
                                                        value="{{ now()->year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}"
                                                        @if (request('month') == now()->year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT)) selected @endif>
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
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng sản phẩm ban
                                            đầu</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ $totalProductStockAndBuycount }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-cube text-info"></i>
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
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng sản phẩm bán
                                            ra</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ $totalProductBuyCount }}
                                        </h4>
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
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng số lượng tồn
                                            kho</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ $totalProductStock }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-box text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Biểu Đồ</h4>
                                <div>
                                    <select id="chartType" class="form-select">
                                        <optgroup label="Sản Phẩm">
                                            <option value="top-selling">Sản Phẩm Bán Chạy</option>
                                            <option value="most-viewed">Lượt Xem Của Sản Phẩm</option>
                                            <option value="low-stock">Sản Phẩm Tồn Kho</option>
                                            <option value="total-sales">Tổng Số Lượng Bán Ra Theo Ngày</option>
                                        </optgroup>
                                        <optgroup label="Doanh Thu">
                                            <option value="revenue">Doanh Thu Theo Danh Mục</option>
                                            <option value="product-revenue">Doanh Thu Theo Từng Sản Phẩm</option>
                                            <option value="profit">Lợi Nhuận Theo Từng Sản Phẩm</option>
                                        </optgroup>
                                        <optgroup label="Khác">
                                            <option value="sales-trends">Xu Hướng Bán Hàng</option>
                                            <option value="feedback">Đánh Giá Khách Hàng Theo Từng Sản Phẩm</option>
                                            <option value="return-rate">Tỉ Lệ Hàng Trả Lại</option>
                                        </optgroup>
                                    </select>
                                </div>

                            </div><!-- end card header -->

                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div id="product_chart" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]'
                                        class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="table-responsive mt-4" id="customer-feedback-table-container" style="display: none;">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center ">
                                    <h4 class="card-title mb-0 flex-grow-1">Chi Tiết bình luận của từng sản phẩm </h4>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tên Sản Phẩm</th>
                                                <th>Đánh Giá Trung Bình</th>
                                                <th>Bình Luận</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customer-feedback-table">
                                            @foreach ($customerFeedback as $feedback)
                                                <tr>
                                                    <td>{{ $feedback['name'] }}</td>
                                                    <td>{{ number_format($feedback['value'], 2) }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($feedback['reviews'] as $review)
                                                                <li><strong>{{ $review->rating }} sao :</strong>
                                                                    {{ $review->review_text }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripte_logic')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // lấy dữ liệu
                let topSellingProducts = @json($topSellingProducts);
                let mostViewedProducts = @json($mostViewedProducts);
                let productStockData = @json($productStockData);
                let totalSalesData = @json($totalSalesData);
                let revenueData = @json($revenueData);
                let profitData = @json($profitData);
                let productRevenueData = @json($productRevenueData);

                let customerFeedback = @json($customerFeedback);
                let returnRateData = @json($returnRateData);
                let salesTrends = @json($salesTrends);


                const chartElement = document.querySelector("#product_chart");
                let chart;

                const renderChart = (data, title, isCurrency = false, isRating = false, lowStockThreshold = null) => {

                    const productNames = data.map(item => item.name || item.category_name || item.date);
                    const productValues = data.map(item => item.value || item.total || item.total);

                    const colors = productValues.map(value =>
                        lowStockThreshold && value < lowStockThreshold ?
                        getComputedStyle(document.documentElement).getPropertyValue('--vz-danger').trim() :
                        getComputedStyle(document.documentElement).getPropertyValue('--vz-primary').trim()
                    );

                    const options = {
                        series: [{
                            name: title,
                            data: productValues
                        }],
                        chart: {
                            type: 'line',
                            height: 350
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        xaxis: {
                            categories: productNames,
                        },
                        yaxis: {
                            title: {
                                text: title
                            }
                        },
                        colors: colors,
                        tooltip: {
                            x: {
                                format: 'dd MMM yyyy'
                            },
                            y: {
                                formatter: function(value) {
                                    if (isCurrency) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        }).format(value);
                                    } else if (isRating) {
                                        return `${value} ⭐`;
                                    }
                                    return value;
                                }
                            }

                        }
                    };

                    if (chart) {
                        chart.destroy();
                    }
                    chart = new ApexCharts(chartElement, options);
                    chart.render().catch(err => console.error(err));
                };

                renderChart(topSellingProducts, "Sản Phẩm Bán Chạy");
                document.getElementById("chartType").addEventListener("change", function() {
                    const chartType = this.value;
                    let selectedData;
                    document.getElementById("customer-feedback-table-container").style.display = "none";
                    switch (chartType) {
                        case "top-selling":
                            selectedData = topSellingProducts;
                            renderChart(selectedData, "Sản Phẩm Bán Chạy");
                            break;
                        case "most-viewed":
                            selectedData = mostViewedProducts;
                            renderChart(selectedData, "Lượt Xem");
                            break;
                        case "low-stock":
                            selectedData = productStockData;
                            renderChart(selectedData, "Sản Phẩm Tồn Kho", false);
                            break;

                        case "total-sales":
                            selectedData = totalSalesData;
                            renderChart(selectedData, "Số Lượng");
                            break;
                        case "revenue":
                            selectedData = revenueData;
                            renderChart(selectedData, "Doanh Thu Theo Danh Mục", true);
                            break;
                        case "profit":
                            selectedData = profitData;
                            renderChart(selectedData, "Lợi Nhuận", true);
                            break;
                        case 'product-revenue':
                            selectedData = productRevenueData;
                            renderChart(selectedData, "Doanh Thu Từng Sản Phẩm", true);
                            break;
                        case 'feedback':
                            selectedData = customerFeedback;
                            renderChart(selectedData, "Feedback của khách hàng", false, true);
                            document.getElementById("customer-feedback-table-container").style.display =
                                "block";
                            break;
                        case 'return-rate':
                            selectedData = returnRateData;
                            renderChart(selectedData, "Tỉ Lệ Hàng Trả Lại (%)");
                            break;
                        case 'sales-trends':
                            selectedData = salesTrends;
                            renderChart(selectedData, "Doanh Số");
                            break;
                        default:
                            selectedData = topSellingProducts;
                            renderChart(selectedData, "Sản Phẩm Bán Chạy");
                            break;
                    }
                });
            });
        </script>
    @endsection
