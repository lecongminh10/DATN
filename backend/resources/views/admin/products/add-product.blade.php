@extends('admin.layouts.app')

@section('libray_css')
    <!-- dropzone css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dropzone/dropzone.css') }}" type="text/css" />
    <!-- Filepond css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/addProduct.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.1.0/styles/choices.min.css" />
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
@endsection
@section('style_css')
    <style>
        .dropzone {
            border: 1px solid rgb(212 212 212 / 80%);
        }

        #searchInput {
            position: relative;
        }

        #result {
            position: absolute;
            right: -5px;
            top: 45px;
            width: 200px;
            z-index: 1000;
            background: none;
            border: 0px;
            box-shadow: none;
            display: none;
        }

        .attribute-input-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            margin-top: 50px;
            /* Adding the margin-top */
            justify-content: space-between;
        }

        .attribute-input-group input {
            margin-right: 10px;
            flex-grow: 1;
            /* Allows the input to expand and fill available space */
            max-width: 400px;
            /* Set the maximum width for the input */
        }

        .attribute-input-group button {
            margin-left: 10px;
            padding: 5px 15px;
            width: auto;
            /* Auto width to fit the button text */
        }

        .attribute-input-group {
            position: relative;
            /* Make the parent relative */
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            justify-content: space-between;
        }

        .suggestions-list {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-top: 5px;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            min-width: 390px;
            position: absolute;
            z-index: 1000;
            background-color: white;
            top: 100%;
            right: 70px;
        }

        #attributesContainer {
            padding-bottom: 25px;
        }

        .suggestions-list li {
            padding: 8px;
            cursor: pointer;
        }

        .suggestions-list li:hover {
            background-color: #f0f0f0;
        }

        /* Your CSS styles here */
        .attribute-input-group {
            margin-bottom: 15px;
            /* Add space between input groups */
        }

        .select2-container {
            width: 100% !important;
            /* Ensure the Select2 dropdown takes the full width */
        }

        /* Optional: Style for the button */
        .btn-danger {
            background-color: #dc3545;
            /* Bootstrap danger color */
            border: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #405189 !important;
            color: #fff !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff !importantimportant;
        }

        .attribute-input-group button {
            margin-right: 15px
        }

        #saveAttributes {
            float: right;
            margin-bottom: 10px;
        }

        .remove-attribute-values {
            color: red;
            font-size: 18px;
        }

        .list-group-item-attribute {
            display: flex;
            /* Use flexbox for layout */
            align-items: center;
            /* Center items vertically */
            padding: 0.75rem 1.25rem;
            /* Add padding for spacing */
            margin-bottom: -1px;
            /* Remove space between items */
            border: 1px solid rgba(0, 0, 0, 0.125);
            /* Light border */
            border-radius: 0.25rem;
            /* Rounded corners */
            background-color: #ffffff;
            /* Background color */
            color: #212529;
            /* Text color */
            transition: background-color 0.15s ease-in-out;
            /* Smooth hover transition */
        }

        .list-group-item-attribute:hover {
            background-color: #f8f9fa;
            /* Change background color on hover */
        }

        .list-group-item-attribute:focus {
            outline: none;
            /* Remove outline on focus */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Shadow effect for focus */
        }

        /* Optional: Styling for checkboxes */
        .list-group-item-attribute input[type="checkbox"] {
            margin-right: 0.5rem;
            /* Space between checkbox and label */
        }

        /* Optional: Additional styling for nested items */
        .list-group-item-attribute.nested {
            padding-left: 1.5rem;
            /* Indentation for nested items */
        }

        .hidden {
            display: none;
        }

        .dropzone .dz-preview.dz-image-preview {
            display: none;
        }

        .cke_notification {
            display: none;
        }

        .coupon-list {
            border: 1px solid #ccc;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            /* Nếu cần định vị bên dưới input */
            background-color: white;
            z-index: 1000;
            /* Để đảm bảo dropdown nằm trên các phần tử khác */
        }

        .coupon-list div {
            padding: 10px;
            cursor: pointer;
        }

        .coupon-list div:hover {
            background-color: #f0f0f0;
            /* Màu nền khi hover */
        }

        #couponList {
            width: 95%;
            padding: 5px 16px;
            border-radius: 3px;

        }

        .coupon-item {
            border: 1px solid #ddd;
            /* Khung cho từng mục mã giảm giá */
            padding: 15px;
            /* Khoảng cách bên trong */
            border-radius: 5px;
            /* Bo góc */
            margin-bottom: 15px;
            /* Khoảng cách giữa các mục */
            background-color: #f9f9f9;
            /* Màu nền */
            position: relative;
            /* Để sử dụng cho vị trí tuyệt đối của các nút */
        }

        .coupon-actions {
            position: absolute;
            /* Đặt vị trí tuyệt đối */
            top: 10px;
            /* Khoảng cách từ trên xuống */
            right: 10px;
            /* Khoảng cách từ bên phải */
            display: flex;
            /* Sử dụng Flexbox để căn chỉnh */
            align-items: center;
            /* Căn giữa theo chiều dọc */
        }

        .coupon-checkbox {
            margin-right: 10px;
            /* Khoảng cách bên phải cho checkbox */
        }

        .coupon-actions label {
            cursor: pointer;
            /* Thay đổi con trỏ khi di chuột vào label */
            margin-bottom: 0;
            /* Bỏ khoảng cách dưới cho label */
        }

        .remove-icon {
            display: inline-block;
            /* Hiển thị dưới dạng khối inline */
            background-color: transparent;
            /* Nền trong suốt */
            border: none;
            /* Không có viền */
            cursor: pointer;
            /* Con trỏ khi di chuột */
            font-size: 20px;
            /* Kích thước biểu tượng */
            color: #dc3545;
            /* Màu sắc của biểu tượng */
            transition: color 0.3s;
            /* Hiệu ứng chuyển màu */
        }

        .remove-icon:hover {
            color: #c82333;
            /* Màu khi di chuột */
        }

        /* Bạn có thể thêm một số padding hoặc margin để tạo khoảng cách */
        .remove-icon {
            margin-left: 10px;
            /* Khoảng cách với phần tử trước */
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Sản phẩm ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Sản phẩm', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col">
                    <form action="{{ route('admin.products.addPostProduct') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm" class="dropzone">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="live-preview">
                                            <div class="row gy-4">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">Tên </label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" id="name" value="{{ old('name') }}">

                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="description" class="form-label">Mô tả ngắn  <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" value="{{old('short_description')}}" name="short_description" id="short_description"></textarea>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="meta_title" class="form-label">SEO tiêu đề  <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="meta_title" id="meta_title" value="{{old('meta_title')}}"></textarea>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="meta_description" class="form-label">SEO mô tả  <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="meta_description" id="meta_description" value="{{old('meta_description')}}"></textarea>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mt-3">
                                                        <label for="code" class="form-label">Mã</label>
                                                        <input type="text"
                                                            class="form-control @error('code') is-invalid @enderror"
                                                            name="code" id="code"
                                                            value="{{ strtoupper(\Str::random(8)) }}">
                                                        @error('code')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="stock" class="form-label">Số lượng tồn kho</label>
                                                        <input type="number"
                                                            class="form-control @error('stock') is-invalid @enderror" value="{{old('stock')}}"
                                                            name="stock" id="stock" onchange="getPrices()">
                                                        @error('stock')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="price_regular" class="form-label">Giá gốc</label>
                                                        <input type="number"
                                                            class="form-control @error('price_regular') is-invalid @enderror" value="{{old('price_regular')}}"
                                                            name="price_regular" id="price_regular" onchange="getPrices()">
                                                        @error('price_regular')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="price_sale" class="form-label">Giá khuyến mãi <span class="text-danger">*</span></label>
                                                        <input type="number"
                                                            class="form-control @error('price_sale') is-invalid @enderror" value="{{old('price_sale')}}"
                                                            name="price_sale" id="price_sale" onchange="getPrices()">
                                                        @error('price_sale')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="product_tags"
                                                            class="form-label text-muted">Thẻ <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="product_tags[]"
                                                            id="choices-multiple-remove-button"
                                                            placeholder="This is a placeholder" multiple>
                                                        </select>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="price_sale" class="form-label">Thời gian bảo hành <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" class="form-control" name="warranty_period" value="{{old('warranty_period')}}"
                                                            id="warranty_period">
                                                    </div>
                                                    <div class="row">
                                                        @php
                                                            $status = [
                                                                'is_active' => 'primary',
                                                                'is_hot_deal' => 'danger',
                                                                'is_good_deal' => 'warning',
                                                                'is_new' => 'success',
                                                                'is_show_home' => 'info',
                                                            ];
                                                        @endphp
                                                        <div class="card-header align-items-center d-flex">
                                                            <h4 class="card-title mb-0 flex-grow-1">Trạng thái <span class="text-danger">*</span></h4>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach ($status as $key => $statu)
                                                                        <div class="col-md-2">
                                                                            <div
                                                                                class="form-check form-switch form-switch-{{ $statu }}">
                                                                                <input
                                                                                    class="form-check-input status-checkbox"
                                                                                    type="checkbox" role="switch" value="{{old($key)}}"
                                                                                    name="{{ $key }}"
                                                                                    id="{{ $key }}">
                                                                                <label class="form-check-label"
                                                                                    for="{{ $key }}">{{ ucwords(str_replace('_', ' ', str_replace('is_', '', $key))) }}</label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header align-items-center d-flex">
                                                            <h4 class="card-title mb-0 flex-grow-1">Danh mục</h4>
                                                            @error('category_id')
                                                                <div>
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="card-body">
                                                            <div data-simplebar style="max-height: 525px;">
                                                                <div class="list-group col nested-list nested-sortable"
                                                                id="nested-sortable">
                                                                @foreach ($categories as $category)
                                                                    @include(
                                                                        'admin.categories.partials.category',
                                                                        ['category' => $category]
                                                                    )
                                                                @endforeach
                                                            </div>
                                                            </div>
                                                        </div><!-- end card-body -->
                                                    </div><!-- end card -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Content</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Editor container -->
                                        <textarea name="content" id="editor-container" style="height: 300px;" value="{{old('content')}}"></textarea>
                                        @error('content')
                                            <div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header">
                                        <h5 class="mb-0">Thêm các biến thế</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="nav flex-column nav-pills text-center" id="v-pills-tab"
                                                    role="tablist" aria-orientation="vertical">
                                                    <a class="nav-link mb-2 active" id="attribute_value"
                                                        data-bs-toggle="pill" href="#v-pills-home" role="tab"
                                                        aria-controls="v-pills-home" aria-selected="true">
                                                        Thuộc tính
                                                    </a>
                                                    <a class="nav-link mb-2" id="product_variant" data-bs-toggle="pill"
                                                        href="#v-pills-profile" role="tab"
                                                        aria-controls="v-pills-profile" aria-selected="false">
                                                        Các biến thể
                                                    </a>
                                                    <a class="nav-link mb-2" id="coupon-tab" data-bs-toggle="pill"
                                                        href="#v-pills-coupons" role="tab"
                                                        aria-controls="v-pills-coupons" aria-selected="false">
                                                        Khuyến mãi
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                                                    <div class="tab-pane fade show active" id="v-pills-home"
                                                        role="tabpanel" aria-labelledby="attribute_value">
                                                        <div id="saveAttributes" class="btn btn-primary  float-start">Lưu
                                                            Giá Trị
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-3">
                                                            <input type="text" id="searchInput"
                                                                class="form-control me-2" placeholder="Nhập thông tin..."
                                                                style="width: 200px;">
                                                        </div>
                                                        <div id="result" class="mt-3 suggestion-list"></div>
                                                        <!-- Div để hiển thị kết quả gợi ý -->
                                                        <div id="attributesContainer" class="mt-3">
                                                            <div id="selectedAttributes"></div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                        aria-labelledby="product_variant">
                                                        <div class="btn btn-info my-2 float-end" id="applyPrice">
                                                            Áp dụng giá toàn bộ
                                                        </div>
                                                        <div id="selectedAttributes">
                                                            <table class="table table-bordered" id="attributeTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Giá trị</th>
                                                                        <th>Giá Gốc</th>
                                                                        <th>Giá Mới</th>
                                                                        <th>Kho</th>
                                                                        <th>Trạng thái</th>
                                                                        <th>Ảnh</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="attributeList">
                                                                    @php
                                                                        $i = 0;
                                                                    @endphp
                                                                    @if (session('product_attributes') && count(session('product_attributes')) > 0)
                                                                        @foreach (session('product_attributes') as $attribute)
                                                                            @php
                                                                                ++$i;
                                                                            @endphp
                                                                            <tr>
                                                                                <td>
                                                                                    @php
                                                                                        $attributeString = '';
                                                                                        $attributeValueString = '';
                                                                                        foreach (
                                                                                            $attribute
                                                                                            as $key => $item
                                                                                        ) {
                                                                                            $attributeString .= "{$key}: {$item}<br>";
                                                                                            $attributeValueString .= "{$item},";
                                                                                        }
                                                                                        $attributeString = rtrim(
                                                                                            $attributeString,
                                                                                            '<br>',
                                                                                        );
                                                                                        $attributeValueString = rtrim(
                                                                                            $attributeValueString,
                                                                                            ', ',
                                                                                        );
                                                                                    @endphp
                                                                                    <input type="hidden"
                                                                                        name="product_variants[{{ $i }}][attributes_values]"
                                                                                        value="{{ $attributeValueString }}"
                                                                                        class="product_variants">
                                                                                    {!! $attributeString !!}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="product_variants[{{ $i }}][original_price]"
                                                                                        class="form-control original_price"
                                                                                        id="original_price_{{ $i }}" />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="product_variants[{{ $i }}][price_modifier]"
                                                                                        class="form-control price_modifier"
                                                                                        id="price_modifier_{{ $i }}" />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="product_variants[{{ $i }}][stock]"
                                                                                        class="form-control stock"
                                                                                        min="0" />
                                                                                </td>
                                                                                <td>
                                                                                    <select
                                                                                        class="form-control status_attribute"
                                                                                        name="product_variants[{{ $i }}][status]">
                                                                                        <option value="none">None
                                                                                        </option>
                                                                                        <option value="available">Available
                                                                                        </option>
                                                                                        <option value="out_of_stock">Out of
                                                                                            Stock</option>
                                                                                        <option value="discontinued">
                                                                                            Discontinued</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="file"
                                                                                        class="form-control"
                                                                                        name="product_variants[{{ $i }}][variant_image]" />
                                                                                </td>
                                                                                <td>
                                                                                    <i
                                                                                        class="ri-delete-bin-5-fill remove-attribute-values"></i>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="7" class="text-center">Không
                                                                                có thuộc tính sản phẩm nào trong session.
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- Tab: Coupons -->
                                                    <div class="tab-pane fade" id="v-pills-coupons" role="tabpanel"
                                                        aria-labelledby="coupon-tab">
                                                        <div data-simplebar style="max-height: 220px;" class="px-3">
                                                            <!-- Submit Button -->
                                                            <div class="row mb-3">
                                                                <div class="col-sm-6">
                                                                    <div class="btn btn-primary" id="showFormCounpon">Thêm
                                                                        mã khuyến mãi</div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control"
                                                                        id="searchCoupon"
                                                                        placeholder="Nhập mã giảm giá để tìm kiếm"
                                                                        oninput="searchCoupons()">
                                                                    <div id="couponList" class="coupon-list"
                                                                        style="display: none;"></div>
                                                                </div>

                                                            </div>
                                                            <!-- Coupon Code & Discount Type -->
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5>Mã khuyến mãi</h5>
                                                                </div>
                                                                <div class="card-body" id="addCoupone">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--  end col -->
                                            </div>
                                            <!--end row-->
                                        </div><!-- end card-body -->
                                    </div><!-- end card -->
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Mục ảnh sản phẩm </h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div>
                                                <input type="file" name="product_galaries[][image_gallery]"
                                                    id="product_galaries" class="hidden" multiple />
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                    </div>
                                                    <h4>Kéo ảnh vào đây.</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <ul class="list-unstyled mb-0" id="dropzone-preview">
                                                </ul>
                                            </div>

                                            <!-- end dropzon-preview -->
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <button class="btn btn-primary" type="submit"
                                                id="uploadButton">Save</button>
                                                <a href="{{route('admin.products.listProduct')}}" class="btn btn-primary mx-2">Trở về</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.products.modalmessages.messageSaveAttribute')
    @include('admin.products.modalmessages.applyprice')
@endsection
<!-- Initialize Quill editor -->

@section('script_libray')
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.1.0/choices.min.js"></script>

    <!-- filepond js -->
    <script src="{{ asset('theme/assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
@section('scripte_logic')
    {{-- <script src="{{ asset('theme/assets/js/addProduct.js') }}"></script> --}}
    <script>
        $('#applyPrice').on('click', function() {
            $('#applyPriceModal').modal('show');
        });

        function getPrices() {
            var priceRegularValue = document.getElementById('price_regular').value;
            var priceSaleValue = document.getElementById('price_sale').value;
            var stock = document.getElementById('stock').value;
            document.getElementById("originalPrice").value = priceRegularValue;
            document.getElementById("salePrice").value = priceSaleValue;
            document.getElementById('stockPrice').value = stock;
        }

        document.getElementById("applyPrices").addEventListener("click", function() {
            var priceRegularValue = document.getElementById("originalPrice").value;
            var priceSaleValue = document.getElementById("salePrice").value;
            var stockPrice = document.getElementById('stockPrice').value;
            var stockStatus = document.getElementById("stockStatus").value;

            const original_prices = document.querySelectorAll('.original_price');
            original_prices.forEach(function(original_price) {
                original_price.value = priceRegularValue;
            })
            const price_modifiers = document.querySelectorAll('.price_modifier');
            price_modifiers.forEach(function(price_modifier) {
                price_modifier.value = priceSaleValue
            })
            const stocks = document.querySelectorAll('.stock')
            stocks.forEach(function(stock) {
                stock.value = stockPrice;
            })
            const status_attributes = document.querySelectorAll('.status_attribute');
            status_attributes.forEach(function(status_attribute) {
                status_attribute.value = stockStatus
            })
            $('#applyPriceModal').modal('hide');
        })

        const checkboxes = document.querySelectorAll('.status-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.value = checkbox.checked ? 1 : 0;
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    checkbox.value = 1;
                } else {
                    checkbox.value = 0;
                }
            });
        });
    </script>
    <script>
        CKEDITOR.replace('editor-container');
    </script>
    <script>
        $(document).ready(function() {
            let attributesFromJson = [];
            const attributesArray = [];
            const selectedAttributes = [];

            $.getJSON('/storage/attributes.json')
                .done(function(data) {
                    data.forEach(function(attribute) {
                        attributesFromJson.push({
                            id: attribute.id,
                            name: attribute.name,
                            values: attribute.values
                        });
                    });

                    attributesFromJson.forEach(attribute => {
                        attributesArray.push(attribute.name);
                    });
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.error('Error loading attributes JSON file:', textStatus, error);
                    console.error('Response:', jqxhr.responseText);
                });

            $('#searchInput').on('input', function() {
                const query = $(this).val().toLowerCase();
                const result = document.getElementById("result");
                result.style.display = 'block';
                let resultHTML = '';

                if (query) {
                    const filteredAttributes = attributesArray.filter(attribute =>
                        attribute.toLowerCase().includes(query) && !selectedAttributes.includes(
                            attribute)
                    );

                    if (filteredAttributes.length > 0) {
                        resultHTML += '<ul class="list-group">';
                        filteredAttributes.forEach(attribute => {
                            resultHTML += `<li class="list-group-item-attribute">${attribute}</li>`;
                        });
                        resultHTML += '</ul>';
                    } else {
                        resultHTML = '<p class="text-muted">Không tìm thấy gợi ý nào.</p>';
                    }
                }
                $('#result').html(resultHTML);
            });

            $(document).on('click', '.list-group-item-attribute', function() {
                const selectedAttribute = $(this).text();
                addAttributeInput(selectedAttribute);
                selectedAttributes.push(selectedAttribute);
                $('#result').empty();
                $('#searchInput').val('');
            });

            function addAttributeInput(attribute) {
                const selectedAttributeData = attributesFromJson.find(attr => attr.name === attribute);
                let optionsHTML = '';

                if (selectedAttributeData && selectedAttributeData.values) {
                    selectedAttributeData.values.forEach(value => {
                        optionsHTML +=
                            `<option value="${value.attribute_value}">${value.attribute_value}</option>`;
                    });
                }

                const attributeGroup = `
                    <div class="attribute-input-group row mb-2">
                        <input type="text" class="form-control col-lg-5 " value="${attribute}" readonly >
                        <div class="col-lg-5">
                            <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                <optgroup label="Options">
                                    ${optionsHTML} 
                                </optgroup>
                            </select>
                        </div>
                        <button class="btn btn-danger remove-attribute col-lg-2">Xóa</button>
                    </div>
                `;
                $('#selectedAttributes').append(attributeGroup);
                // Initialize Select2
                $('.js-example-basic-multiple').select2({
                    placeholder: "Chọn giá trị...",
                    allowClear: true
                });
            }

            $(document).on('click', '.remove-attribute', function() {
                const attributeToRemove = $(this).closest('.attribute-input-group').find('input').val();
                selectedAttributes.splice(selectedAttributes.indexOf(attributeToRemove),
                    1); // Xóa thuộc tính khỏi mảng đã chọn
                $(this).closest('.attribute-input-group').remove();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#searchInput').length) {
                    $('#result').empty();
                    $('#result').hide();
                }
            });
        });

        ///
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#saveAttributes', function() {
                const selectedAttributes = [];
                const selectedValuesByAttribute = {};
                $('.attribute-input-group').each(function() {
                    const attributeName = $(this).find('input').val();
                    const selectedOptions = $(this).find('.js-example-basic-multiple').val();

                    if (selectedOptions && selectedOptions.length > 0) {
                        selectedAttributes.push(attributeName);
                        selectedValuesByAttribute[attributeName] = selectedOptions;
                    }
                });
                const attributeCombinations = [];

                selectedAttributes.forEach(attribute => {
                    if (selectedValuesByAttribute[attribute]) {
                        selectedValuesByAttribute[attribute].forEach(value => {
                            attributeCombinations.push(`${attribute},${value}`);
                        });
                    }
                });

                console.log(attributeCombinations);
                const groupedValues = {};

                attributeCombinations.forEach(item => {
                    const [key, value] = item.split(',');
                    if (!groupedValues[key]) {
                        groupedValues[key] = [];
                    }
                    groupedValues[key].push(value);
                });
                const groupedArray = Object.keys(groupedValues).map(key => {
                    return {
                        key: key,
                        values: groupedValues[key]
                    };
                });
                console.log("Grouped Array:", groupedArray);

                const combinations = [];

                function generateCombinations(currentCombination, index) {
                    if (index === groupedArray.length) {
                        combinations.push({
                            ...currentCombination
                        });
                        return;
                    }

                    const {
                        key,
                        values
                    } = groupedArray[index];
                    for (const value of values) {
                        currentCombination[key] = value;
                        generateCombinations(currentCombination, index + 1);
                    }
                }

                generateCombinations({}, 0);

                console.log("Combinations:", combinations);
                $.ajax({
                    url: '/admin/save-attributes',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        attributes: combinations
                    }),
                    success: function(response) {
                        console.log(response.data);
                        alert('Lưu giá trị thành công');

                        // Assuming response.attributes contains the array of objects
                        const attributes = response.data;
                        console.log(attributes);

                        let htmlContent = '';

                        // Clear the existing content in the attributeList
                        $('#attributeList').empty();

                        if (attributes.length > 0) {
                            attributes.forEach((attribute, index) => {
                                let attributeString = '';
                                let attributeValueString = '';

                                // Construct attribute strings
                                for (const [key, item] of Object.entries(attribute)) {
                                    attributeString += `${key}: ${item}<br>`;
                                    attributeValueString += `${item},`;
                                }

                                // Remove trailing comma
                                attributeValueString = attributeValueString.slice(0, -
                                    1);

                                // Build the HTML for the row
                                htmlContent += `
                                <tr>
                                    <td>
                                        <input type="hidden" name="product_variants[${index + 1}][attributes_values]" value="${attributeValueString}" class="product_variants">
                                        ${attributeString}
                                    </td>
                                    <td>
                                        <input type="number" name="product_variants[${index + 1}][original_price]" class="form-control original_price" id="original_price_${index + 1}" />
                                    </td>
                                    <td>
                                        <input type="number" name="product_variants[${index + 1}][price_modifier]" class="form-control price_modifier" id="price_modifier_${index + 1}" />
                                    </td>
                                    <td>
                                        <input type="number" name="product_variants[${index + 1}][stock]" class="form-control stock" min="0"/>
                                    </td>
                                    <td>
                                        <select class="form-control status_attribute" name="product_variants[${index + 1}][status]">
                                            <option value="none">None</option>
                                            <option value="available">Available</option>
                                            <option value="out_of_stock">Out of Stock</option>
                                            <option value="discontinued">Discontinued</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="product_variants[${index + 1}][variant_image]" />
                                    </td>
                                    <td>
                                        <i class="ri-delete-bin-5-fill remove-attribute-values"></i>
                                    </td>
                                </tr>
                            `;
                            });
                        } else {
                            htmlContent = `
                            <tr>
                                <td colspan="7" class="text-center">Không có thuộc tính sản phẩm nào trong session.</td>
                            </tr>
                        `;
                        }

                        // Append the constructed HTML to the attributeList
                        $('#attributeList').append(htmlContent);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Lỗi khi lưu giá trị:', textStatus, errorThrown);
                        alert('Có lỗi xảy ra khi lưu giá trị.');
                    }
                });
            });
        });
        //////
        $(document).on('click', '.remove-attribute-values', function() {
            $(this).closest('tr').remove();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $.getJSON('/storage/tags.json')
                .done(function(data) {
                    console.log('Fetched tags data:', data);

                    const selectElement = document.getElementById('choices-multiple-remove-button');
                    data.forEach(function(tag) {
                        const option = document.createElement('option');
                        option.value = tag.id;
                        option.textContent = tag.name;
                        selectElement.appendChild(option);
                    });
                    const multipleCancelButton = new Choices(selectElement, {
                        removeItemButton: true,
                    });
                    console.log('Choices initialized with options:', selectElement.options);
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.error('Error loading tags JSON file:', textStatus, error);
                    console.error('Response:', jqxhr.responseText);
                });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        $(function() {
            // Initialize sortable for nested lists
            $('.nested-sortable').sortable({
                items: '> .list-group-item',
                connectWith: '.nested-sortable',
                placeholder: 'ui-state-highlight',
                update: function(event, ui) {

                    const movedItemId = ui.item.data('id');
                    const parentId = ui.item.parent().closest('.list-group-item').data(
                        'id'); // Get the new parent ID

                    if (parentId) {
                        updateParentId(movedItemId, parentId);
                    } else {
                        updateParentId(movedItemId, null);
                    }
                }
            }).disableSelection();

            const checkboxes = document.querySelectorAll('.category-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach(cb => {
                            if (cb !== this) {
                                cb.checked = false;
                            }
                        });
                        console.log(checkbox);
                    }
                });
            });
        });

        function updateParentId(itemId, parentId) {
            $.ajax({
                url: '/admin/categories/update-category-parent',
                method: 'POST',
                data: {
                    id: itemId,
                    parent_id: parentId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Parent ID updated successfully:', response);
                },
                error: function(xhr) {
                    console.error('Error updating parent ID:', xhr);
                }
            });
        }
    </script>
    <script>
        Dropzone.options.uploadForm = {
            paramName: "product_galaries[][image_gallery]", // Name of the file input
            maxFilesize: 2, // Maximum file size
            addRemoveLinks: true,
            autoProcessQueue: false, // Prevent automatic submission
            init: function() {
                const myDropzone = this;
                document.querySelector("#uploadButton").onclick = function(event) {
                    event.preventDefault();

                    // Nếu có tệp tin được tải lên
                    if (myDropzone.getAcceptedFiles().length > 0) {
                        const dataTransfer = new DataTransfer();

                        // Thêm tệp tin đã tải lên vào DataTransfer
                        myDropzone.files.forEach(function(file, index) {
                            const checkbox = document.querySelector(
                                `input[name="product_galaries[][is_main]"][data-index="${index}"]`);
                            const isMainValue = checkbox ? (checkbox.checked ? '1' : '0') : '0';

                            const newFile = new File([file], file.name, {
                                type: file.type
                            });
                            dataTransfer.items.add(newFile);

                            // Thêm giá trị của checkbox vào một hidden input
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name =
                                `product_galaries[${index}][is_main]`; // Cấu trúc lại tên để tương ứng
                            hiddenInput.value = isMainValue;
                            document.getElementById('uploadForm').appendChild(hiddenInput);
                        });

                        document.getElementById('product_galaries').files = dataTransfer.files;
                    }
                    document.getElementById('uploadForm').submit();
                };

                this.on("success", function(file, response) {
                    const imgElement = document.createElement('img');
                    imgElement.src = response.imageUrl; // URL của hình ảnh đã tải lên
                    document.getElementById('imagePreview').appendChild(imgElement);
                });

                this.on("addedfile", function(file) {
                    const index = this.files.length - 1;
                    const listItem = document.createElement('li');
                    listItem.className = "mt-2";
                    listItem.innerHTML = `
                        <div class="border rounded">
                            <div class="d-flex p-2">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-light rounded">
                                        <img data-dz-thumbnail class="img-fluid rounded d-block"
                                            src="${URL.createObjectURL(file)}" alt="Uploaded Image" style="max-width: 50px; max-height: 50px;" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="pt-1">
                                        <h5 class="fs-14 mb-1" data-dz-name>${file.name}</h5>
                                        <p class="fs-13 text-muted mb-0" data-dz-size>${file.size} bytes</p>
                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-switch form-switch-custom form-switch-success me-2">
                                        <input class="form-check-input is-main-checkbox" type="checkbox" role="switch" name="product_galaries[][is_main]" value="1" data-index="${index}" onchange="initializeCheckboxes(this)">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-file">Delete</button>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('dropzone-preview').appendChild(listItem);
                    listItem.querySelector('.remove-file').onclick = function() {
                        myDropzone.removeFile(file);
                        listItem.remove();
                    };
                    console.log(file);
                });
            }
        };

        function initializeCheckboxes(checkbox) {
            const checkboxes = document.querySelectorAll(
                '.is-main-checkbox');

            checkboxes.forEach((item) => {
                if (item === checkbox) {
                    item.checked = true;
                    item.value = 1;
                } else {
                    item.checked = false;
                    item.value = 0;
                }
            });
        }
    </script>
    <script>
        const couponData = []; // Mảng này sẽ chứa dữ liệu từ coupons.json
        const selectedCoupons = []; // Mảng để lưu trữ các mã giảm giá đã chọn

        // Tải dữ liệu mã giảm giá từ JSON
        document.addEventListener('DOMContentLoaded', function() {
            $.getJSON('/storage/coupons.json')
                .done(function(data) {
                    couponData.push(...data); // Lưu dữ liệu vào mảng couponData
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.error('Error loading coupons JSON file:', textStatus, error);
                });
        });

        // Hàm tìm kiếm và hiển thị danh sách mã giảm giá
        function searchCoupons() {
            const input = document.getElementById('searchCoupon').value.toLowerCase();
            const couponList = document.getElementById('couponList');

            // Xóa danh sách hiện tại
            couponList.innerHTML = '';

            // Nếu không có input, ẩn danh sách
            if (!input) {
                couponList.style.display = 'none';
                return;
            }

            // Lọc mã giảm giá theo code hoặc mô tả
            const filteredCoupons = couponData.filter(coupon =>
                coupon.code.toLowerCase().includes(input)
            );

            // Hiển thị các mã giảm giá phù hợp
            filteredCoupons.forEach(coupon => {
                const div = document.createElement('div');
                div.textContent = `${coupon.code} - ${coupon.description}`;

                // Thêm sự kiện onclick để xử lý việc chọn mã giảm giá
                div.onclick = function() {
                    // Kiểm tra xem mã giảm giá đã được chọn hay chưa
                    const isSelected = selectedCoupons.some(selected => selected.id === coupon.id);

                    if (!isSelected) {
                        // Nếu chưa chọn, thêm mã giảm giá vào danh sách đã chọn
                        selectedCoupons.push(coupon);
                    } else {
                        // Nếu đã chọn, loại bỏ mã giảm giá khỏi danh sách
                        const index = selectedCoupons.indexOf(coupon);
                        selectedCoupons.splice(index, 1);
                    }

                    // Cập nhật nội dung của #addCoupone
                    updateCouponInfo();
                    // Gán giá trị vào input tìm kiếm
                    document.getElementById('searchCoupon').value = '';
                    couponList.style.display = 'none'; // Ẩn danh sách sau khi chọn
                };

                couponList.appendChild(div);
            });

            // Hiện danh sách nếu có kết quả
            couponList.style.display = filteredCoupons.length ? 'block' : 'none';
        }

        // Hàm cập nhật thông tin mã giảm giá đã chọn
        function updateCouponInfo() {
            const addCouponElement = document.getElementById('addCoupone');
            addCouponElement.innerHTML = ''; // Xóa hết dữ liệu hiện có

            selectedCoupons.forEach(coupon => {
                const couponInfo = `
             <div class="coupon-item mb-3">
                <p><strong>Mã:</strong> ${coupon.code}</p>
                <p><strong>Mô tả:</strong> ${coupon.description}</p>
                <p><strong>Giá trị giảm giá:</strong> ${coupon.discount_value}</p>
                <p><strong>Giảm giá tối đa:</strong> ${coupon.max_discount_amount}</p>
                <p><strong>Giá trị đơn hàng tối thiểu:</strong> ${coupon.min_order_value}</p>
                <p><strong>Ngày bắt đầu:</strong> ${coupon.start_date}</p>
                <p><strong>Ngày kết thúc:</strong> ${coupon.end_date}</p>
                <p><strong>Giới hạn sử dụng:</strong> ${coupon.usage_limit !== null ? coupon.usage_limit > 0 : false}</p>
                <p><strong>Dùng chung với mã giảm giá khác:</strong> ${coupon.is_stackable ? 'Có' : 'Không'}</p>
                <p><strong>Giới hạn người dùng :</strong> ${coupon.user_limit !== null ? coupon.user_limit > 0 : false}</p>
                <p><strong>Số lần sử dụng:</strong> ${coupon.per_user_limit !== null ? coupon.per_user_limit > 0 : false}</p>
                
                <div class="coupon-actions">
                    <div class="form-check form-switch form-switch-${coupon.id}">
                        <input
                      class="form-check-input status-checkbox" type="checkbox" role="switch" name="coupon[][${coupon.code}]" value="${coupon.code}" id="couponCheckbox_${coupon.id}">
                    </div>
                    <a href="javascript:void(0);" onclick="removeCoupon(${coupon.id})" class="remove-icon">
                        <i class="ri-delete-bin-5-fill"></i>
                    </a>
                </div>
            </div>


        `;
                addCouponElement.innerHTML += couponInfo; // Thêm thông tin vào #addCoupone
            });
        }

        // Hàm để loại bỏ mã giảm giá đã chọn
        function removeCoupon(couponId) {
            const index = selectedCoupons.findIndex(coupon => coupon.id === couponId);
            if (index !== -1) {
                selectedCoupons.splice(index, 1); // Loại bỏ mã giảm giá
                updateCouponInfo(); // Cập nhật lại thông tin hiển thị
            }
        }
    </script>
    <script>
        document.getElementById("showFormCounpon").addEventListener("click", function() {
            const addCouponElement = document.getElementById('addCoupone');
            addCouponElement.innerHTML = ''; // Clear the element before adding a new form

            const form = `
                    <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="couponCode" class="form-label">Mã khuyến mãi:</label>
                    <input type="text" class="form-control" id="couponCode" placeholder="Nhập mã khuyến mãi" required value="{{ strtoupper(\Str::random(8)) }}" name="addcoupon[code]">
                    <input type="hidden" name="addcoupon[applies_to]" value="product">
                </div>

                <div class="col-sm-6">
                    <label for="discountType" class="form-label">Loại giảm giá:</label>
                    <select class="form-select" id="discountType" name="addcoupon[discount_type]" required>
                        <option value="percentage">Phần trăm (%)</option>
                        <option value="fixed_amount">Cố định (VND)</option>
                    </select>
                </div>
            </div>

            <!-- Giá trị giảm giá & Giảm tối đa -->
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Discount (%)</label>
                        <input type="number" class="form-control" id="addcoupon[discount_value]" name="addcoupon[discount_value]" placeholder="Nhập giá trị giảm giá" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="maxDiscount" class="form-label">Giảm tối đa:</label>
                    <input type="number" class="form-control" id="maxDiscount" name="addcoupon[max_discount_amount]" placeholder="Nhập số tiền giảm tối đa" required>
                </div>
            </div>

            <!-- Giá trị đơn hàng tối thiểu & Số lần sử dụng -->
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="minOrderValue" class="form-label">Giá trị đơn hàng tối thiểu:</label>
                    <input type="number" class="form-control" id="minOrderValue" name="addcoupon[min_order_value]" placeholder="Nhập giá trị đơn hàng tối thiểu" required> 
                </div>

                <div class="col-sm-6">
                    <label for="usageLimit" class="form-label">Giới hạn sử dụng:</label>
                    <input type="number" class="form-control" id="usageLimit" name="addcoupon[usage_limit]" placeholder="Nhập số lần sử dụng tối đa" required>
                </div>
            </div>

            <!-- Số lần tối đa mỗi người dùng có thể sử dụng mã -->
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="perUserLimit" class="form-label">Số lần tối đa mỗi người dùng có thể sử dụng mã:</label>
                    <input type="number" required class="form-control" id="perUserLimit" name="addcoupon[per_user_limit]" placeholder="Nhập số lần tối đa cho mỗi người dùng">
                </div>

                <div class="col-sm-6">
                    <label for="description" class="form-label">Mô tả mã giảm giá:</label>
                    <input class="form-control" required id="description" name="addcoupon[description]" placeholder="Nhập mô tả">
                </div>
            </div>

            <!-- Thời gian bắt đầu & Thời gian kết thúc -->
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="startDate" class="form-label">Ngày bắt đầu:</label>
                    <input type="datetime-local" class="form-control" id="startDate" name="addcoupon[start_date]" required>
                </div>

                <div class="col-sm-6">
                    <label for="endDate" class="form-label">Ngày kết thúc:</label>
                    <input type="datetime-local" class="form-control" id="endDate" name="addcoupon[end_date]" required>
                </div>
            </div>

            <!-- Trạng thái hoạt động -->
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label" for="is-stackable-input">Có thể dùng chung với mã khác?</label>
                    <div class="form-check form-switch form-switch-success">
                        <input type="hidden" name="addcoupon[is_stackable]" value="0">
                        <input class="form-check-input" type="checkbox" id="is-stackable-input" name="addcoupon[is_stackable]" value="1" {{ old('is_stackable') ? 'checked' : '' }} required>
                    </div>
                </div>

                <div class="col-sm-4 mb-3">
                    <label class="form-label" for="is-active-input">Trạng thái?</label>
                    <div class="form-check form-switch form-switch-success">
                        <input type="hidden" name="addcoupon[is_active]" value="0">
                        <input class="form-check-input" type="checkbox" id="is-active-input" name="addcoupon[is_active]" value="1" {{ old('is_active') ? 'checked' : '' }} required>
                    </div>
                </div>

                <div class="col-sm-4 mb-3">
                    <label class="form-label" for="eligible-users-only-input">Chỉ dành cho một số người dùng?</label>
                    <div class="form-check form-switch form-switch-success">
                        <input type="hidden" name="addcoupon[eligible_users_only]" value="0">
                        <input class="form-check-input" type="checkbox" id="eligible-users-only-input" name="addcoupon[eligible_users_only]" value="1" {{ old('eligible_users_only') ? 'checked' : '' }} required>
                    </div>
                </div>
            </div>
        `;
            addCouponElement.innerHTML = form;
        });
    </script>
@endsection
