@extends('client.layouts.app')
@section('style_css')
    <style>
        .related-products {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-top: 20px;
        }

        .related-products h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .product-default {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .product-details {
            width: 100%;
            max-width: 300px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-details:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-title {
            font-size: 1.1em;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        .product-title a {
            color: #333;
            text-decoration: none;
        }

        .product-title a:hover {
            color: #08c;
        }

        .price-box {
            text-align: center;
            margin: 10px 0;
        }

        .new-price {
            font-weight: bold;
            color: #08c;
            font-size: 1.2em;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            margin-left: 10px;
        }

        .product-action {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .product-action a {
            text-decoration: none;
            color: #333;
            font-size: 1.2em;
            transition: color 0.3s ease;
        }

        .product-action a:hover {
            color: #08c;
        }

        .btn-add-cart {
            background: #08c;
            color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            text-transform: uppercase;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-add-cart:hover {
            background: #0056b3;
            color: #fff;
        }

        .view-detail {
            border: none;
            background: transparent;
            color: #08c;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .view-detail:hover {
            color: #0056b3;
        }
    </style>
@endsection
@section('content')
    @include('client.layouts.nav')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-1">
                    <article class="post single">
                        <div class="post-media" style="width: 550px; height: 550px;">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }} " style="width: 550px; height: 550px;">
                        </div><!-- End .post-media -->

                        <div class="post-body">
                            <div class="post-date">
                                <span class="day">{{ $post->created_at->format('d') }}</span>
                                <span class="month">{{ $post->created_at->format('M') }}</span>
                            </div><!-- End .post-date -->

                            <h2 class="post-title">{{ $post->title }}</h2>

                            <div class="post-meta">
                                <a href="#" class="hash-scroll">{{ $post->comments_count }} Bình luận</a>
                            </div><!-- End .post-meta -->

                            <div class="post-content">
                               
                                <p>{!! strip_tags(html_entity_decode($post->content), '<p><img><a><b><i><ul><ol><li>') !!}</p>
                            </div><!-- End .post-content -->

                            <div class="row">
                                <h2>Sản phẩm liên quan</h2>
                                @foreach ($relatedProducts as $item)
                                    <div class="col-6 col-sm-4">
                                        <div class="product-default">
                                            <div class="product-details">
                                                <div class="category-wrap">
                                                    <figure>
                                                        <a href="{{ route('client.showProduct', $item->id) }}">
                                                            @php
                                                                $mainImage = $item->galleries->where('is_main', true)->first();
                                                            @endphp
                    
                                                            @if ($mainImage)
                                                                <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205"
                                                                    height="205" alt="{{ $item->name }}" />
                                                            @endif
                                                        </a>
                                                    </figure>
                                                    <div class="category-list">
                                                        <a href="{{ route('client.products.Category', ['id' => $item->category->id]) }}"
                                                            class="product-category">{{ $item->category->name }}</a>
                                                    </div>
                                                </div>

                                                <h3 class="product-title"> <a
                                                        href="{{ route('client.showProduct', $item->id) }}">{{ $item->name }}</a>
                                                </h3>

                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings"
                                                            style="width:{{ $item->rating * 20 }}%"></span>
                                                        <span class="tooltiptext tooltip-top">{{ $item->rating }} </span>
                                                    </div>
                                                    <!-- End .product-ratings -->
                                                </div>
                                                <!-- End .product-container -->

                                                <div class="price-box">
                                                    @if ($item->price_sale == null)
                                                        <span class="new-price"
                                                            style="color: #08c; font-size: 1.2em;">{{ number_format($item->price_regular, 0, ',', '.') }}
                                                            ₫</span>
                                                    @else
                                                        <span class="new-price"
                                                            style="color: #08c;  font-size: 1.2em;">{{ number_format($item->price_sale, 0, ',', '.') }}
                                                            ₫</span>
                                                        <span
                                                            class="old-price">{{ number_format($item->price_regular, 0, ',', '.') }}
                                                            ₫</span>
                                                    @endif
                                                </div>

                                                <!-- End .price-box -->

                                                <div class="product-action">
                                                    <a href="#" class="btn-icon-wish" title="wishlist"
                                                        data-product-id="{{ $item->id }}"><i
                                                            class="icon-heart"></i></a>
                                                    <a href="#" class="btn-icon btn-add-cart add-cart"
                                                        data-product-id="{{ $item->id }}" data-toggle="modal"><i
                                                            class="fa fa-arrow-right"></i><span>Thêm vào giỏ hàng</span></a>
                                                    <a href="{{ route('client.showProduct', $item->id) }}"
                                                        class="btn-quickview" title="Quick View">
                                                        <button class="view-detail"><i
                                                                class="fas fa-external-link-alt"></i></button>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End .product-details -->
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            
                        </div><!-- End .post-body -->
                    </article><!-- End .post -->

                    <hr class="mt-2 mb-1">
                </div><!-- End .col-lg-9 -->
                <div class="sidebar-toggle custom-sidebar-toggle">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="sidebar-overlay"></div>
                <div class="col-lg-3 order-lg-3">
                    <div class="sidebar-wrapper" data-sticky-sidebar-options='{"offsetTop": 72}'>
                        

                        <div class="widget widget-post">
                            <h4 class="widget-title">Bài viết gần đây</h4>

                            <ul class="simple-post-list">
                                @foreach ($posts->take(5) as $post)
                                    <li>
                                        <div class="post-media">
                                            <a href="{{ route('client.blogs.show', $post->id) }}">
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Post">
                                            </a>
                                        </div><!-- End .post-media -->
                                        <div class="post-info">
                                            <a href="{{ route('client.blogs.show', $post->id) }}">{{ $post->title }}</a>
                                            <div class="post-meta">{{ $post->created_at->format('F d, Y') }}</div>
                                        </div><!-- End .post-info -->
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- End .widget -->

                        
                    </div><!-- End .sidebar-wrapper -->
                </div><!-- End .col-lg-3 -->

                <!-- Sidebar code here -->
            </div><!-- End .row -->
        </div><!-- End .container -->

    </main><!-- End .main -->
@endsection
@section('scripte_logic')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        let isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        if (window.location.hash === "#_=_") {
            window.location.hash = "";
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Thêm vào giỏ hàng
            const addToCartButtons = document.querySelectorAll('.btn-add-cart');
            addToCartButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn chuyển trang
                    const productId = button.getAttribute('data-product-id');
                    if (isLoggedIn) {
                        // Gọi AJAX để thêm sản phẩm vào giỏ hàng
                        $.ajax({
                            type: "POST",
                            url: "{{ route('addCart') }}", // Thay bằng route tương ứng
                            data: {
                                product_id: productId,
                                quantity: 1, // Thiết lập số lượng mặc định là 1
                                _token: '{{ csrf_token() }}' // CSRF token
                            },
                            success: function(response) {

                                // alert("Sản phẩm đã được thêm vào giỏ hàng thành công!");
                                updateCartDisplay(response);


                            },
                            error: function(xhr) {
                                if (xhr.status === 401) {
                                    alert(
                                        "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng."
                                    );
                                } else {
                                    alert("Đã xảy ra lỗi. Vui lòng thử lại.");
                                }
                            }
                        });
                    } else {
                        alert("Bạn cần đăng nhập để thêm sản phẩm vào danh sách yêu thích.");
                    }
                });
            });

            // Thêm vào wishlist
            const wishlistButtons = document.querySelectorAll('.btn-icon-wish');
            wishlistButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn chuyển trang
                    const productId = button.getAttribute('data-product-id');
                    if (isLoggedIn) {
                        // Gọi AJAX để thêm sản phẩm vào wishlist
                        $.ajax({
                            type: "POST",
                            url: "{{ route('addWishList') }}", // Thay bằng route tương ứng
                            data: {
                                product_id: productId,
                                _token: '{{ csrf_token() }}' // CSRF token
                            },
                            success: function(response) {
                                // Xử lý khi thêm vào wishlist thành công
                                // alert("Sản phẩm đã được thêm vào danh sách yêu thích!");
                                $('#addToCart').modal('show');
                            },
                            error: function(xhr) {
                                if (xhr.status === 401) {
                                    alert(
                                        "Bạn cần đăng nhập để thêm sản phẩm vào danh sách yêu thích."
                                    );
                                } else {
                                    alert("Đã xảy ra lỗi. Vui lòng thử lại.");
                                }
                            }
                        });
                    } else {
                        alert("Bạn cần đăng nhập để thêm sản phẩm vào danh sách yêu thích.");
                    }
                });
            });
        });

        function updateCartDisplay(data) {
            // Đặt lại nội dung của phần sản phẩm trong giỏ hàng
            let cartContent = '';
            let subTotal = 0;

            // Duyệt qua các sản phẩm trong giỏ hàng
            data.carts.forEach(item => {
                let price = item.product.price_sale > 0 ? item.product.price_sale : item.product.price_regular;
                if (item.productVariant) {
                    price = item.productVariant.price_modifier;
                }
                const sub = price * item.quantity;
                subTotal += sub;

                // Kiểm tra và lấy ảnh chính từ galleries
                let mainImage = item.product.galleries.find(gallery => gallery.is_main);
                let imageUrl = mainImage && mainImage.image_gallery ?
                    `/storage/${mainImage.image_gallery}` :
                    '/images/default-image.jpg'; // Nếu không có ảnh chính, dùng ảnh mặc định

                // Xây dựng HTML cho từng sản phẩm
                cartContent += `
                <div class="product">
                    <div class="product-details">
                        <h4 class="product-title">
                            <a href="/product/${item.product.id}">${item.product.name}</a>
                        </h4>
                        <span class="cart-product-info">
                                <span class="cart-product-qty">${item.quantity}</span> × 
                                ${price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })} ₫
                        </span>
                    </div>
                    <figure class="product-image-container">
                        <a href="/product/${item.product.id}" class="product-image">
                            <img src="${imageUrl}" width="80" height="80" alt="${item.product.name}">
                        </a>
                        <a href="#" class="btn-remove icon-cancel" title="Remove Product" data-id="${item.id}" onclick="removeFromCart(this)"></a>
                    </figure>
                </div>
            `;
            });
            // console.log(data.totalQuantity);

            document.querySelector(".cart-count").innerHTML = data.totalQuantity

            // Cập nhật HTML giỏ hàng
            document.querySelector('.dropdown-cart-products').innerHTML = cartContent;
            document.querySelector('.cart-total-price').innerText = `${subTotal.toLocaleString('vi-VN')}₫`;
        }

        // Giả sử đây là JSON nhận được từ server
        const cartData = {
            totalQuantity: 18,
            carts: [
                // Array sản phẩm
            ]
        };


        // Modal thông báo thêm giỏ hàng
        document.querySelector("#addToCart .modal-body").innerHTML = `<p style="">Thêm vào giỏ hàng thành công</p>`
    </script>
@endsection
