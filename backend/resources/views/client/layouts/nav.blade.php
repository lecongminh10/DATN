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
                        <a href="{{route('client')}}">Home</a>
                    </li>
                    <li>
                        <a href="">Categories</a>
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
                    <li >
                        <a href="{{route('client.products')}}">Products</a>
                        <!-- End .megamenu -->
                    </li>
                    <li class="active">
                        <a href="#" class="sf-with-ul"><i class="sicon-envelope"></i>Trang</a>
                        <ul>
                            @foreach($page as $page)
                                <li>
                                    <a href="{{ route('pages.show', ['permalink' => $page->permalink]) }}">{{ $page->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('client.blogs.index') }}"><i class="sicon-book-open"></i>Blog</a></li>
                </ul>
            </nav>
        </div>
        {{-- <div class="header-right">
            <div class="header-search header-icon header-search-inline header-search-category w-lg-max">
                <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                <form action="#" method="get">
                    <div class="header-search-wrapper">
                        <input type="search" class="form-control" name="q" id="qq" placeholder="Search..." required>
                        <div class="select-custom">
                            <select id="category" name="cat">
                                <option value="">All Categories</option>
                                <option value="4">Fashion</option>
                                <option value="12">- Women</option>
                                <option value="13">- Men</option>
                                <option value="66">- Jewellery</option>
                                <option value="67">- Kids Fashion</option>
                                <option value="5">Electronics</option>
                                <option value="21">- Smart TVs</option>
                                <option value="22">- Cameras</option>
                                <option value="63">- Games</option>
                                <option value="7">Home &amp; Garden</option>
                                <option value="11">Motors</option>
                                <option value="31">- Cars and Trucks</option>
                                <option value="32">- Motorcycles &amp; Powersports</option>
                                <option value="33">- Parts &amp; Accessories</option>
                                <option value="34">- Boats</option>
                                <option value="57">- Auto Tools &amp; Supplies</option>
                            </select>
                        </div>
                        <!-- End .select-custom -->
                        <button class="btn p-0 icon-search-3" type="submit"></button>
                    </div>
                    <!-- End .header-search-wrapper -->
                </form>
            </div>
            <!-- End .header-search -->

            <a href="login.html" class="header-icon login-link"><i class="icon-user-2"></i></a>

            <a href="wishlist.html" class="header-icon"><i class="icon-wishlist-2"></i></a>

            <div class="dropdown cart-dropdown">
                <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <i class="minicart-icon"></i>
                    <span class="cart-count badge-circle">3</span>
                </a>

                <div class="cart-overlay"></div>

                <div class="dropdown-menu mobile-cart">
                    <a href="#" title="Close (Esc)" class="btn-close">×</a>

                    <div class="dropdownmenu-wrapper custom-scrollbar">
                        <div class="dropdown-cart-header">Shopping Cart</div>
                        <!-- End .dropdown-cart-header -->

                        <div class="dropdown-cart-products">
                            <div class="product">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="demo1-product.html">Ultimate 3D Bluetooth Speaker</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span> × $99.00
                                    </span>
                                </div>
                                <!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="demo1-product.html" class="product-image">
                                        <img src="assets/images/products/product-1.jpg" alt="product" width="80" height="80">
                                    </a>

                                    <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                </figure>
                            </div>
                            <!-- End .product -->

                            <div class="product">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="demo1-product.html">Brown Women Casual HandBag</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span> × $35.00
                                    </span>
                                </div>
                                <!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="demo1-product.html" class="product-image">
                                        <img src="assets/images/products/product-2.jpg" alt="product" width="80" height="80">
                                    </a>

                                    <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                </figure>
                            </div>
                            <!-- End .product -->

                            <div class="product">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="demo1-product.html">Circled Ultimate 3D Speaker</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span> × $35.00
                                    </span>
                                </div>
                                <!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="demo1-product.html" class="product-image">
                                        <img src="assets/images/products/product-3.jpg" alt="product" width="80" height="80">
                                    </a>
                                    <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                </figure>
                            </div>
                            <!-- End .product -->
                        </div>
                        <!-- End .cart-product -->

                        <div class="dropdown-cart-total">
                            <span>SUBTOTAL:</span>

                            <span class="cart-total-price float-right">$134.00</span>
                        </div>
                        <!-- End .dropdown-cart-total -->

                        <div class="dropdown-cart-action">
                            <a href="cart.html" class="btn btn-gray btn-block view-cart">View
                                Cart</a>
                            <a href="checkout.html" class="btn btn-dark btn-block">Checkout</a>
                        </div>
                        <!-- End .dropdown-cart-total -->
                    </div>
                    <!-- End .dropdownmenu-wrapper -->
                </div>
                <!-- End .dropdown-menu -->
            </div>
            <!-- End .dropdown -->
        </div> --}}
    </div>
    <!-- End .container -->
</div>
