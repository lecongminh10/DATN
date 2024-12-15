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
                {{-- <li>
                    <a href="#" class="sf-with-ul"><i class="sicon-envelope"></i>Trang</a>

                    <ul>
                        <li><a href="wishlist.html">Wishlist</a></li>
                        <li><a href="cart.html">Shopping Cart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="dashboard.html">Dashboard</a></li>
                        <li><a href="demo1-about.html">About Us</a></li>
                        <li><a href="#">Blog</a>
                            <ul>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="single.html">Blog Post</a></li>
                            </ul>
                        </li>
                        <li><a href="demo1-contact.html">Contact Us</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="forgot-password.html">Forgot Password</a></li>
                    </ul>
                </li> --}}
                <li>
                    <a href="{{route('client.products')}}" ><i
                            class="sicon-basket"></i>Sản phẩm</a>
                </li>
                <li><a href="{{ route('client.blogs.index') }}"><i class="sicon-book-open"></i>Bài viết</a></li>
                <li><a href="demo1-about.html"><i class="sicon-users"></i>Chúng tôi</a></li>
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
    <!-- End .widget -->

    <!-- End .widget -->

    {{-- <div class="widget widget-posts post-date-in-media media-with-zoom mb-0 mb-lg-2 pb-lg-2">
        <div class="owl-carousel owl-theme dots-left dots-m-0 dots-small" data-owl-options="
            { 'margin' : 20,
              'loop': false }">
            <article class="post">
                <div class="post-media">
                    <a href="single.html">
                        <img src="{{asset('themeclient/assets/images/blog/home/post-1.jpg')}}" data-zoom-image="{{asset('themeclient/assets/images/blog/home/post-1.jpg')}}" width="280" height="209" alt="Post">
                    </a>
                    <div class="post-date">
                        <span class="day">29</span>
                        <span class="month">Jun</span>
                    </div>
                    <!-- End .post-date -->

                    <span class="prod-full-screen">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <!-- End .post-media -->

                <div class="post-body">
                    <h2 class="post-title">
                        <a href="single.html">Bản tin công nghệ </a>
                    </h2>

                    <div class="post-content">
                        <p>Leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with... </p>

                        <a href="single.html" class="read-more">read more <i
                                class="icon-right-open"></i></a>
                    </div>
                    <!-- End .post-content -->
                </div>
                <!-- End .post-body -->
            </article>

            <article class="post">
                <div class="post-media">
                    <a href="single.html">
                        <img src="{{asset('themeclient/assets/images/blog/home/post-2.jpg')}}" data-zoom-image="{{asset('themeclient/assets/images/blog/home/post-2.jpg')}}" width="280" height="209" alt="Post">
                    </a>
                    <div class="post-date">
                        <span class="day">29</span>
                        <span class="month">Jun</span>
                    </div>
                    <!-- End .post-date -->
                    <span class="prod-full-screen">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <!-- End .post-media -->

                <div class="post-body">
                    <h2 class="post-title">
                        <a href="single.html">Fashion Trends</a>
                    </h2>

                    <div class="post-content">
                        <p>Leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with... </p>

                        <a href="single.html" class="read-more">read more <i
                                class="icon-right-open"></i></a>
                    </div>
                    <!-- End .post-content -->
                </div>
                <!-- End .post-body -->
            </article>

            <article class="post">
                <div class="post-media">
                    <a href="single.html">
                        <img src="{{asset('themeclient/assets/images/blog/home/post-3.jpg')}}" data-zoom-image="{{asset('themeclient/assets/images/blog/home/post-3.jpg')}}" width="280" height="209" alt="Post">
                    </a>
                    <div class="post-date">
                        <span class="day">29</span>
                        <span class="month">Jun</span>
                    </div>
                    <!-- End .post-date -->
                    <span class="prod-full-screen">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <!-- End .post-media -->

                <div class="post-body">
                    <h2 class="post-title">
                        <a href="single.html">
                            Post Format Video</a>
                    </h2>

                    <div class="post-content">
                        <p>Leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with... </p>

                        <a href="single.html" class="read-more">read more <i
                                class="icon-right-open"></i></a>
                    </div>
                    <!-- End .post-content -->
                </div>
                <!-- End .post-body -->
            </article>
        </div>
        <!-- End .posts-slider -->
    </div> --}}
    <!-- End .widget -->
</aside>