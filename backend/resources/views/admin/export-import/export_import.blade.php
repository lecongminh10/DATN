@extends('admin.layouts.app')
@section('style_css')
    <style>
        .export-box{
            margin-bottom: 20px;
        }
        .export-title{
            /* font-style: inherit; */
        }
        .import-box{
            margin-bottom: 20px;
        }
        .title{
            color: #405189;
            font-size: 18px;
        }
        .text{
            color: gray;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Export-Import</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="export">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-2 export-box">
                            <div class="col-sm">
                                <h5 class="export-title mb-0">Export</h5>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-sm">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.export-import.exportCategory') }}"><b class="title"><i class="las la-box"></i> Category</b></a>
                                        <p class="text">Xuất dữ liệu danh mục của bạn sang tệp CSV hoặc Excel.</p>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.export-import.exportProduct') }}"><b class="title"><i class="las la-box"></i> Products</b></a>
                                        <p class="text">Xuất dữ liệu sản phẩm của bạn sang tệp CSV hoặc Excel.</p>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.export-import.exportPost') }}"><b class="title"><i class="las la-box"></i> Post</b></a>
                                        <p class="text">Xuất dữ liệu bài viết của bạn sang tệp CSV hoặc Excel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="import">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-2 import-box">
                            <div class="col-sm">
                                <h5 class="import-title mb-0">Import</h5>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-sm">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.export-import.importCategory') }}"><b class="title"><i class="las la-box"></i> Category</b></a>
                                        <p class="text">Nhập dữ liệu danh mục của bạn từ tệp CSV hoặc Excel.</p>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.export-import.importProduct') }}"><b class="title"><i class="las la-box"></i> Products</b></a>
                                        <p class="text">Nhập dữ liệu sản phẩm của bạn từ tệp CSV hoặc Excel.</p>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.export-import.importPost') }}"><b class="title"><i class="las la-box"></i> Post</b></a>
                                        <p class="text">Nhập dữ liệu bài viết của bạn từ tệp CSV hoặc Excel.</p>
                                    </div>
                                </div>
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