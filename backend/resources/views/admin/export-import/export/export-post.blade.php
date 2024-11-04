@extends('admin.layouts.app')
@section('style_css')
    <style>
        .total-category{
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Xuất - Nhập</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại</a></li>
                            <li class="breadcrumb-item active">Xuất bài viết</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Xuất bài viết</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                        <div class="total-category">
                            <h5>Tổng bài viết</h5>
                            <span class="number"><b>30</b></span>
                        </div>
                    </div>

                    <div class="card-body">
                            <div class="title-category">
                                <div class="content">
                                    <h5 class="title">Cột</h5>
                                    <a href="#"><h5 class="title-link">Tất cả</h5></a>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 checkbox-container">
                                            <input type="checkbox" name="option" id="checkbox" class="custom-checkbox">
                                            <label for="checkbox">Bài viết 1</label>
                                        </div>
                                        <div class="col-md-4 checkbox-container">
                                            <input type="checkbox" name="option" id="checkbox" class="custom-checkbox">
                                            <label for="checkbox">Bài viết 2</label>
                                        </div>
                                        <div class="col-md-4 checkbox-container">
                                            <input type="checkbox" name="option" id="checkbox" class="custom-checkbox">
                                            <label for="checkbox">Bài viết 3</label>
                                        </div>
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
                                <button class="btn btn-primary">Export</button>
                            </div>
                        </div>
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
    
@endsection