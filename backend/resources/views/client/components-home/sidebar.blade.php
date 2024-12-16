<aside class="sidebar-home col-lg-3 order-lg-first mobile-sidebar">
    <div class="side-menu-wrapper text-uppercase mb-2 d-none d-lg-block">
        {{-- <h2 class="side-menu-title bg-gray ls-n-25">Browse Categories</h2> --}}

        <nav class="side-nav">
            <ul class="menu menu-vertical sf-arrows">
                <li class="active"><a href="{{route('client')}}"><i class="icon-home"></i>Trang chủ</a></li>
                <li>
                    <a href="{{route('client.products')}}" class="sf-with-ul"><i class="sicon-badge"></i>Danh mục</a>
                    <div class="megamenu megamenu-fixed-width megamenu-3cols">
                        <div class="row">
                            @foreach ($categories as $parent)
                                <div class="col-lg-4">
                                    <a href="{{ route('client.products.Category',$parent->id) }}" class="nolink pl-0">{{ $parent->name }}</a>
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
                </li>
                <li>
                    <a href="{{route('client.products')}}" ><i
                            class="sicon-basket"></i>Sản phẩm</a>
                </li>
                <li><a href="{{ route('client.blogs.index') }}"><i class="sicon-book-open"></i>Bài viết</a></li>
                <li>
                    <a href="" class="sf-with-ul"><i class="sicon-badge"></i>Trang</a>
                    <div class="megamenu megamenu-fixed-width megamenu-3cols">
                        <div class="row">
                             <ul class="submenu col-lg-4">
                                    @foreach ($pages as $item)
                                          <li><a href="{{ url($item->permalink) }}">{{ $item->name }}</a></li>
                                    @endforeach
                            </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End .side-menu-container -->

    <div class="widget widget-banners px-3 pb-3 text-center">
        <div class="owl-carousel owl-theme dots-small">
            <div class="banner d-flex flex-column align-items-center">
                <h3 class="badge-sale bg-primary d-flex flex-column align-items-center justify-content-center text-uppercase">
                    <em>Mới nhất</em>Nhiều sản phẩm
                </h3>

                <h4 class="sale-text text-uppercase"><small>Khuyến mãi </small>50<sup>%</sup><sub>off</sub></h4>
                <p>Nhiều loại sản phẩm khác nhau</p>
            </div>
            <!-- End .banner -->

            <div class="banner banner4">
                <figure>
                    <img src="{{asset('themeclient/assets/images/demoes/demo1/banners/banner-7.jpg')}}" alt="banner">
                </figure>

                <div class="banner-layer">
                    <div class="coupon-sale-content">
                        <h4>Iphone 16 mới nhất</h4>
                        <h5 class="coupon-sale-text text-gray ls-n-10 p-0 font1"><i>Giảm ngay</i><b class="text-white bg-dark font1">10%</b> OFF</h5>
                        <p class="ls-0">Top sản phẩm mới!</p>
                    </div>
                </div>
            </div>
            <!-- End .banner -->

            <div class="banner banner5">
                <h4>Mới nhất</h4>

                <figure class="m-b-3">
                    <img src="{{asset('themeclient/assets/images/demoes/demo1/banners/banner-8.jpg')}}" alt="banner">
                </figure>

                <div class="banner-layer">
                    <div class="coupon-sale-content">
                        <h5 class="coupon-sale-text ls-n-10 p-0 font1"><i>Mua ngay</i><b class="text-white bg-secondary font1">50%</b> OFF</h5>
                    </div>
                </div>
            </div>
            <!-- End .banner -->
        </div>
        <!-- End .banner-slider -->
    </div>
</aside>