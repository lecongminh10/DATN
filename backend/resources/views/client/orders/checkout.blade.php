@extends('client.layouts.app')

@section('style_css')
    <style>
        .checkout-steps {
            margin-top: -39px;
        }

        /* Địa chỉ nhận hàng */
        .name-phone {
            margin-right: 10px;
        }

        .name {
            /* margin-right: -60px; */
            width: 100px;
        }

        .address {}

        .small-text {
            font-size: 10px;
            width: 75px;
            text-align: center;
            padding: 6px 6px;
            margin: 0 12px;
            border: 1px solid #2a78b0;
        }

        .small-link {
            font-size: 12px;
            text-align: center;
            margin-right: 6px;
            width: 60px;
        }

        /* Sản phẩm */
        .product-container {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .product-image {
            margin-right: 15px;
        }

        .img-thumbnail {
            width: 50px;
            height: 50px;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-price,
        .product-quantity,
        .product-total {
            text-align: center;
        }

        .text-end {
            text-align: center;
            width: 70px;
        }

        .product-quantity {
            width: 70px;
        }

        .text-muted {
            color: #6c757d;
        }

        .fw-bold {
            font-weight: bold;
        }

        .namePro {
            width: 190px;
        }

        /* Modal */
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 1rem);
        }

        #addAddressModal .modal-dialog {
            max-width: 625px;
        }

        #editAddressModal .modal-dialog {
            max-width: 625px;
        }


        .small-title {
            font-size: 10px;
            width: 75px;
            text-align: center;
            padding: 6px 6px;
            border: 1px solid #2a78b0;
        }

        .btn-close-address {
            font-size: 30px;
            font-weight: 100;
            color: #dcdcdc;
            cursor: pointer;
            border: none;
            background: transparent;
        }

        .btn-close-address:hover {
            color: #6c757d;
        }

        .btnAddAddress {
            border: 1px solid #dcdcdc;
            color: #6c757d;
            background-color: transparent;
            padding: 10px 10px;
            cursor: pointer;
            margin-left: 300px;
        }

        .btnAddAddress:hover {
            background: #f3f3f3c0;
        }

        .btnHuy {
            border: 1px solid #dcdcdc;
            color: #6c757d;
            width: 130px;
            background-color: transparent;
            padding: 10px 10px;
            cursor: pointer;
        }

        .btnHuy:hover {
            background: #f3f3f3c0;
        }

        .btnEdit {
            border: 1px solid #dcdcdc;
            color: white;
            width: 130px;
            background-color: #2a78b0;
            padding: 10px 10px;
            cursor: pointer;
        }

        .btnEdit:hover {
            background-color: #4689b9;
        }

        .btnAdd {
            border: 1px solid #dcdcdc;
            color: white;
            width: 130px;
            background-color: #2a78b0;
            padding: 10px 10px;
            cursor: pointer;
        }

        .btnAdd:hover {
            background-color: #4689b9;
        }

        .btnBack {
            border: 1px solid #dcdcdc;
            color: #6c757d;
            width: 130px;
            background-color: transparent;
            padding: 10px 10px;
            cursor: pointer;
        }

        .btnBack:hover {
            background: #f3f3f3c0;
        }

        .btnText {
            border: 1px solid #dcdcdc;
            color: #6c757d;
            width: 100px;
            background-color: transparent;
            padding: 5px 5px;
            margin-right: 10px;
            cursor: pointer;
        }

        .btnText:focus {
            border: 1px solid #2a78b0;
            color: #2a78b0;
        }

        .form-check-label {
            margin-left: 10px;
        }

        .form-control {
            max-height: 30px !important;
        }

        select.form-control {
            max-height: 30px !important;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
            /* Biểu tượng mũi tên */
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 26px;
            padding-right: 30px;
        }

        .add-address-button {
            font-size: 0.85rem;
            /* Smaller font size */
            padding: 6px 12px;
            /* Reduced padding for a compact look */
            font-weight: 500;
            /* Medium font weight for readability */
            border-radius: 5px;
            /* Slightly rounded corners */
            background-color: #007bff;
            /* Primary color */
            border: none;
            /* Remove default border */
            color: white;
            /* White text */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Subtle shadow for depth */
            transition: background-color 0.3s, transform 0.2s;
            /* Smooth transitions */
        }

        .add-address-button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            transform: translateY(-2px);
            /* Lift effect on hover */
        }

        .add-address-button:active {
            background-color: #004080;
            /* Darker shade on click */
            transform: translateY(0);
            /* Remove lift effect */
        }

        /* Address Item */
        .address-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        .address-checkbox {
            margin-right: 12px;
        }

        /* Address Label with Flex Alignment */
        .address-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .address-info {
            max-width: 80%;
            color: #333;
            font-weight: 500;
        }

        .address-text {
            white-space: normal;
            word-wrap: break-word;
        }

        .small-title {
            font-size: 0.85rem;
            color: #2a78b0;
            font-weight: bold;
            margin-left: 8px;
        }

        .edit-address-link {
            color: #007bff;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
            margin-left: 8px;
        }

        .no-address {
            color: #666;
            font-size: 0.9rem;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .modal-backdrop.show {
            opacity: 0.5;
            /* Điều chỉnh độ mờ lớp phủ tối */
            background-color: rgba(0, 0, 0, 0.5);
        }

        .namePro {
            margin: 7px;
            /* Set margin for the item */
            font-size: 15px;
        }

        .namePro .product-details {
            padding-left: 10px;
        }

        .namePro .attribute-item {
            font-size: 12px;
            margin-bottom: 5px !important;
        }

        .namePro .text-muted {
            font-size: 12px;
        }

        .namePro .attribute-item strong {
            color: rgba(0, 0, 0, 0.6);
            font-weight: 300;
            font-size: 12px;
        }

        .checkout-container textarea.form-control {
            min-height: 70px;
        }

        #discount-info {
            display: none;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #d9e2eb59;
            border: 1px solid #bde1f5
        }

        /* Cải thiện giao diện của phần thông tin giảm giá */
        .alert-info {
            box-shadow: inset 0px 0px 1px 0px #0088cc;
            background-color: #ffffff;
            border-color: #e0ebf0;
            color: #3d4143;
            padding: 5px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            padding: 5px;
        }

        .alert-info p {
            margin: 0;
            line-height: 1.6;
            padding: 5px;
        }

        .alert-info p strong {
            font-weight: bold;
            color: #3d4349;
        }

        .alert-info p span {
            font-size: 5px;
            color: #2980b9;
        }

        .alert-info p {
            margin-bottom: 5px;
        }
    </style>
@endsection


@section('content')

    @php
        Auth::check() ? Auth::user()->id : '';
    @endphp

    <header class="header home">
        <div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': true}">
            <div class="container">
                <nav class="main-nav w-100">
                    <ul class="menu">
                        <li>
                            <a href="demo4.html">Home</a>
                        </li>
                        <li>
                            <a href="category.html">Categories</a>
                            <div class="megamenu megamenu-fixed-width megamenu-3cols">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="#" class="nolink">VARIATION 1</a>
                                        <ul class="submenu">
                                            <li><a href="category.html">Fullwidth Banner</a></li>
                                            <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a>
                                            </li>
                                            <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a>
                                            </li>
                                            <li><a href="category.html">Left Sidebar</a></li>
                                            <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                                            <li><a href="category-off-canvas.html">Off Canvas Filter</a></li>
                                            <li><a href="category-horizontal-filter1.html">Horizontal Filter1</a>
                                            </li>
                                            <li><a href="category-horizontal-filter2.html">Horizontal Filter2</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                        <a href="#" class="nolink">VARIATION 2</a>
                                        <ul class="submenu">
                                            <li><a href="category-list.html">List Types</a></li>
                                            <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll</a>
                                            </li>
                                            <li><a href="category.html">3 Columns Products</a></li>
                                            <li><a href="category-4col.html">4 Columns Products</a></li>
                                            <li><a href="category-5col.html">5 Columns Products</a></li>
                                            <li><a href="category-6col.html">6 Columns Products</a></li>
                                            <li><a href="category-7col.html">7 Columns Products</a></li>
                                            <li><a href="category-8col.html">8 Columns Products</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4 p-0">
                                        <div class="menu-banner">
                                            <figure>
                                                <img src="assets/images/menu-banner.jpg" width="192" height="313"
                                                    alt="Menu banner">
                                            </figure>
                                            <div class="banner-content">
                                                <h4>
                                                    <span class="">UP TO</span><br />
                                                    <b class="">50%</b>
                                                    <i>OFF</i>
                                                </h4>
                                                <a href="category.html" class="btn btn-sm btn-dark">SHOP NOW</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .megamenu -->
                        </li>
                        <li>
                            <a href="product.html">Products</a>
                            <div class="megamenu megamenu-fixed-width">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="#" class="nolink">PRODUCT PAGES</a>
                                        <ul class="submenu">
                                            <li><a href="product.html">SIMPLE PRODUCT</a></li>
                                            <li><a href="product-variable.html">VARIABLE PRODUCT</a></li>
                                            <li><a href="product.html">SALE PRODUCT</a></li>
                                            <li><a href="product.html">FEATURED & ON SALE</a></li>
                                            <li><a href="product-custom-tab.html">WITH CUSTOM TAB</a></li>
                                            <li><a href="product-sidebar-left.html">WITH LEFT SIDEBAR</a></li>
                                            <li><a href="product-sidebar-right.html">WITH RIGHT SIDEBAR</a></li>
                                            <li><a href="product-addcart-sticky.html">ADD CART STICKY</a></li>
                                        </ul>
                                    </div><!-- End .col-lg-4 -->

                                    <div class="col-lg-4">
                                        <a href="#" class="nolink">PRODUCT LAYOUTS</a>
                                        <ul class="submenu">
                                            <li><a href="product-extended-layout.html">EXTENDED LAYOUT</a></li>
                                            <li><a href="product-grid-layout.html">GRID IMAGE</a></li>
                                            <li><a href="product-full-width.html">FULL WIDTH LAYOUT</a></li>
                                            <li><a href="product-sticky-info.html">STICKY INFO</a></li>
                                            <li><a href="product-sticky-both.html">LEFT & RIGHT STICKY</a></li>
                                            <li><a href="product-transparent-image.html">TRANSPARENT IMAGE</a></li>
                                            <li><a href="product-center-vertical.html">CENTER VERTICAL</a></li>
                                            <li><a href="#">BUILD YOUR OWN</a></li>
                                        </ul>
                                    </div><!-- End .col-lg-4 -->

                                    <div class="col-lg-4 p-0">
                                        <div class="menu-banner menu-banner-2">
                                            <figure>
                                                <img src="assets/images/menu-banner-1.jpg" width="182" height="317"
                                                    alt="Menu banner" class="product-promo">
                                            </figure>
                                            <i>OFF</i>
                                            <div class="banner-content">
                                                <h4>
                                                    <span class="">UP TO</span><br />
                                                    <b class="">50%</b>
                                                </h4>
                                            </div>
                                            <a href="category.html" class="btn btn-sm btn-dark">SHOP NOW</a>
                                        </div>
                                    </div><!-- End .col-lg-4 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu -->
                        </li>
                        <li class="">
                            <a href="#">Pages</a>
                            <ul>
                                <li><a href="wishlist.html">Wishlist</a></li>
                                <li><a href="cart.html">Shopping Cart</a></li>
                                <li><a href="checkout.html">Checkout</a></li>
                                <li><a href="dashboard.html">Dashboard</a></li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="#">Blog</a>
                                    <ul>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="single.html">Blog Post</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact Us</a></li>
                                <li><a href="login.html">Login</a></li>
                                <li><a href="forgot-password.html">Forgot Password</a></li>
                            </ul>
                        </li>
                        <li><a href="blog.html">Blog</a></li>
                        <li>
                            <a href="#">Elements</a>
                            <ul class="custom-scrollbar">
                                <li><a href="element-accordions.html">Accordion</a></li>
                                <li><a href="element-alerts.html">Alerts</a></li>
                                <li><a href="element-animations.html">Animations</a></li>
                                <li><a href="element-banners.html">Banners</a></li>
                                <li><a href="element-buttons.html">Buttons</a></li>
                                <li><a href="element-call-to-action.html">Call to Action</a></li>
                                <li><a href="element-countdown.html">Count Down</a></li>
                                <li><a href="element-counters.html">Counters</a></li>
                                <li><a href="element-headings.html">Headings</a></li>
                                <li><a href="element-icons.html">Icons</a></li>
                                <li><a href="element-info-box.html">Info box</a></li>
                                <li><a href="element-posts.html">Posts</a></li>
                                <li><a href="element-products.html">Products</a></li>
                                <li><a href="element-product-categories.html">Product Categories</a></li>
                                <li><a href="element-tabs.html">Tabs</a></li>
                                <li><a href="element-testimonial.html">Testimonials</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact Us</a></li>
                        <li class="float-right"><a href="https://1.envato.market/DdLk5" class="pl-5"
                                target="_blank">Buy Porto!</a></li>
                        <li class="float-right"><a href="#" class="pl-5">Special Offer!</a></li>
                    </ul>
                </nav>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header>

    <main class="main main-test">
        <div class="container checkout-container">
            <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li>
                    <a href="{{ route('shopping-cart') }}">Mua sắm</a>
                </li>
                <li class="active">
                    <a href="{{ route('checkout') }}">Thanh toán đơn hàng</a>
                </li>
                <li class="disabled">
                    <a href="#"></a>
                </li>
            </ul>

            <div class="checkout-discount">
                <h4>Mã giảm giá?
                    <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                        aria-controls="collapseTwo" class="btn btn-link btn-toggle">ENTER YOUR CODE</button>
                </h4>
                <div id="collapseTwo" class="collapse">
                    <div class="feature-box">
                        <div class="feature-box-content row">
                            <div class="col-6">
                                <p>Nếu bạn có mã giảm giá, hãy nhập mã vào ô bên dưới.</p>
                                <form id="couponForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm w-auto"
                                            placeholder="Nhập mã" required name="coupon_code" id="coupon_code" />
                                        <div class="input-group-append">
                                            <button class="btn btn-sm mt-0" type="button" onclick="applyCoupon()"
                                                data-toggle="modal" data-target="#applyToCoupon" id="messageAlert">Nhập
                                                mã giảm giá</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div id="discount-info" style="display: {{ session('coupons') ? 'block' : 'none' }};">
                                    @if (session('coupons'))
                                        @foreach (session('coupons') as $coupon)
                                            <div class="alert-info position-relative">
                                                <p class="end position-absolute top-0 end-0 m-0"
                                                    style="right: 10px; color: #b7062ef2;">Đang áp dụng</p>
                                                <p><strong class="mx-2">Mã giảm giá:</strong>{{ $coupon['code'] }}</p>
                                                <p><strong class="mx-2">Giá trị giảm giá:</strong>
                                                    {{ $coupon['discount_type'] == 'percentage'
                                                        ? $coupon['discount_value'] . ' %'
                                                        : number_format($coupon['discount_amount'], 0, ',', '.') . ' đ' }}
                                                </p>
                                                <p><strong class="mx-2">Số tiền được giảm:</strong>
                                                    {{ number_format($coupon['discount_amount'], 0, ',', '.') }}đ</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div> <!-- Hiển thị thông tin giảm giá -->
                                <button id="applyDiscountBtn" class="btn btn-primary mt-3" style="display:none;"
                                    onclick="applyDiscountToOrder()">Áp dụng giảm giá</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('addOrder') }}" method="post" id="checkout-form">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <ul class="checkout-steps">
                            <li>
                                <h2 class="step-title mb-2">Địa chỉ nhận hàng</h2>
                                <div class="form-group mb-1 pb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="name-phone">
                                            <div class="name me-2">
                                                <strong>{{ Auth::check() ? Auth::user()->username : 'Chưa có tên' }}</strong>
                                            </div>
                                            <div class="phone me-2">
                                                <strong>{{ Auth::check() ? Auth::user()->phone_number : 'Chưa có số điện thoại' }}</strong>
                                            </div>
                                        </div>
                                        <div class="address">
                                            @php
                                                if (Auth::check()) {
                                                    $displayAddress = Auth::user()->addresses;
                                                }
                                            @endphp
                                            @if (count($displayAddress))
                                                @foreach ($displayAddress as $address)
                                                    @if ($address->active == true)
                                                        <span id="displayAddress"> {{ $address->specific_address }},
                                                            {{ $address->ward }}, {{ $address->district }},
                                                            {{ $address->city }}</span>
                                                        <br>
                                                        <span class="small-text ms-2 my-2" style="color: #2a78b0">Mặc
                                                            Định</span>
                                                        <a href="#editAddressModal" class="small-link ms-2 my-2"
                                                            data-bs-toggle="modal">Thay Đổi</a>
                                                        <input type="hidden" name="shipping_address_id"
                                                            value="{{ $address->id }}">
                                                    @endif
                                                @endforeach
                                            @else
                                                <span>Chưa có địa chỉ</span>
                                                <button type="button" class="btnAddAddress my-3" id="btnAddAddress"
                                                    data-bs-toggle="modal" data-bs-target="#addAddressModal">+ Thêm Địa
                                                    Chỉ Mới</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Địa chỉ --}}
                                @include('client.orders.modal.index')
                                {{-- End modal --}}

                                <div class="form-group">
                                    <label class="order-comments">Sản phẩm</label>
                                </div>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cartCheckout as $item)
                                    <div class="product-container">
                                        <div class="product-image">
                                            @php
                                                if (
                                                    $item->productVariant &&
                                                    !empty($item->productVariant->variant_image)
                                                ) {
                                                    $url = $item->productVariant->variant_image;
                                                } else {
                                                    $mainImage = $item->product->getMainImage();
                                                    $url = $mainImage
                                                        ? $mainImage->image_gallery
                                                        : 'default-image-path.jpg';
                                                }
                                            @endphp
                                            <img src="{{ Storage::url($url) }}" alt="{{ $item->product->name }}"
                                                class="img-thumbnail" style="width: 120px;height: 100px;">
                                        </div>
                                        <div class="product-info">
                                            <div class="d-flex justify-content-between mt-1">
                                                <div class="namePro">
                                                    <span class="product-name">{{ $item->product->name }}</span>
                                                    <div class="text-muted">Loại: </div>
                                                    @if ($item->productVariant)
                                                        <div class="product-details">
                                                            <div class="attribute-list">
                                                                @if ($item->productVariant->attributeValues)
                                                                    @foreach ($item->productVariant->attributeValues as $attributeValue)
                                                                        <p class="attribute-item">
                                                                            <strong>{{ $attributeValue->attribute->attribute_name }}:</strong>
                                                                            <span>{{ $attributeValue->attribute_value }}</span>
                                                                        </p>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-muted">Đơn giá</span>
                                                    <div class="fw-bold">
                                                        @if ($item->productVariant)
                                                            @if (!empty($item->productVariant->price_modifier))
                                                                {{ number_format($item->productVariant->price_modifier, 0, ',', '.') }}
                                                                đ
                                                            @else
                                                                {{ number_format($item->productVariant->original_price, 0, ',', '.') }}
                                                                đ
                                                            @endif
                                                        @else
                                                            @if (!empty($item->product->price_sale))
                                                                {{ number_format($item->product->price_sale, 0, ',', '.') }}
                                                                đ
                                                            @else
                                                                {{ number_format($item->product->price_modifier, 0, ',', '.') }}
                                                                đ
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="product-quantity">
                                                    <span class="text-muted">Số lượng</span>
                                                    <div class="fw-bold">{{ $item->quantity }}</div>
                                                </div>
                                                @php
                                                    $price = 0;

                                                    // Check if productVariant exists
                                                    if ($item->productVariant) {
                                                        // Check if price_modifier is not empty or null
                                                        if (!empty($item->productVariant->price_modifier)) {
                                                            $price = $item->productVariant->price_modifier; // Use price_modifier if available
                                                        } else {
                                                            // Use original_price if price_modifier is not set
                                                            $price = $item->productVariant->original_price;
                                                        }
                                                    } else {
                                                        // Handle case where productVariant is null
                                                        if (!empty($item->product->price_sale)) {
                                                            $price = $item->product->price_sale; // Use price_sale if available
                                                        } else {
                                                            // Fallback to price_regular or handle if neither is set
                                                            $price = $item->product->price_regular ?? 0; // Use price_regular if available
                                                        }
                                                    }

                                                    // Calculate total
                                                    $total = $price * $item->quantity;
                                                @endphp

                                                <div class="product-total">
                                                    <span class="text-muted">Thành tiền</span>
                                                    <div class="fw-bold"> {{ number_format($total, 0, ',', '.') }}
                                                        đ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="form-group">
                                    <label class="order-comments">Ghi chú</label>
                                    <textarea id="note" class="form-control" name="note" placeholder="Bạn có gì muốn dặn dò shop không ?"
                                        cols="30" rows="10"></textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="order-summary">

                            <h3>ĐƠN HÀNG CỦA BẠN</h3>

                            <table class="table table-mini-cart">
                                <thead>
                                    <tr>
                                        <th colspan="2">Sản Phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subTotal = 0;
                                        $quantity = 0;
                                    @endphp
                                    @foreach ($cartCheckout as $key => $value)
                                        <tr>
                                            <td class="product-col">
                                                <h3 class="product-title">
                                                    {{ $value->product->name }}
                                                    <span class="product-qty">× {{ $value->quantity }}</span>
                                                    <input type="hidden"
                                                        name="order_item[{{ $key }}][product_id]"
                                                        value="{{ $value->product_id }}">
                                                    <input type="hidden"
                                                        name="order_item[{{ $key }}][product_variant_id]"
                                                        value="{{ $value->product_variants_id }}">
                                                    <input type="hidden"
                                                        name="order_item[{{ $key }}][quantity]"
                                                        value="{{ $value->quantity }}">
                                                    <input type="hidden" name="order_item[{{ $key }}][price]"
                                                        value="{{ $value->total_price }}">
                                                    <input type="hidden" name="order_item[{{ $key }}][id_cart]"
                                                        value="{{ $value->id }}">
                                                </h3>
                                            </td>
                                            <td class="price-col">
                                                <span>
                                                    @if ($value->productVariant)
                                                        @if (!empty($value->productVariant->price_modifier))
                                                            <span
                                                                class="">{{ number_format($value->productVariant->price_modifier, 0, ',', '.') }}
                                                                đ</span>
                                                        @else
                                                            <span
                                                                class="">{{ number_format($value->productVariant->original_price, 0, ',', '.') }}
                                                                đ</span>
                                                        @endif
                                                    @else
                                                        @if (!empty($value->product->price_sale))
                                                            <span
                                                                class="">{{ number_format($value->product->price_sale, 0, ',', '.') }}
                                                                đ</span>
                                                        @else
                                                            <span
                                                                class="">{{ number_format($value->product->price_regular, 0, ',', '.') }}
                                                                đ</span>
                                                        @endif
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @php
                                            $subTotal += $value->total_price; // Assuming total_price is already price * quantity
                                            $quantity += $value->quantity;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="border:none">
                                        <td>
                                            <h4>Số lượng</h4>
                                        </td>
                                        <td class="quantity-col">
                                            <span class="quantity">×{{ $quantity }}</span>
                                        </td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <td style="margin-top: 10px">
                                            <h4>Tổng phụ</h4>
                                        </td>
                                        <td class="price-col">
                                            <span>{{ number_format($subTotal, 0, ',', '.') }} đ</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="margin-top: 10px">
                                            <h4>Mã giảm giá</h4>
                                        </td>
                                        <td class="price-col"></td>
                                    </tr>
                                    <tr id="couponInfo">
                                        @php
                                            //  dd(session('coupons'));
                                        @endphp
                                        @if (session('coupons'))
                                            @foreach (session('coupons') as $key => $coupon)
                                    <tr>
                                        <td style="padding-left: 5px;">
                                            <h5 style="font-weight: 100; font-size: 11px; padding-left: 20px;margin: 0px;">
                                                {{ $coupon['code'] }}</h5>
                                        </td>
                                        <td class="price-col price-coupone">
                                            {{ number_format($coupon['discount_amount'], 0, ',', '.') }}đ</td>
                                    </tr>
                                    <input type="hidden" name="coupons[{{ $key }}][code]"
                                        value="{{ $coupon['code'] }}" />
                                    <input type="hidden" name="coupons[{{ $key }}][discount_amount]"
                                        value="{{ $coupon['discount_amount'] }}" />
                                    @endforeach
                                    @endif
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <h4>Vận chuyển</h4>
                                            <div class="form-group form-group-custom-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input shipp-fe"
                                                        name="shipp[{{ $dataShippingMethod['value'] }}]"
                                                        value="{{ $dataShippingMethod['shipp'] }}" checked
                                                        onchange="updateTotal()">
                                                    <label class="custom-control-label">
                                                        {{ $dataShippingMethod['message'] }}
                                                        (
                                                        {{ is_numeric($dataShippingMethod['shipp']) ? number_format((float) $dataShippingMethod['shipp'], 0, ',', '.') : 'N/A' }}
                                                        đ
                                                        )
                                                    </label>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr class="order-shipping">
                                        <td class="text-left" colspan="2">
                                            <h4 class="m-b-sm">Phương thức thanh toán</h4>
                                            <div class="form-group form-group-custom-control">
                                                <div class="custom-control custom-checkbox d-flex">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="payment-online" name="radio_pay" value="VNPay"
                                                        onclick="selectPayment(this)" />
                                                    <label class="custom-control-label" for="payment-online">Thanh toán
                                                        VNPay</label>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-custom-control mb-0">
                                                <div class="custom-control custom-checkbox d-flex mb-0">
                                                    <input type="checkbox" class="custom-control-input" id="payment-cash"
                                                        name="radio_pay" value="Cash" onclick="selectPayment(this)"
                                                        checked />
                                                    <label class="custom-control-label" for="payment-cash">Thanh toán sau
                                                        khi nhận hàng</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="order-total">
                                        <td>
                                            <h4>Tổng </h4>
                                        </td>
                                        <td>
                                            <b class="total-price"><span id="totalPriceDisplay" style="font-size: 2rem"
                                                    name="price">{{ number_format($subTotal, 0, ',', '.') }}
                                                    đ</span></b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            {{-- <div class="payment-methods">
                                    <h4 class="">Payment methods</h4>
                                    <div class="info-box with-icon p-0">
                                        <p>
                                            Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.
                                        </p>
                                    </div>
                                </div> --}}

                            <input type="hidden" name="price" id="totalAmountInput" value="{{ $subTotal }}">
                            <button type="submit" class="btn btn-dark btn-place-order" form="checkout-form">
                                Đặt hàng
                            </button>
                        </div>
                        <!-- End .cart-summary -->
                    </div>
                    <!-- End .col-lg-4 -->
                </div>
            </form>
            <!-- End .row -->
        </div>
        <!-- End .container -->


    </main>
    {{-- Modal thông báo lỗi khi áp dụng mã giảm giá --}}

    <!-- Modal -->
    <div class="modal fade" id="applyToCoupon" tabindex="-1" role="dialog" aria-labelledby="applyToCouponLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width: 550px">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyToCouponLabel">Thông báo </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script_libray')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endsection

@section('scripte_logic')
    <script>
        $(document).ready(function() {
            $('button[data-dismiss="modal"]').on('click', function() {
                $('#applyToCoupon').modal('hide');  // Đóng modal
                location.reload();  // Tải lại trang
            });

            // Khi nhấn ra ngoài modal để đóng modal và tải lại trang
            $('#applyToCoupon').on('click', function (e) {
                if ($(e.target).hasClass('modal')) {
                    $('#applyToCoupon').modal('hide');  // Đóng modal nếu người dùng nhấn ngoài modal
                    location.reload();  // Tải lại trang
                }
            });
        });

        // Chọn checkbox
        function selectPayment(selectedCheckbox) {
            // Lấy tất cả checkbox trong cùng nhóm
            const checkboxes = document.querySelectorAll('input[name="radio_pay"]');

            checkboxes.forEach(checkbox => {
                // Nếu checkbox không phải là checkbox đã được chọn
                if (checkbox !== selectedCheckbox) {
                    // Bỏ chọn tất cả checkbox khác
                    checkbox.checked = false;
                }
            });
        }

        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            const number = Number(value).toFixed(2);
            const [whole, decimal] = number.split('.');
            const formattedWhole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return `${formattedWhole} đ`;
        }
        // Hàm định dạng giá trị giảm giá
        function formatCurrency2(value) {
            const number = Number(value).toFixed(2);
            const [whole, decimal] = number.split('.');
            const formattedWhole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return `${formattedWhole}`;
        }

        // Hàm cập nhật tổng tiền với phí vận chuyển và giảm giá nếu có
        function calculateTotal(subtotal, discount = 0, shippingCost = 0) {
            const total = subtotal - discount + shippingCost; // Tính tổng tiền sau khi trừ giảm giá và cộng phí ship
            document.getElementById('totalPriceDisplay').textContent = formatCurrency(total); // Hiển thị tổng tiền
            document.getElementById('totalAmountInput').value = total; // Cập nhật giá trị tổng vào input ẩn
        }

        // Hàm cập nhật phí vận chuyển
        function updateShipping() {
            const shippingCost = parseFloat(document.querySelector('input[name="radio-ship"]:checked').value);
            console.log('phí vận chuyển là ',shippingCost);
            
            const subtotal = parseFloat('{{ $subTotal }}'); // Giá trị tổng phụ từ server
            const discount = parseFloat(document.getElementById('discountAmountInput')?.value ||
                0); // Lấy giá trị giảm giá từ input (nếu có)
            calculateTotal(subtotal, discount, shippingCost); // Tính tổng với giá trị giảm giá và phí vận chuyển
        }

        function updateTotal() {
            const subtotal = parseFloat('{{ $subTotal }}');
            const shippingCost = parseFloat(document.querySelector('input.shipp-fe:checked').value);
            let discountTotal = 0;
            @if (session('coupons'))
                @foreach (session('coupons') as $coupon)
                    discountTotal += {{ $coupon['discount_amount'] }};
                @endforeach
            @endif
            let total = 0;
            total = subtotal + shippingCost - discountTotal;
            if (total < 0) {
                total = 0;
            }

            document.getElementById('totalPriceDisplay').textContent = formatCurrency(total);
            document.getElementById('totalAmountInput').value = total;
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });

        let appliedCoupons = []; // Mảng lưu trữ các mã giảm giá đã áp dụng
        // Hàm áp dụng mã giảm giá
        function applyCoupon() {
            const couponCode = document.getElementById("coupon_code").value.trim();

            // Xóa thông báo lỗi nếu có khi người dùng bắt đầu nhập mã mới
            const discountInfo = document.getElementById("discount-info");
            const couponInfo = document.getElementById("couponInfo");
            if (!couponCode) {
                document.querySelector("#applyToCoupon .modal-body").innerHTML =
                    `<p style="color: red;">Vui lòng nhập mã giảm giá</p>`
                return;
            }
            // Lấy giá trị của phí vận chuyển được chọn
            const shippingCost = parseFloat(document.querySelector('input.shipp-fe:checked').value);

            // Kiểm tra xem mã giảm giá đã được áp dụng hay chưa
            if (appliedCoupons.includes(couponCode)) {
                document.querySelector("#applyToCoupon .modal-body").innerHTML =
                    `<p style="color: red;">Mã giảm giá này đã được áp dụng</p>`
                return;
            }

            // Gửi yêu cầu tới server để kiểm tra mã giảm giá
            fetch("/apply-coupon", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        coupon_code: couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {    
                    document.getElementById("coupon_code").value=""
                 if (data.success) {
                    const discountInfo = document.getElementById("discount-info");
                    discountInfo.style.display="block";
                    const couponInfo = document.getElementById("couponInfo");
                        // Lưu mã giảm giá vào danh sách đã áp dụng
                        appliedCoupons.push(couponCode);

                        // Hiển thị thông tin giảm giá vào discountInfo
                        discountInfo.innerHTML += `
                        <div class="alert-info position-relative">
                            <p class="end position-absolute top-0 end-0 m-0" style="right: 10px; color: #b7062ef2;">Đang áp dụng</p>
                            <p><strong>Mã giảm giá:</strong> ${data.coupon.code}</p>
                            <p><strong>Giá trị giảm giá:</strong> ${formatCurrency2(data.coupon.discount_value)} ${data.coupon.discount_type === 'percentage' ? '%' : 'đ'}</p>
                            <p><strong>Số tiền được giảm:</strong> ${formatCurrency(data.coupon.discount_amount)}</p>
                        </div>`;

                        // Hiển thị thông tin giảm giá vào couponInfo
                        const newRow = `
                            <tr>
                                <td style="padding-left: 5px;">
                                    <h5 style="font-weight: 100; font-size: 11px; padding-left: 20px;margin: 0px;">${data.coupon.code}</h5>
                                </td>
                                <td class="price-col price-coupone" >${formatCurrency(data.coupon.discount_amount)}</td>
                            </tr> 
                             <input type="hidden" name="coupons[${data.coupon.code}][code]" value="${data.coupon.code}"/>
                             <input type="hidden" name="coupons[${data.coupon.code}][discount_amount]" value="${data.coupon.discount_amount}"/>
                            `;
                        couponInfo.insertAdjacentHTML('beforebegin', newRow);

                        document.querySelector("#applyToCoupon .modal-body").innerHTML= `<p style="">${data.message}</p>`
                        // Tính tổng giảm giá từ tất cả các mã đã áp dụng
                        const totalPriceDisplay = document.getElementById("totalPriceDisplay");
                        const currentTotal = parseFloat(totalPriceDisplay.innerText.replace(/[^\d.-]/g, ''));
                        const discountAmount = parseFloat(data.coupon.discount_amount);
                        console.log(discountAmount);
                        
                        const newTotal = currentTotal*1000 - discountAmount;
                        if(newTotal<0){
                            newTotal=0;
                        }
                        // Display the formatted new total (assuming formatCurrency handles formatting)
                        totalPriceDisplay.innerText = formatCurrency(newTotal);

                    } else {
                        console.log(data.message);
                        
                         document.querySelector("#applyToCoupon .modal-body").innerHTML= `<p style="color: red;">${data.message}</p>`
                       //  updateShipping(); // Cập nhật lại tổng với phí vận chuyển
                    }
                })
                .catch(error => {
                     document.getElementById("coupon_code").value=""
                     document.querySelector("#applyToCoupon .modal-body").innerHTML= `<p style="color: red;">Đã có lỗi khi thêm mã giảm giá</p>`
                });
        }



        // Gọi hàm updateShipping() khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            updateShipping();
        });

        // Sự kiện thay đổi phí vận chuyển
        document.querySelectorAll('input[name="radio-ship"]').forEach(radio => {
            radio.addEventListener('change', updateShipping);
        });

        // Nút cập nhật địa chỉ
        document.querySelectorAll('.edit-address-link').forEach(link => {
            link.addEventListener('click', function(event) {
                const addressData = event.target.dataset; // Lấy thông tin địa chỉ từ thuộc tính dữ liệu

                // Cập nhật thông tin vào form
                document.getElementById('updateName').value = addressData.name;
                document.getElementById('updatePhone').value = addressData.phone;
                document.getElementById('updateAddress').value = addressData.specificAddress;

                // Cập nhật ID địa chỉ
                document.getElementById('id_address').value = addressData.id;

                // Hiển thị modal cập nhật
                $('#editAddressModal').modal('hide'); // Ẩn modal cũ
                $('#updateAddressModal').modal('show'); // Hiện modal cập nhật
            });
        });

        document.getElementById('btnBackToEdit').addEventListener('click', function() {
            $('#updateAddressModal').modal('hide'); // Ẩn modal cập nhật
            $('#editAddressModal').modal('show'); // Hiện lại modal cũ
        });



        // Modal thêm mới địa chỉ
        document.addEventListener("DOMContentLoaded", function() {
            const btnAddAddress = document.getElementById('btnAddAddress');
            const addAddressForm = document.getElementById('new-address-form');
            const updateAddressForm = document.getElementById('update-address-form');
            const btnAdd = document.getElementById('btnAdd');
            const btnBack = document.getElementById('btnBack');
            const btnHuy = document.getElementById('btnHuy');

            // Nút thêm địa chỉ mới
            btnAddAddress.addEventListener('click', function () {
                $('#editAddressModal').modal('show');
                let isUpdating = false;
                const newCitySelect = document.querySelector("#newCity");
                const newDistrictSelect = document.querySelector("#newDistrict");
                const newWardSelect = document.querySelector("#newWard");
                const newAddressInput = document.querySelector("#newAddress");

                // Disable selects initially
                [newDistrictSelect, newWardSelect].forEach(select => {
                    select.disabled = true;
                });

                // Fetch and populate cities
                function getCities(selectElement, isSelected = '') {
                    if (isUpdating) return;
                    isUpdating = true;
                    fetch("https://provinces.open-api.vn/api/p/")
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch cities');
                            return response.json();
                        })
                        .then(data => {
                            selectElement.innerHTML = '<option value="">Tỉnh/Thành phố</option>';
                            data.forEach(city => {
                                const selected = city.name === isSelected ? ' selected' : '';
                                selectElement.innerHTML += `<option value="${city.code}"${selected}>${city.name}</option>`;
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error))
                        .finally(() => {
                            isUpdating = false;
                        });
                }

                // Fetch districts based on selected city
                function getDistricts(cityCode, isSelected = '') {
                    if (isUpdating) return;
                    isUpdating = true;
                    fetch(`https://provinces.open-api.vn/api/p/${cityCode}?depth=2`)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch districts');
                            return response.json();
                        })
                        .then(data => {
                            newDistrictSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                            data.districts.forEach(district => {
                                const selected = district.name === isSelected ? ' selected' : '';
                                newDistrictSelect.innerHTML += `<option value="${district.code}"${selected}>${district.name}</option>`;
                            });
                            newDistrictSelect.disabled = false;
                            newWardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                            newWardSelect.disabled = true;
                        })
                        .catch(error => console.error('Error fetching districts:', error))
                        .finally(() => {
                            isUpdating = false;
                        });
                }

                // Fetch wards based on selected district
                function getWards(districtCode, isSelected = '') {
                    if (isUpdating) return;
                    isUpdating = true;
                    fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch wards');
                            return response.json();
                        })
                        .then(data => {
                            newWardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                            data.wards.forEach(ward => {
                                const selected = ward.name === isSelected ? ' selected' : '';
                                newWardSelect.innerHTML += `<option value="${ward.code}"${selected}>${ward.name}</option>`;
                            });
                            newWardSelect.disabled = false;
                        })
                        .catch(error => console.error('Error fetching wards:', error))
                        .finally(() => {
                            isUpdating = false;
                        });
                }

                // Reset district and ward selects
                function resetDistrictAndWard() {
                    newDistrictSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                    newWardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                    newDistrictSelect.disabled = true;
                    newWardSelect.disabled = true;
                }

                // Update address input
                function updateAddressInput() {
                    const city = newCitySelect.options[newCitySelect.selectedIndex]?.text || '';
                    const district = newDistrictSelect.options[newDistrictSelect.selectedIndex]?.text || '';
                    const ward = newWardSelect.options[newWardSelect.selectedIndex]?.text || '';
                    newAddressInput.value ='';
                }

                // Event listener for city selection
                newCitySelect.addEventListener("change", function () {
                    const cityCode = this.value;
                    if (cityCode) {
                        resetDistrictAndWard();
                        getDistricts(cityCode);
                    } else {
                        resetDistrictAndWard();
                        updateAddressInput();
                    }
                });

                // Event listener for district selection
                newDistrictSelect.addEventListener("change", function () {
                    const districtCode = this.value;
                    if (districtCode) {
                        newWardSelect.innerHTML = '<option value="">Loading...</option>';
                        getWards(districtCode);
                    } else {
                        resetDistrictAndWard();
                        updateAddressInput();
                    }
                });

                // Event listener for ward selection
                newWardSelect.addEventListener("change", updateAddressInput);

                // Fetch cities on modal open
                getCities(newCitySelect);
            });


            // Nút trở lại
            btnBack.addEventListener('click', function() {
                // Ẩn form thêm và quay lại trang hiển thị địa chỉ
                addAddressForm.style.display = 'none';
                updateAddressForm.style.display = 'none';
                btnBack.style.display = 'none';
                btnHuy.style.display = 'inline-block';
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            // Elements for the update form
            const updateCitySelect = document.querySelector("#city");
            const updateDistrictSelect = document.querySelector("#district");
            const updateWardSelect = document.querySelector("#ward");
            const tam = '';

            // Disable district and ward selects initially
            [updateDistrictSelect, updateWardSelect].forEach(select => {
                select.disabled = true;
            });

            // Function to fetch and populate cities
            function getCities(selectElement, isSelected = '') {
                fetch("https://provinces.open-api.vn/api/p/")
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch cities');
                        return response.json();
                    })
                    .then(data => {
                        selectElement.innerHTML = '<option value="">Tỉnh/Thành phố</option>';
                        data.forEach(city => {
                            const selected = city.name === isSelected ? ' selected' : '';
                            selectElement.innerHTML +=
                                `<option value="${city.code}"${selected}>${city.name}</option>`;
                        });
                        selectElement.dispatchEvent(new Event('change'));
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }

            // Function to fetch districts based on selected city
            function getDistricts(cityCode, districtSelect, wardSelect, isSelected = '') {                
                fetch(`https://provinces.open-api.vn/api/p/${cityCode}?depth=2`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch districts');
                        return response.json();
                    })
                    .then(data => {
                        districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                        data.districts.forEach(district => {
                            const selected = district.name === isSelected ? ' selected' : '';
                            districtSelect.innerHTML +=
                                `<option value="${district.code}"${selected}>${district.name}</option>`;
                        });
                        districtSelect.disabled = false;
                        let tam =updateDistrictSelect.value;
                        if(wardSelect!==''){
                            updateWardSelect.disabled = false;
                            getWards(tam,updateWardSelect,wardSelect)
                        } else{
                            wardSelect.innerHTML = '<option value="">Phường/Xã</option>'; // Reset wards
                            updateWardSelect.disabled = false; // Disable until district is selected
                        }
                    })
                    .catch(error => console.error('Error fetching districts:', error));
            }

            // Function to fetch wards based on selected district
            function getWards(districtCode, updateWardSelect ,isSelected) {    

                fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch wards');
                        return response.json();
                    })
                    .then(data => {
                        
                        updateWardSelect.innerHTML = '<option value="">Phường/Xã</option>'; // Reset options
                        data.wards.forEach(ward => {
                            const selected = ward.name === isSelected ? ' selected' :
                            ''; // Set selected
                            updateWardSelect.innerHTML +=
                                `<option value="${ward.code}"${selected}>${ward.name}</option>`;
                        });

                        // Enable dropdown after data is loaded
                        updateWardSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching wards:', error);
                        wardSelect.disabled = true; // Disable dropdown if error occurs
                    });
            }


            // Reset function for district and ward selects
            function resetDistrictAndWard(districtSelect, wardSelect) {
                districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                districtSelect.disabled = true;
                wardSelect.disabled = true;
            }

            // Reset form when modal is hidden
            $('#update-address-form').on('hidden.bs.modal', function() {
                resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
            });

            document.querySelectorAll('.edit-address-link').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const id_address = this.dataset.id;
                    const name = this.dataset.name;
                    const phone = this.dataset.phone;
                    const specificAddress = this.dataset.specificAddress;
                    const ward = this.dataset.ward;
                    const district = this.dataset.district;
                    const city = this.dataset.city;
                    document.getElementById('id_address').value = id_address
                    document.getElementById('updateName').value = name;
                    document.getElementById('updatePhone').value = phone;
                    document.getElementById('updateAddress').value = specificAddress;
                
                    getCities(updateCitySelect, city); // Update city select

                    const cityChangeHandler = function() {
                        const cityCode = this.value;
                        if (cityCode) {
                            getDistricts(cityCode, updateDistrictSelect,ward,
                                district);
                        } else {
                            resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
                        }
                    };

                    const districtChangeHandler = function() {
                        const districtCode = this.value;
                        console.log('Selected district code:', districtCode);

                        if (districtCode) {
                            getWards(districtCode, updateWardSelect,
                                ward); // Fetch wards and set the selected ward
                        } else {
                            resetDistrictAndWard(updateWardSelect);
                        }
                    };
                    
                    // Update event listeners
                    updateCitySelect.removeEventListener("change", cityChangeHandler);
                    updateCitySelect.addEventListener("change", cityChangeHandler);

                    updateDistrictSelect.removeEventListener("change", districtChangeHandler);
                    updateDistrictSelect.addEventListener("change", districtChangeHandler);

                    // Trigger fetching districts after city selection
                    updateCitySelect.dispatchEvent(new Event('change'));
                });
            });
        });




        document.addEventListener("DOMContentLoaded", function() {
            const addAddressForm = document.querySelector("#addAddressForm");
            const btnAdd = document.querySelector("#btnAdd");

            function getSelectedText(selectElement) {
                return selectElement.selectedOptions[0].textContent;
            }


            btnAdd.addEventListener("click", function(event) {
                event.preventDefault();

                const formData = new FormData(addAddressForm);
                const newName = document.getElementById("newName");
                const newPhone = document.getElementById("newPhone");
                const citySelect = document.querySelector("#newCity");
                const districtSelect = document.querySelector("#newDistrict");
                const wardSelect = document.querySelector("#newWard");
                const specific_address = document.querySelector("#newAddress");
                const displayAddress = document.querySelector("#displayAddress");
                if (citySelect && districtSelect && wardSelect) {
                    formData.append('city', getSelectedText(citySelect));
                    formData.append('district', getSelectedText(districtSelect));
                    formData.append('ward', getSelectedText(wardSelect));
                    formData.append('specific_address', specific_address.value);
                    formData.append('username', newName.value);
                    formData.append('phone_number', newPhone.value);
                }
                fetch('addresses', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        $('#addAddressModal').modal('hide');
                        document.querySelector("#applyToCoupon .modal-body").innerHTML='';
                         if (data.message) {
                            document.querySelector("#applyToCoupon .modal-body").innerHTML =
                                `<p class='text-primary'>${data.message}</p>`
                            $('#applyToCoupon').modal('show');
                        }
                        location.reload();
                    })
                    .catch(error => {
                        $('#addAddressModal').modal('hide');
                        document.querySelector("#applyToCoupon .modal-body").innerHTML='';
                         if (error) {
                            document.querySelector("#applyToCoupon .modal-body").innerHTML =
                                `<p style="color: red;">${error}</p>`
                            $('#applyToCoupon').modal('show');
                        }
                        location.reload();
                    });
            });
        });

        document.getElementById('btnConfirm').addEventListener('click', function() {
            const selectedCheckbox = document.querySelector('.address-checkbox:checked');

            if (selectedCheckbox) {
                const addressId = selectedCheckbox.value;

                fetch(`/addresses/set-default/${addressId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            addressId: addressId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll('.address-checkbox').forEach(cb => cb.checked = false);
                            selectedCheckbox.checked = true; // Keep the selected checkbox checked
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert('Có lỗi xảy ra khi cập nhật địa chỉ mặc định.');
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            } else {
                alert('Vui lòng chọn một địa chỉ để cập nhật.');
            }
        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // or from hidden input
                }
            });

            function getSelectedText(selectElement) {
                return selectElement.selectedOptions[0].textContent;
            }
            $('#btnConfirmUpdate').on('click', function(e) {

                e.preventDefault();
                let formData = {
                    id_address: $('#id_address').val(),
                    name: $('#updateName').val(),
                    phone: $('#updatePhone').val(),
                    city: getSelectedText(document.getElementById('city')),
                    district: getSelectedText(document.getElementById('district')),
                    ward: getSelectedText(document.getElementById('ward')),
                    address: $('#updateAddress').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '/update-address',
                    data: formData,
                    success: function(response) {         
                        $('#addAddressModal').modal('hide');
                        document.querySelector("#applyToCoupon .modal-body").innerHTML='';
                         if (response.success) {
                            document.querySelector("#applyToCoupon .modal-body").innerHTML =
                                `<p class='text-primary'>${response.success}</p>`
                            $('#applyToCoupon').modal('show');
                        }
                    },
                    error: function(xhr) {
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
