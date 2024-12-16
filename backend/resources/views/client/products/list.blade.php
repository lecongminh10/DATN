<?php
$minPrice = \App\Models\Product::min('price_sale'); // Lấy giá trị min
$maxPrice = \App\Models\Product::max('price_sale'); // Lấy giá trị max
?>
@extends('client.layouts.app')
@section('style_css')
    <style>
        .add-cart {
            background-color: #f4f4f4;
        }

        /* Css modal */
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            /* height: 100%; Để modal ở giữa chiều dọc */
            /* margin: 0; Loại bỏ khoảng cách mặc định */
        }

        .modal-content {
            max-height: calc(100vh - 3rem);
            /* Đảm bảo modal không vượt quá chiều cao màn hình */
            overflow-y: auto;
            /* Cuộn nếu nội dung quá dài */
        }

        .view-detail {
            border: none;
            color: #4d4c4a;
            cursor: pointer;
            margin-top: 9px;
            background-color: transparent;
        }

        .btn-icon-wish {
            margin-top: 10px;
        }

        .btn-detail {
            border: none;
            background-color: transparent;
            color: #4d4c4a;
            cursor: pointer;
            margin-top: 10px;
        }

        .scrollable-content {
            max-height: 300px; /* Giới hạn chiều cao */
            overflow-y: auto; /* Hiển thị thanh cuộn dọc khi nội dung vượt quá */
            padding-right: 10px; /* Khoảng cách cho thanh cuộn */
        }

        /* Thanh cuộn cơ bản */
        .scrollable-content::-webkit-scrollbar {
            width: 8px; /* Độ rộng thanh cuộn */
            height: 8px; /* Độ cao thanh cuộn ngang (nếu có) */
        }

        /* Đường dẫn thanh cuộn */
        .scrollable-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Đối với Firefox */
        .scrollable-content {
            scrollbar-width: thin;
        }

        /* Nút thu gọn danh mục */
        .toggle {
            cursor: pointer;
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 10px;
            position: relative;
            transition: transform 0.3s ease; /* Hiệu ứng xoay */
        }

        .toggle::before {
            content: ''; /* Mũi tên lên  */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: #000000;
        }

        /* Xoay xuống khi danh mục con được mở */
        .toggle.rotate {
            transform: rotate(180deg);
        }

        .toggle::before {
            content: ''; /* Mũi tên lên  */
        }

        .toggle.rotate::before {
            content: ''; /* Mũi tên xuống  */
        }
    </style>
@endsection
@section('content')
    @include('client.layouts.nav')
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-9 main-content">
                <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                    <div class="toolbox-left">
                        <a href="#" class="sidebar-toggle">
                            <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                <path d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                    class="cls-2"></path>
                                <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                <path d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                    class="cls-2"></path>
                            </svg>
                            <span>Filter</span>
                        </a>
                        <form action="{{ route('client.products.sort') }}" method="GET">
                            <div class="toolbox-item toolbox-sort">
                                <label>Sắp Xếp:</label>
                                <div class="select-custom">
                                    <select name="orderby" class="form-control" id="sort-options"
                                        onchange="this.form.submit()">
                                        <option value="price-asc" {{ request('orderby') == 'price-asc' ? 'selected' : '' }}>
                                            Giá thấp - cao</option>
                                        <option value="price-desc"
                                            {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>
                                            Giá cao - thấp</option>
                                        <option value="hot-promotion"
                                            {{ request('orderby') == 'hot-promotion' ? 'selected' : '' }}>
                                            Khuyến mãi hot</option>
                                        <option value="popularity"
                                            {{ request('orderby') == 'popularity' ? 'selected' : '' }}>
                                            Xem nhiều</option>
                                    </select>
                                </div>
                                <div class="toolbox-item toolbox-filter mt-1 ml-3">
                                    <label>Chọn tháng:</label>
                                    <div class="select-custom">
                                        <select name="month" class="form-control" onchange="this.form.submit()">
                                            <option value="">Tất cả</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ request('month') == $i ? 'selected' : '' }}>
                                                    Tháng {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End .toolbox-item -->
                    </div>
                    <!-- End .toolbox-left -->
                </nav>

                @php
                    // dd($products)
                @endphp
                <div class="row" style="margin-top: -30px">
                    @foreach ($products as $item)
                        <div class="col-6 col-sm-4">
                            <div class="product-default">
                                <figure>
                                    {{-- @foreach ($item->galleries as $value) --}}
                                    <a href="{{ route('client.showProduct', $item->id) }}">
                                        @php
                                            $mainImage = $item->galleries->where('is_main', true)->first();
                                            $otherImages = $item->galleries->where('is_main', false)->take(1);
                                        @endphp

                                        @if ($mainImage)
                                            <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205"
                                                height="205" alt="{{ $item->name }}" />
                                        @endif

                                        @foreach ($otherImages as $value)
                                            <img src="{{ \Storage::url($value->image_gallery) }}" width="205"
                                                height="205" alt="{{ $item->name }}" />
                                        @endforeach
                                    </a>
                                    {{-- @endforeach --}}
                                    <div class="label-group">
                                        @if ($item->is_hot_deal == 1)
                                            <div class="product-label label-hot">HOT</div>
                                        @endif
                                        {{-- <div class="product-label label-hot">HOT</div> --}}

                                        @php
                                             if (isset($item->variants) && $item->variants->isNotEmpty()) {
                                                $minPrice = $item->variants->filter(function ($variant) {
                                                    return $variant->price_modifier !== null;
                                                })->isNotEmpty()
                                                    ? $item->variants->min('price_modifier')
                                                    : $item->variants->min('original_price');
                                                
                                                $maxPrice = $item->variants->filter(function ($variant) {
                                                    return $variant->price_modifier !== null;
                                                })->isNotEmpty()
                                                    ? $item->variants->max('price_modifier')
                                                    : $item->variants->max('original_price');
                                            } else {
                                                $minPrice = $item->price_sale;
                                                $maxPrice = $item->price_regular;
                                            }

                                            // Tính toán phần trăm giảm giá nếu có giá sale hợp lệ
                                            $discountPercentage = null;
                                            if (
                                                $item->price_sale !== null &&
                                                $item->price_sale < $item->price_regular
                                            ) {
                                                $discountPercentage = round(
                                                    (($item->price_regular - $item->price_sale) /
                                                        $item->price_regular) *
                                                        100,
                                                );
                                            }
                                        @endphp

                                        @if ($discountPercentage !== null)
                                            <div class="product-label label-sale">- {{ $discountPercentage }}%</div>
                                        @endif
                                    </div>
                                </figure>

                                <div class="product-details">
                                    <div class="category-wrap">
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
                                            <span class="ratings" style="width:{{ $item->rating * 20 }}%"></span>
                                            <span class="tooltiptext tooltip-top">{{ $item->rating }} </span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="new-price" style="color: #08c;  font-size: 1em;">{{number_format($minPrice, 0, ',', '.')}} đ ~ {{number_format($maxPrice, 0, ',', '.')}} đ</span>
                                    </div>

                                    <!-- End .price-box -->

                                    <div class="product-action">
                                        <a href="#" class="btn-icon-wish" title="wishlist"
                                            data-product-id="{{ $item->id }}"><i class="icon-heart"></i></a>
                                        <a href="#" class="btn-icon btn-add-cart add-cart"
                                            data-product-id="{{ $item->id }}" data-toggle="modal"><i
                                                class="fa fa-arrow-right"></i><span>Thêm vào giỏ hàng</span></a>
                                        <a href="{{ route('client.showProduct', $item->id) }}" class="btn-quickview"
                                            title="Quick View">
                                            <button class="view-detail"><i class="fas fa-external-link-alt"></i></button>
                                        </a>
                                    </div>
                                </div>
                                <!-- End .product-details -->
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- End .row -->
                <nav class="toolbox toolbox-pagination">
                    <div class="toolbox-item toolbox-show">
                        <label>Show:</label>
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="select-custom mt-5">
                                <select name="count" class="form-control" onchange="this.form.submit()">
                                    <option value="12" {{ request('count') == 12 ? 'selected' : '' }}>12</option>
                                    <option value="24" {{ request('count') == 24 ? 'selected' : '' }}>24</option>
                                    <option value="36" {{ request('count') == 36 ? 'selected' : '' }}>36</option>
                                </select>
                            </div>
                            <!-- End .select-custom -->
                        </form>
                    </div>
                    <!-- End .toolbox-item -->
                    {{-- <ul class="pagination toolbox-item">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </ul> --}}
                </nav>
            </div>
            <!-- End .col-lg-9 -->

            <div class="sidebar-overlay"></div>
            <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                <div class="sidebar-wrapper">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true"
                                aria-controls="widget-body-2">Danh mục</a>
                        </h3>

                        <div class="collapse show" id="widget-body-2">
                            <div class="widget-body">
                                <ul class="cat-list">
                                    @foreach ($categories as $category)
                                        <li>
                                            @if ($category->parent_id == null)
                                                <a href="{{ route('client.products.Category', ['id' => $category->id]) }}"
                                                    role="button"
                                                    aria-expanded="{{ $category->children->isNotEmpty() ? 'true' : 'false' }}"
                                                    aria-controls="widget-category-{{ $category->id }}">
                                                    {{ $category->name }}
                                                    <span class="products-count">({{ $category->products_count }})</span>
                                                </a>
                                                <span class="toggle" data-target="#widget-category-{{ $category->id }}"></span>
                                            @endif
                                            @if ($category->children->isNotEmpty())
                                                <div class="collapse" id="widget-category-{{ $category->id }}">
                                                    <ul class="cat-sublist">
                                                        @foreach ($category->children as $subcategory)
                                                            <li>
                                                                <a href="{{ route('client.products.Category', $subcategory->id) }}">
                                                                    {{ $subcategory->name }}
                                                                    <span class="products-count">({{ $subcategory->products_count }})</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        

                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget border border-bottom">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">
                                Đặc tính
                            </a>
                        </h3>
                    
                        <div class="collapse show" id="widget-body-3">
                            <div class="widget-body pb-0">
                                <!-- Thêm lớp cuộn -->
                                <div class="scrollable-content">
                                    <form action="{{ route('client.products.filterByProducts') }}" method="GET">
                                        <div class="price-input-wrapper">
                                            <!-- Input kết hợp select -->
                                            <div class="form-group">
                                                @foreach($attributes as $attribute)
                                          
                                                    <!-- Tên thuộc tính -->
                                                    <label for="attribute-{{ $attribute->id }}">{{ $attribute->attribute_name }}:</label>
                                                    <!-- Select chứa giá trị của thuộc tính -->
                                                    <select name="attributes[]" id="attribute-{{ $attribute->id }}" class="form-control mb-2" style="height: 45px">
                                                        <option value="" selected>Chọn {{ $attribute->attribute_name }}</option>
                                                        @foreach($attribute->attributeValues as $value)
                                                            <option value="{{ $value->id }}">{{ $value->attribute_value }}</option>
                                                        @endforeach
                                                    </select>
                                                @endforeach
                                            </div>
                    
                                            <!-- Input giá tối thiểu -->
                                            <div class="form-group">
                                                <label for="min">Giá tối thiểu (₫):</label>
                                                <input type="text" class="form-control" name="min" id="min" 
                                                    value="{{ $minPriceFormatted ?? '' }}" min="0">
                                            </div>
                                            <!-- Input giá tối đa -->
                                            <div class="form-group">
                                                <label for="max">Giá tối đa (₫):</label>
                                                <input type="text" class="form-control" name="max" id="max" 
                                                    value="{{ $maxPriceFormatted ?? '' }}" min="0">
                                            </div>
                                        </div>
                    
                                        <div class="filter-price-action d-flex align-items-center justify-content-between flex-wrap">
                                            <button type="submit" class="btn btn-primary">Lọc</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End .collapse -->
                    </div> 

                    <!-- End .widget -->

                    <div style="margin-bottom: 50px"></div>

                </div>
                <!-- End .sidebar-wrapper -->
            </aside>
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="addToCartLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width: 550px">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToCartLabel">Thông báo </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
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
        $(document).ready(function() {
            $("#price-slider").slider({
                range: true,
                min: {{ $minPrice }},
                max: {{ $maxPrice }},
                values: [{{ $minPrice }}, {{ $maxPrice }}],
                slide: function(event, ui) {
                    $("#filter-price-range").text("₫" + ui.values[0] + " - ₫" + ui.values[1]);
                    $("#min").val(ui.values[0]); // Lưu giá trị min vào input hidden
                    $("#max").val(ui.values[1]); // Lưu giá trị max vào input hidden
                }
            });

            // Hiển thị khoảng giá mặc định
            $("#filter-price-range").text("₫" + $("#price-slider").slider("values", 0) + " - ₫" +
                $("#price-slider").slider("values", 1));
        });
        document.getElementById('sort-options').addEventListener('change', function() {
            this.form.submit();
        });


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
    document.querySelector("#addToCart .modal-body").innerHTML= `<p style="">Thêm vào giỏ hàng thành công</p>`

    $(document).ready(function () {
        // Khi nhấn vào input, hiển thị danh sách tùy chọn
        $('#attribute').on('focus click', function () {
            $('#attribute-select').show();
        });

        // Khi chọn một tùy chọn trong select
        $('#attribute-select').on('change', function () {
            const selectedOption = $(this).find('option:selected').text();
            const selectedValue = $(this).val();

            // Hiển thị giá trị trong input
            $('#attribute').val(selectedOption);

            // Gán giá trị vào input ẩn để gửi form
            $('#selected-attribute').val(selectedValue);

            // Ẩn danh sách tùy chọn
            $(this).hide();
        });

        // Ẩn select khi nhấn ra ngoài
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.form-group').length) {
                $('#attribute-select').hide();
            }
        });
    });

    // Nút ẩn danh mục
    document.addEventListener('DOMContentLoaded', function () {
        // Chọn tất cả các toggle button
        const toggles = document.querySelectorAll('.toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                // Lấy ID mục tiêu từ data-target
                const targetId = toggle.getAttribute('data-target');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Toggle class 'show' để ẩn/hiện danh mục con
                    targetElement.classList.toggle('show');

                    // Toggle trạng thái quay của toggle
                    toggle.classList.toggle('rotate');

                    // Toggle trạng thái aria-expanded
                    const isExpanded = targetElement.classList.contains('show');
                    toggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                }
            });
        });
    });
    </script>
@endsection
</style>
