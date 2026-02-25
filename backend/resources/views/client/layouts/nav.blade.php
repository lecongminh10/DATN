<div class="header-bottom sticky-header d-none d-lg-block bg-gray" data-sticky-options="{'mobile': true}">
    <div class="container">
        {{-- <div class="header-left">
            <a href="demo1.html" class="logo">
                <img src="assets/images/logo.png" alt="Porto Logo">
            </a>
        </div> --}}
        <div class="header-center">
            <nav class="main-nav w-100"> 
                <ul class="menu">
                    <li>
                        <a href="{{route('client')}}">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{route('client.products')}}">Sản phẩm</a>
                        <!-- End .megamenu -->
                    </li>
                    {{-- <li>
                        <a href="#">Trang</a>
                    </li> --}}
                    <li><a href="{{route('client.blogs.index')}}">Bài viết</a></li>
                    @if($pages->count() > 0)
                    <li>
                        <a href="#" class="sf-with-ul">Trang</a>
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
            </nav>
        </div>
    </div>
    <!-- End .container -->
</div>
