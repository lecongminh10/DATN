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
                    <li><a href="">Liên hệ</a></li>
                    <li><a href="">Chúng tôi</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End .container -->
</div>
