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
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    @include('admin.layouts.component.page-header', [
                        'title' => 'Sản phẩm ',
                        'breadcrumb' => [
                            ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                            ['name' => 'Sản phẩm', 'url' => '#']
                        ]
                    ])
                    <form action="{{ route('admin.products.updatePutProduct',$product->id) }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm" class="dropzone">
                        @csrf
                        @method('PUT')
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
                                                        name="name" id="name"
                                                        value="{{ old('name', $product->name) }}">

                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="description" class="form-label">Mô tả ngắn</label>
                                                    <textarea class="form-control" name="short_description" id="short_description"
                                                        value="{{ old('short_description', $product->short_description) }}">{{$product->short_description}}</textarea>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="meta_title" class="form-label">SEO tiêu đề</label>
                                                    <textarea class="form-control" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}">{{$product->meta_title}}</textarea>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="meta_description" class="form-label">SEO mô tả</label>
                                                    <textarea class="form-control" name="meta_description" id="meta_description"
                                                        value="{{ old('meta_description', $product->meta_description) }}">{{$product->meta_description}}</textarea>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mt-3">
                                                        <label for="code" class="form-label">Mã</label>
                                                        <input type="text"
                                                            class="form-control @error('code') is-invalid @enderror"
                                                            name="code" id="code"
                                                            value="{{ old(strtoupper(\Str::random(8)), $product->code) }}">
                                                        @error('code')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="stock" class="form-label">Số lượng tồn kho</label>
                                                        <input type="number"
                                                            class="form-control @error('stock') is-invalid @enderror"
                                                            name="stock" id="stock"
                                                            value="{{ old('stock', $product->stock) }}" onchange="getPrices()">
                                                        @error('stock')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="price_regular" class="form-label">Giá gốc</label>
                                                        <input type="number"
                                                            class="form-control @error('price_regular') is-invalid @enderror"
                                                            name="price_regular" id="price_regular"
                                                            value="{{ old('price_regular', $product->price_regular) }}" onchange="getPrices()">
                                                        @error('price_regular')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="price_sale" class="form-label">Giá khuyến mãi</label>
                                                        <input type="number"
                                                            class="form-control @error('price_sale') is-invalid @enderror"
                                                            name="price_sale" id="price_sale"
                                                            value="{{ old('price_sale', $product->price_sale) }}" onchange="getPrices()">
                                                        @error('price_sale')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="product_tags"
                                                            class="form-label text-muted">Thẻ</label>
                                                        <select class="form-control" name="product_tags[]"
                                                            id="choices-multiple-remove-button"
                                                            placeholder="This is a placeholder" multiple>
                                                        </select>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="price_sale" class="form-label">Thời gian bảo hành
                                                        </label>
                                                        <input type="number" class="form-control" name="warranty_period"
                                                            id="warranty_period" value="{{$product->warranty_period}}">
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
                                                            <h4 class="card-title mb-0 flex-grow-1">Trạng thái</h4>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach ($status as $key => $statu)
                                                                        <div class="col-md-2">
                                                                            <div
                                                                                class="form-check form-switch form-switch-{{ $statu }}">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" role="switch"
                                                                                    name="{{ $key }}"
                                                                                    value="1"
                                                                                    id="{{ $key }}"
                                                                                    @if (isset($product->$key) && $product->$key == 1) checked @endif>
                                                                                <!-- Check if the product status is 1 -->
                                                                                <label class="form-check-label"
                                                                                    for="{{ $key }}">
                                                                                    {{ ucwords(str_replace('_', ' ', str_replace('is_', '', $key))) }}
                                                                                </label>
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
                                                            <div class="list-group col nested-list nested-sortable"
                                                                id="nested-sortable">
                                                                @foreach ($categories as $category)
                                                                    @include(
                                                                        'admin.categories.partials.category',
                                                                        ['category' => $category]
                                                                    )
                                                                @endforeach
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
                                        <textarea name="content" id="editor-container" style="height: 300px;">{{ $product->content }}</textarea>
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
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                                                    <div class="tab-pane fade show active" id="v-pills-home"
                                                        role="tabpanel" aria-labelledby="attribute_value">
                                                        <div id="saveAttributes" class="btn btn-primary  float-start">Lưu Giá Trị
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
                                                                        <th>Thuộc tính</th>
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
                                                                </tbody>
                                                            </table>

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
                                                @foreach ($product->galleries as $item)
                                                    <li class="mt-2">
                                                        <div class="border rounded">
                                                            <div class="d-flex p-2">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar-sm bg-light rounded">
                                                                        <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                                            src="{{Storage::url($item->image_gallery)}}" alt="Uploaded Image" style="max-width: 50px; max-height: 50px;" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="pt-1">
                                                                        <h5 class="fs-14 mb-1" data-dz-name>{{ basename($item->image_gallery)}}</h5>
                                                                        <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="form-check form-switch form-switch-custom form-switch-success me-2">
                                                                        <input class="form-check-input is-main-checkbox" type="checkbox" role="switch" name="product_galaries[{{ basename($item->image_gallery)}}][is_main]" value="1" data-index="${index}" onchange="initializeCheckboxes(this)" 
                                                                            @checked($item->is_main)
                                                                        >
                                                                        <input type="hidden"  name="product_galaries[{{ basename($item->image_gallery)}}][id]" value="{{$item->id}}">
                                                                        <input type="hidden"  name="product_galaries[{{ basename($item->image_gallery)}}][image_gallery]" value="{{$item->image_gallery}}">
                                                                    </div>
                                                                    <button type="button" class="btn btn-sm btn-danger remove-file" id="DeleteGalary">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
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
                                        <button class="btn btn-primary" type="submit" id="uploadButton">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewImageModalLabel">Variant Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="variantImage" src="" alt="Variant Image" class="img-fluid" style="max-width:250px; max-height:250px" />
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
    <script>
        $('#applyPrice').on('click', function() {
            var priceRegularValue = document.getElementById('price_regular').value;
            var priceSaleValue = document.getElementById('price_sale').value;
            var stockValue = document.getElementById('stock').value;
            var regularPriceNumber = parseFloat(priceRegularValue);
            var salePriceNumber = parseFloat(priceSaleValue);

            var originalPriceInteger = Math.floor(regularPriceNumber); 
            var salePriceInteger = Math.floor(salePriceNumber); 

            document.getElementById("originalPrice").value = originalPriceInteger; 
            document.getElementById("salePrice").value = salePriceInteger;
            document.getElementById("stockPrice").value= stockValue
            
            $('#applyPriceModal').modal('show');
        });

        document.getElementById("applyPrices").addEventListener("click", function() {
        
            var priceRegularValue = document.getElementById("originalPrice").value;
            var priceSaleValue = document.getElementById("salePrice").value;
            var stockPrice = document.getElementById('stockPrice').value;
            var stockStatus = document.getElementById("stockStatus") ? document.getElementById("stockStatus").value : ''; 

            const original_prices = document.querySelectorAll('.original_price');
            original_prices.forEach(function(original_price) {
                original_price.value = priceRegularValue;
            });
            
            const price_modifiers = document.querySelectorAll('.price_modifier');
            price_modifiers.forEach(function(price_modifier) {
                price_modifier.value = priceSaleValue;
            });
            
            const stocks = document.querySelectorAll('.stock');
            stocks.forEach(function(stock) {
                stock.value = stockPrice;
            });
            
            const status_attributes = document.querySelectorAll('.status_attribute');
            status_attributes.forEach(function(status_attribute) {
                status_attribute.value = stockStatus;
            });

            $('#applyPriceModal').modal('hide');
        });

    </script>
    <script>
        CKEDITOR.replace('editor-container');
    </script>
    <script>
           // Log the variants data to the console and print them to the #attributeList table
           var variant = @json($variants);
                const variantAttributeID=[];
                // First, print the variants to the screen in the attributeList table
                variant.forEach((variantData) => {
                    variantAttributeID.push(variantData.product_attribute_id);
                    
                    $('#attributeList').append(`
                        <tr class="variant-row"> <!-- Add class to identify variant rows -->
                            <input type="hidden" name="product_variants[${variantData.id}][id]" value="${variantData.id}" class="product_variants">
                            <input type="hidden" name="product_variants[${variantData.id}][product_attribute_id]" value="${variantData.product_attribute_id}" class="product_variants">
                            <input type="hidden" name="product_variants[${variantData.id}][variant_image]" value="${variantData.variant_image}" class="product_variants">
                            <input type="hidden" name="product_variants[${variantData.id}][sku]" value="${variantData.sku}" class="product_variants">  
                            <td>${variantData.attribute_name}</td>
                            <td>${variantData.attribute_value}</td>
                            <td>
                                <input type="number" name="product_variants[${variantData.id}][original_price]" class="form-control original_price" id="original_price_${variantData.id}" value="${variantData.original_price}" />
                            </td>
                            <td>
                                <input type="number" name="product_variants[${variantData.id}][price_modifier]" class="form-control price_modifier" id="price_modifier_${variantData.id}" value="${variantData.price_modifier}" />
                            </td>
                            <td>
                                <input type="number" name="product_variants[${variantData.id}][stock]" class="form-control stock" min="0" value="${variantData.stock}" />
                            </td>
                            <td>
                                <select class="form-control status_attribute" name="product_variants[${variantData.id}][status]">
                                    <option value="none">None</option>
                                    <option value="available" ${variantData.status === 'available' ? 'selected' : ''}>Available</option>
                                    <option value="out_of_stock" ${variantData.status === 'out_of_stock' ? 'selected' : ''}>Out of Stock</option>
                                    <option value="discontinued" ${variantData.status === 'discontinued' ? 'selected' : ''}>Discontinued</option>
                                </select>
                            </td>
                            <td>
                                <input type="file" class="form-control" name="product_variants[${variantData.id}][variant_image]" />
                            </td>
                            <td class="d-inline-flex align-items-center">
                              <i class="ri-eye-fill view-attribute-values me-2" title="View" data-bs-toggle="modal" data-bs-target="#viewImageModal" data-image-url="${variantData.variant_image}" >
                                </i> <!-- View Icon -->

                                <i class="ri-delete-bin-5-fill remove-attribute-values" title="Delete"></i> <!-- Delete Icon -->
                            </td>

                        </tr>
                            `);
                });
                $(document).ready(function() {
                    // Event listener for the view icon
                    $('.view-attribute-values').on('click', function() {
                        // Get the image URL from the data attribute
                        var imageUrl = $(this).data('image-url');
                        var fullImageUrl = '/storage/' + imageUrl;
                        // Set the image source in the modal
                        $('#variantImage').attr('src', fullImageUrl);
                    });
                });


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
                        // Assume initially that the value should be shown
                        let showOption = true;

                        // Loop through each attributeID to check if the value.id matches any attributeID
                        variantAttributeID.forEach((attributeID) => {
                            if (value.id === attributeID) {
                                showOption = false; // If a match is found, don't show the option
                            }
                        });

                        // If no match was found, show the option
                        if (showOption) {
                            optionsHTML += `<option value="${value.attribute_value}">${value.attribute_value}</option>`;
                        }
                    });
                }                   
                const attributeGroup = `
                    <div class="attribute-input-group row mb-2">
                        <input type="text" class="form-control col-lg-5" value="${attribute}" readonly>
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

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#saveAttributes', function() {
                const selectedValues = [];

                $('.js-example-basic-multiple').each(function() {
                    const selectedOptions = $(this).val();
                    if (selectedOptions) {
                        selectedValues.push(...selectedOptions);
                    }
                });
                $.ajax({
                    url: '/admin/save-attributes',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        attributes: selectedValues 
                    }),
                    success: function(response) {
                        $('#attributeModal').modal('show');
                        $('#attributeList tr').not('.variant-row')
                    .remove(); 
                        response.attributes.forEach((attribute) => {
                            $('#attributeList').append(`
                            <tr>
                                <input type="hidden" name="product_variants[${attribute.id}][product_attribute_id]" value="${attribute.id}" class="product_variants">
                                <td>${attribute.name}</td>
                                <td>${attribute.value}</td>
                                <td>
                                    <input type="number" name="product_variants[${attribute.id}][original_price]" class="form-control original_price" id="original_price_${attribute.id}" />
                                </td>
                                <td>
                                    <input type="number" name="product_variants[${attribute.id}][price_modifier]" class="form-control price_modifier" id="price_modifier_${attribute.id}" />
                                </td>
                                <td>
                                    <input type="number" name="product_variants[${attribute.id}][stock]" class="form-control stock" min="0" />
                                </td>
                                <td>
                                    <select class="form-control status_attribute" name="product_variants[${attribute.id}][status]">
                                        <option value="none">None</option>
                                        <option value="available" ${attribute.status === 'available' ? 'selected' : ''}>Available</option>
                                        <option value="out_of_stock" ${attribute.status === 'out_of_stock' ? 'selected' : ''}>Out of Stock</option>
                                        <option value="discontinued" ${attribute.status === 'discontinued' ? 'selected' : ''}>Discontinued</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="product_variants[${attribute.id}][variant_image]" />
                                </td>
                                <td>
                                    <i class="ri-delete-bin-5-fill remove-attribute-values"></i>
                                </td>
                            </tr>
                        `);
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error saving values:', textStatus, errorThrown);
                        alert('An error occurred while saving the values.');
                    }
                });

            });
        });
        $(document).on('click', '.remove-attribute-values', function() {
            $(this).closest('tr').remove();
        });
    </script>
    <script>
        var selectedTags = @json($selectedTags);

        document.addEventListener('DOMContentLoaded', function() {
            $.getJSON('/storage/tags.json')
                .done(function(data) {
                    console.log('Fetched tags data:', data);

                    const selectElement = document.getElementById('choices-multiple-remove-button');
                    data.forEach(function(tag) {
                        const option = document.createElement('option');
                        option.value = tag.id;
                        option.textContent = tag.name;

                        // Check if the tag ID is in the selectedTags array
                        if (selectedTags.includes(tag.id)) {
                            option.selected = true; // Mark the option as selected
                        }

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
            paramName: "product_galaries[][image_gallery]", 
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

                        // Đặt files cho input ẩn
                        document.getElementById('product_galaries').files = dataTransfer.files;
                    }

                    // Gửi form
                    document.getElementById('uploadForm').submit();
                };

                // Xử lý khi upload thành công
                this.on("success", function(file, response) {
                    const imgElement = document.createElement('img');
                    imgElement.src = response.imageUrl; // URL của hình ảnh đã tải lên
                    document.getElementById('imagePreview').appendChild(imgElement);
                });

                // Sự kiện khi một tệp tin được thêm vào
                this.on("addedfile", function(file) {
                    const index = this.files.length - 1; // Được chỉ số tệp tin hiện tại
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

                    // Xử lý nút xóa
                    listItem.querySelector('.remove-file').onclick = function() {
                        myDropzone.removeFile(file); // Xóa tệp từ Dropzone
                        listItem.remove(); // Xóa phần xem trước
                    };
                });
            }
        };

        function initializeCheckboxes(checkbox) {
            const checkboxes = document.querySelectorAll(
                '.is-main-checkbox'); // Lấy tất cả checkbox có class 'is-main-checkbox'

            checkboxes.forEach((item) => {
                if (item === checkbox) {
                    // Nếu checkbox hiện tại được checked, đặt value là 1, nếu không thì 0
                    item.checked = true;
                    item.value = 1;
                } else {
                    // Bỏ checked ở các checkbox khác và đặt value của chúng về 0
                    item.checked = false;
                    item.value = 0;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Handle delete button click
            $('.remove-file').on('click', function() {
                // Find the parent <li> element and remove it
                $(this).closest('li').remove();
            });
        });
    </script>
@endsection
