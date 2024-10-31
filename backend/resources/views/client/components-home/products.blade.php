<!-- resources/views/components/productcomponent.blade.php -->

<h2 class="section-title ls-n-10 m-b-4 appear-animate" data-animation-name="fadeInUpShorter">
    {{ $title }}
</h2>

<div class="products-slider owl-carousel owl-theme dots-top dots-small m-b-1 pb-1 appear-animate"
    data-animation-name="fadeInUpShorter">

    @foreach ($products as $item)
        <div class="product-default inner-quickview inner-icon">
            <figure class="img-effect">
                <a href="{{ route('client.showProduct', $item->id) }}">
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
                    <div class="product-label label-hot">HOT</div>
                    @if ($item->price_sale < $item->price_regular)
                        @php
                            $discountPercentage = round((($item->price_regular - $item->price_sale) / $item->price_regular) * 100);
                        @endphp
                        <div class="product-label label-sale">SALE - {{ $discountPercentage }}%</div>
                    @endif
                </div>
                <div class="btn-icon-group">
                    <a href="#" title="Add To Cart" class="btn-icon btn-add-cart product-type-simple">
                        <i class="icon-shopping-cart"></i>
                    </a>
                </div>
                <a href="{{ route('client.showProduct', $item->id) }}" class="btn-quickview" title="Quick View">Chi tiết</a>
            </figure>
            <div class="product-details">
                <div class="category-wrap">
                    <div class="category-list">
                        <a href="{{ route('client.showProduct', $item->id) }}" class="product-category">
                            {{ $item->category->name }}
                        </a>
                    </div>
                    <a href="wishlist.html" title="Add to Wishlist" class="btn-icon-wish">
                        <i class="icon-heart"></i>
                    </a>
                </div>
                <h3 class="product-title">
                    <a href="">{{ $item->name }}</a>
                </h3>
                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:{{ $item->rating * 20 }}%"></span>
                        <span class="tooltiptext tooltip-top">{{ $item->rating }}</span>
                    </div>
                </div>
                <div class="price-box">
                    @if ($item->price_sale < $item->price_regular)
                        <span class="product-price" style="text-decoration: line-through; font-size: 0.8em;">
                            {{ number_format($item->price_regular, 0, ',', '.') }} VNĐ
                        </span>
                        <br>
                        <span class="product-sale-price" style="color: #08c; font-size: 1.2em;">
                            {{ number_format($item->price_sale, 0, ',', '.') }} VNĐ
                        </span>
                    @else
                        <span class="product-price" style="color: #08c;">
                            {{ number_format($item->price_regular, 0, ',', '.') }} VNĐ
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
