<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu menu-with-icon">
                <li><a href="{{route('client')}}"><i class="icon-home"></i>Trang chủ</a></li>
                <li>
                    <a href=" {{route('client.products') }}" class="sf-with-ul"><i class="sicon-basket"></i>Sản phẩm</a>
                </li>
                <li><a href="{{route('client.blogs.index')}}"><i class="sicon-book-open"></i>Bài viết</a></li>
                {{-- <li><a href="demo1-about.html"><i class="sicon-users"></i>About Us</a></li> --}}
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
