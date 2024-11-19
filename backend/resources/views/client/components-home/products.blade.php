<!-- resources/views/components/productcomponent.blade.php -->

<h2 class="section-title ls-n-10 m-b-4 appear-animate" data-animation-name="fadeInUpShorter">
    {{ $title }}
</h2>

<div class="products-slider owl-carousel owl-theme dots-top dots-small m-b-1 pb-1 appear-animate"
    data-animation-name="fadeInUpShorter">
    @foreach ($products as $item)
        <div class="product-default inner-quickview inner-icon" data-product-id="{{ $item->id }}" data-product-variant-id="{{ $item->product_variant_id }}">
            <figure class="img-effect">
                <a href="{{route('client.showProduct',$item->id)}}">
                    @php
                        $mainImage = $item->galleries->where('is_main', true)->first();
                        $otherImages = $item->galleries->where('is_main', false)->take(1);
                    @endphp
                
                    @if ($mainImage)
                        <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205" height="205" alt="{{ $item->name }}" />
                    @endif
                    
                    @foreach ($otherImages as $value)
                        <img src="{{ \Storage::url($value->image_gallery) }}" width="205" height="205" alt="{{ $item->name }}" />
                    @endforeach
                    </a>
                <div class="label-group">
                    @if ($item->is_hot_deal == 1)
                        <div class="product-label label-hot">HOT</div>
                    @endif
                    {{-- <div class="product-label label-hot">HOT</div> --}}

                    @php
                        // Xác định giá sản phẩm
                        if (isset($item->productVariant)) {
                            // Nếu có product_variant, lấy giá từ biến thể
                            $price = $item->productVariant->price_modifier;
                        } else {
                            // Nếu không có product_variant, kiểm tra giá sale của sản phẩm
                            $price = ($item->price_sale !== null && $item->price_sale < $item->price_regular)
                                ? $item->price_sale // Lấy giá sale nếu có
                                : $item->price_regular; // Nếu không có giá sale, lấy giá thường
                        }

                        // Tính toán phần trăm giảm giá nếu có giá sale hợp lệ
                        $discountPercentage = null;
                        if ($item->price_sale !== null && $item->price_sale < $item->price_regular) {
                            $discountPercentage = round(
                                (($item->price_regular - $item->price_sale) / $item->price_regular) * 100
                            );
                        }
                    @endphp

                    @if ($discountPercentage !== null)
                        <div class="product-label label-sale">- {{ $discountPercentage }}%</div>
                    @endif

                    {{-- <div class="product-label label-sale"></div> --}}
                </div>
                <div class="btn-icon-group">
                    <a href="#" title="Add To Cart"
                        class="btn-icon btn-add-cart product-type-simple"><i
                            class="icon-shopping-cart"></i></a>
                </div>
                <a href="{{route('client.showProduct', $item->id)}}"  title="Quick View"><button class="btn-quickview" style="cursor: pointer;">Chi tiết</button></a>
            </figure>
            <div class="product-details">
                <div class="category-wrap">
                    <div class="category-list">
                        <a href="{{route('client.showProduct',$item->id)}}" class="product-category">
                            {{-- {{ $item->category->name }} --}}
                        </a>
                    </div>
                    <a href="#" class="btn-icon-wish"
                    onclick="addToWishlist({{ $item->id }}, {{ $item->product_variant_id }})"
                    title="{{ $item->isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                        <i class="icon-heart {{ $item->isInWishlist ? 'active' : '' }}"></i>
                    </a>
                </div>
                <h3 class="product-title"> <a href="">{{ $item->name }}</a> </h3>
                </h3>
                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:{{ $item->rating * 20 }}%"></span>
                        <!-- Đoạn này sẽ tính phần trăm dựa trên giá trị rating (0 - 5 sao) -->
                        <span class="tooltiptext tooltip-top">{{ $item->rating }} </span>
                        <!-- Hiển thị giá trị rating khi hover chuột -->
                    </div>
                    <!-- End .product-ratings -->
                </div>
                <!-- End .product-container -->
                <div class="price-box">
                    @if ($item->price_sale == null)
                        <span class="new-price" style="color: #08c; font-size: 1.2em;">{{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                    @else
                        <span class="new-price" style="color: #08c;  font-size: 1.2em;">{{ number_format($item->price_sale, 0, ',', '.') }} ₫</span>
                        <span class="old-price">{{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                    @endif
                </div>
                <!-- End .price-box -->
            </div>
            <!-- End .product-details -->
        </div>
    @endforeach
</div>
