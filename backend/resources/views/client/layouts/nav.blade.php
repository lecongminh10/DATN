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
                        <a href="{{route('client.products')}}">Danh mục</a>
                        <div class="megamenu megamenu-fixed-width megamenu-3cols">
                            <div class="row">
                                @foreach ($categories as $parent)
                                    <div class="col-lg-4">
                                        <a href="#" class="nolink pl-0">{{ $parent->name }}</a>
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
                        <!-- End .megamenu -->
                    </li>
                    <li class="">
                        <a href="{{route('client.products')}}">Products</a>
                    </li>
                    <li class="">
                        <a href="" class="sf-with-ul"><i class="sicon-envelope"></i>Trang</a>
                        <ul>
                            @foreach($page as $page)
                                <li>
                                    <a href="{{ route('pages.show', ['permalink' => $page->permalink]) }}">{{ $page->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class=""><a href="{{ route('client.blogs.index') }}"><i class="sicon-book-open"></i>Blog</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End .container -->
</div>
