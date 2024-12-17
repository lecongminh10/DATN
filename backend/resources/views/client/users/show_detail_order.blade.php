@extends('client.layouts.app')

    @section('style_css')

    <link rel="stylesheet" href="{{ asset('theme/assets/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

    <style>
        .order-container {
            background-color: #fff;
            padding: 0 50px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            color: #333;
            max-width: 1200px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .order-header h2 {
            font-size: 20px;
            font-weight: bold;
        }

        .order-status {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #e0f7e9;
            color: #28a745;
            text-transform: uppercase;
        }

        .order-info,
        .shipping-info {
            margin-bottom: 15px;
        }

        .order-info{
            margin-right: 10px; 
        }

        .order-info span,
        .shipping-info span {
            display: block;
            font-size: 14px;
            color: #555;
        }

        .order-details,
        .payment-method {
            margin-top: 20px;
        }

        .order-details table,
        .payment-method table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .order-details th,
        .order-details td,
        .payment-method th,
        .payment-method td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .total-row {
            font-weight: bold;
        }

        .diachi {
            justify-content: space-between;
            display: flex;
        }

        .table .thead {
            background-color: rgb(198, 223, 233);
            color: #000;
            font-weight: bold;
        }

        .btn-cancel-order {
            background-color: #dc3545;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 20px;
        }

        .btn-cancel-order:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .btn-cancel-order:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.5);
        }

        .btn-cancel-order {
            background-color: #f44336;
            color: white;
            border: none;
            margin-top: -20px;
            margin-bottom: 20px;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-cancel-order:hover {
            background-color: #d32f2f;
        }

        .order-container .btn-review {
            background-color: #ffc107;
            /* Màu nền vàng */
            color: white;
            /* Màu chữ trắng */
            font-size: 12px; /* Giảm font-size */
            font-weight: bold;
            padding: 5px 10px; /* Giảm padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px; /* Giảm khoảng cách trên */
        }

        .order-container .btn-review:hover {
            background-color: #e0a800;
            /* Màu nền khi hover */
            transform: scale(1.05);
        }

        .order-container .btn-danger {
            background-color: #dc3545;
            /* Màu nền đỏ */
            color: white;
            /* Màu chữ trắng */
            font-size: 12px; /* Giảm font-size */
            font-weight: bold;
            padding: 5px 10px; /* Giảm padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px; /* Giảm khoảng cách trên */
        }

        .order-container .btn-danger:hover {
            background-color: #bb2d3b;
            /* Màu nền khi hover */
            transform: scale(1.05);
        }


        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-body {
            background-color: #ffffff;
            padding: 20px;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: bold;
        }

        .btn-close {
            background-color: transparent;
            border: none;
            font-size: 1.5rem;
            color: #6c757d;
        }

        .btn-close:hover {
            color: #dc3545;
        }

        .star-rating .star {
            cursor: pointer;
            color: #ccc;
            /* Màu mặc định khi không được chọn */
        }

        .star-rating .star.selected {
            color: #f39c12;
            /* Màu vàng khi được chọn */
        }

        .star-rating .star:hover,
        .star-rating .star:hover~.star {
            color: #ccc;
            /* Đặt màu mặc định khi hover */
        }
        .cke_notification {
            display: none;
        }
        /* .dropzone {
            border: 1px solid rgb(212 212 212 / 80%);
        }
        .dropzone .dz-preview.dz-image-preview {
            display: none;
        } */

        /* #preview-container img {
            object-fit: cover;
            border: 1px solid #ddd;
        } */
        /* Tùy chỉnh input file */
        .custom-file-upload label {
            cursor: pointer;
            padding: 10px 15px;
            display: inline-block;
            color: white;
            border-radius: 5px;
        }

        /* Ảnh xem trước */
        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        #preview-container .preview-item {
            position: relative;
            width: 100px;
            height: 100px;
        }

        #preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Nút xóa ảnh */
        #preview-container .remove-btn {
            position: absolute;
            top: 2px;
            right: 8px;
            background: transparent;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 18px;
            text-align: center;
            line-height: 20px;
            cursor: pointer;
        }


        .order-status {
            /* font-weight: bold; */
            /* color: #000; Mặc định */
        }

        .order-status.refund-pending {
            color: #ffc107; /* Màu vàng */
        }

        .order-status.refund-approved {
            color: #28a745; /* Màu xanh lá */
        }

        .order-status.refund-rejected {
            color: #dc3545; /* Màu đỏ */
        }
    </style>
@endsection

@section('content')
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
    <main class="main home mt-3">
        <div class="container mb-2">
            <div class="row mb-3 pb-3">
                <div class="col-lg-9">
                    <div class="container pl-5   pr-5 pb-3 order-container">
                        <div class="order-header pt-4">
                            <div>
                                <h2>Đơn hàng: {{ $orders->code }}</h2>
                                    @if (!$showButtons)
                                        <strong>Trạng thái : Hoàn trả</strong>
                                    @endif
                                <br>
                                    @if (!empty($messageStatus))
                                    <p class="mt-2"> <strong>Lí do :{{$messageStatus}}</strong></p>
                                    @endif
                                <p class="mt-2">Thời gian: {{ $dateTimeOrders->format('d M, Y h:i A') }}</p>
                            </div>
                            <div class="order-status {{ 'refund-' . Str::slug($refundStatus) }}">{{ $orderStatus }}</div>
                        </div>
                        @if ($orders->status === 'Chờ xác nhận')
                            <button type="button" class="btn btn-cancel-order" data-bs-toggle="modal"
                                data-bs-target="#cancelOrderModal">
                                Hủy đơn hàng
                            </button>
                        @endif

                        @if ($orders->status === 'Hoàn thành' && $showButtons)
                            <div class="d-flex mb-3">
                                <button type="button" class="btn btn-review" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    Đánh giá sản phẩm
                                </button>
                                <button type="button" class="btn btn-danger ms-auto" data-bs-toggle="modal" data-bs-target="#refundModal">
                                    Yêu cầu trả hàng/Hoàn tiền
                                </button>
                            </div>
                        @endif


                        <div class="diachi">
                            <div class="order-info">
                                <h5>Địa chỉ giao hàng</h5>
                                <p class="fw-large" id="billing-name">{{ config('app.name') }}</p>
                                <span>Trường CĐ FPT PolyTechnic, Đường Trịnh Văn Bô, Bắc Từ Liêm, Hà Nội</span>
                                <span>Điện thoại: 0392853609</span>
                            </div>

                            <div class="shipping-info">
                                <h5>Địa chỉ nhận hàng</h5>
                                <p class="fw-large" id="shipping-name">{{ Auth::user()->username }}</p>
                                <p class="text-muted mb-1" id="shipping-address-line-1">
                                    {{ $address->specific_address }},{{ $address->ward }},{{ $address->district }},{{ $address->city }}
                                </p>
                                <p class="text-muted mb-1">Điện thoại:{{ Auth::user()->phone_number }}</p>
                            </div>
                        </div>

                        <div class="order-details">
                            <h5>Sản phẩm</h5>
                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="thead">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col" class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="products-list">
                                    @foreach ($orders->items as $key => $value)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td class="text-start">
                                                <span class="fw-medium">{{ $value->product->name }}</span>
                                                @php
                                                    $variant = $value->productVariant;
                                                @endphp
                                                @if ($variant)
                                                    <!-- Check if $variant is not null -->
                                                    @php
                                                        $attributes = $variant->attributeValues;
                                                    @endphp
                                                    @if ($attributes->isNotEmpty())
                                                        @foreach ($attributes as $attribute)
                                                            <p class="text-muted mb-0 "
                                                                style="font-size: 12px; padding-left: 10px;">
                                                                {{ $attribute->attribute->attribute_name }}:
                                                                {{ $attribute->attribute_value }} @if (!$loop->last)
                                                                @endif
                                                            </p>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted mb-0">No attributes available</p>
                                                    @endif
                                                @else
                                                    <p class="text-muted mb-0">No variant available</p>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $img = '';
                                                    $variant = $value->productVariant;
                                                    if (!empty($variant)) {
                                                        $img = $value->productVariant->variant_image;
                                                    } else {
                                                        $img = $value->product->getMainImage()->image_gallery;
                                                    }
                                                @endphp
                                                <img src="{{ Storage::url($img) }}" alt="Ảnh sản phẩm" width="100px"
                                                    height="100px">
                                            </td>
                                            @if ($variant)
                                                @php

                                                    $price = !empty($variant->price_modifier)
                                                        ? $variant->price_modifier
                                                        : $variant->original_price;
                                                @endphp
                                                <td>{{ number_format($price, 0, ',', '.') }} đ</td>
                                            @else
                                                @php
                                                    $price = !empty($value->product->price_sale)
                                                        ? $value->product->price_sale
                                                        : $value->product->price_regular;
                                                @endphp
                                                <td>{{ number_format($price, 0, ',', '.') }} đ</td>
                                            @endif
                                            <td>{{ $value->quantity }}</td>
                                            <td class="text-end">
                                                {{ number_format($price * $value->quantity, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="payment-method mb-5">
                            <h5>Phương thức thanh toán</h5>
                            <table>
                                @foreach ($payments as $key => $value)
                                    <tr>
                                        <td>Loại thanh toán:</td>
                                        <td>
                                            @if ($value->gateway_name == 'cash')
                                                Thanh toán tiền mặt
                                            @else
                                                {{ $value->gateway_name }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Giá:</td>
                                        <td>{{ number_format($orders->total_price, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelOrderModalLabel">Xác nhận hủy đơn hàng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn chắc chắn muốn hủy đơn hàng này?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <form action="{{ route('users.cancel', $orders->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form action="{{ route('users.submitReview', $orders->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Đánh giá sản phẩm:</label>
                                            <div class="star-rating" style="font-size: 24px;">
                                                <input type="hidden" name="rating" id="rating" required>
                                                <span class="star" data-value="1">&#9733;</span>
                                                <span class="star" data-value="2">&#9733;</span>
                                                <span class="star" data-value="3">&#9733;</span>
                                                <span class="star" data-value="4">&#9733;</span>
                                                <span class="star" data-value="5">&#9733;</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Bình luận:</label>
                                            <textarea name="review_text" id="comment" class="form-control" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Hoàn trả Modal --}}
                    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="refundModalLabel">Yêu cầu trả hàng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('refunds.store') }}" method="POST" id="uploadForm" class="dropzone" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="order_code" class="form-label">Mã đơn hàng</label>
                                            <input type="text" class="form-control" id="order_code" name="order_code" value="{{ $orders->code }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="refund_method" class="form-label">Phương thức hoàn trả</label>
                                            <select class="form-control" id="refund_method" name="refund_method" required>
                                                <option value="cash">Tiền mặt</option>
                                                <option value="payment">Chuyển khoản</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reason" class="form-label">Lý do hoàn trả</label>
                                            <textarea class="form-control" id="editor-container" name="reason" required role="20" cols="10"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Ảnh minh chứng</label>
                                            <div class="custom-file-upload">
                                                <input type="file" class="form-control d-none" name="image[]" id="image" multiple>
                                                <label for="image" class="btn btn-primary">Chọn ảnh</label>
                                            </div>
                                            <div id="preview-container" class="row mt-3"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button id="uploadButton" type="submit" class="btn btn-danger">Gửi yêu cầu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('client.users.left_menu')
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.star-rating .star').forEach(function(star) {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                document.getElementById('rating').value = value;

                document.querySelectorAll('.star-rating .star').forEach(function(s) {
                    s.classList.remove('selected');
                });

                this.classList.add('selected');
                let previousSibling = this.previousElementSibling;
                while (previousSibling) {
                    previousSibling.classList.add('selected');
                    previousSibling = previousSibling.previousElementSibling;
                }
            });
        });
        
    </script>
     
@endsection

@section('script_libray')

@endsection

@section('scripte_logic')
<script>
document.getElementById('image').addEventListener('change', function (event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = ''; 

    Array.from(files).forEach((file, index) => {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = (e) => {
                const previewItem = document.createElement('div');
                previewItem.classList.add('preview-item');

                const img = document.createElement('img');
                img.src = e.target.result;

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.innerHTML = '×';
                removeBtn.addEventListener('click', () => {
                    previewItem.remove(); // Xóa ảnh khỏi giao diện
                });

                previewItem.appendChild(img);
                previewItem.appendChild(removeBtn);
                previewContainer.appendChild(previewItem);
            };

            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
