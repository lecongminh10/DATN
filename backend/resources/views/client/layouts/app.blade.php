@php
    use App\Models\Seo;

    $seo = SEO::getSeoByCurrentUrl();

@endphp
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from portotheme.com/html/porto_ecommerce/demo1.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Nov 2023 14:02:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <meta name="title" content="@yield('meta_title') , {{ $seo->meta_title ?? '' }}">
    <meta name="description" content="@yield('meta_description') , {{ $seo->meta_description ?? '' }}">
    <meta name="keywords" content="@yield('keywords') , {{ $seo->meta_keywords ?? '' }}">


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('themeclient/assets/images/icons/favicon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        WebFontConfig = {
            google: {
                families: ['Open+Sans:300,400,600,700', 'Poppins:300,400,500,600,700,800',
                    'Oswald:300,400,500,600,700,800', 'Playfair+Display:900', 'Shadows+Into+Light:400'
                ]
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = '{{ asset('themeclient/assets/js/webfont.js') }}';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('themeclient/assets/css/bootstrap.min.css') }}">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('themeclient/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themeclient/assets/css/demo1.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themeclient/assets/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themeclient/assets/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
    @yield('style_css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
</head>

<body>
    <div class="page-wrapper">
        @include('client.advertising_bar.index')
        <!-- End .top-notice -->

        @include('client.layouts.header')
        <!-- End .header -->

        @yield('content')
        <!-- End .main -->

        @include('client.layouts.footer')
        <!-- End .footer -->

        {{-- @vite('resources/js/coupon.js') --}}




    </div>
    <!-- End .page-wrapper -->

    {{-- <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div> --}}

    <div class="mobile-menu-overlay"></div>
    <!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu menu-with-icon">
                    <li><a href="demo1.html"><i class="icon-home"></i>Home</a></li>
                    <li>
                        <a href="demo1-shop.html" class="sf-with-ul"><i class="sicon-badge"></i>Categories</a>
                        <ul>
                            <li><a href="category.html">Full Width Banner</a></li>
                            <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a></li>
                            <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a></li>
                            <li><a href="https://www.portotheme.com/html/porto_ecommerce/category-sidebar-left.html">Left
                                    Sidebar</a></li>
                            <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                            <li><a href="category-off-canvas.html">Off Canvas Filter</a></li>
                            <li><a href="category-horizontal-filter1.html">Horizontal Filter 1</a></li>
                            <li><a href="category-horizontal-filter2.html">Horizontal Filter 2</a></li>
                            <li><a href="#">List Types</a></li>
                            <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll<span
                                        class="tip tip-new">New</span></a></li>
                            <li><a href="category.html">3 Columns Products</a></li>
                            <li><a href="category-4col.html">4 Columns Products</a></li>
                            <li><a href="category-5col.html">5 Columns Products</a></li>
                            <li><a href="category-6col.html">6 Columns Products</a></li>
                            <li><a href="category-7col.html">7 Columns Products</a></li>
                            <li><a href="category-8col.html">8 Columns Products</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="demo1-product.html" class="sf-with-ul"><i class="sicon-basket"></i>Products</a>
                        <ul>
                            <li>
                                <a href="#" class="nolink">PRODUCT PAGES</a>
                                <ul>
                                    <li><a href="product.html">SIMPLE PRODUCT</a></li>
                                    <li><a href="product-variable.html">VARIABLE PRODUCT</a></li>
                                    <li><a href="product.html">SALE PRODUCT</a></li>
                                    <li><a href="product.html">FEATURED & ON SALE</a></li>
                                    <li><a href="product-sticky-info.html">WIDTH CUSTOM TAB</a></li>
                                    <li><a href="product-sidebar-left.html">WITH LEFT SIDEBAR</a></li>
                                    <li><a href="product-sidebar-right.html">WITH RIGHT SIDEBAR</a></li>
                                    <li><a href="product-addcart-sticky.html">ADD CART STICKY</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="nolink">PRODUCT LAYOUTS</a>
                                <ul>
                                    <li><a href="product-extended-layout.html">EXTENDED LAYOUT</a></li>
                                    <li><a href="product-grid-layout.html">GRID IMAGE</a></li>
                                    <li><a href="product-full-width.html">FULL WIDTH LAYOUT</a></li>
                                    <li><a href="product-sticky-info.html">STICKY INFO</a></li>
                                    <li><a href="product-sticky-both.html">LEFT & RIGHT STICKY</a></li>
                                    <li><a href="product-transparent-image.html">TRANSPARENT IMAGE</a></li>
                                    <li><a href="product-center-vertical.html">CENTER VERTICAL</a></li>
                                    <li><a href="#">BUILD YOUR OWN</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="sf-with-ul"><i class="sicon-envelope"></i>Pages</a>
                        <ul>
                            <li>
                                <a href="wishlist.html">Wishlist</a>
                            </li>
                            <li>
                                <a href="cart.html">Shopping Cart</a>
                            </li>
                            <li>
                                <a href="checkout.html">Checkout</a>
                            </li>
                            <li>
                                <a href="dashboard.html">Dashboard</a>
                            </li>
                            <li>
                                <a href="login.html">Login</a>
                            </li>
                            <li>
                                <a href="forgot-password.html">Forgot Password</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="blog.html"><i class="sicon-book-open"></i>Blog</a></li>
                    <li><a href="demo1-about.html"><i class="sicon-users"></i>About Us</a></li>
                </ul>

                <ul class="mobile-menu menu-with-icon mt-2 mb-2">
                    <li class="border-0">
                        <a href="#" target="_blank"><i class="sicon-star"></i>Buy Porto!<span
                                class="tip tip-hot">Hot</span></a>
                    </li>
                </ul>

                <ul class="mobile-menu">
                    <li><a href="login.html">My Account</a></li>
                    <li><a href="demo1-contact.html">Contact Us</a></li>
                    <li><a href="wishlist.html">My Wishlist</a></li>
                    <li><a href="#">Site Map</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="login.html" class="login-link">Log In</a></li>
                </ul>
            </nav>
            <!-- End .mobile-nav -->

            <form class="search-wrapper mb-2" action="#">
                <input type="text" class="form-control mb-0" placeholder="Search..." required />
                <button class="btn icon-search text-white bg-transparent p-0" type="submit"></button>
            </form>

            <div class="social-icons">
                <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
                </a>
                <a href="#" class="social-icon social-twitter icon-twitter" target="_blank">
                </a>
                <a href="#" class="social-icon social-instagram icon-instagram" target="_blank">
                </a>
            </div>
        </div>
        <!-- End .mobile-menu-wrapper -->
    </div>
    <!-- End .mobile-menu-container -->

    <div class="sticky-navbar">
        <div class="sticky-info">
            <a href="demo1.html">
                <i class="icon-home"></i>Home
            </a>
        </div>
        <div class="sticky-info">
            <a href="demo1-shop.html" class="">
                <i class="icon-bars"></i>Categories
            </a>
        </div>
        <div class="sticky-info">
            <a href="wishlist.html" class="">
                <i class="icon-wishlist-2"></i>Wishlist
            </a>
        </div>
        <div class="sticky-info">
            <a href="login.html" class="">
                <i class="icon-user-2"></i>Account
            </a>
        </div>
        <div class="sticky-info">
            <a href="cart.html" class="">
                <i class="icon-shopping-cart position-relative">
                    <span class="cart-count badge-circle">3</span>
                </i>Cart
            </a>
        </div>
    </div>

    <!-- Biểu tượng chat -->
    <div class="chat-icon" onclick="toggleChat()">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTe5Q6tKljOdWyzL7ROdOPCdw0g0y8Uo-V2yg&s"
            alt="Chat Icon" />
    </div>

    <!-- Hộp chat -->
    <div id="chat-box" class="chat-box">
        <div class="page-content page-container" id="page-content">
            <div class="row container d-flex justify-content-center">
                <div class="w-ful">
                    <div class="card card-bordered">
                        <div class="card-header position-relative">
                            <h4 class="card-title"><strong>Chat</strong></h4>
                            <a class="btn btn-xs btn-secondary close-chat position-absolute"
                                style="top: 15px; right: 10px;" onclick="toggleChat()" href="#">X</a>
                        </div>

                        <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                            style="overflow-y: scroll !important; height:400px !important;">

                        </div>

                        <div class="publisher bt-1 border-light">
                            <img class="avatar avatar-xs"
                                src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <input class="publisher-input" type="text" placeholder="Chat " id="message-input">
                            <span class="publisher-btn file-group">
                                <i class="fa fa-paperclip file-browser"></i>
                                <input type="file">
                            </span>
                            <a class="publisher-btn text-info" href="#" data-abc="true" id="send-button"><i
                                    class="fa fa-paper-plane"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('client.advertising_bar.newsletter-popup')
    <!-- End .newsletter-popup -->

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.countdown.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Điều hướng đến các đường dẫn bên ở file js --}}
    <script>
        var routes = {
            shoppingCart: "{{ route('shopping-cart') }}",
            checkout: "{{ route('checkout') }}"
        };
    </script>

    <script>
        function removeFromCart(element) {
            const cartId = element.getAttribute('data-id'); // Lấy ID của sản phẩm từ data-id

            // Gửi yêu cầu xóa sản phẩm
            fetch(`/remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'), // CSRF token
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Xóa sản phẩm ra khỏi DOM
                        const productElement = element.closest('.product'); // Tìm phần tử sản phẩm tương ứng

                        // Tính toán subtotal
                        const cartProductInfo = productElement.querySelector(
                            '.cart-product-info'); // Thông tin giá và số lượng
                        const [quantityText, priceText] = cartProductInfo.textContent.split('×').map(item => item
                            .trim());

                        const quantity = parseInt(quantityText.replace(/\D/g, ''), 10); // Lấy số lượng từ text
                        const price = parseInt(priceText.replace(/\./g, '').replace('₫', ''), 10); // Lấy giá từ text
                        const subtotalForProduct = quantity * price; // Tính subtotal cho sản phẩm

                        // Cập nhật subtotal tổng
                        const subtotalElement = document.querySelector('.cart-total-price');
                        const currentSubtotal = parseInt(subtotalElement.textContent.replace(/\./g, '').replace('₫',
                            ''), 10);
                        const newSubtotal = currentSubtotal - subtotalForProduct;

                        // Cập nhật DOM
                        subtotalElement.textContent =
                            `${newSubtotal.toLocaleString('vi-VN')}₫`; // Hiển thị subtotal mới
                        productElement.remove(); // Xóa sản phẩm khỏi giao diện
                    } else {
                        console.error('Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.');
                    }
                })
                .catch(error => {
                    console.error('Lỗi kết nối hoặc xử lý:', error);
                });
        }
        window.addEventListener('beforeunload', function() {
            // Send a GET request to the '/clear-coupons' route to clear the session
            fetch('/clear-coupons', {
                    method: 'GET', // Set the request method to GET
                    headers: {
                        'Content-Type': 'application/json', // Set the content type to JSON
                    },
                })
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    console.log('Coupons session cleared:', data); // Log success
                })
                .catch(error => {
                    console.error('Error:', error); // Log any error
                });
        });

        function toggleChat() {
            const chatBox = document.getElementById('chat-box');
            chatBox.style.display = chatBox.style.display === 'none' ? 'block' : 'none';

            let url = '{{ route('chat.getDataChatClient') }}';

            axios.post(url, {
                    _token: '{{ csrf_token() }}'
                })
                .then(response => {          
                    innerViewChatClient(response.data.data) 
                })
                .catch(error => {
                    console.error('Error fetching chat messages:', error);
                });
        }

        function innerViewChatClient(data) {
            let view = document.getElementById('chat-content');
            let chatHTML = '';
            let currentUserId = @json(Auth::check() ? Auth::user()->id : null);
            data.forEach(message => {
                if (message.sender_id === currentUserId) {
                    chatHTML += `
                        <div class="media media-chat media-chat-reverse">
                            <div class="media-body">
                                <p>${message.message}</p>
                                <p class="meta" style="color:#9b9b9b"><time datetime="2018">${formatDateTime(message.created_at)}</time></p>
                            </div>
                        </div>`;
                } else {
                    chatHTML += `
                        <div class="media media-chat">
                            <img class="avatar"
                                src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                alt="Avatar">
                            <div class="media-body">
                                <p>${message.message}</p>
                                <p class="meta" style="color:#9b9b9b"><time datetime="2018">${formatDateTime(message.created_at)}</time></p>
                            </div>
                        </div>`;
                }
            });

            view.innerHTML = chatHTML;
        }

        function formatDateTime(dateTime) {
            const date = new Date(dateTime);

            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); 
            const year = date.getFullYear();

            return `${hours}:${minutes}, ${day}-${month}-${year}`;
        }

    </script>

    <!-- Main JS File -->
    <script src="{{ asset('themeclient/assets/js/main.min.js') }}"></script>
    @yield('script_libray')
    @yield('scripte_logic')
    {{-- <script>(function(){var js = "window['__CF$cv$params']={r:'8205254108eb1073',t:'MTY5OTAyMDA0OC4zMzMwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/61b90d1d/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";var _0xh = document.createElement('iframe');_0xh.height = 1;_0xh.width = 1;_0xh.style.position = 'absolute';_0xh.style.top = 0;_0xh.style.left = 0;_0xh.style.border = 'none';_0xh.style.visibility = 'hidden';document.body.appendChild(_0xh);function handler() {var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;if (_0xi) {var _0xj = _0xi.createElement('script');_0xj.innerHTML = js;_0xi.getElementsByTagName('head')[0].appendChild(_0xj);}}if (document.readyState !== 'loading') {handler();} else if (window.addEventListener) {document.addEventListener('DOMContentLoaded', handler);} else {var prev = document.onreadystatechange || function () {};document.onreadystatechange = function (e) {prev(e);if (document.readyState !== 'loading') {document.onreadystatechange = prev;handler();}};}})();</script></body> --}}


    <!-- Mirrored from portotheme.com/html/porto_ecommerce/demo1.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Nov 2023 14:03:11 GMT -->
    @vite('resources/js/app.js')
    <script type="module">
        const userId = @json(Auth::check() ? Auth::user()->id : null);
        const chatBody = document.querySelector('.chat-body');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        const chatBox = document.getElementById('chat-box');


        Echo.private(`chat.${userId}`)
            .listen('MessageSent', (e) => {
                if (e !== null) {
                    renderDataMessage(e)
                }
            });

        // Send a message
        sendButton.addEventListener('click', async () => {
            const message = messageInput.value.trim();

            if (message) {
                try {
                    let response = await axios.post('/chat/send-message', {
                        message: message,
                        receiver_id: userId,
                    });
                    messageInput.value = ''; // Clear input
                } catch (error) {
                    messageInput.value = '';
                    let view = document.getElementById('chat-content');
                    let timeElement = document.createElement('p');
                    timeElement.classList.add('text-center', 'small', 'my-1'); 
                    timeElement.innerHTML =formatDateTime(new Date());
                    view.appendChild(timeElement);

                    let messages = document.createElement('p');
                    messages.classList.add('text-center', 'text-danger', 'my-4','mb-3');
                    messages.innerHTML = "Đã có lỗi khi gửi";

                    view.appendChild(messages);


                    console.error('Error sending message:', error);
                }
            }
        });

        function renderDataMessage(data){
            let view = document.getElementById('chat-content');
            let currentUserId = @json(Auth::check() ? Auth::user()->id : null);
            let chatHTML = '';
            if (data.sender.id === currentUserId) {
                    chatHTML += `
                        <div class="media media-chat media-chat-reverse">
                            <div class="media-body">
                                <p>${data.message}</p>
                                <p class="meta" style="color:#9b9b9b"><time datetime="2018">${formatDateTime(new Date())}</time></p>
                            </div>
                        </div>`;
                } else {
                    chatHTML += `
                        <div class="media media-chat">
                            <img class="avatar"
                                src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                alt="Avatar">
                            <div class="media-body">
                                <p>${data.message}</p>
                                <p class="meta" style="color:#9b9b9b"><time datetime="2018">${formatDateTime(new Date())}</time></p>
                            </div>
                        </div>`;
            }
            view.insertAdjacentHTML('beforeend', chatHTML);
        }
    </script>


</html>
