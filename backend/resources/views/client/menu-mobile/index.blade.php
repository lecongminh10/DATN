<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu menu-with-icon">
                <li><a href="{{route('client')}}"><i class="icon-home"></i>Trang chủ</a></li>
                {{-- <li>
                    <a href="{{route('client.products')}}" class="sf-with-ul"><i class="sicon-badge"></i>Danh mục</a>
                    <div class="megamenu megamenu-fixed-width megamenu-3cols">
                        <div class="row">
                            @foreach ($categories as $parent)
                                <ul>
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
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </li> --}}
                <li>
                    <a href=" {{route('client.products') }}" class="sf-with-ul"><i class="sicon-basket"></i>Sản phẩm</a>
                </li>
                <li><a href="{{route('client.blogs.index')}}"><i class="sicon-book-open"></i>Bài viết</a></li>
                @if(isset($pages) && $pages->count() > 0)
                <li>
                    <a href="#" class="sf-with-ul"><i class="sicon-badge"></i>Trang</a>
                    <ul class="submenu">
                        @foreach ($pages as $item)
                        <li>
                            <a href="{{ route('pages.show', ltrim(parse_url($item->permalink, PHP_URL_PATH), '/')) }}">
                                {{ $item->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endif
            </ul>

            <ul class="mobile-menu">
                {{-- <a href="login.html">Hồ sơ của tôi</a></li> --}}
                <li> <a href="{{ Auth::check() ? route('users.indexClient') : route('client.login') }}" >
                    Hồ sơ của tôi </a>
                </li>
                {{-- <li><a href="demo1-contact.html">Liên hệ</a></li> --}}
                <li><a href="{{ route('wishList') }}">Mục yêu thích</a></li>
                {{-- <li><a href="#">Site Map</a></li>
                <li><a href="cart.html">Cart</a></li>
                <li><a href="login.html" class="login-link">Log In</a></li> --}}
            </ul>
        </nav>
        <!-- End .mobile-nav -->
    </div>
    <!-- End .mobile-menu-wrapper -->
</div>
