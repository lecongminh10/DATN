<aside class="sidebar-home col-lg-3 order-lg-first mobile-sidebar">
    <div class="side-menu-wrapper text-uppercase mb-2 d-none d-lg-block">
        {{-- <h2 class="side-menu-title bg-gray ls-n-25">Browse Categories</h2> --}}

        <nav class="side-nav">
            <ul class="menu menu-vertical sf-arrows">
                <li class="active"><a href="{{route('client')}}"><i class="icon-home"></i>Trang chủ</a></li>
                <li>
                    <a href="{{ route('client.products') }}" class="sf-with-ul"><i class="sicon-badge"></i>Danh mục</a>
                    <div class="megamenu megamenu-fixed-width megamenu-3cols">
                        <div class="row">
                            @foreach ($categories as $parent)
                                <div class="col-lg-4">
                                    <a href="{{ route('client.products.Category', $parent->id) }}"
                                        class="nolink pl-0">{{ $parent->name }}</a>
                                    @if ($parent->children->isNotEmpty())
                                        <ul class="submenu">
                                            @foreach ($parent->children as $child)
                                                <li><a
                                                        href="{{ route('client.products.Category', $child->id) }}">{{ $child->name }}</a>
                                                </li>
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
            @foreach ($bannerLeft as $banner)
                @if ($banner->active == 1)
                    <div class="banner d-flex flex-column align-items-center text-center">
                        <figure class="mb-4">
                            <img src="{{ Storage::url($banner->image) }}" alt="{{$banner->title}}"
                                class="img-fluid rounded shadow-lg">
                        </figure>
                        <h4 class="sale-text text-uppercase mb-1">
                            <small>Khuyến mãi </small>
                            <span>{{ $banner->sale ?? 0 }}<sup>%</sup><sub>off</sub></span>
                        </h4>
                        <p class="mb-1">{{ $banner->description ?? 'Nhiều loại sản phẩm khác nhau' }}</p>
                    </div>
                @endif
            @endforeach
        </div>
        <!-- End .banner-slider -->
    </div>
</aside>
