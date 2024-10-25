@extends('client.layouts.app')

@section('style_css')



<style>
.checkout-steps{
    margin-top: -39px;
}
/* Địa chỉ nhận hàng */
.name-phone{
    margin-right: 10px;
}
.name{
    /* margin-right: -60px; */
    width: 100px;
}
.address{

}
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

.product-price, .product-quantity, .product-total {
    text-align: center;
}
.text-end{
    text-align: center;
    width: 120px;
}
.product-quantity{
    width: 70px;
}

.text-muted {
    color: #6c757d;
}

.fw-bold {
    font-weight: bold; 
}

.namePro{
    width: 170px;
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


.small-title{
    font-size: 10px;
    width: 75px;
    text-align: center;
    padding: 6px 6px;
    border: 1px solid #2a78b0;
}

.btn-close-address{
    font-size: 30px;
    font-weight: 100;
    color: #dcdcdc;
    cursor: pointer;
    border: none;
    background: transparent;
}

.btn-close-address:hover{
    color: #6c757d;
}

.btnAddAddress{
    border: 1px solid #dcdcdc;
    color:#6c757d;
    background-color: transparent;
    padding: 10px 10px;
    cursor: pointer;
    margin-left: 300px;
}
.btnAddAddress:hover{
    background: #f3f3f3c0;
}

.btnHuy{
    border: 1px solid #dcdcdc;
    color:#6c757d;
    width: 130px;
    background-color: transparent;
    padding: 10px 10px;
    cursor: pointer;
}
.btnHuy:hover{
    background: #f3f3f3c0;
}

.btnEdit{
    border: 1px solid #dcdcdc;
    color: white;
    width: 130px;
    background-color: #2a78b0;
    padding: 10px 10px;
    cursor: pointer;
}
.btnEdit:hover{
    background-color: #4689b9;
}

.btnAdd{
    border: 1px solid #dcdcdc;
    color: white;
    width: 130px;
    background-color: #2a78b0;
    padding: 10px 10px;
    cursor: pointer;
}
.btnAdd:hover{
    background-color: #4689b9;
}

.btnBack {
    border: 1px solid #dcdcdc;
    color:#6c757d;
    width: 130px;
    background-color: transparent;
    padding: 10px 10px;
    cursor: pointer;
}

.btnBack:hover{
    background: #f3f3f3c0;
}

.btnText{
    border: 1px solid #dcdcdc;
    color:#6c757d;
    width: 100px;
    background-color: transparent;
    padding: 5px 5px;
    margin-right: 10px;
    cursor: pointer;
}

.btnText:focus{
    border: 1px solid #2a78b0;
    color: #2a78b0;
}

.form-check-label{
    margin-left: 10px;
}

select.form-control {
    appearance: none; 
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>'); /* Biểu tượng mũi tên */
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 26px;
    padding-right: 30px; 
}



</style>
@endsection


@section('content')

@php
    Auth::check() ? Auth::user()->id : ''  
@endphp

<header class="header home">
    <div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': true}">
        <div class="container">
            <nav class="main-nav w-100">
                <ul class="menu">
                    <li>
                        <a href="{{ route('client') }}">Home</a>
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
                <a href="{{ route('shopping-cart') }}">Shopping Cart</a>
            </li>
            <li class="active">
                <a href="{{ route('checkout') }}">Checkout</a>
            </li>
            <li class="disabled">
                <a href="#">Order Complete</a>
            </li>
        </ul>
        

        <div class="checkout-discount">
            <h4>Have a coupon?
                <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne" class="btn btn-link btn-toggle">ENTER YOUR CODE</button>
            </h4> 

            <div id="collapseTwo" class="collapse">
                <div class="feature-box">
                    <div class="feature-box-content">
                        <p>If you have a coupon code, please apply it below.</p>

                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm w-auto" placeholder="Coupon code" required="" name="order_item[][discount]" />
                                <div class="input-group-append">
                                    <button class="btn btn-sm mt-0" type="submit">
                                        Apply Coupon
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <ul class="checkout-steps">
                    <li>
                        <form action="{{ route('addOrder') }}" method="post" id="checkout-form">
                            @csrf
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
                                            // Determine the display value for the address
                                            $displayAddress = $address->address_line ?? $address->address_line1 ?? $address->address_line2 ?? null;
                                        @endphp
                                        @if ($displayAddress)
                                            <span>{{ $displayAddress }}</span>
                                            {{-- <span class="small-text ms-2" style="color: #2a78b0">Mặc Định</span> --}}
                                            <a href="#editAddressModal" class="small-link ms-2" data-bs-toggle="modal">Thay Đổi</a>
                                        @else
                                            <span>Chưa có địa chỉ</span>
                                            <button type="button" class="btnAddAddress my-3" id="btnAddAddress" data-bs-toggle="modal" data-bs-target="#addAddressModal">+ Thêm Địa Chỉ Mới</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Địa chỉ --}}
                            <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAddressModalLabel">Địa Chỉ Của Tôi</h5>
                                            {{-- <button type="button" class="btn-close-address" data-bs-dismiss="modal" aria-label="Đóng">×</button> --}}
                                        </div>
                                        <div class="modal-body" id="address-content">
                                            <!-- Địa chỉ hiện tại -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6>{{ Auth::check() ? Auth::user()->username : '' }}</h6>
                                                    <p>{{ Auth::check() ? Auth::user()->phone_number : '' }} </p>
                                                    <p>{{ $displayAddress ?? '' }}</p>
                                                    {{-- <span class="small-title" style="color: #2a78b0">Mặc định</span> --}}
                                                </div>
                                                <a href="#" class="text-primary" id="btnEditAddress">Cập nhật</a>
                                            </div>
                                        </div>
                            
                                        <!-- Form cập nhật địa chỉ -->
                                        <div class="modal-body" id="update-address-form" style="display: none;">
                                            {{-- <h5>Cập nhật địa chỉ</h5> --}}
                                            <form id="updateAddressForm">
                                                <!-- Họ và tên + Số điện thoại cùng hàng -->
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <input type="text" class="form-control" placeholder="Họ và tên" id="updateName" value="{{ Auth::check() ? Auth::user()->username : '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <input type="text" class="form-control" placeholder="Số điện thoại" id="updatePhone" value="{{ Auth::check() ? Auth::user()->phone_number : '' }}">
                                                    </div>
                                                </div>
                                                <!-- Tỉnh/Thành phố, Quận/Huyện, Phường/Xã -->
                                                <div class="mb-2">
                                                    <select class="form-control" name="city" id="updateLocation">
                                                        <option value="">Tỉnh/Thành phố</option>
                                                    </select>
                                                    <select class="form-control" name="district" id="updateLocation">
                                                        <option value="">Quận/Huyện</option>
                                                    </select>
                                                    <select class="form-control" name="ward" id="updateLocation">
                                                        <option value="">Phường/Xã</option>
                                                    </select>
                                                </div>
                                                <!-- Địa chỉ cụ thể -->
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" placeholder="Địa chỉ cụ thể" id="updateAddress" value="{{ $displayAddress ?? '' }}">
                                                </div>
                                                <!-- Đặt làm địa chỉ mặc định -->
                                                {{-- <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="updateDefaultAddressCheck">
                                                    {{-- <label class="form-check-label" for="updateDefaultAddressCheck"> Đặt làm địa chỉ mặc định </label>
                                                </div> --}}
                                            </form>
                                        </div>
                            
                                        <div class="modal-footer">
                                            <button type="button" class="btnHuy" id="btnHuy" data-bs-dismiss="modal">Hủy</button>
                                            <button type="button" class="btnBack" id="btnBack" style="display: none;">Trở Lại</button>
                                            <button type="button" class="btnEdit" id="btnEdit">Xác nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End modal --}}

                            {{-- Modal Thêm địa chỉ --}}
                            <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ</h5>
                                        </div>
                            
                                        <!-- Form thêm địa chỉ mới -->
                                        <div class="modal-body" id="new-address-form" style="display: none;">
                                            <form id="addAddressForm">
                                                <!-- Họ và tên + Số điện thoại cùng hàng -->
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <input type="text" class="form-control" name="username" placeholder="Họ và tên" id="newName">
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <input type="phone" class="form-control" name="phone" placeholder="Số điện thoại" id="newPhone">
                                                    </div>
                                                </div>
                                                <!-- Tỉnh/Thành phố, Quận/Huyện, Phường/Xã -->
                                                <div class="mb-2">
                                                    <select class="form-control" name="city" id="newCity">
                                                        <option value="">Tỉnh/Thành phố</option>
                                                    </select>
                                                    <select class="form-control" name="district" id="newDistrict">
                                                        <option value="">Quận/Huyện</option>
                                                    </select>
                                                    <select class="form-control" name="ward" id="newWard">
                                                        <option value="">Phường/Xã</option>
                                                    </select>
                                                </div>
                                                <!-- Địa chỉ cụ thể -->
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" name="newAddress" placeholder="Địa chỉ cụ thể" id="newAddress" >
                                                </div>
                                                <!-- Đặt làm địa chỉ mặc định -->
                                                {{-- <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="newDefaultAddressCheck">
                                                    <label class="form-check-label" for="newDefaultAddressCheck"> Đặt làm địa chỉ mặc định </label>
                                                </div> --}}
                                            </form>
                                        </div>
                            
                                        <div class="modal-footer">
                                            <button type="button" class="btnHuy" id="btnHuy" data-bs-dismiss="modal">Hủy</button>
                                            <button type="button" class="btnAdd" id="btnAdd">Thêm địa chỉ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End modal --}}


                            {{-- <div class="form-group mb-1 pb-2">
                                <label>Họ và tên
                                    <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="username" class="form-control" value="{{ Auth::check() ? Auth::user()->username : ''  }}"/>
                            </div>

                            <div class="form-group mb-1 pb-2">
                                <label>Địa chỉ <abbr class="required" title="required">*</abbr></label>
                                    @php
                                    // Xác định giá trị hiển thị
                                    $displayAddress = $address->address_line ?? $address->address_line1 ?? $address->address_line2;
                                    //   dd($displayAddress)
                                    @endphp
                                    @if (!empty($displayAddress)) 
                                        <input type="text" class="form-control form-check-label" name="address" for="address-{{ $address->id }}" value="{{ $displayAddress }}"/> 
                                    @endif
                            </div> --}}
                            

                            {{-- <div class="form-group mb-1 pb-2">
                                <label>Xã
                                    <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="ward" class="form-control" placeholder="Xã ..." value=""/>
                            </div>
                            
                            <div class="form-group">
                                <label>Quận / Huyện <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="district" class="form-control" placeholder="Nhập Quận / Huyện" value="" />
                            </div>

                            <div class="form-group">
                                <label>Thành phố  
                                    <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="city" class="form-control" placeholder="Nhập Thành Phố" value=""  />
                            </div> --}}

                            {{-- <div class="form-group">
                                <label>Mã bưu chính / Zip
                                    <abbr class="required" title="required">*</abbr></label>
                                <input type="text" class="form-control" required />
                            </div> --}} 

                            {{-- <div class="form-group">
                                <label>Số điện thoại <abbr class="required" title="required">*</abbr></label>
                                <input type="tel" name="phone_number" class="form-control" value="{{ Auth::check() ? Auth::user()->phone_number : ''  }}"/>
                            </div> --}}

                            <div class="form-group">
                                <label class="order-comments">Sản phẩm</label>
                            </div>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($cartCheckout as $item)
                            
                            <div class="product-container">
                                <div class="product-image">
                                    <img src="" alt="{{ $item->product->name }}" class="img-thumbnail" >
                                </div>
                                <div class="product-info">
                                    <div class="d-flex justify-content-between mt-1">
                                        <div class="namePro">
                                            <span>{{ $item->product->name }}</span>
                                            <div class="text-muted">Loại: </div>
                                            {{-- <span class="text-danger small">Đổi ý miễn phí 15 ngày</span> --}}
                                        </div>
                                        <div class="text-end">
                                            <span class="text-muted">Đơn giá</span>
                                            <div class="fw-bold">
                                                @if ($item->product && is_null($item->productVariant)) 
                                                    @if (!is_null($item->product->price_sale) && $item->product->price_sale > 0) 
                                                        {{ number_format($item->product->price_sale, 0, ',', '.') }} ₫
                                                    @else
                                                        {{ number_format($item->product->price_regular, 0, ',', '.') }} ₫
                                                    @endif
                                                @elseif ($item->product && $item->productVariant) 
                                                    {{ number_format($item->productVariant->price_modifier, 0, ',', '.') }} ₫
                                                @endif
                                        </div>
                                        </div>
                                        <div class="product-quantity">
                                            <span class="text-muted">Số lượng</span>
                                            <div class="fw-bold">{{ $item->quantity }}</div>
                                        </div>
                                        @php

                                            if ($item->product && is_null($item->productVariant)) {
                                                // Kiểm tra sản phẩm thường
                                                if (!is_null($item->product->price_sale) && $item->product->price_sale > 0) {
                                                    // Nếu có giá sale, sử dụng giá sale
                                                    $total = $item->product->price_sale * $item->quantity; 
                                                } else {
                                                    // Nếu không có giá sale, sử dụng giá thường
                                                    $total = $item->product->price_regular * $item->quantity; 
                                                }
                                            } elseif ($item->product && $item->productVariant) {
                                                // Nếu là sản phẩm biến thể, sử dụng giá biến thể
                                                $total = $item->productVariant->price_modifier * $item->quantity; 
                                            }

                                        @endphp
                                        <div class="product-total">
                                            <span class="text-muted">Thành tiền</span>
                                            <div class="fw-bold">{{ number_format($total, 0, ',', '.') }} ₫</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                                
                            <div class="form-group">
                                <label class="order-comments">Ghi chú</label>
                                <textarea id="note" class="form-control" name="note" placeholder="Bạn có gì muốn dặn dò shop không ?" cols="30" rows="10"></textarea>
                            </div>
                    </li>
                </ul>
            </div>
            <!-- End .col-lg-8 -->

            <div class="col-lg-5">
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
                            @foreach ($cartCheckout as $key=> $value)
                            {{-- @php
                                /// đoạn lấy cartCheckout ở đâu
                            @endphp --}}
                            <tr>
                                <td class="product-col">
                                    <h3 class="product-title">
                                        {{ $value->product->name }}
                                        <span class="product-qty">× {{ $value->quantity }}</span>
                                        <input type="hidden" name="order_item[{{$key}}][product_id]" value="{{ $value->product_id }}"> 
                                        <input type="hidden" name="order_item[{{$key}}][product_variant_id]" value="{{ $value->product_variants_id}}">
                                        <input type="hidden" name="order_item[{{$key}}][quantity]" value="{{ $value->quantity}}">
                                        <input type="hidden" name="order_item[{{$key}}][price]" value="{{ $value->total_price}}">
                                        <input type="hidden" name="order_item[{{$key}}][id_cart]"  value="{{ $value->id}}">
                                    </h3>
                                </td>

                                @php
                                    $sub = $value->total_price ; // Ko nhân vs số lượng nữa
                                @endphp

                                <td class="price-col">
                                    <span>
                                        {{ number_format($sub, 0, ',', '.') }} ₫
                                    </span>
                                </td>
                            </tr>
                                @php
                                    $subTotal += $value->total_price;
                                    $quantity += $value->quantity
                                @endphp
                            @endforeach

                        </tbody>
                        <tfoot>
                            
                            <tr  style="border:none">
                                <td>
                                    <h4>Số lượng</h4>
                                </td>
                                <td class="quantity-col">
                                    <span class="quantity">×{{ $quantity }}</span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal" >
                                <td style="margin-top: 10px">
                                    <h4>Tổng phụ</h4>
                                </td>
                                <td class="price-col">
                                    <span>{{ number_format($subTotal, 0, ',', '.') }} ₫</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left">
                                    <h4>Vận chuyển</h4>
                                    
                                    <div class="form-group form-group-custom-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="radio-ship" value="30.000" checked onchange="updateTotal()">
                                            <label class="custom-control-label">Giao hàng nhanh (30.000 ₫)</label>
                                            {{-- 30K --}}
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-group -->

                                    <div class="form-group form-group-custom-control mb-0">
                                        <div class="custom-control custom-radio mb-0">
                                            <input type="radio" class="custom-control-input" name="radio-ship" value="15.000" onchange="updateTotal()">
                                            <label class="custom-control-label">Giao hàng tiết kiệm (15.000 ₫)</label>
                                            {{-- 15K --}}
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-group -->

                                    

                                    {{-- <form action="#">
                                     
                                        <button type="submit" class="btn btn-shop btn-update-total">
                                            Cập nhật tổng 
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                            <tr class="order-shipping">
                                <td class="text-left" colspan="2">
                                    <h4 class="m-b-sm">Phương thức thanh toán</h4>
                            
                                    <div class="form-group form-group-custom-control">
                                        <div class="custom-control custom-checkbox d-flex">
                                            <input 
                                                type="checkbox" 
                                                class="custom-control-input" 
                                                id="payment-online" 
                                                name="radio_pay" 
                                                value="online" 
                                                onclick="selectPayment(this)"
                                            />
                                            <label class="custom-control-label" for="payment-online">Thanh toán online</label>
                                        </div>
                                        <!-- End .custom-checkbox -->
                                    </div>
                                    <!-- End .form-group -->
                            
                                    <div class="form-group form-group-custom-control mb-0">
                                        <div class="custom-control custom-checkbox d-flex mb-0">
                                            <input 
                                                type="checkbox" 
                                                class="custom-control-input" 
                                                id="payment-cash" 
                                                name="radio_pay" 
                                                value="cash" 
                                                onclick="selectPayment(this)" 
                                                checked
                                            />
                                            <label class="custom-control-label" for="payment-cash">Thanh toán sau khi nhận hàng</label>
                                        </div>
                                        <!-- End .custom-checkbox -->
                                    </div>
                                    <!-- End .form-group -->
                                </td>
                            </tr>

                            <tr class="order-total">
                                <td>
                                    <h4>Tổng </h4>
                                </td>
                                <td>
                                    <b class="total-price"><span id="totalPriceDisplay" name="price">{{ number_format($subTotal, 0, ',', '.') }} ₫</span></b>
                                    <input type="hidden" name="price" id="totalAmountInput" value="{{ number_format($subTotal, 0, ',', '.') }} ₫">
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

                    <input type="hidden" name="price" id="totalAmountInput" value="{{ number_format($subTotal, 0, ',', '.') }} ₫">
                    <button type="submit" class="btn btn-dark btn-place-order" form="checkout-form">
                        Đặt hàng
                    </button>
                </form>
                </div>
                <!-- End .cart-summary -->
            </div>
            <!-- End .col-lg-4 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

 
</main>



@endsection
    

@section('script_libray')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
    
@section('scripte_logic')
<script>
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
// Cập nhật giá tiền khi chọn radio
function updateTotal() {
    // Lấy giá trị subtotal từ server
    const subtotal = parseFloat('{{ $subTotal }}');

    // Lấy giá trị của phí vận chuyển được chọn và chuyển sang dạng số
    const shippingCost = parseFloat(
        document.querySelector('input[name="radio-ship"]:checked').value.replace(/\./g, '')
    );

    // Tính toán tổng tiền
    const total = subtotal + shippingCost;

    // Cập nhật hiển thị tổng tiền với định dạng tiền Việt Nam
    document.getElementById('totalPriceDisplay').textContent = `${total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.')} ₫`;
    document.getElementById('totalAmountInput').value = total; // Cập nhật giá trị hidden input
}

// Gọi hàm updateTotal() khi trang được tải
document.addEventListener('DOMContentLoaded', function () {
    updateTotal();
});
// End

// Hiện modal cập nhật địa chỉ
document.addEventListener('DOMContentLoaded', function() {
    const btnEdit = document.getElementById('btnEdit');
    const btnBack = document.getElementById('btnBack');
    const btnHuy = document.getElementById('btnHuy');
    const addressContent = document.getElementById('address-content');
    const updateAddressForm = document.getElementById('update-address-form');

    // Nút cập nhật địa chỉ
    document.getElementById('btnEditAddress').addEventListener('click', function() {
        document.getElementById('editAddressModalLabel').innerText = "Cập Nhật Địa Chỉ"; // Thay đổi tiêu đề
        addressContent.style.display = 'none';
        updateAddressForm.style.display = 'block';

        btnEdit.textContent = 'Xác nhận';
        btnBack.style.display = 'inline-block';
        btnHuy.style.display = 'none';
    });

    // Nút trở lại
    btnBack.addEventListener('click', function() {
        addressContent.style.display = 'block';
        updateAddressForm.style.display = 'none';

        btnEdit.textContent = 'Xác nhận';
        btnBack.style.display = 'none';
        btnHuy.style.display = 'inline-block';
    });

    // Đặt chế độ mặc định là "Hủy" và "Xác nhận" khi mở modal
    $('#editAddressModal').on('show.bs.modal', function() {
        document.getElementById('editAddressModalLabel').innerText = "Địa Chỉ Của Tôi"; // Khôi phục tiêu đề
        addressContent.style.display = 'block';
        updateAddressForm.style.display = 'none';

        btnEdit.textContent = 'Xác nhận';
        btnBack.style.display = 'none';
        btnHuy.style.display = 'inline-block';
    });
});


// Modal thêm mới địa chỉ
document.addEventListener("DOMContentLoaded", function () {
    const btnAddAddress = document.getElementById('btnAddAddress');
    const addAddressForm = document.getElementById('new-address-form');
    const updateAddressForm = document.getElementById('update-address-form');
    const btnAdd = document.getElementById('btnAdd');
    const btnBack = document.getElementById('btnBack');
    const btnHuy = document.getElementById('btnHuy');

    // Nút thêm địa chỉ mới
    btnAddAddress.addEventListener('click', function () {
        // Hiển thị form thêm địa chỉ và ẩn form cập nhật
        addAddressForm.style.display = 'block';
        updateAddressForm.style.display = 'none';
        document.getElementById('addAddressModalLabel').innerText = "Thêm địa chỉ mới";

        // Cập nhật trạng thái nút
        btnAdd.textContent = 'Thêm địa chỉ';
        btnBack.style.display = 'inline-block';
        btnHuy.style.display = 'none';
    });

    // Nút trở lại
    btnBack.addEventListener('click', function () {
        // Ẩn form thêm và quay lại trang hiển thị địa chỉ
        addAddressForm.style.display = 'none';
        updateAddressForm.style.display = 'none';
        btnBack.style.display = 'none';
        btnHuy.style.display = 'inline-block';
    });
});


// Lấy danh sách các tỉnh thành phố, quận huyện, xã phường cho thêm và cập nhật
document.addEventListener("DOMContentLoaded", function () {
    // Elements for the update form
    const updateCitySelect = document.querySelector("#updateLocation[name='city']");
    const updateDistrictSelect = document.querySelector("#updateLocation[name='district']");
    const updateWardSelect = document.querySelector("#updateLocation[name='ward']");

    // Elements for the add form
    const newCitySelect = document.querySelector("#newCity");
    const newDistrictSelect = document.querySelector("#newDistrict");
    const newWardSelect = document.querySelector("#newWard");

    // Disable district and ward selects initially
    [updateDistrictSelect, updateWardSelect, newDistrictSelect, newWardSelect].forEach(select => {
        select.disabled = true;
    });

    // Function to fetch and populate cities
    function getCities(selectElement) {
        fetch("https://provinces.open-api.vn/api/p/")
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = '<option value="">Tỉnh/Thành phố</option>';
                data.forEach(city => {
                    selectElement.innerHTML += `<option value="${city.code}">${city.name}</option>`;
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }

    // Function to fetch districts based on selected city
    function getDistricts(cityCode, districtSelect, wardSelect) {
        fetch(`https://provinces.open-api.vn/api/p/${cityCode}?depth=2`)
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                data.districts.forEach(district => {
                    districtSelect.innerHTML += `<option value="${district.code}">${district.name}</option>`;
                });
                districtSelect.disabled = false;
                wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                wardSelect.disabled = true;
            })
            .catch(error => console.error('Error fetching districts:', error));
    }

    // Function to fetch wards based on selected district
    function getWards(districtCode, wardSelect) {
        fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
            .then(response => response.json())
            .then(data => {
                wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                data.wards.forEach(ward => {
                    wardSelect.innerHTML += `<option value="${ward.code}">${ward.name}</option>`;
                });
                wardSelect.disabled = false;
            })
            .catch(error => console.error('Error fetching wards:', error));
    }

    // Function to reset district and ward selects
    function resetDistrictAndWard(districtSelect, wardSelect) {
        districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
        districtSelect.disabled = true;
        wardSelect.disabled = true;
    }

    // Load cities into both forms on page load
    getCities(updateCitySelect);
    getCities(newCitySelect);

    // Event listeners for city selection in update form
    updateCitySelect.addEventListener("change", function () {
        const cityCode = this.value;
        if (cityCode) {
            getDistricts(cityCode, updateDistrictSelect, updateWardSelect);
        } else {
            resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
        }
    });

    // Event listener for district selection in update form
    updateDistrictSelect.addEventListener("change", function () {
        const districtCode = this.value;
        if (districtCode) {
            getWards(districtCode, updateWardSelect);
        } else {
            resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
        }
    });

    // Event listeners for city selection in add form
    newCitySelect.addEventListener("change", function () {
        const cityCode = this.value;
        if (cityCode) {
            getDistricts(cityCode, newDistrictSelect, newWardSelect);
        } else {
            resetDistrictAndWard(newDistrictSelect, newWardSelect);
        }
    });

    // Event listener for district selection in add form
    newDistrictSelect.addEventListener("change", function () {
        const districtCode = this.value;
        if (districtCode) {
            getWards(districtCode, newWardSelect);
        } else {
            resetDistrictAndWard(newDistrictSelect, newWardSelect);
        }
    });

    // Reset form data when the modals are closed
    $('#update-address-form').on('hidden.bs.modal', function () {
        resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
    });

    $('#addAddressModal').on('hidden.bs.modal', function () {
        resetDistrictAndWard(newDistrictSelect, newWardSelect);
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const newCitySelect = document.querySelector("#newCity");
    const newDistrictSelect = document.querySelector("#newDistrict");
    const newWardSelect = document.querySelector("#newWard");
    const newAddressInput = document.querySelector("#newAddress");

    // Disable district and ward selects initially
    newDistrictSelect.disabled = true;
    newWardSelect.disabled = true;

    // Function to update address input
    function updateAddressInput() {
        const city = newCitySelect.options[newCitySelect.selectedIndex].text;
        const district = newDistrictSelect.options[newDistrictSelect.selectedIndex].text;
        const ward = newWardSelect.options[newWardSelect.selectedIndex].text;

        // Check if all selections are made
        if (city && district && ward) {
            newAddressInput.value = `${ward}, ${district}, ${city}`;
        } else {
            newAddressInput.value = ''; // Clear the input if not all are selected
        }
    }

    // Event listeners for city selection
    newCitySelect.addEventListener("change", function () {
        const cityCode = this.value;
        if (cityCode) {
            // Fetch districts based on selected city
            getDistricts(cityCode, newDistrictSelect, newWardSelect);
        } else {
            resetDistrictAndWard(newDistrictSelect, newWardSelect);
            updateAddressInput(); // Clear input if no city is selected
        }
    });

    // Event listener for district selection
    newDistrictSelect.addEventListener("change", function () {
        const districtCode = this.value;
        if (districtCode) {
            // Fetch wards based on selected district
            getWards(districtCode, newWardSelect);
        } else {
            resetWard(newWardSelect);
            updateAddressInput(); // Clear input if no district is selected
        }
    });

    // Event listener for ward selection
    newWardSelect.addEventListener("change", updateAddressInput);

    // Function to reset district and ward selects
    function resetDistrictAndWard(districtSelect, wardSelect) {
        districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
        districtSelect.disabled = true;
        wardSelect.disabled = true;
    }

    // Function to reset ward selects only
    function resetWard(wardSelect) {
        wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
        wardSelect.disabled = true;
    }

    // Fetch cities on page load
    getCities(newCitySelect);
});

// Thêm address vào dữ liệu
document.addEventListener("DOMContentLoaded", function () {
    const addAddressForm = document.querySelector("#addAddressForm");
    const btnAdd = document.querySelector("#btnAdd");

    btnAdd.addEventListener("click", function () {
        // Lấy dữ liệu từ form
        const formData = new FormData(addAddressForm);

        // Gửi dữ liệu đến server thông qua AJAX
        fetch('addresses', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // alert('Thêm địa chỉ thành công!');
                // Tải lại trang để hiển thị địa chỉ mới
                location.reload(); // Tải lại trang
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra!');
        });
    });
});




</script>
@endsection