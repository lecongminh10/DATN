<header class="header home">
    <div class="header-middle text-dark sticky-header">
        <div class="container">
            <div class="header-left col-lg-2 w-auto pl-0">
                <button class="mobile-menu-toggler mr-2" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('client') }}" class="logo">
                    <img src="{{ asset('logo.png') }}" width="200" height="100"
                        alt="ZonMart">
                </a>
            </div>
            <!-- End .header-left -->

            <div class="header-right w-lg-max pl-2">
                <div class="header-search header-icon header-search-inline header-search-category w-lg-max">
                    <a href="/" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                    <form action="{{ route('search') }}" method="get">
                        <div class="header-search-wrapper" style="border: 1px solid #08c;">
                            <input type="search" class="form-control" name="q" id="q"
                                placeholder="Search..." required>
                            <button class="btn icon-magnifier" type="submit" aria-label="Search"></button>
                        </div>
                    </form>
                </div>
                <!-- End .header-search -->

                <div class="header-contact d-none d-lg-flex align-items-center pr-xl-5 mr-5 mr-xl-3 ml-5">
                    <i class="icon-phone-2"></i>
                    <h6 class="pt-1 line-height-1">Liên hệ<a href="tel:#"
                            class="d-block text-dark ls-10 pt-1">0392853609</a></h6>
                </div>
                <!-- End .header-contact -->
                <a href="{{ Auth::check() ? route('users.indexClient') : route('client.login') }}"
                    class="header-icon header-icon-user">
                    <i class="icon-user-2"></i>
                </a>
                <a href="{{ route('wishList') }}" title="Cart" class="header-icon wishlist" style="  position: relative;">
                    <i class="icon-wishlist-2"></i>
                    <span class="wishlist-count badge-circle" style="position: absolute;top: 0;right: -10px; ">
                        {{($wishlistCount >0) ? $wishlistCount:''}}
                    </span>
               </a>
                <div class="dropdown cart-dropdown">
                    <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <i class="minicart-icon"></i>
                            @php
                                if($cartCount >0 && isset($cartCount)){
                                    $count =  $cartCount;
                                }else{
                                    $count='';
                                }
                            @endphp
                        <span class="cart-count badge-circle">{{ $count }}</span>
                    </a>

                    <div class="cart-overlay"></div>

                    <div class="dropdown-menu mobile-cart">
                        <a href="#" title="Close (Esc)" class="btn-close">×</a>

                        <div class="dropdownmenu-wrapper custom-scrollbar">
                            <div class="dropdown-cart-header">Giỏ hàng</div>
                            <!-- End .dropdown-cart-header -->

                            <div class="dropdown-cart-products">
                                @php
                                    $subTotal = 0; 
                                @endphp            
                               @if (isset($carts))
                               @foreach ($carts as $item)
                               <div class="product">
                                   <div class="product-details">
                                       <h4 class="product-title">
                                           <a href="{{ route('client.showProduct', $item->product->id ) }}">{{ $item->product->name }}</a>
                                       </h4>
                                       @php
                                            if ($item->product) {
                                                if (!is_null($item->product->price_sale) && $item->product->price_sale > 0) {
                                                    $price = $item->product->price_sale;
                                                } else {
                                                    $price = $item->product->price_regular; 
                                                }
                                                $sub = $price * $item->quantity; 
                                            }
                                           $subTotal += $sub; 
                                       @endphp
                                       <span class="cart-product-info">
                                           {{-- <input type="hidden" name="" value="{{ number_format($item->total_price, 0, ',', '.') }}"> --}}
                                           <span class="cart-product-qty">{{ $item->quantity }}</span> × {{ number_format( $price, 0, ',', '.') }}₫
                                       </span>
                                   </div>
                                   <!-- End .product-details -->
                                    <figure class="product-image-container">
                                            <a href="{{ route('client.showProduct', $item->product->id ) }}" class="product-image">
                                            @php
                                            $url = $item->product->getMainImage() && $item->product->getMainImage()->image_gallery
                                            ? $item->product->getMainImage()->image_gallery
                                            : 'path/to/default-image.jpg'; // Đường dẫn tới ảnh mặc định
                                            @endphp
                                            <img src="{{ Storage::url($url)}}" style="width: 80px; height: 70px" alt="{{ $item->product->name }}" />
                                            </a>
                                                                            
                                            <a href="#" class="btn-remove icon-cancel" title="Remove Product" data-id="{{ $item->id }}" onclick="removeFromCart(this)"></a>
                                    </figure>
                               </div>
                               @endforeach
                               @endif
                                <!-- End .product -->
                            </div>
                            <!-- End .cart-product -->

                            <div class="dropdown-cart-total">
                                <span>Tổng giá:</span>
                                <span
                                    class="cart-total-price float-right">{{ number_format($subTotal, 0, ',', '.') }}₫</span>
                            </div>
                            <!-- End .dropdown-cart-total -->

                            <div class="dropdown-cart-action">
                                <a href="{{ route('shopping-cart') }}" class="btn btn-gray btn-block view-cart">Giỏ hàng</a>
                                <a href="{{ route('checkout') }}" class="btn btn-dark btn-block">Mua ngay</a>
                            </div>
                            <!-- End .dropdown-cart-total -->
                        </div>
                        <!-- End .dropdownmenu-wrapper -->
                    </div>
                    <!-- End .dropdown-menu -->
                </div>
                <!-- End .dropdown -->
            </div>
            <!-- End .header-right -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .header-middle -->
</header>
