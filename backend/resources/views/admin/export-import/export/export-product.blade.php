@extends('admin.layouts.app')
@section('style_css')
    <style>
        .title-total{
            background-color: #eef3f6;
            padding: 30px 0  30px 0;
            font-size: 18px;
            text-align: center;
        }

        .number{
            font-size: 27px;
        }

        .content{
            display: flex;
            align-items: center;
        }

        .title{
            margin-right: 13px;
            font-size: 15px;
        }

        .title-link{
            color: #206dc4;
        }
        .title-link:hover{
            text-decoration: underline;
        }

        /* Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px; /* Khoảng cách giữa mỗi hộp kiểm */
        }

        .custom-checkbox {
            appearance: none; /* Xóa kiểu hộp kiểm mặc định */
            width: 23px;
            height: 23px;
            border: 1px solid gainsboro;
            border-radius: 4px; /* Góc bo tròn */
            position: relative;
            margin-right: 10px; /* Khoảng cách giữa hộp kiểm và nhãn */
            cursor: pointer;
        }

        .custom-checkbox:checked {
            background-color: #405189; /* Đảm bảo nền vẫn màu xanh khi được chọn */
        }

        .custom-checkbox:checked::after {
            content: '✔'; /* ✔ */
            font-size: 18px;
            color: white;
            position: absolute;
            top: -2px;
            left: 3px;
            padding-bottom: 5px;

        }

        .checkbox-container label {
            font-size: 16px;
            padding-top: 6px;
        }

        /* Radio */
        .radio-type {
            display: flex;
            align-items: center;
            gap: 10px; /* Khoảng cách giữa các tùy chọn */
        }

        .custom-radio {
            appearance: none; /* Xóa kiểu radio mặc định */
            width: 20px;
            height: 20px;
            border: 1px solid gainsboro; /* Đường viền màu xám */
            border-radius: 50%; /* Làm cho nó tròn */
            margin-right: 5px; /* Khoảng cách giữa radio và nhãn */
            position: relative;
            cursor: pointer;
        }

        .custom-radio:checked {
            background-color: #405189; /* Nền xanh khi được chọn */
            border-color: #405189;
        }

        .custom-radio:checked::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background-color: white; /* Chấm trắng bên trong */
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .radio-type label {
            font-size: 16px; /* Điều chỉnh kích thước phông chữ */
            padding-top: 5px;
            cursor: pointer;
        }

        .button{
            background-color: #eef3f6;
        }
    </style>

    
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @include('admin.layouts.component.page-header', [
                'title' => 'Xuất - Nhập',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Xuất sản phẩm', 'url' => '#'],
                ],
            ])

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Xuất sản phẩm</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="title-total ">
                                    <h5>Tổng mặt hàng</h5>
                                    <span class="number"><b>{{ $sumProduct }}</b></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="title-total x">
                                    <h5>Tổng sản phẩm</h5>
                                    <span class="number"><b>{{ $countProduct }}</b></span>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="title-total ">
                                    <h5>Tổng sản phẩm biến thể</h5>
                                    <span class="number"><b>{{ $countProductVariants }}</b></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                            <div class="title-category">
                                <div class="content">
                                    <h5 class="title">Cột</h5>
                                    <a href="#"  id="selectAllCheckboxes"><h5 class="title-link">Tất cả</h5></a>
                                </div>
                            </div>
                            <form action="export-products" method="post">
                                @csrf
                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h6>Sản phẩm: </h6>
                                    </div>
                                    <div class="row align-items-center">

                                        @php
                                            $columnNamesPro = [
                                                'id' => 'ID sản phẩm',
                                                'category_id' => 'Mã danh mục',
                                                'code ' => 'Mã sản phẩm',
                                                'name' => 'Tên sản phẩm',
                                                'short_description' => 'Mô tả ngắn',
                                                'content' => 'Mô tả chi tiết',
                                                'price_regular' => 'Giá sản phẩm',
                                                'price_sale' => 'Giá giảm',
                                                'stock' => 'Số lượng tồn kho',
                                                'rating' => 'Điểm đánh giá',
                                                'warranty_period' => "Thời gian bảo hành(tháng)",
                                                'view' => 'Số lượt xem',
                                                'buycount' => 'Số lượng lượt mua',
                                                'wishlistscount' => 'Số lượng lượt yêu thích',
                                                'is_active' => 'Cờ kích hoạt sản phẩm',
                                                'is_hot_deal' => 'Trạng thái hot của sản phẩm',
                                                'is_show_home' => 'Trạng thái hiển thị ra màn hình chủ',
                                                'is_new' => 'Trạng thái sản phẩm mới',
                                                'is_good_deal' => '	Trạng thái tốt của sản phẩm',
                                                'slug' => 'Slug của sản phẩm',
                                                'meta_title' => 'Tiêu đề SEO của sản phẩm',
                                                'meta_description' => 'Mô tả SEO của sản phẩm',
                                                'deleted_at' => 'Ngày xóa',
                                                'deleted_by' => 'Người xóa',
                                                'created_at' => 'Ngày tạo',
                                                'updated_at' => 'Ngày cập nhật',
                                            ];
                                        @endphp
                                        @foreach ($columnsDataPro as $key=> $pro)
                                            <div class="col-md-4 checkbox-container">
                                                <input type="checkbox" name="product[][{{ $pro['name'] }}]" id="checkbox-{{ $pro['name'] }}" class="custom-checkbox">
                                                <label for="checkbox-{{ $pro['name'] }}">{{ $columnNamesPro[$pro['name']] ?? $pro['name'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h6>Sản phẩm biến thể: </h6>
                                    </div>
                                    <div class="row align-items-center">
                                        @php
                                            $columnNamesProVar = [
                                                'id' => 'ID sản phẩm biến thể',
                                                'product_id' => 'Mã sản phẩm',
                                                'price_modifier' => 'Giá biến thể',
                                                'original_price' => 'Giá gốc',
                                                'stock' => 'Số lượng tồn kho',
                                                'sku' => 'Mã SKU',
                                                'status' => 'Trạng thái',
                                                'deleted_at' => 'Ngày xóa',
                                                'deleted_by' => 'Người xóa',
                                                'created_at' => 'Ngày tạo',
                                                'updated_at' => 'Ngày cập nhật',
                                            ];
                                        @endphp
                                        @foreach ($columnNamesProVar as $key => $proVar)
                                            <div class="col-md-4 checkbox-container">
                                                <input type="checkbox" name="product_variant[][{{$key}}]" id="checkbox-{{$key}}" class="custom-checkbox">
                                                <label for="checkbox-{{$key}}">{{ $proVar}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="title-category">
                                <div class="content">
                                    <h5 class="title">Định dạng</h5>
                                </div>
                                <div class="radio-type">
                                    {{-- <input type="radio" id="csvOption" name="format" class="custom-radio">
                                    <label for="csvOption">CSV</label> --}}
                                    
                                    <input type="radio" id="excelOption" name="radio" class="custom-radio">
                                    <label for="excelOption">Excel</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0 button">
                            <div class="">
                                {{-- <a href="{{ route('admin.export-import.view-export-import') }}"><button class="btn btn-primary me-2">Quay lại</button></a> --}}
                                <button class="btn btn-primary" id="exportButton" disabled>Xuất</button>
                            </div>
                        </div>
                    </form>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script_libray')
    
@endsection

@section('scripte_logic')
    <script>
        // Nhấn Tất cả sẽ tích chọn checkbox
        document.getElementById('selectAllCheckboxes').addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn chuyển hướng mặc định
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        
        // Kiểm tra nếu có ít nhất một checkbox chưa được chọn
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        
        // Thiết lập lại trạng thái của tất cả checkbox dựa vào allChecked
        checkboxes.forEach(checkbox => checkbox.checked = !allChecked);
        });

        // Khi chọn các checkbox và radio sẽ cho nhấn xuất
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.custom-checkbox');
            const radioButtons = document.querySelectorAll('.custom-radio');
            const exportButton = document.getElementById('exportButton');

            function updateExportButtonState() {
                // Kiểm tra nếu ít nhất một checkbox được chọn
                const isAnyCheckboxChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                // Kiểm tra nếu ít nhất một radio button được chọn
                const isAnyRadioChecked = Array.from(radioButtons).some(radio => radio.checked);
                // Kích hoạt nút Xuất nếu có ít nhất một checkbox và một radio được chọn
                exportButton.disabled = !(isAnyCheckboxChecked && isAnyRadioChecked);
            }

            // Lắng nghe sự kiện thay đổi trên checkbox và radio button
            checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateExportButtonState));
            radioButtons.forEach(radio => radio.addEventListener('change', updateExportButtonState));
        });

        // Gửi dữ liệu
        //document.getElementById('exportButton').addEventListener('click', function () {
        //    const selectedColumns = Array.from(document.querySelectorAll('.custom-checkbox:checked')).map(checkbox => checkbox.id.replace('checkbox-', ''));
        //    const selectedFormat = document.querySelector('.custom-radio:checked').id;

        //    fetch("export-products", {
        //        method: 'POST',
        //        headers: {
        //            'Content-Type': 'application/json',
        //            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //        },
        //        body: JSON.stringify({ columns: selectedColumns, format: selectedFormat })
        //    })
        //    .then(response => response.blob())
        //    .then(blob => {
        //        const url = window.URL.createObjectURL(blob);
        //        const a = document.createElement('a');
        //        a.style.display = 'none';
        //        a.href = url;
        //        a.download = 'products_and_variants.xlsx';
        //        document.body.appendChild(a);
        //        a.click();
        //        window.URL.revokeObjectURL(url);
        //    })
        //    .catch(error => console.error('Export failed:', error));
        //});

    </script>
@endsection