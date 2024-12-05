<div class="col-sm-6 col-md-4 pb-4 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="200">
    <div class="product-column">
        <h3 class="section-sub-title ls-n-20">Sản phẩm đánh giá hàng đầu</h3>

        @foreach ($ratingProducts->slice(0, 3) as $key => $value)
            <div class="product-default left-details product-widget">
                <figure>
                    <a href="{{route('client.showProduct',$value->id)}}">
                        @php
                            $mainImage = $value->galleries->where('is_main', true)->first();
                            $otherImages = $value->galleries->where('is_main', false)->take(1);
                        @endphp
                    
                        @if ($mainImage)
                            <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205" height="205" alt="{{ $value->name }}" />
                        @endif
                        
                        @foreach ($otherImages as $value)
                            <img src="{{ \Storage::url($value->image_gallery) }}" width="205" height="205" alt="{{ $value->name }}" />
                        @endforeach
                        </a>
                </figure>
                <div class="product-details">
                    <h3 class="product-title"> <a href="{{route('client.showProduct',$value->id)}}">{{ $value->name }}</a> </h3>
                    <div class="ratings-container">
                        <div class="product-ratings">
                            @php
                                // Đảm bảo giá trị rating và maxRating không bị null
                                $maxRating = 5; // Số sao tối đa
                                $ratingPercent = $value->rating ? ($value->rating / $maxRating) * 100 : 0;
                            @endphp
                            <span class="ratings" style="width:{{ $ratingPercent }}%"></span>
                            <!-- End .ratings -->
                            <span class="tooltiptext tooltip-top">
                                {{ $value->rating ?? 0 }}/{{ $maxRating }}
                            </span>
                        </div>
                        <!-- End .product-ratings -->
                    </div>
                    <!-- End .product-container -->
                    <div class="price-box">
                        {{-- <span class="product-price">{{ number_format($value->price_regular, 0, ',', '.') }} ₫</span> --}}
                        <span class="product-price" >
                            {{ number_format($value->price_sale ?? $value->price_regular, 0, ',', '.') }} ₫
                        </span>
                        {{-- @if ($value->price_sale == null)
                            <span class="product-price" style="color: #08c; font-size: 1.2em;">{{ number_format($value->price_regular, 0, ',', '.') }} ₫</span>
                        @else
                            <span class="product-price" style="color: #08c;  font-size: 1.2em;">{{ number_format($value->price_sale, 0, ',', '.') }} ₫</span>
                            <span class="old-price">{{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                        @endif --}}
                    </div>
                    <!-- End .price-box -->
                </div>
                <!-- End .product-details -->
            </div>
        @endforeach
    </div>
    <!-- End .product-column -->
</div>
<!-- End .col-md-4 -->

<div class="col-sm-6 col-md-4 pb-4 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="500">
    <div class="product-column">
        <h3 class="section-sub-title ls-n-20">Sản phẩm bán chạy nhất</h3>
        @foreach ($products->slice(0, 3) as $key => $value)
            <div class="product-default left-details product-widget ">
                <figure>
                    <a href="{{route('client.showProduct',$value->id)}}">
                        @php
                            $mainImage = $value->galleries->where('is_main', true)->first();
                            $otherImages = $value->galleries->where('is_main', false)->take(1);
                        @endphp
                    
                        @if ($mainImage)
                            <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205" height="205" alt="{{ $value->name }}" />
                        @endif
                        
                        @foreach ($otherImages as $value)
                            <img src="{{ \Storage::url($value->image_gallery) }}" width="205" height="205" alt="{{ $value->name }}" />
                        @endforeach
                        </a>
                </figure>
                <div class="product-details">
                    <h3 class="product-title"> <a href="{{route('client.showProduct',$value->id)}}">{{ $value->name }}</a>
                    </h3>
                    <div class="ratings-container">
                        <div class="product-ratings">
                            @php
                                // Đảm bảo giá trị rating và maxRating không bị null
                                $maxRating = 5; // Số sao tối đa
                                $ratingPercent = $value->rating ? ($value->rating / $maxRating) * 100 : 0;
                            @endphp
                            <span class="ratings" style="width:{{ $ratingPercent }}%"></span>
                            <!-- End .ratings -->
                            <span class="tooltiptext tooltip-top">
                                {{ $value->rating ?? 0 }}/{{ $maxRating }}
                            </span>
                        </div>
                        <!-- End .product-ratings -->
                    </div>
                    <!-- End .product-container -->
                    <div class="price-box">
                        <span class="product-price" >
                            {{ number_format($value->price_sale ?? $value->price_regular, 0, ',', '.') }} ₫
                        </span>
                    </div>
                    <!-- End .price-box -->
                </div>
                <!-- End .product-details -->
            </div>
        @endforeach
    </div>
    <!-- End .product-column -->
</div>
<!-- End .col-md-4 -->

<div class="col-sm-6 col-md-4 pb-4 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="800">
    <div class="product-column">
        <h3 class="section-sub-title ls-n-20">Sản phẩm mới nhất</h3>

        @foreach($latestProducts->slice(0, 3) as $key => $value)
            <div class="product-default left-details product-widget ">
                <figure>
                    <a href="{{route('client.showProduct',$value->id)}}">
                        @php
                            $mainImage = $value->galleries->where('is_main', true)->first();
                            $otherImages = $value->galleries->where('is_main', false)->take(1);
                        @endphp
                    
                        @if ($mainImage)
                            <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205" height="205" alt="{{ $value->name }}" />
                        @endif
                        
                        @foreach ($otherImages as $value)
                            <img src="{{ \Storage::url($value->image_gallery) }}" width="205" height="205" alt="{{ $value->name }}" />
                        @endforeach
                        </a>
                </figure>
                <div class="product-details">
                    <h3 class="product-title"> <a href="{{route('client.showProduct',$value->id)}}">{{ $value->name }}</a> </h3>
                    <div class="ratings-container">
                        <div class="product-ratings">
                            @php
                                // Đảm bảo giá trị rating và maxRating không bị null
                                $maxRating = 5; // Số sao tối đa
                                $ratingPercent = $value->rating ? ($value->rating / $maxRating) * 100 : 0;
                            @endphp
                            <span class="ratings" style="width:{{ $ratingPercent }}%"></span>
                            <!-- End .ratings -->
                            <span class="tooltiptext tooltip-top">
                                {{ $value->rating ?? 0 }}/{{ $maxRating }}
                            </span>
                        </div>
                        <!-- End .product-ratings -->
                    </div>
                    <!-- End .product-container -->
                    <div class="price-box">
                        <span class="product-price" >
                            {{ number_format($value->price_sale ?? $value->price_regular, 0, ',', '.') }} ₫
                        </span>
                    </div>
                    <!-- End .price-box -->
                </div>
                <!-- End .product-details -->
            </div>
        @endforeach
    </div>
    <!-- End .product-column -->
</div>