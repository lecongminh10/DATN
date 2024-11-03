<?php
$minPrice = \App\Models\Product::min('price_sale'); // Lấy giá trị min
$maxPrice = \App\Models\Product::max('price_sale'); // Lấy giá trị max
?>
@extends('client.layouts.app')
@section('style_css')
    <style>
   .cat-list, .cat-sublist {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.cat-list > li, .cat-sublist > li {
    margin: 5px 0;
}

.cat-list a, .cat-sublist a {
    text-decoration: none;
    color: #333;
    padding: 5px 10px;
    display: block;
}

.cat-sublist {
    padding-left: 15px;
    margin-top: 5px;
    border-left: 1px solid #ddd;
}

    </style>
@endsection
@section('content')
    @include('client.layouts.nav')
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
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
                                    <select name="orderby" class="form-control" id="sort-options">
                                        <option value="price-asc" {{ request('orderby') == 'price-asc' ? 'selected' : '' }}>
                                            Giá thấp - cao</option>
                                        <option value="price-desc"
                                            {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>Giá cao - thấp
                                        </option>
                                        <option value="hot-promotion"
                                            {{ request('orderby') == 'hot-promotion' ? 'selected' : '' }}>Khuyến mãi hot
                                        </option>
                                        <option value="popularity"
                                            {{ request('orderby') == 'popularity' ? 'selected' : '' }}>Xem nhiều</option>
                                    </select>
                                </div>
                                <!-- End .select-custom -->
                            </div>
                        </form>

                        <!-- End .toolbox-item -->
                    </div>
                    <!-- End .toolbox-left -->

                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-show">
                            <label>Show:</label>
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="select-custom">
                                    <select name="count" class="form-control" onchange="this.form.submit()">
                                        <option value="12" {{ request('count') == 12 ? 'selected' : '' }}>12</option>
                                        <option value="24" {{ request('count') == 24 ? 'selected' : '' }}>24</option>
                                        <option value="36" {{ request('count') == 36 ? 'selected' : '' }}>36</option>
                                    </select>
                                </div>
                                <!-- End .select-custom -->
                            </form>
                            <!-- End .select-custom -->
                        </div>
                        <!-- End .toolbox-item -->

                        <div class="toolbox-item layout-modes">
                            <a href="category.html" class="layout-btn btn-grid active" title="Grid">
                                <i class="icon-mode-grid"></i>
                            </a>
                            <a href="category-list.html" class="layout-btn btn-list" title="List">
                                <i class="icon-mode-list"></i>
                            </a>
                        </div>
                        <!-- End .layout-modes -->
                    </div>
                    <!-- End .toolbox-right -->
                </nav>

                <div class="row">
                    @foreach ($products as $item)
                        <div class="col-6 col-sm-4">
                            <div class="product-default">
                                <figure>
                                    @php
                                    $mainImage = $item->galleries->firstWhere('is_main', true);
                                    $fallbackImage = $item->galleries->first();
                                    @endphp
                                    
                                    @if ($mainImage)
                                        <a href="{{ route('client.showProduct', $item->id) }}">
                                            <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205" height="205" alt="{{ $item->name }}" />
                                        </a>
                                    @elseif ($fallbackImage)
                                        <a href="{{ route('client.showProduct', $item->id) }}">
                                            <img src="{{ \Storage::url($fallbackImage->image_gallery) }}" width="205" height="205" alt="{{ $item->name }}" />
                                        </a>
                                    @endif
                                
                                    <div class="label-group">
                                        <div class="product-label label-hot">{{ $item->tags }}</div>
                                        @if ($item->price_sale < $item->price_regular)
                                            @php
                                                $discountPercentage = round(
                                                    (($item->price_regular - $item->price_sale) /
                                                        $item->price_regular) *
                                                        100,
                                                );
                                            @endphp
                                            <div class="product-label label-sale">SALE - {{ $discountPercentage }}%</div>
                                        @endif
                                    </div>
                                </figure>

                                <div class="product-details">
                                    <div class="category-wrap">
                                        <div class="category-list">
                                            <a href="{{route('client.showProduct', $item->id)}}"
                                                class="product-category">{{ $item->category->name }}</a>
                                        </div>
                                    </div>

                                    <h3 class="product-title"> <a href="{{route('client.showProduct', $item->id)}}">{{ $item->name }}</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:{{ $item->rating * 20 }}%"></span>
                                            <span class="tooltiptext tooltip-top">{{ $item->rating }} </span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        @if ($item->price_sale < $item->price_regular)
                                            <span class="product-price" style="color: #08c;">
                                                {{ number_format($item->price_sale, 0, ',', '.') }} ₫
                                                </span>
                                            <span class="old-price"
                                                style="text-decoration: line-through; font-size: 0.8em;">
                                                {{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                                        @else
                                            <span class="product-price" style="color: #08c;">{{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                                        @endif
                                    </div>

                                    <!-- End .price-box -->

                                    <div class="product-action">
                                        <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i
                                                class="icon-heart"></i></a>
                                        <a href="{{route('client.showProduct', $item->id)}}" class="btn-icon btn-add-cart"><i
                                                class="fa fa-arrow-right"></i><span>Xem chi tiết </span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
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
                            <div class="select-custom">
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
                    <ul class="pagination toolbox-item">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </ul>
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
                            <!-- Assuming this is part of your main view where categories are displayed -->
                                <div class="widget-body">
                                    @include('client.products.components.categories-list', ['categories' => $categories])
                                </div>
                            <!-- End .widget-body -->
                        </div>

                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true"
                                aria-controls="widget-body-3">Giá </a>
                        </h3>

                        <div class="collapse show" id="widget-body-3">
                            <div class="widget-body pb-0">
                                <form action="{{ route('client.products.filterByPrice') }}" method="GET">
                                    <div class="price-slider-wrapper">
                                        <div id="price-slider"></div>
                                    </div>

                                    <div
                                        class="filter-price-action d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="filter-price-text">
                                            Giá từ:
                                            <span id="filter-price-range">{{ number_format($minPrice ?? 0, 0, ',', '.') }} đ - 
                                                {{ number_format($maxPrice ?? 100000000, 0, ',', '.') }} đ</span>
                                        </div>

                                        <input type="hidden" name="min" id="min"
                                            value="{{ $minPrice ?? 0 }}">
                                        <input type="hidden" name="max" id="max"
                                            value="{{ $maxPrice ?? 100000000 }}">

                                        <button type="submit" class="btn btn-primary">Lọc</button>
                                    </div>

                                </form>

                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>

                    <!-- End .widget -->

                    <div class="widget widget-color">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true"
                                aria-controls="widget-body-4">Color</a>
                        </h3>

                        <div class="collapse show" id="widget-body-4">
                            <div class="widget-body pb-0">
                                <ul class="config-swatch-list">
                                    <li class="active">
                                        <a href="#" style="background-color: #000;"></a>
                                    </li>
                                    <li>
                                        <a href="#" style="background-color: #0188cc;"></a>
                                    </li>
                                    <li>
                                        <a href="#" style="background-color: #81d742;"></a>
                                    </li>
                                    <li>
                                        <a href="#" style="background-color: #6085a5;"></a>
                                    </li>
                                    <li>
                                        <a href="#" style="background-color: #ab6e6e;"></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget widget-size">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="true"
                                aria-controls="widget-body-5">Size</a>
                        </h3>

                        <div class="collapse show" id="widget-body-5">
                            <div class="widget-body pb-0">
                                <ul class="config-size-list">
                                    <li class="active"><a href="#">XL</a></li>
                                    <li><a href="#">L</a></li>
                                    <li><a href="#">M</a></li>
                                    <li><a href="#">S</a></li>
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->
                    <div class="widget widget-memory">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-memory" role="button" aria-expanded="true"
                                aria-controls="widget-body-memory">Bộ Nhớ</a>
                        </h3>

                        <div class="collapse show" id="widget-body-memory">
                            <div class="widget-body pb-0">
                                <ul class="config-size-list">
                                    <li class="active"><a href="#">128GB</a></li>
                                    <li><a href="#">256GB</a></li>
                                    <li><a href="#">512GB</a></li>
                                    <li><a href="#">1TB</a></li>
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->
                    <div class="widget widget-ram">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-ram" role="button" aria-expanded="true"
                                aria-controls="widget-body-ram">RAM</a>
                        </h3>

                        <div class="collapse show" id="widget-body-ram">
                            <div class="widget-body pb-0">
                                <ul class="config-size-list">
                                    <li class="active"><a href="#">8GB</a></li>
                                    <li><a href="#">16GB</a></li>
                                    <li><a href="#">32GB</a></li>
                                    <li><a href="#">64GB</a></li>
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>

                    {{-- <div class="widget widget-block">
                        <h3 class="widget-title">Custom HTML Block</h3>
                        <h5>This is a custom sub-title.</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non placerat mi. Etiam non tellus
                        </p>
                    </div> --}}
                    <!-- End .widget -->
                </div>
                <!-- End .sidebar-wrapper -->
            </aside>
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>
@endsection
@section('scripte_logic')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
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

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".cat-list a[role='button']").forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault();
                    const targetId = this.getAttribute("aria-controls");
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        targetElement.classList.toggle("show");
                        this.setAttribute(
                            "aria-expanded",
                            targetElement.classList.contains("show") ? "true" : "false"
                        );
                    }
                });
            });
        });

        
    </script>
    <script>
        function toggleDropdown(event) {
                // Prevent default action
                event.preventDefault();

                // Get the clicked toggle element and corresponding sublist
                const toggle = event.target;
                const sublist = document.getElementById(toggle.getAttribute('aria-controls'));

                // Toggle the visibility of the sublist
                if (sublist.style.display === 'none') {
                    sublist.style.display = 'block';
                    toggle.setAttribute('aria-expanded', 'true');
                } else {
                    sublist.style.display = 'none';
                    toggle.setAttribute('aria-expanded', 'false');
                }
            }
        </script>
        
@endsection
</style>
