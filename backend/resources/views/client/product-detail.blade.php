@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('keywords', $meta_keywords)
@extends('client.layouts.app')
@section('style_css')
    <style>                                                                                                                                                                                        } */
        #priceBox {
            display: flex;
            align-items: center;
            /* Căn giữa theo chiều dọc */
            gap: 10px;
            /* Khoảng cách giữa giá cũ và giá mới */
        }

        .carousel-hidden {
            display: none !important;
        }


        .old-price {
            text-decoration: line-through;
            /* Gạch ngang giá cũ */
            color: #999;
            /* Màu sắc cho giá cũ */
        }

        .new-price {
            font-weight: bold;
            /* Làm đậm giá mới */
            color: #e74c3c;
            /* Màu sắc cho giá mới */
        }


        .cart-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Màu nền mờ */
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 9999;
        }

        .cart-modal.show {
            display: flex;
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
            max-width: 100%;
            /* Chiều rộng tối đa */
            max-height: 300px;
            /* Chiều cao tối đa (tùy chỉnh theo nhu cầu) */
            overflow: auto;
            /* Thêm thanh cuộn nếu nội dung vượt quá */
            padding: 10px;
            /* Khoảng cách bên trong */
            border: 1px solid #cccccc44;
            /* Viền để phân biệt khung */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0);
            /* Thêm bóng mờ nhẹ */
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
    @include('client.layouts.nav')
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
                                <!-- Optional labels (e.g., sale, new) -->
                            </div>

                            <div id="product-single-carousel"
                                class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                @foreach ($allImages as $item)
                                    <div class="product-item">
                                        <img class="product-single-image" src="{{ \Storage::url($item) }}"
                                            data-zoom-image="{{ \Storage::url($item) }}" width="468" height="468"
                                            alt="product" />
                                    </div>
                                @endforeach
                            </div>
                            {{-- <img class="product-single-image" src="{{ asset('storage/' . $item) }}"
                                data-zoom-image="{{ asset('storage/' . $item) }}" width="468" height="468"
                                alt="product" /> --}}

                            <!-- End .product-single-carousel -->

                            <div class="product-gallery">
                                <img id="product-image" src="" alt="">
                            </div>

                            <span class="prod-full-screen">
                                <i class="icon-plus"></i>
                            </span>
                        </div>

                        <!-- Thumbnails -->
                        <div class="prod-thumbnail ">
                            @foreach ($allImages as $item)
                                <div class="owl-dot" data-image="{{ \Storage::url($item) }}">
                                    <img src="{{ \Storage::url($item) }}" width="110" height="110"
                                        alt="product-thumbnail" />
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <!-- End .product-single-gallery -->


                    <div class="col-lg-7 col-md-6 product-single-details">
                        <h1 class="product-title">{{ $data->name }}</h1>
                        {{-- <div class="price-box">
                            @if ($data->price_sale == null)
                                <span class="new-price">{{ number_format($data->price_regular, 0, ',', '.') }} ₫</span>
                            @else
                                <span class="old-price">{{ number_format($data->price_regular, 0, ',', '.') }} ₫</span>
                                <span class="new-price">{{ number_format($data->price_sale, 0, ',', '.') }} ₫</span>
                            @endif
</div> --}}

                        @php
                            $lowestPriceVariant = null;

                            if (!empty($variants)) {
                                $lowestPriceVariant = collect($variants)->reduce(function ($lowest, $variant) {
                                    return !$lowest || $variant['price_modifier'] < $lowest['price_modifier']
                                        ? $variant
                                        : $lowest;
                                });
                            }
                        @endphp

                        <div id="price-box" class="price-box">
                            @if ($lowestPriceVariant)
                                @if (
                                    !empty($lowestPriceVariant['original_price']) &&
                                        $lowestPriceVariant['original_price'] > $lowestPriceVariant['price_modifier']
                                )
                                    <span class="old-price" id="old-price-variant">
                                        {{ number_format($lowestPriceVariant['original_price'], 0, ',', '.') }} VNĐ
                                    </span>
                                @endif
                                <span class="new-price" id="new-price-variant">
                                    {{ number_format($lowestPriceVariant['price_modifier'], 0, ',', '.') }} VNĐ
                                </span>
                            @else
                                <p class="new-price">Không có biến thể nào khả dụng</p>
                            @endif
                        </div>


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
                                    <a href="{{ route('client.products.Category', ['id' => $data->category->id]) }}"
                                        class="product-category">{{ $data->category->name }}</a>
                                </strong>
                            </li>
                            <li>
                                Thời gian bảo hành:
                                <strong> {{ $data->warranty_period }} tháng</strong>
                            </li>
                            <li>
                                <strong>Thẻ:</strong>
                                <span class="product-tags">
                                    @foreach ($data->tags as $tag)
                                        <a href="#"
                                            class="badge bg-primary text-white product-category p-2">{{ $tag->name }}</a>
                                        @if (!$loop->last)
                                            <span class="text-muted">, </span>
                                        @endif
                                    @endforeach
                                </span>
                            </li>
                        </ul>

                        @php
                            $attributesGrouped = [];

                            if (count($variants) > 0) {
                                foreach ($variants as $variant) {
                                    if (count($variant['attributes']) > 0) {
                                        foreach ($variant['attributes'] as $attribute) {
                                            if (!isset($attributesGrouped[$attribute['attribute_name']])) {
                                                $attributesGrouped[$attribute['attribute_name']] = [];
                                            }
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
                                                <a href="javascript:;" class="attribute-link"
                                                    data-attribute-name="{{ $attributeName }}"
                                                    data-attribute-value="{{ $value }}"
                                                    style="min-height: 30px; min-width: 70px;">
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
                            <a href="javascript:;" data-quantity-product="1" onchange="updateQuantity()"
                                data-product-id="{{ $data->id }}" data-variant-id="" id="product-variant-id"
                                class="btn btn-dark add-cart mr-2 disabled" title="Add to Cart">Thêm vào giỏ hàng</a>
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
                                                        <strong>{{ $comment->user->username }}</strong> –
                                                        {{ \Carbon\Carbon::parse($comment->review_date)->locale('vi')->isoFormat('D MMMM YYYY') }}
                                                    </span>
                                                </div>

                                                <div class="comment-content">
                                                    <p>{{ $comment->review_text }}</p>
                                                </div>
                                                @if ($comment->reply_text)
                                                    <div class="admin-reply">
                                                        <p><strong>Zomart:</strong>
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
    <!-- Modal thông báo khi xóa danh mục -->
    <!-- Modal thông báo khi thêm vào giỏ hàng -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModal">Thông Báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="stock-alert-message">Sản phẩm đã được thêm vào giỏ hàng.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script_libray')
    <!-- Bao gồm JS của Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>


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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variants = @json($variants);
            const priceBox = document.getElementById('price-box');
            const attributeLinks = document.querySelectorAll('.attribute-link');
            const variantInput = document.getElementById('product-variant-id');
            let selectedAttributes = {};
            showLowestPrice();

            // Gắn sự kiện cho các liên kết thuộc tính
            attributeLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const filterContainer = this.closest('.product-single-filter');
                    const attributeName = this.dataset.attributeName;
                    const attributeValue = this.dataset.attributeValue;
                    const isAlreadyActive = this.classList.contains('active');

                    filterContainer.querySelectorAll('.attribute-link').forEach(otherLink => {
                        otherLink.classList.remove('active');
                    });

                    if (isAlreadyActive) {
                        delete selectedAttributes[attributeName];
                    } else {
                        this.classList.add('active');
                        selectedAttributes[attributeName] = attributeValue;
                    }
                    updatePriceAndVariant();
                });
            });

            /**
             * Hiển thị giá nhỏ nhất từ danh sách biến thể
             */
            function showLowestPrice() {
                if (variants && variants.length > 0) {
                    const lowestPriceVariant = variants.reduce((prev, current) =>
                        parseInt(current.price_modifier) < parseInt(prev.price_modifier) ? current : prev
                    );

                    priceBox.innerHTML = `
                        ${lowestPriceVariant.original_price && parseInt(lowestPriceVariant.original_price) > parseInt(lowestPriceVariant.price_modifier)
                            ? `<span class="old-price">${parseInt(lowestPriceVariant.original_price).toLocaleString('vi-VN')} VNĐ</span>`
                            : ''
                        }
                        <span class="new-price">
                            ${parseInt(lowestPriceVariant.price_modifier).toLocaleString('vi-VN')} VNĐ
                        </span>
                    `;
                    var variantId =document.querySelector('#product-variant-id')
                    variantId.setAttribute("data-variant-id", lowestPriceVariant.id);        
                    lowestPriceVariant.attributes.forEach(attr => {
                        const attributeLinks = document.querySelectorAll(
                            `.attribute-link[data-attribute-name="${attr.attribute_name}"][data-attribute-value="${attr.attribute_value}"]`
                        );
                        if (attributeLinks.length > 0) {
                            attributeLinks.forEach(link => {
                                link.classList.add('active');
                                const parentLi = link.closest('li');
                                if (parentLi) {
                                    parentLi.classList.add('active');
                                }
                            });
                        }
                    });

                } else {
                    priceBox.innerHTML = `<p class="new-price">Không có biến thể nào khả dụng</p>`;
                }
            }

            function updatePriceAndVariant() {
                // Tìm biến thể phù hợp với các thuộc tính đã chọn
                const matchedVariant = variants.find(variant =>
                    variant.attributes.every(attr =>
                        selectedAttributes[attr.attribute_name] === attr.attribute_value
                    )
                );
                console.log(matchedVariant);

                // Hiển thị giá và cập nhật ID biến thể
                priceBox.innerHTML = `
        ${matchedVariant.original_price && parseInt(matchedVariant.original_price) > parseInt(matchedVariant.price_modifier)
            ? `<span class="old-price">${parseInt(matchedVariant.original_price).toLocaleString('vi-VN')} VNĐ</span>`
            : ''
        }
        <span class="new-price">
            ${parseInt(matchedVariant.price_modifier).toLocaleString('vi-VN')} VNĐ
        </span>
    `;

                if (variantInput) {
                    variantInput.setAttribute("data-variant-id", matchedVariant.id);
                }

                // Cập nhật hình ảnh chính
                const mainImage = document.getElementById('product-image');
                mainImage.src = `{{ asset('storage/') }}/${matchedVariant.variant_image}`;

                // Cập nhật carousel ảnh biến thể
                const productCarousel = document.querySelector('.product-single-carousel');
                productCarousel.innerHTML = ''; // Clear existing images

                matchedVariant.images.forEach(imageUrl => {
                    const productItem = document.createElement('div');
                    productItem.className = 'product-item';
                    productItem.innerHTML = `
            <img class="product-single-image" 
                 src="{{ asset('storage/') }}/${imageUrl}" 
                 data-zoom-image="{{ asset('storage/') }}/${imageUrl}" 
                 width="468" height="468" alt="product" />
        `;
                    productCarousel.appendChild(productItem);
                });

                // Cập nhật ảnh thu nhỏ
                const productThumbnails = document.querySelector('.prod-thumbnail');
                productThumbnails.innerHTML = ''; // Clear existing thumbnails

                matchedVariant.images.forEach(imageUrl => {
                    const thumbnailItem = document.createElement('div');
                    thumbnailItem.className = 'owl-dot';
                    thumbnailItem.innerHTML = `
            <img src="{{ asset('storage/') }}/${imageUrl}" width="110" height="110" alt="product-thumbnail" />
        `;
                    productThumbnails.appendChild(thumbnailItem);
                });
            }
        });

        const productVariant = document.getElementById('product-variant-id');
        if (productVariant) {
            productVariant.addEventListener('click', function() {
                const productId = productVariant.getAttribute('data-product-id');
                const productVariantId = productVariant.getAttribute('data-variant-id');
                const quantity = 1; // Mặc định là 1 sản phẩm

                // Gửi yêu cầu Ajax để thêm sản phẩm vào giỏ hàng
                $.ajax({
                    type: "POST",
                    url: "{{ route('addCart') }}",
                    data: {
                        product_id: productId,
                        product_variants_id: productVariantId,
                        quantity: quantity, // Sử dụng số lượng là 1
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var stockAlertMmessage = document.querySelector('#stock-alert-message');
                        if(response.status==false){
                            stockAlertMmessage.innerHTML=response.message;
                            showCartModal();
                        }
                        showCartModal();
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
                        } else {
                            alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    }
                });
            });

            // Hàm hiển thị modal khi thêm sản phẩm vào giỏ hàng thành công
            function showCartModal() {
                var cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
                cartModal.show(); // Hiển thị modal
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const attributeInputs = document.querySelectorAll('.attribute-input');

            attributeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    console.log(`Selected ${this.name}: ${this.value}`);
                });
            });
        });

        // Đổi giá variant

        // Biến để lưu trữ giá của từng biến thể

        document.addEventListener('DOMContentLoaded', function() {
            const variants = @json($variants);
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.owl-dot');
            const mainImage = document.getElementById('product-image'); // Ảnh chính
            const productCarousel = document.getElementById('product-single-carousel'); // Carousel chính

            // Lắng nghe sự kiện click trên từng thumbnail
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    const imageUrl = thumbnail.getAttribute(
                        'data-image'); // Lấy đường dẫn ảnh từ thuộc tính data-image
                    mainImage.src = imageUrl; // Cập nhật ảnh chính

                    // Không ẩn carousel, nhưng có thể thay đổi trạng thái khác nếu cần
                    productCarousel.classList.add(
                        'carousel-hidden'); // Nếu bạn muốn ẩn carousel tạm thời
                });
            });
        });
    </script>
@endsection
