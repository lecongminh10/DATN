@extends('admin.layouts.app')
@section('style_css')
    <style>
        /* .warning{
            display: flex;
            color: #4299e6;
        }
        
        .mdi{
            font-size: 25px;
            margin-right: 6px;
        }

        .text{
            font-size: 15px;
            margin-top: 7px;
        } */

        .file-upload-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100px; /* Điều chỉnh chiều cao khi cần thiết */
            background-color: #f8fafc; /* Màu nền sáng */
            border: 1px dashed #d1d5db; /* Kiểu đường viền đứt nét */
            border-radius: 8px; /* Góc bo tròn */
            color: #374151; /* Màu chữ */
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            position: relative;
        }

        .file-upload-container h3{
            font-size: 16px;
        }

        .file-input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .text-span{
            margin-top: 5px;
            color: #a0a1a3;
        }

        .table-thead{
            text-transform: uppercase; 
            color: rgb(148, 146, 146);
            font-style: inherit;
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
                            <li class="breadcrumb-item active">Nhập danh mục</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border border-dashed border-end-0 border-start-0 border-top-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Nhập danh mục</h5>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                        <div class="warning" >
                            <i class="mdi mdi-information-outline"></i>
                            <span class="text">Nếu bạn muốn xuất dữ liệu Sản phẩm, bạn có thể thực hiện nhanh chóng bằng cách nhấp vào Xuất sang CSV hoặc Xuất sang Excel.</span>
                        </div>

                        <div class="upload">

                        </div>
                    </div> --}}

                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                        <div class="file-upload-container">
                            <h3>Drag and drop file here or click to upload</h3>
                            <input type="file" class="file-input" accept=".csv, .xls, .xlsx"/>
                        </div>
                        <div class="text-span">
                            <span>Chọn một tệp có phần mở rộng sau: csv, xls, xlsx.</span>
                        </div>
                    </div>

                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0 button">
                        <div class="btn-footer">
                            <button class="btn btn-primary">Nhập</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Quy tắc</h5>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead class="table-thead">
                            <tr>
                                <th class="ps-3"> Cột</th>
                                <th> Quy tắc</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table-tbody">
                            <tr>
                                <td class="w-50 ps-3">Tên thuộc tính</td>
                                <td>Quy tắc</td>
                            </tr>
                            <tr>
                                <td class="w-50 ps-3">Tên thuộc tính</td>
                                <td>Quy tắc</td>
                            </tr>
                            <tr>
                                <td class="w-50 ps-3">Tên thuộc tính</td>
                                <td>Quy tắc</td>
                            </tr>
                            <tr>
                                <td class="w-50 ps-3">Tên thuộc tính</td>
                                <td>Quy tắc</td>
                            </tr>
                        </tbody>
                    </table>
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