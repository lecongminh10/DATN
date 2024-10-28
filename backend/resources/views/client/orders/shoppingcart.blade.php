@extends('client.layouts.app')

@section('style_css')
    <style>
        .product-details {
            padding: 10px; /* Khoảng cách bên trong */
            margin-bottom: 15px; /* Khoảng cách giữa các sản phẩm */
            border-radius: 5px; /* Góc bo tròn */
        }

        .product-name {
            font-weight: bold; /* Làm đậm tên sản phẩm */
            font-size: 1em; /* Kích thước chữ lớn hơn */
            color: #333; /* Màu chữ */
        }

        .attribute-list {
            margin-top: 10px; /* Khoảng cách giữa tên sản phẩm và thuộc tính */
            padding-left: 15px; /* Khoảng cách bên trái cho thuộc tính */
        }
        .attribute-list p {
            margin-bottom: 0px !important;
        }
        .attribute-item {
            font-size: 0.9em; /* Kích thước chữ nhỏ hơn cho thuộc tính */
            color: #555; /* Màu chữ nhạt hơn */
        }

        .attribute-item strong {
            color: #000; /* Màu chữ cho tên thuộc tính */
        }
        .product-price {
            text-align: right; /* Aligns prices to the right */
        }

        .price-sale {
            color: #0088cc; /* Bootstrap Danger color for sale prices */
            font-weight: bold; /* Makes sale price bold */
            font-size: 11px !important; /* Slightly larger font for emphasis */
        }

        .price-original {
            color: #999; /* Light gray color for original prices */
            text-decoration: line-through; /* Adds a strikethrough effect */
            font-size: 10px !important; /* Regular size for original prices */
            margin-left: 10px; /* Adds space between sale and original prices */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-price {
                text-align: left; /* Align left on smaller screens */
            }
        }
        .product-title .product-details{
                padding-left: 10px;
            }
        .product-title .attribute-item {
                font-size: 12px !important;
                margin-bottom: 5px !important;
            }
        .product-title .text-muted{
                font-size: 12px !important;
            }
        .product-title .attribute-item strong {
                color: rgba(0, 0, 0, 0.6);
                font-weight: 300;
                font-size: 12px !important;
            }


    </style>
@endsection


@section('content')


<header class="header home">
    <div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': true}">
        <div class="container">
            {{-- <nav class="main-nav w-100">
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
            </nav> --}}
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header>

<main class="main">
    <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li class="active">
                <a href="{{ route('shopping-cart') }}">Shopping Cart</a>
            </li>
            <li>
                <a href="{{ route('checkout') }}">Checkout</a>
            </li>
            <li class="disabled">
                <a href="#">Order Complete</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-lg-9">
                <div class="cart-table-container">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th class="thumbnail-col"></th>
                                <th>Tên sản phẩm </th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $totalAmount = 0; 
                                $totalQuantity = 0; 
                            ?>
                            @foreach ($carts as $value)
                            <tr class="product-row">
                                <td>
                                    <figure class="product-image-container">
                                        <a href="{{route('client.showProduct',$value->product->id)}}" class="product-image">
                                            @php
                                                if ($value->productVariant && !empty($value->productVariant->variant_image)) {
                                                    $url = $value->productVariant->variant_image; 
                                                } else {
                                                    $mainImage = $value->product->getMainImage(); 
                                                    $url = $mainImage ? $mainImage->image_gallery : 'default-image-path.jpg';
                                                }
                                            @endphp
                                            <img src="{{ Storage::url($url) }}" alt="{{ $value->product->name }}">
                                        </a>
                        
                                        <a href="#" class="btn-remove icon-cancel" title="Remove Product" data-id="{{ $value->id }}" onclick="removeFromCart(this)"></a>
                                    </figure>
                                </td>
                                <td class="product-col">
                                    <h5 class="product-title">
                                        <a href="{{route('client.showProduct',$value->product->id)}}">
                                            @if ($value->productVariant)
                                                <div class="product-details">
                                                    <span class="product-name py-2">{{ $value->product->name }}</span>
                                                    <div class="text-muted">Loại: </div>
                                                    <div class="attribute-list">
                                                        @if ($value->productVariant->attributeValues)
                                                            @foreach ($value->productVariant->attributeValues as $attributeValue)
                                                                <p class="attribute-item">
                                                                    <strong>{{ $attributeValue->attribute->attribute_name }}:</strong> 
                                                                    <span>{{ $attributeValue->attribute_value }}</span>
                                                                </p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="product-name">{{ $value->product->name }}</span>
                                            @endif
                                        </a>
                                    </h5>
                                </td>
                                <td class="product-price">
                                    @if ($value->productVariant)
                                        @if (!empty($value->productVariant->price_modifier) && $value->productVariant->price_modifier!==null)
                                            <span class="">{{ number_format($value->productVariant->price_modifier, 0, ',', '.') }} đ</span>
                                            <del class="">{{ number_format($value->productVariant->original_price, 0, ',', '.') }} đ</del>
                                        @else
                                            <span class="">{{ number_format($value->productVariant->original_price, 0, ',', '.') }} đ</span>
                                        @endif
                                    @else
                                        @if (!empty($value->product->price_sale) && $value->product->price_sale!==null)
                                            <span class="">{{ number_format($value->product->price_sale, 0, ',', '.') }} đ</span>
                                            <del class="">{{ number_format($value->product->price_regular, 0, ',', '.') }} đ</del>
                                        @else
                                            <span class="">{{ number_format($value->product->price_regular, 0, ',', '.') }} đ</span>
                                        @endif
                                    @endif
                                </td>                
                                <td>
                                    <div class="product-single-qty">
                                        <input class="horizontal-quantity form-control" 
                                                type="number"
                                                min="1" 
                                                data-price="{{ $value->productVariant ? 
                                                                (!empty($value->productVariant->price_modifier) ? 
                                                                    $value->productVariant->price_modifier : 
                                                                    $value->productVariant->original_price) : 
                                                                ($value->product ? ($value->product->price_sale ?: $value->product->price_regular) : 0) }}"
                                                value="{{ $value->quantity }}"
                                                onchange="updateSubtotal(this)">
                                 
                                    </div>
                                </td>
                                <?php 
                                $price = 0;
                                $subTotal = 0;
                                
                                // Check if the product exists and if there's no product variant
                                if ($value->product && is_null($value->productVariant)) {
                                    $price = $value->product->price_regular; // Use regular price
                                    $subTotal = $price * $value->quantity; 
                                }
                                // Check if both product and product variant exist
                                elseif ($value->product && $value->productVariant) {
                                    $price = $value->productVariant->price_modifier ?? $value->productVariant->original_price; // Use price modifier if exists, else original price
                                    $subTotal = $price * $value->quantity; 
                                } else {
                                    $subTotal = 0; // Default to 0 if no product or variant
                                }
                                
                                $totalAmount += $subTotal; // Accumulate total amount
                                $totalQuantity += $value->quantity; // Accumulate total quantity
                                ?>
                                
                                <td class="text-right">
                                    <span class="subtotal-price">{{ number_format($subTotal, 0, ',', '.') }} đ</span>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>                        
                        <tfoot>
                            <tr>
                                <td colspan="5" class="clearfix">
                                    

                                    <div class="float-right">
                                        <button type="submit" class="btn btn-shop btn-update-cart">
                                            Cập nhật giỏ hàng
                                        </button>
                                    </div><!-- End .float-right -->
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- End .cart-table-container -->
            </div><!-- End .col-lg-8 -->

            <div class="col-lg-3">
                <div class="cart-summary">
                    <h3>Tổng giỏ hàng</h3>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p>Số lượng</p>
                            <p>Tổng giá</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <p>× {{ $totalQuantity }}</p>
                            <p>{{ number_format($totalAmount, 0, ',', '.') }} đ</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <td >Tổng cộng</td>
                            <?php $toTal = $totalAmount;?>
                            <span id="totalAmountDisplay" class="mx-3" style="padding-left:30px">{{ number_format($toTal, 0, ',', '.') }} đ</span>
                        </div>
                    </div>
                    <div class="checkout-methods">
                        <a href="{{ route('checkout') }}" class="btn btn-block btn-dark">Đến giỏ hàng
                            <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div><!-- End .cart-summary -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- margin -->
</main><!-- End .main -->

@endsection
    

@section('script_libray')
     
@endsection
    
@section('script_logic')
<script>
function updateSubtotal(inputElement) {
    const price = parseFloat(inputElement.getAttribute('data-price')) || 0;
    const quantity = parseInt(inputElement.value);
    const subTotal = price * quantity;
    function formatCurrency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ'; 
    }

    const subTotalElement = inputElement.closest('tr').querySelector('.subtotal-price');
    subTotalElement.textContent = formatCurrency(subTotal); 
}


// Xóa khỏi giỏ hàng
function removeFromCart(element) {
    const cartId = element.getAttribute('data-id'); // Lấy ID của sản phẩm từ data-id

    // Gửi yêu cầu xóa sản phẩm
    fetch(`remove/${cartId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token
        },
    })
    .then(response => {
        if (response.ok) {
            // Xóa hàng ra khỏi DOM
            const row = element.closest('tr'); // Tìm dòng sản phẩm tương ứng
            row.remove(); // Xóa dòng sản phẩm khỏi bảng
        } else {
            alert('Có lỗi xảy ra khi xóa sản phẩm');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Update cart
document.querySelector('.btn-update-cart').addEventListener('click', function() {
        const cartItems = [];
        
        document.querySelectorAll('.product-row').forEach(row => {
            const id = row.querySelector('.btn-remove').getAttribute('data-id'); // Lấy ID sản phẩm
            const quantity = row.querySelector('.horizontal-quantity').value; // Lấy số lượng

            cartItems.push({ id, quantity }); // Đưa vào mảng cartItems
        });

        // Gửi yêu cầu cập nhật
        fetch('update-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token
            },
            body: JSON.stringify({ cartItems }) // Gửi mảng cartItems
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // alert(data.message); // Hiển thị thông báo thành công
                location.reload(); // Tải lại trang để cập nhật giỏ hàng
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });


</script>
@endsection