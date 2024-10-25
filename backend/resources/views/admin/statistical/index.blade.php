@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Thống kê</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="area_chart_irregular" data-colors='["--vz-primary", "--vz-warning", "--vz-success"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                </div><!--end row-->
            </div>
        </div>
    </div>
@endsection
@section('scripte_logic')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Gọi AJAX để lấy dữ liệu doanh thu
            fetch('/api/stats/revenue')
                .then(response => response.json())
                .then(data => {
                    let seriesData = data.map(item => [new Date(item.date).getTime(), item.revenue]);

                    var options = {
                        series: [{
                            name: "Revenue",
                            data: seriesData,
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                        },
                        xaxis: {
                            type: 'datetime'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#area_chart_irregular"), options);
                    chart.render();
                });
        });
    </script>
@endsection
