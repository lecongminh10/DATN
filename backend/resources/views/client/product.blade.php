@extends('client.layouts.app')
@section('style_css')
    <style>
        /* .icon-wishlist-2 {
            color: #ccc; 
        }

        .icon-wishlist-filled {
            color: red; 
        } */

        /* .wishlist-modal {
        position: fixed;
        right: 20px;
        bottom: 20px;
        background-color: #333;
        color: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s, bottom 0.3s;
        }

        .wishlist-modal.show {
            opacity: 1;
            bottom: 40px;
        } */

        .cart-modal {
        position: fixed;
        right: 20px;
        top: 80px;
        background-color: #333;
        color: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s, bottom 0.3s;
        }

        .cart-modal.show {
            opacity: 1;
            bottom: 100px;
        }
    </style>
@endsection
@section('content')
    @php
        $allImages = [];
        $mainImage = null; // Biến tạm để lưu ảnh chính
        // Lặp qua các ảnh trong gallery
        foreach ($data->galleries as $gallery) {
            if (isset($gallery->image_gallery)) {
                // Nếu ảnh là chính, lưu vào biến tạm
                if ($gallery->is_main) {
                    // Chỉ lưu ảnh chính một lần và không thêm vào mảng ở đây
                    $mainImage = $gallery->image_gallery;
                } else {
                    // Thêm các ảnh khác vào mảng
                    $allImages[] = $gallery->image_gallery;
                }
            }
        }
        // Nếu có ảnh chính, thêm vào vị trí 0 của mảng
        if ($mainImage !== null) {
            array_unshift($allImages, $mainImage);
        }
        foreach ($data->variants as $variant) {
            if (isset($variant->variant_image)) {
                $allImages[] = $variant->variant_image;
            }
        }


    @endphp
    <header class="header">
        <div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': false}">
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
                            </div>
                            <!-- End .megamenu -->
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
                                    </div>
                                    <!-- End .col-lg-4 -->

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
                                    </div>
                                    <!-- End .col-lg-4 -->

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
                                    </div>
                                    <!-- End .col-lg-4 -->
                                </div>
                                <!-- End .row -->
                            </div>
                            <!-- End .megamenu -->
                        </li>
                        <li>
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
            </div>
            <!-- End .container -->
        </div>
        <!-- End .header-bottom -->
    </header>
    <main class="main">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                </ol>
            </nav>

            <div class="product-single-container product-single-default">
                {{-- <div class="cart-message d-none">
                    <strong class="single-cart-notice">“Men Black Sports Shoes”</strong>
                    <span>has been added to your cart.</span>
                </div> --}}

                <div class="row">
                    <div class="col-lg-5 col-md-6 product-single-gallery">
                        <div class="product-slider-container">
                            <div class="label-group">
                                {{-- <div class="product-label label-hot">HOT</div> --}}

                                {{-- <div class="product-label label-sale">
                                    -16%
                                </div> --}}
                            </div>

                            <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                @foreach ($allImages as $item)
                                    <div class="product-item">
                                        <img class="product-single-image" src="{{ \Storage::url($item) }}"
                                            data-zoom-image="{{ \Storage::url($item) }}" width="468" height="468"
                                            alt="product" />
                                    </div>
                                @endforeach
                            </div>
                            <!-- End .product-single-carousel -->
                            <span class="prod-full-screen">
                                <i class="icon-plus"></i>
                            </span>
                        </div>

                        <div class="prod-thumbnail owl-dots">
                            @foreach ($allImages as $item)
                                <div class="owl-dot">
                                    <img src="{{ \Storage::url($item) }}" width="110" height="110"
                                        alt="product-thumbnail" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- End .product-single-gallery -->

                    <div class="col-lg-7 col-md-6 product-single-details">
                        <h1 class="product-title">{{ $data->name }}</h1>

                        <div class="product-nav">
                            <div class="product-prev">
                                <a href="#">
                                    <span class="product-link"></span>

                                    <span class="product-popup">
                                        <span class="box-content">
                                            <img alt="product" width="150" height="150"
                                                src="assets/images/products/product-3.jpg" style="padding-top: 0px;">

                                            <span>Circled Ultimate 3D Speaker</span>
                                        </span>
                                    </span>
                                </a>
                            </div>

                            <div class="product-next">
                                <a href="#">
                                    <span class="product-link"></span>

                                    <span class="product-popup">
                                        <span class="box-content">
                                            <img alt="product" width="150" height="150"
                                                src="assets/images/products/product-4.jpg" style="padding-top: 0px;">

                                            <span>Blue Backpack for the Young</span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:60%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <!-- End .product-ratings -->

                            <a href="#" class="rating-link">( 6 Reviews )</a>
                        </div>
                        <!-- End .ratings-container -->

                        <hr class="short-divider">

                        <div class="price-box">
                            @if ($data->price_sale == null)
                                <span class="new-price">{{ number_format($data->price_regular, 0, ',', '.') }} ₫</span>
                            
                            @else
                                <span class="old-price">{{ number_format($data->price_regular, 0, ',', '.') }} ₫</span>
                                <span class="new-price">{{ number_format($data->price_sale, 0, ',', '.') }} ₫</span>
                            @endif
                        </div>
                        <!-- End .price-box -->

                        <div class="product-desc">
                            <p>
                                {{ $data->short_description }}
                            </p>
                        </div>
                        <!-- End .product-desc -->

                        <ul class="single-info-list">

                            <li>
                                SKU: <strong> {{ $data->code }}</strong>
                            </li>

                            <li>
                                CATEGORY: <strong><a href="#"
                                        class="product-category">{{ $data->category->name }}</a></strong>
                            </li>

                            <li>
                                TAGs: <strong><a href="#" class="product-category">CLOTHES</a></strong>,
                                <strong><a href="#" class="product-category">SWEATER</a></strong>
                            </li>
                            @foreach ($attribute as $item)
                                <div class="product-filters-container">
                                    <div class="product-single-filter">
                                        <label class="fw-bold">{{ $item->attribute_name }}:</label>
                                        <ul class="config-size-list config-color-list config-filter-list list-unstyled">
                                            @foreach ($item->attributeValues as $value)
                                                @if ($data->variants->contains('product_attribute_id', $value->id))
                                                    <li class="mb-1"> 
                                                        <a href="javascript:;"
                                                            class="d-flex align-items-center justify-content-center">
                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-bs-placement="top" title="Out of Stock">
                                                                {{ $value->attribute_value }}
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                        </ul>

                        <div class="product-action">
                            <div class="product-single-qty">
                                <input class="horizontal-quantity form-control" type="text">
                            </div>
                            <!-- End .product-single-qty -->

                            <a href="javascript:;" class="btn btn-dark add-cart mr-2" 
                            data-product-id="{{ $data->id }}" 
                            data-product-variant-id="{{ $data->product_variant_id }}"
                            data-quantity="1" 
                            id="cart-toggle" 
                            title="Add to Cart">Add to Cart</a>

                            <a href="{{ route('shopping-cart') }}" class="btn btn-gray view-cart d-none">View cart</a>
                        </div>
                        <!-- End .product-action -->

                        <hr class="divider mb-0 mt-0">

                        <div class="product-single-share mb-3">
                            <label class="sr-only">Share:</label>

                            <div class="social-icons mr-2">
                                <a href="#" class="social-icon social-facebook icon-facebook" target="_blank"
                                    title="Facebook"></a>
                                <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"
                                    title="Twitter"></a>
                                <a href="#" class="social-icon social-linkedin fab fa-linkedin-in" target="_blank"
                                    title="Linkedin"></a>
                                <a href="#" class="social-icon social-gplus fab fa-google-plus-g" target="_blank"
                                    title="Google +"></a>
                                <a href="#" class="social-icon social-mail icon-mail-alt" target="_blank"
                                    title="Mail"></a>
                            </div>
                            <!-- End .social-icons -->

                            <a href="javascript:void(0);" class="btn-icon-wish add-wishlist" title="Add to Wishlist" 
                                data-product-id="{{ $data->id }}" 
                                data-product-variant-id="{{ $data->product_variant_id }}"
                                id="wishlist-toggle">
                                <i class="icon-wishlist-2" id="wishlist-icon"></i>
                                <span id="wishlist-text">Add to Wishlist</span>
                            </a>
                        </div>
                        <!-- End .product single-share -->
                    </div>
                    <!-- End .product-single-details -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .product-single-container -->

            <div class="product-single-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content"
                            role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="product-tab-size" data-toggle="tab" href="#product-size-content"
                            role="tab" aria-controls="product-size-content" aria-selected="true">Size Guide</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content"
                            role="tab" aria-controls="product-tags-content" aria-selected="false">Additional
                            Information</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content"
                            role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews (1)</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                        aria-labelledby="product-tab-desc">
                        <div class="product-desc-content">
                            <p>{{ $data->content }}</p>
                        </div>
                        <!-- End .product-desc-content -->
                    </div>
                    <!-- End .tab-pane -->

                    <div class="tab-pane fade" id="product-size-content" role="tabpanel"
                        aria-labelledby="product-tab-size">
                        <div class="product-size-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('themeclient/assets/images/products/single/body-shape.png') }}" alt="body shape"
                                        width="217" height="398">
                                </div>
                                <!-- End .col-md-4 -->

                                <div class="col-md-8">
                                    <table class="table table-size">
                                        <thead>
                                            <tr>
                                                <th>SIZE</th>
                                                <th>CHEST(in.)</th>
                                                <th>WAIST(in.)</th>
                                                <th>HIPS(in.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>XS</td>
                                                <td>34-36</td>
                                                <td>27-29</td>
                                                <td>34.5-36.5</td>
                                            </tr>
                                            <tr>
                                                <td>S</td>
                                                <td>36-38</td>
                                                <td>29-31</td>
                                                <td>36.5-38.5</td>
                                            </tr>
                                            <tr>
                                                <td>M</td>
                                                <td>38-40</td>
                                                <td>31-33</td>
                                                <td>38.5-40.5</td>
                                            </tr>
                                            <tr>
                                                <td>L</td>
                                                <td>40-42</td>
                                                <td>33-36</td>
                                                <td>40.5-43.5</td>
                                            </tr>
                                            <tr>
                                                <td>XL</td>
                                                <td>42-45</td>
                                                <td>36-40</td>
                                                <td>43.5-47.5</td>
                                            </tr>
                                            <tr>
                                                <td>XXL</td>
                                                <td>45-48</td>
                                                <td>40-44</td>
                                                <td>47.5-51.5</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End .row -->
                        </div>
                        <!-- End .product-size-content -->
                    </div>
                    <!-- End .tab-pane -->

                    <div class="tab-pane fade" id="product-tags-content" role="tabpanel"
                        aria-labelledby="product-tab-tags">
                        <table class="table table-striped mt-2">
                            <tbody>
                                <tr>
                                    <th>Weight</th>
                                    <td>23 kg</td>
                                </tr>

                                <tr>
                                    <th>Dimensions</th>
                                    <td>12 × 24 × 35 cm</td>
                                </tr>

                                <tr>
                                    <th>Color</th>
                                    <td>Black, Green, Indigo</td>
                                </tr>

                                <tr>
                                    <th>Size</th>
                                    <td>Large, Medium, Small</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- End .tab-pane -->

                    <div class="tab-pane fade" id="product-reviews-content" role="tabpanel"
                        aria-labelledby="product-tab-reviews">
                        <div class="product-reviews-content">
                            <h3 class="reviews-title">1 review for Men Black Sports Shoes</h3>

                            <div class="comment-list">
                                <div class="comments">
                                    <figure class="img-thumbnail">
                                        <img src="assets/images/blog/author.jpg" alt="author" width="80"
                                            height="80">
                                    </figure>

                                    <div class="comment-block">
                                        <div class="comment-header">
                                            <div class="comment-arrow"></div>

                                            <div class="ratings-container float-sm-right">
                                                <div class="product-ratings">
                                                    <span class="ratings" style="width:60%"></span>
                                                    <!-- End .ratings -->
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <!-- End .product-ratings -->
                                            </div>

                                            <span class="comment-by">
                                                <strong>Joe Doe</strong> – April 12, 2018
                                            </span>
                                        </div>

                                        <div class="comment-content">
                                            <p>Excellent.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="add-product-review">
                                <h3 class="review-title">Add a review</h3>

                                <form action="#" class="comment-form m-0">
                                    <div class="rating-form">
                                        <label for="rating">Your rating <span class="required">*</span></label>
                                        <span class="rating-stars">
                                            <a class="star-1" href="#">1</a>
                                            <a class="star-2" href="#">2</a>
                                            <a class="star-3" href="#">3</a>
                                            <a class="star-4" href="#">4</a>
                                            <a class="star-5" href="#">5</a>
                                        </span>

                                        <select name="rating" id="rating" required="" style="display: none;">
                                            <option value="">Rate…</option>
                                            <option value="5">Perfect</option>
                                            <option value="4">Good</option>
                                            <option value="3">Average</option>
                                            <option value="2">Not that bad</option>
                                            <option value="1">Very poor</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Your review <span class="required">*</span></label>
                                        <textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>
                                    </div>
                                    <!-- End .form-group -->


                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="form-group">
                                                <label>Name <span class="required">*</span></label>
                                                <input type="text" class="form-control form-control-sm" required>
                                            </div>
                                            <!-- End .form-group -->
                                        </div>

                                        <div class="col-md-6 col-xl-12">
                                            <div class="form-group">
                                                <label>Email <span class="required">*</span></label>
                                                <input type="text" class="form-control form-control-sm" required>
                                            </div>
                                            <!-- End .form-group -->
                                        </div>

                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="save-name" />
                                                <label class="custom-control-label mb-0" for="save-name">Save my
                                                    name, email, and website in this browser for the next time I
                                                    comment.</label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </form>
                            </div>
                            <!-- End .add-product-review -->
                        </div>
                        <!-- End .product-reviews-content -->
                    </div>
                    <!-- End .tab-pane -->
                </div>
                <!-- End .tab-content -->
            </div>
            <!-- End .product-single-tabs -->

            <div class="products-section pt-0">
                <h2 class="section-title">Related Products</h2>

                <div class="products-slider owl-carousel owl-theme dots-top dots-small">
                    <div class="product-default">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/product-1.jpg') }}" width="280" height="280"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/product-1-2.jpg') }}" width="280" height="280"
                                    alt="product">
                            </a>
                            <div class="label-group">
                                <div class="product-label label-hot">HOT</div>
                                <div class="product-label label-sale">-20%</div>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="category-list">
                                <a href="category.html" class="product-category">Category</a>
                            </div>
                            <h3 class="product-title">
                                <a href="product.html">Ultimate 3D Bluetooth Speaker</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:80%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->
                            <div class="price-box">
                                <del class="old-price">$59.00</del>
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="wishlist.html" title="Wishlist" class="btn-icon-wish"><i
                                        class="icon-heart"></i></a>
                                <a href="product.html" class="btn-icon btn-add-cart"><i
                                        class="fa fa-arrow-right"></i><span>SELECT
                                        OPTIONS</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/product-3.jpg') }}" width="280" height="280"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/product-3-2.jpg') }}" width="280" height="280"
                                    alt="product">
                            </a>
                            <div class="label-group">
                                <div class="product-label label-hot">HOT</div>
                                <div class="product-label label-sale">-20%</div>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="category-list">
                                <a href="category.html" class="product-category">Category</a>
                            </div>
                            <h3 class="product-title">
                                <a href="product.html">Circled Ultimate 3D Speaker</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:80%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->
                            <div class="price-box">
                                <del class="old-price">$59.00</del>
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="wishlist.html" title="Wishlist" class="btn-icon-wish"><i
                                        class="icon-heart"></i></a>
                                <a href="product.html" class="btn-icon btn-add-cart"><i
                                        class="fa fa-arrow-right"></i><span>SELECT
                                        OPTIONS</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/product-7.jpg') }}" width="280" height="280"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/product-7-2.jpg') }}" width="280" height="280"
                                    alt="product">
                            </a>
                            <div class="label-group">
                                <div class="product-label label-hot">HOT</div>
                                <div class="product-label label-sale">-20%</div>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="category-list">
                                <a href="category.html" class="product-category">Category</a>
                            </div>
                            <h3 class="product-title">
                                <a href="product.html">Brown-Black Men Casual Glasses</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:80%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->
                            <div class="price-box">
                                <del class="old-price">$59.00</del>
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="wishlist.html" title="Wishlist" class="btn-icon-wish"><i
                                        class="icon-heart"></i></a>
                                <a href="product.html" class="btn-icon btn-add-cart"><i
                                        class="fa fa-arrow-right"></i><span>SELECT
                                        OPTIONS</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/product-6.jpg') }}" width="280" height="280"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/product-6-2.jpg') }}" width="280" height="280"
                                    alt="product">
                            </a>
                            <div class="label-group">
                                <div class="product-label label-hot">HOT</div>
                                <div class="product-label label-sale">-20%</div>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="category-list">
                                <a href="category.html" class="product-category">Category</a>
                            </div>
                            <h3 class="product-title">
                                <a href="product.html">Men Black Gentle Belt</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:80%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->
                            <div class="price-box">
                                <del class="old-price">$59.00</del>
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="wishlist.html" title="Wishlist" class="btn-icon-wish"><i
                                        class="icon-heart"></i></a>
                                <a href="product.html" class="btn-icon btn-add-cart"><i
                                        class="fa fa-arrow-right"></i><span>SELECT
                                        OPTIONS</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/product-4.jpg') }}') }}" width="280" height="280"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/product-4-2.jpg') }}') }}" width="280" height="280"
                                    alt="product">
                            </a>
                            <div class="label-group">
                                <div class="product-label label-hot">HOT</div>
                                <div class="product-label label-sale">-20%</div>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="category-list">
                                <a href="category.html" class="product-category">Category</a>
                            </div>
                            <h3 class="product-title">
                                <a href="product.html">Blue Backpack for the Young - S</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:80%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->
                            <div class="price-box">
                                <del class="old-price">$59.00</del>
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="wishlist.html" title="Wishlist" class="btn-icon-wish"><i
                                        class="icon-heart"></i></a>
                                <a href="product.html" class="btn-icon btn-add-cart"><i
                                        class="fa fa-arrow-right"></i><span>SELECT
                                        OPTIONS</span></a>
                                <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        <!-- End .product-details -->
                    </div>
                </div>
                <!-- End .products-slider -->
            </div>
            <!-- End .products-section -->

            <hr class="mt-0 m-b-5" />

            <div class="product-widgets-container row pb-2">
                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title">Featured Products</h4>
                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-1.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-1-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Ultimate 3D Bluetooth Speaker</a>
                            </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-2.jpg') }}') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-2-2.jpg') }}') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Brown Women Casual HandBag</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top">5.00</span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-3.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-3-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Circled Ultimate 3D Speaker</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title">Best Selling Products</h4>
                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-4.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-4-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Blue Backpack for the Young - S</a>
                            </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top">5.00</span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-5.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-5-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Casual Spring Blue Shoes</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-6.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-6-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Men Black Gentle Belt</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top">5.00</span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title">Latest Products</h4>
                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-7.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-7-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Men Black Sports Shoes</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-8.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-8-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Brown-Black Men Casual Glasses</a>
                            </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top">5.00</span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-9.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-9-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Black Men Casual Glasses</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 pb-5 pb-md-0">
                    <h4 class="section-sub-title">Top Rated Products</h4>
                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-10.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-10-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Basketball Sports Blue Shoes</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-11.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-11-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Men Sports Travel Bag</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top">5.00</span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>

                    <div class="product-default left-details product-widget">
                        <figure>
                            <a href="product.html">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-12.jpg') }}" width="74" height="74"
                                    alt="product">
                                <img src="{{ asset('themeclient/assets/images/products/small/product-12-2.jpg') }}" width="74" height="74"
                                    alt="product">
                            </a>
                        </figure>

                        <div class="product-details">
                            <h3 class="product-title"> <a href="product.html">Brown HandBag</a> </h3>

                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->
                            </div>
                            <!-- End .product-container -->

                            <div class="price-box">
                                <span class="product-price">$49.00</span>
                            </div>
                            <!-- End .price-box -->
                        </div>
                        <!-- End .product-details -->
                    </div>
                </div>
            </div>
            <!-- End .row -->
        </div>
        <!-- End .container -->
    </main>
    <!-- End .main -->

    {{-- <!-- Modal thông báo thêm vào wishlist -->
    <div id="wishlist-add-modal" class="wishlist-modal" style="display: none;">
        <div class="modal-content">
            <p>Sản phẩm đã được thêm vào danh sách yêu thích!</p>
        </div>
    </div>

    <!-- Modal thông báo xóa khỏi wishlist -->
    <div id="wishlist-remove-modal" class="wishlist-modal" style="display: none;">
        <div class="modal-content">
            <p>Sản phẩm đã bị xóa khỏi danh sách yêu thích!</p>
        </div>
    </div> --}}
    <!-- Modal thông báo thêm vào giỏ hàng -->
    <div id="cart-add-modal" class="cart-modal" style="display: none;">
        <div class="modal-content">
            <p>Sản phẩm đã được thêm vào giỏ hàng!</p>
        </div>
    </div>
@endsection

@section('scripte_logic')
    <script>
        (function() {
            var js =
                "window['__CF$cv$params']={r:'820525e73bc48b57',t:'MTY5OTAyMDA3NC4zNDIwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/61b90d1d/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";
            var _0xh = document.createElement('iframe');
            _0xh.height = 1;
            _0xh.width = 1;
            _0xh.style.position = 'absolute';
            _0xh.style.top = 0;
            _0xh.style.left = 0;
            _0xh.style.border = 'none';
            _0xh.style.visibility = 'hidden';
            document.body.appendChild(_0xh);

            function handler() {
                var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;
                if (_0xi) {
                    var _0xj = _0xi.createElement('script');
                    _0xj.innerHTML = js;
                    _0xi.getElementsByTagName('head')[0].appendChild(_0xj);
                }
            }
            if (document.readyState !== 'loading') {
                handler();
            } else if (window.addEventListener) {
                document.addEventListener('DOMContentLoaded', handler);
            } else {
                var prev = document.onreadystatechange || function() {};
                document.onreadystatechange = function(e) {
                    prev(e);
                    if (document.readyState !== 'loading') {
                        document.onreadystatechange = prev;
                        handler();
                    }
                };
            }
        })();
    </script>
    
    <script>

        // Thêm cart
        document.addEventListener('DOMContentLoaded', function() {
        const cartToggle = document.getElementById('cart-toggle');

        cartToggle.addEventListener('click', function() {
            const productId = cartToggle.getAttribute('data-product-id');
            const productVariantId = cartToggle.getAttribute('data-product-variant-id');
            const quantity = cartToggle.getAttribute('data-quantity');

            // Gọi AJAX để thêm sản phẩm vào giỏ hàng
            $.ajax({
                type: "POST",
                url: "{{ route('addCart') }}", // Thay bằng route tương ứng
                data: {
                    product_id: productId,
                    product_variants_id: productVariantId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}' // CSRF token
                },
                success: function(response) {
                    // Hiển thị thông báo thêm vào giỏ hàng thành công hoặc xử lý UI nếu cần
                    showCartModal(); // Gọi hàm hiển thị modal (tương tự như wishlist)
                    // location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        // alert('You need to be logged in to add items to your cart.'); // Bỏ thông báo nếu không cần thiết
                    } else {
                        // alert('An error occurred. Please try again.'); // Bỏ thông báo nếu không cần thiết
                    }
                }
            });
        });

        function showCartModal() {
            // Hiển thị modal thông báo thêm vào giỏ hàng thành công
            const cartModal = document.getElementById('cart-add-modal');
            cartModal.classList.add('show');
            setTimeout(function() {
                cartModal.classList.remove('show');
            }, 3000); // Modal sẽ tự động ẩn sau 3 giây
        }
    });


        // Thêm wishlist
        document.addEventListener('DOMContentLoaded', function() {
        const wishlistToggle = document.getElementById('wishlist-toggle');
        const wishlistIcon = document.getElementById('wishlist-icon');
        const wishlistAddModal = document.getElementById('wishlist-add-modal');
        const wishlistRemoveModal = document.getElementById('wishlist-remove-modal');

        wishlistToggle.addEventListener('click', function() {
            const productId = wishlistToggle.getAttribute('data-product-id');
            const productVariantId = wishlistToggle.getAttribute('data-product-variant-id');

            // Gọi AJAX để thêm hoặc xóa sản phẩm khỏi wishlist
            $.ajax({
                type: "POST",
                url: "{{ route('addWishList') }}",
                data: {
                    product_id: productId,
                    product_variants_id: productVariantId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.in_wishlist) {
                        wishlistIcon.style.color = 'red'; // Đổi màu trái tim thành đỏ
                        showModal(wishlistAddModal); // Hiển thị modal thêm
                    } else {
                        wishlistIcon.style.color = ''; // Đặt lại màu trái tim
                        showModal(wishlistRemoveModal); // Hiển thị modal xóa
                    }
                }
            });
        });

        function showModal(modal) {
            modal.classList.add('show');
            setTimeout(function() {
                modal.classList.remove('show');
            }, 3000); // Modal sẽ tự ẩn sau 3 giây
        }
    });

    </script>

    </body>
@endsection
