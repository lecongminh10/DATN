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
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Biểu Đồ</h4>
                                <div>
                                    <select id="chartType" class="form-select">
                                        <optgroup label="Sản Phẩm">
                                            <option value="top-selling">Sản Phẩm Bán Chạy</option>
                                            <option value="most-viewed">Sản Phẩm Có Lượt Xem Cao Nhất</option>
                                            <option value="low-stock">Số Lượng Sản Phẩm</option>
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
                let lowStockProducts = @json($lowStockProducts);
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
                            const lowStockThreshold = 10;
                            selectedData = lowStockProducts;
                            renderChart(selectedData, "Số lượng", false, false, lowStockThreshold);
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
