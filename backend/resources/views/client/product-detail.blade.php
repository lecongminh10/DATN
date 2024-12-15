@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('keywords', $meta_keywords)
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

        .attribute-link {
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            text-align: center;
            min-width: 60px;
        }

        .attribute-link.active {
            background-color: #007bff;
            /* Màu nền khi active */
            color: #fff;
            /* Màu chữ khi active */
            border-color: #007bff;
        }

        .product-single-filter {
            margin-bottom: 10px;
        }

        .config-size-list {
            display: flex;
            gap: 10px;
            list-style-type: none;
            padding: 0;
        }

        #new-price-variant {
            color: #222529;
            font-size: 2.4rem;
            letter-spacing: -0.02em;
            vertical-align: middle;
            line-height: 0.8;
            margin-left: 3px;
        }
        .product-desc-content {
            max-width: 100%; /* Chiều rộng tối đa */
            max-height: 300px; /* Chiều cao tối đa (tùy chỉnh theo nhu cầu) */
            overflow: auto; /* Thêm thanh cuộn nếu nội dung vượt quá */
            padding: 10px; /* Khoảng cách bên trong */
            border: 1px solid #cccccc44; /* Viền để phân biệt khung */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0); /* Thêm bóng mờ nhẹ */
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
                    $mainImage = $gallery->image_gallery;
                } else {
                    // Thêm các ảnh khác vào mảng
                    $allImages[] = $gallery->image_gallery;
                }
            }
        }

        // Nếu có ảnh chính, thêm vào vị trí đầu tiên của mảng
        if ($mainImage !== null) {
            array_unshift($allImages, $mainImage);
        }

        // Lặp qua các biến thể và thêm ảnh của biến thể vào danh sách
        foreach ($data->variants as $variant) {
            if (isset($variant->variant_image)) {
                $allImages[] = $variant->variant_image;
            }
        }

    @endphp
    <header class="header">
        <div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': true}">
            <div class="container">
                <nav class="main-nav w-100">
                    <ul class="menu">
                        <li>
                            <a href="{{ route('client') }}">Trang chủ</a>
                        </li>
                        <li>
                            <a href="#">Danh mục</a>
                            <div class="megamenu megamenu-fixed-width megamenu-3cols">
                                <div class="row">
                                    @foreach ($categories as $parent)
                                        <div class="col-lg-4">
                                            <a href="#" class="nolink pl-0">{{ $parent->name }}</a>
                                            @if($parent->children->isNotEmpty())
                                                <ul class="submenu">
                                                    @foreach ($parent->children as $child)
                                                        <li><a href="{{ route('client.products.Category',$child->id) }}">{{ $child->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                      @endforeach
                                </div>
                            </div>
                            <!-- End .megamenu -->
                        </li>
                        <li><a href="{{route('client.products')}}">Sản phẩm </a></li>
                        <li>
                            <a href="#">Bài viết </a>
                        </li>
                        <li><a href="blog.html">Liên hệ chúng tôi</a></li>
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
                    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                </ol>
            </nav>

            <div class="product-single-container product-single-default">
                {{-- <div class="cart-message d-none">
                    <strong class="single-cart-notice">“Men Black Sports Shoes”</strong>
                    <span>has been added to your cart.</span>
                </div> --}}

                <div class="row">
                    @php
                        $allImages = [];
                        $mainImage = null; // Biến tạm để lưu ảnh chính

                        // Lặp qua các ảnh trong gallery
                        foreach ($data->galleries as $gallery) {
                            if (isset($gallery->image_gallery)) {
                                // Nếu ảnh là chính, lưu vào biến tạm
                                if ($gallery->is_main) {
                                    $mainImage = $gallery->image_gallery;
                                } else {
                                    // Thêm các ảnh khác vào mảng
                                    $allImages[] = $gallery->image_gallery;
                                }
                            }
                        }

                        // Nếu có ảnh chính, thêm vào vị trí đầu tiên của mảng
                        if ($mainImage !== null) {
                            array_unshift($allImages, $mainImage);
                        }

                        // Lặp qua các biến thể và thêm ảnh của biến thể vào danh sách
                        foreach ($data->variants as $variant) {
                            if (isset($variant->variant_image)) {
                                $allImages[] = $variant->variant_image;
                            }
                        }
                    @endphp

                    <div class="col-lg-5 col-md-6 product-single-gallery">
                        <div class="product-slider-container">
                            <div class="label-group">
                                {{-- <div class="product-label label-hot">HOT</div> --}}

                                {{-- <div class="product-label label-sale">
                                    -16%
                                </div> --}}
                            </div>

                            <!-- Slider chính hiển thị hình ảnh sản phẩm -->
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
                            <div class="product-gallery">
                                <img id="product-image" src="{{ asset('path_to_default_image.jpg') }}" alt="">
                            </div>

                            <span class="prod-full-screen">
                                <i class="icon-plus"></i>
                            </span>
                        </div>

                        <!-- Hiển thị ảnh dưới dạng thumbnail -->
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

                        {{-- <div class="product-nav">
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

                            {{-- <a href="#" class="rating-link">( 6 Reviews )</a>
                        </div> --}}
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
                            <!---->
                            <li>
                                Mã:
                                <strong> {{ $data->code }}</strong>
                            </li>

                            <li>
                                Danh mục:
                                <strong>
                                    <a href="{{route('client.products.Category',['id'=> $data->category->id])}}" class="product-category">{{ $data->category->name }}</a>
                                </strong>
                            </li>

                            <li>
                                <strong>Thẻ:</strong>
                                <span class="product-tags">
                                    @foreach ($data->tags as $tag)
                                        <a href="#" class="badge bg-primary text-white product-category p-2">{{ $tag->name }}</a>
                                        @if (!$loop->last)
                                            <span class="text-muted">, </span>
                                        @endif
                                    @endforeach
                                </span>
                            </li>                            
                        </ul>

                        @php
                            // Mảng để nhóm các thuộc tính và giá trị của chúng từ tất cả các biến thể
                            $attributesGrouped = [];

                            // Duyệt qua từng biến thể
                            if (count($variants) > 0) {
                                foreach ($variants as $variant) {
                                    if (count($variant['attributes']) > 0) {
                                        foreach ($variant['attributes'] as $attribute) {
                                            // Nhóm các giá trị thuộc tính theo tên thuộc tính
                                            if (!isset($attributesGrouped[$attribute['attribute_name']])) {
                                                $attributesGrouped[$attribute['attribute_name']] = [];
                                            }

                                            // Thêm giá trị vào mảng nếu chưa tồn tại để tránh trùng lặp
                                            if (
                                                !in_array(
                                                    $attribute['attribute_value'],
                                                    $attributesGrouped[$attribute['attribute_name']],
                                                )
                                            ) {
                                                $attributesGrouped[$attribute['attribute_name']][] =
                                                    $attribute['attribute_value'];
                                            }
                                        }
                                    }
                                }
                            }
                        @endphp

                        @if (count($attributesGrouped) > 0)
                            @foreach ($attributesGrouped as $attributeName => $values)
                                <div class="product-single-filter">
                                    <label>{{ $attributeName }}:</label>
                                    <ul class="config-size-list">
                                        @foreach ($values as $value)
                                            <li>
                                                <a href="javascript:;"
                                                    class="d-flex align-items-center justify-content-center attribute-link"
                                                    style="min-height: 30px ; min-width:70px"
                                                    data-attribute-name="{{ $attributeName }}"
                                                    data-attribute-value="{{ $value }}">
                                                    {{ $value }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif

                        {{-- <div class="product-single-filter">
                                <label></label>
                                <a class="font1 text-uppercase clear-btn" href="#">Clear</a>
                            </div> --}}
                        <!---->

                        <div class="product-action">
                            <div class="price-box product-filtered-price" style="display: flex;">
                            </div>

                            <div class="product-single-qty">
                                <input class="horizontal-quantity form-control" onchange="updateQuantity()"
                                    id="quantity-product" type="text">
                            </div>
                            <!-- End .product-single-qty -->

                            <a href="javascript:;" data-quantity-product="1" onchange="updateQuantity()"
                                data-product-id="{{ $data->id }}" data-variant-id="" id="product-variant-id"
                                class="btn btn-dark add-cart mr-2" title="Add to Cart">Thêm vào giỏ hàng</a>
                            <a href="{{ route('shopping-cart') }}" class="btn btn-gray view-cart d-none">Xem giỏ hàng</a>
                        </div>
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
                            role="tab" aria-controls="product-desc-content" aria-selected="true">Mô tả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content"
                            role="tab" aria-controls="product-reviews-content" aria-selected="false">Bình luận</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                        aria-labelledby="product-tab-desc">
                        <div class="product-desc-content">
                            <p>{!! strip_tags(html_entity_decode($data->content), '<p><img><a><b><i><ul><ol><li>') !!}</p>
                        </div>
                        <!-- End .product-desc-content -->
                    </div>
                    <!-- End .tab-pane -->
                    @php
                        $comments = App\Models\UserReview::with(['user', 'product'])->get();
                    @endphp

                    <div class="tab-pane fade" id="product-reviews-content" role="tabpanel"
                        aria-labelledby="product-tab-reviews">
                        <div class="product-reviews-content">
                            <div class="comment-list">
                                @if ($comments->isNotEmpty())
                                    @foreach ($comments as $comment)
                                        <div class="comments">
                                            <figure class="img-thumbnail">
                                                <img src="{{ Storage::url($comment->user->profile_picture) }}"
                                                    alt="author" width="80" height="80">
                                            </figure>

                                            <div class="comment-block">
                                                <div class="comment-header">
                                                    <div class="comment-arrow"></div>

                                                    <div class="ratings-container float-sm-right">
                                                        <div class="product-ratings">
                                                            <!-- Hiển thị xếp hạng sao dựa trên rating -->
                                                            <span class="ratings"
                                                                style="width:{{ ($comment->rating / 5) * 100 }}%"></span>
                                                            <span
                                                                class="tooltiptext tooltip-top">{{ $comment->rating }}</span>
                                                        </div>
                                                    </div>

                                                    <span class="comment-by">
                                                        <strong>{{ $comment->user->name }}</strong> –
                                                        {{ \Carbon\Carbon::parse($comment->review_date)->locale('vi')->isoFormat('D MMMM YYYY') }}
                                                    </span>
                                                </div>

                                                <div class="comment-content">
                                                    <p>{{ $comment->review_text }}</p>
                                                </div>
                                                @if ($comment->reply_text)
                                                    <div class="admin-reply">
                                                        <p><strong>{{ $comment->user->username }} trả lời:</strong>
                                                            {{ $comment->reply_text }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Không có bình luận nào.</p>
                                @endif
                            </div>

                            <div class="divider"></div>
                        </div>
                    </div>
                </div>
                <!-- End .tab-content -->
            </div>
            <!-- End .product-single-tabs -->
            {{-- @include('client.components-home.products', [
                'title' => 'Lượt đánh giá cao nhất',
                'products' => $topRatedProducts,
            ]) --}}
            @include('client.components-home.products', [
                'title' => 'Giảm giá nhiều nhất',
                'products' => $bestSellingProducts,
            ])
            @include('client.components-home.products', [
                'title' => 'Mới nhất',
                'products' => $latestProducts,
            ])
            <div class="mb-3"></div>
            <!-- End .row -->
        </div>
        <!-- End .container -->
    </main>
    <!-- End .main -->

    <!-- Modal thông báo thêm vào wishlist -->
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
    </div>
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
            };
        })();
    </script>
    <script>
        document.querySelectorAll('.rating-stars a').forEach(function(star) {
             star.addEventListener('click', function(event) {
                 event.preventDefault();
                 let rating = star.getAttribute('data-rating');
                 document.getElementById('rating').value = rating; // Cập nhật giá trị của input hidden
                 // Làm nổi bật các sao đã chọn
                 document.querySelectorAll('.rating-stars a').forEach(function(s) {
                     s.classList.remove('selected');
                 });
                 star.classList.add('selected');
             });
         });
         document.addEventListener('DOMContentLoaded', function() {
             // Lắng nghe sự kiện thay đổi trên các input để thực hiện thêm các hành động
             const attributeInputs = document.querySelectorAll('.attribute-input');
 
             attributeInputs.forEach(input => {
                 input.addEventListener('change', function() {
                     // Có thể thực hiện các hành động khi một thuộc tính được chọn, ví dụ:
                     console.log(`Selected ${this.name}: ${this.value}`);
                 });
             });
         });
 
         // Đổi giá variant 
 
         // Biến để lưu trữ giá của từng biến thể
         const variants = @json($variants);
 
         document.addEventListener('DOMContentLoaded', function() {
             const priceBox = document.querySelector('.product-filtered-price');
             let selectedAttributes = {};
 
             document.querySelectorAll('.attribute-link').forEach(link => {
                 link.addEventListener('click', function() {
                     const filterContainer = this.closest('.product-single-filter');
                     const attributeName = this.dataset.attributeName;
                     const attributeValue = this.dataset.attributeValue;
 
                     // Kiểm tra nếu thuộc tính hiện tại đã được chọn
                     const isAlreadyActive = this.classList.contains('active');
 
                     // Bỏ chọn các lựa chọn khác trong cùng một nhóm thuộc tính
                     filterContainer.querySelectorAll('.attribute-link').forEach(otherLink => {
                         otherLink.classList.remove('active');
                     });
 
                     if (isAlreadyActive) {
                         // Nếu đã chọn, bỏ chọn và xóa khỏi selectedAttributes
                         delete selectedAttributes[attributeName];
                     } else {
                         // Chọn thuộc tính được nhấn và cập nhật vào selectedAttributes
                         this.classList.add('active');
                         selectedAttributes[attributeName] = attributeValue;
                     }
 
                     // Tìm biến thể khớp với thuộc tính đã chọn
                     const matchedVariant = variants.find(variant =>
                         variant.attributes.every(attr =>
                             selectedAttributes[attr.attribute_name] === attr.attribute_value
                         )
                     );
 
                     // Cập nhật hiển thị giá
                     if (matchedVariant) {
                         // Kiểm tra nếu phần tử có tồn tại
                         let variantInput = document.getElementById("product-variant-id");
                         let variantWishlist = document.getElementById("wishlist-variant-id");
                         // if (variantInput && variantWishlist ) {
                         variantInput.setAttribute("data-variant-id", matchedVariant.id);
                         variantWishlist.setAttribute("data-variant-id", matchedVariant.id);
                         console.log("Product Variant ID:", matchedVariant.id); // Log the variant ID
                         // console.log(variantWishlist);
                         // console.log(variantInput);
 
 
                         // } else {
                         //     console.log("Element with ID 'product_variant_id' does not exist.");
                         // }
                         priceBox.innerHTML = `
                     <del class="old-price" id="old-price-variant">${matchedVariant.original_price ? parseInt(matchedVariant.original_price).toLocaleString('vi-VN') + " VNĐ" : ''}</del>
                     <p class="new-price" id="new-price-variant">${parseInt(matchedVariant.price_modifier).toLocaleString('vi-VN')} VNĐ</p>
                 `;
                         // console.log(matchedVariant.price_modifier);
                     } else {
                         // Đặt lại hiển thị giá nếu không có biến thể nào khớp
                         priceBox.innerHTML = `
                     <p class="new-price" id="new-price-variant">Chọn các thuộc tính để xem giá</p>
                 `;
                     }
 
                     console.log(matchedVariant.id);
                 });
             });
         });
 
 
         function updateQuantity() {
             let quantity = document.getElementById("quantity-product").value;
             let variantInput = document.getElementById("product-variant-id");
 
             // Check if quantity is a valid number
             if (quantity && !isNaN(quantity)) {
                 variantInput.setAttribute("data-quantity-product", quantity);
                 console.log("Quantity set to:", quantity); // Log for verification
             } else {
                 console.log("Invalid quantity value");
             }
         }
 
 
         // Thêm giỏ hàng
         document.addEventListener('DOMContentLoaded', function() {
             const productVariant = document.getElementById('product-variant-id');
 
             productVariant.addEventListener('click', function() {
                 const productId = productVariant.getAttribute('data-product-id');
                 const productVariantId = productVariant.getAttribute('data-variant-id');
                 const quantity = productVariant.getAttribute('data-quantity-product');
 
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
     </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện thay đổi trên các input để thực hiện thêm các hành động
    const attributeInputs = document.querySelectorAll('.attribute-input');

    attributeInputs.forEach(input => {
        input.addEventListener('change', function () {
            // Có thể thực hiện các hành động khi một thuộc tính được chọn, ví dụ:
            console.log(`Selected ${this.name}: ${this.value}`);
        });
    });
});

// Đổi giá variant

// Biến để lưu trữ giá của từng biến thể

document.addEventListener('DOMContentLoaded', function () {
    const variants = @json($variants);
    const priceBox = document.querySelector('.product-filtered-price');
    let selectedAttributes = {};

    document.querySelectorAll('.attribute-link').forEach(link => {
        link.addEventListener('click', function () {
            const filterContainer = this.closest('.product-single-filter');
            const attributeName = this.dataset.attributeName;
            const attributeValue = this.dataset.attributeValue;

            // Kiểm tra nếu thuộc tính hiện tại đã được chọn
            const isAlreadyActive = this.classList.contains('active');

            // Bỏ chọn các lựa chọn khác trong cùng một nhóm thuộc tính
            filterContainer.querySelectorAll('.attribute-link').forEach(otherLink => {
                otherLink.classList.remove('active');
            });

            if (isAlreadyActive) {
                // Nếu đã chọn, bỏ chọn và xóa khỏi selectedAttributes
                delete selectedAttributes[attributeName];
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
    })
})
    </script>

@endsection
