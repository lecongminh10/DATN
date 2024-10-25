@extends('client.layouts.app')

@section('style_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .stock-status1{
            border-radius:5px; 
            padding: 4px 6px;
            background-color: #de293a; 
            color: white;
            text-align: center;
            display: inline-block; /* Thay đổi display sang inline-block */
            width: 85px; /* Hoặc bất kỳ giá trị nào bạn muốn */
        }
        .stock-status2{
            border-radius:5px; 
            padding: 4px 6px;
            background-color: #29de2f; 
            color: white;
            text-align: center;
            display: inline-block; /* Thay đổi display sang inline-block */
            width: 85px; /* Hoặc bất kỳ giá trị nào bạn muốn */
        }

        .toast-message {
        position: fixed;
        top: 100px;
        right: 20px;
        background-color: #28a745; /* Màu xanh lá cây */
        color: white;
        padding: 15px;
        border-radius: 5px;
        z-index: 1000;
        transition: opacity 0.5s ease, transform 0.5s ease;
        }
    </style>
@endsection

@section('content')

<header class="header">
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
                                            <img src="assets/images/menu-banner-1.jpg" alt="Menu banner"
                                                class="product-promo">
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
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li class="float-right"><a href="https://1.envato.market/DdLk5" class="pl-5"
                            target="_blank">Buy Porto!</a></li>
                    <li class="float-right"><a href="#" class="pl-5">Special Offer!</a></li>
                </ul>
            </nav>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->

<main class="main">
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{  route('client') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Yêu thích
                        </li>
                    </ol>
                </div>
            </nav>

            <h1>Yêu thích</h1>
        </div>
    </div>

    <div class="container">
        <div class="wishlist-title">
            <h2 class="p-2">Danh sách yêu thích</h2>
        </div>
        <div class="wishlist-table-container">
            <table class="table table-wishlist mb-0">
                <thead>
                    <tr>
                        <th class="thumbnail-col"></th>
                        <th class="product-col">Sản phẩm</th>
                        <th class="price-col">Giá</th>
                        <th class="status-col">Trạng thái</th>
                        <th class="action-col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($wishLists->isEmpty())
                        <tr class="product-row">
                            <td colspan="5" class="text-center">
                                <h4>Bạn chưa có sản phẩm yêu thích</h3>
                            </td>
                        </tr>
                    @else
                        @foreach ($wishLists as $value)
                        <tr class="product-row">
                            <td>
                                <figure class="product-image-container">
                                    <a href="product.html" class="product-image">
                                        @php
                                            if ($value->productVariant && !empty($value->productVariant->variant_image)) {
                                                $url = $value->productVariant->variant_image; 
                                            } else {
                                                $mainImage = $value->product->getMainImage(); 
                                                $url = $mainImage ? $mainImage->image_gallery : 'default-image-path.jpg';
                                            }
                                        @endphp
                                    </a>

                                    <a href="javascript:void(0);" class="btn-remove icon-cancel" 
                                        title="Remove Product" data-id="{{ $value->id }}" 
                                        onclick="removeFromWishlist({{ $value->id }})"></a>
                                </figure>
                            </td>
                            <td>
                                <h5 class="product-title">
                                    <a href="product.html">{{ $value->product->name }}</a>
                                </h5>
                            </td>
                            <td class="price-box">
                                @if ($value->product && is_null($value->productVariant)) 
                                    @if (!is_null($value->product->price_sale) && $value->product->price_sale > 0) 
                                        {{ number_format($value->product->price_sale, 0, ',', '.') }} ₫
                                    @else
                                        {{ number_format($value->product->price_regular, 0, ',', '.') }} ₫
                                    @endif
                                @elseif ($value->product && $value->productVariant) 
                                    {{ number_format($value->productVariant->price_modifier, 0, ',', '.') }} ₫
                                @endif
                            </td>
                            <td>
                            @if ($value->product->stock == 0 )
                            <span class="stock-status1">Hết hàng</span>
                            @else
                            <span class="stock-status2">Còn hàng</span>
                            @endif
                                
                            </td>
                            <td class="">
                                <a href="{{ route('client.showProduct', $value->product->id) }}" class="btn btn-quickview mt-1 mt-md-0"
                                    title="">Xem</a>
                                <button 
                                    class="btn btn-dark btn-add-cart product-type-simple btn-shop" 
                                    data-product-id="{{ $value->product->id }}" 
                                    data-product-variant-id="{{ $productVariant->id ?? '' }}">
                                    Thêm vào giỏ hàng
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div><!-- End .cart-table-container -->

        {{-- Thông báo --}}
        <div id="customToast" class="toast-message" style="display: none;">
            Sản phẩm đã được thêm vào giỏ hàng!
        </div>

    </div><!-- End .container -->

</main><!-- End .main -->

@endsection

@section('script_libray')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection

@section('scripte_logic')

<script>
// Xóa khỏi wishlist
    function removeFromWishlist(wishlistId) {
        fetch(`/wishlist/${wishlistId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Tải lại trang nếu xóa thành công
            if (data.message === 'Wishlist item deleted successfully') {
                location.reload(); // Tải lại trang
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Xử lý lỗi nếu cần thiết, nhưng không hiển thị thông báo
        });
    }

    // Thêm vào cart
    $(document).ready(function() {
        $('.btn-add-cart').on('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

            // Lấy thông tin sản phẩm từ nút
            var productId = $(this).data('product-id'); // Lấy data-product-id
            var productVariantId = $(this).data('product-variant-id'); // Lấy data-product-variant-id
            var quantity = 1; // Hoặc lấy từ một input nếu cần

            $.ajax({
                url: '{{ route('addCart') }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    product_variants_id: productVariantId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}' // Đừng quên CSRF token
                },
                success: function(response) {
                    // Hiển thị thông báo thành công
                    $('#customToast').fadeIn(400).delay(2000).fadeOut(400);
                },
                error: function(xhr) {
                    // Xử lý lỗi nhưng không hiển thị thông báo
                    console.error('Có lỗi xảy ra:', xhr);
                }
            });
        });
    });

</script>

@endsection