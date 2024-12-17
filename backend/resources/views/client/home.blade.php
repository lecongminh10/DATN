@extends('client.layouts.app')
@section('content')
    <main class="main home">
        <div class="container mb-2">
            <div>
                @php
                    $infoBox = App\Models\InfoBox::first(); // Lấy dữ liệu từ DB
                @endphp

                <div style ="display:{{ $infoBox->active ? '' : 'none' }}"
                    class="info-boxes-container row row-joined mb-2 font2">
                    <!-- Info Box 1 -->
                    <div class="info-box info-box-icon-left col-lg-4">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>{{ $infoBox->title1 ?? 'No information available' }}</h4>
                            <p class="">{{ $infoBox->description_shopping ?? 'No information available' }}</p>
                        </div>
                    </div>

                    <!-- Info Box 2 -->
                    <div class="info-box info-box-icon-left col-lg-4">
                        <i class="icon-money"></i>

                        <div class="info-box-content">
                            <h4>{{ $infoBox->title2 ?? 'No information available' }}</h4>
                            <p class="text-body">{{ $infoBox->description_money ?? 'No information available' }}</p>
                        </div>
                    </div>

                    <!-- Info Box 3 -->
                    <div class="info-box info-box-icon-left col-lg-4">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>{{ $infoBox->title3 ?? 'No information available' }}</h4>
                            <p class="text-body">{{ $infoBox->description_support ?? 'No information available' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="home-slider slide-animate owl-carousel owl-theme mb-2"
                        data-owl-options="{
                    'loop': false,
                    'dots': true,
                    'nav': false
                }">
                        @include('client.advertising_bar.slide-home')
                    </div>

                    <div class="banners-container m-b-2 owl-carousel owl-theme"
                        data-owl-options="{
                    'dots': false,
                    'margin': 20,
                    'loop': false,
                    'responsive': {
                        '480': {
                            'items': 2
                        },
                        '768': {
                            'items': 3
                        }
                    }
                }">
                        @include('client.banner.banner2')
                    </div>

                    @include('client.components-home.products', [
                        'title' => 'Mới nhất',
                        'products' => $latestProducts,
                    ])

                    @include('client.components-home.products', [
                        'title' => 'Truy cập nhiều nhất',
                        'products' => $products,
                    ])

                    @include('client.components-home.products', [
                        'title' => 'Lượt mua nhiều nhất',
                        'products' => $buyCountProducts,
                    ])
                    @include('client.banner.trademark')
                    <div class="row products-widgets">
                        @include('client.banner.product-widgets-home')
                    </div>

                    <hr class="mt-1 mb-3 pb-2">

                    <div class="feature-boxes-container">

                        @php
                            $infoBoxFooter = App\Models\infoBoxFooter::first(); // Lấy dữ liệu từ DB
                        @endphp
                        <div class="row" style ="display:{{ $infoBoxFooter->active ? '' : 'none' }}">
                            <div class="col-md-4 appear-animate" data-animation-name="fadeInRightShorter"
                                data-animation-delay="200">
                                <div class="feature-box  feature-box-simple text-center">
                                    <i class="icon-earphones-alt"></i>

                                    <div class="feature-box-content p-0">
                                        <h3 class="mb-0 pb-1">{{ $infoBoxFooter->title_1 }}</h3>
                                        <h5 class="mb-1 pb-1">{{ $infoBoxFooter->sub_title_1 }}</h5>

                                        <p>{{ $infoBoxFooter->description_support }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 appear-animate" data-animation-name="fadeInRightShorter"
                                data-animation-delay="400">
                                <div class="feature-box feature-box-simple text-center">
                                    <i class="icon-credit-card"></i>

                                    <div class="feature-box-content p-0">
                                        <h3 class="mb-0 pb-1">{{ $infoBoxFooter->title_2 }}</h3>
                                        <h5 class="mb-1 pb-1">{{ $infoBoxFooter->sub_title_2 }}</h5>

                                        <p>{{ $infoBoxFooter->description_payment }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 appear-animate" data-animation-name="fadeInRightShorter"
                                data-animation-delay="600">
                                <div class="feature-box feature-box-simple text-center">
                                    <i class="icon-action-undo"></i>

                                    <div class="feature-box-content p-0">
                                        <h3 class="mb-0 pb-1">{{ $infoBoxFooter->title_3 }}</h3>
                                        <h5 class="mb-1 pb-1">{{ $infoBoxFooter->sub_title_3 }}</h5>

                                        <p>{{ $infoBoxFooter->description_return }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle custom-sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
                @include('client.components-home.sidebar')
                {{-- @include('client.products.search-results') --}}
            </div>
        </div>
    </main>
@endsection
@section('scripte_logic')
    <script>
        if (window.location.hash === "#_=_") {
            window.location.hash = "";
        }
    </script>
@endsection
