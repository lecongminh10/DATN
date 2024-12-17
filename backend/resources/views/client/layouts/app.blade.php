@php
    use App\Models\Seo;

    $seo = SEO::getSeoByCurrentUrl();

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <meta name="title" content="@yield('meta_title') , {{ $seo->meta_title ?? '' }}">
    <meta name="description" content="@yield('meta_description') , {{ $seo->meta_description ?? '' }}">
    <meta name="keywords" content="@yield('keywords') , {{ $seo->meta_keywords ?? '' }}">


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

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
    @include('client.menu-mobile.index')
    <!-- End .mobile-menu-container -->


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
                
                            <span class="publisher-btn file-group"><i class="fa fa-paperclip file-browser"></i><input type="file" id="fileInput" accept="image/*"></span>
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
        // Thêm cart
        $(document).ready(function() {
            $('.btn-add-cart').on('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a
                // Lấy thông tin sản phẩm từ thẻ cha của nút
                var productElement = $(this).closest('.product-default');
                var productId = productElement.data('product-id'); // Đảm bảo bạn có data-product-id trong HTML
                var productVariantId = productElement.data('product-variant-id'); // Nếu cần
                var cart_count = document.querySelector('.cart-count')
                var quantity = 1; // Hoặc lấy từ một input nếu cần
                $.ajax({
                    url: '{{ route('addCart') }}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        product_variants_id: productVariantId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}' // Đừng quên CSRF token
                    },
                    success: function(response) {
                        console.log(response);
                        
                        if (response.carts && response.carts.length > 0) {
                            let cartHTML = '';
                            let subTotal = 0;
                            response.carts.forEach(item => {
                                let price = 0;
                                let sub = 0;

                                if (item.product) {
                                    price = item.product.price_sale > 0 ? item.product.price_sale : item.product.price_regular;
                                    sub = price * item.quantity; 
                                }
                                subTotal += sub;
                                const mainImage = item.product.galleries.find(gallery => gallery.is_main);
                                cartHTML += `
                                    <div class="product">
                                        <div class="product-details">
                                            <h4 class="product-title">
                                                <a href="/product/${item.product.id}">${item.product.name}</a>
                                            </h4>
                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">${item.quantity}</span> × ${new Intl.NumberFormat().format(price)}₫
                                            </span>
                                        </div>
                                        <figure class="product-image-container">
                                            <a href="/product/${item.product.id}" class="product-image">
                                                <img src="${mainImage ? '/storage/' + mainImage.image_gallery : ''}" style="width: 80px; height: 70px" alt="${item.product.name}" />
                                            </a>
                                            <a href="#" class="btn-remove icon-cancel" title="Remove Product" data-id="${item.id}" onclick="removeFromCart(this)"></a>
                                        </figure>
                                    </div>
                                `;
                            });
                            $('.dropdown-cart-products').html(cartHTML);
                            $('.dropdown-cart-total .cart-total-price').text(new Intl.NumberFormat().format(subTotal) + '₫');
                        } else {
                            $('.dropdown-cart-products').html('<p>Trống.</p>');
                            $('.dropdown-cart-total .cart-total-price').text('0₫');
                        }

                        cart_count.innerHTML=response.totalQuantity
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                alert(value[0]); 
                            });
                        }
                    }
                });
            });
        });
    // Thêm vào yêu thích
    function addToWishlist(element,productId, productVariantId) {
        let wishlist=document.querySelector('.wishlist-count');
        $.ajax({
            type: "POST",
            url: "{{ route('addWishList') }}",
            data: {  
                product_id: productId,
                product_variants_id: productVariantId,
                _token: '{{ csrf_token() }}'      
            },
            success: function(response) {             
                if (!response.status) {
                    $(element).removeClass('added-wishlist'); 
                }
                wishlist.innerHTML=response.count
            }
        });
    }
    </script>
    <script>
        function removeFromCart(element) {
            const cartId = element.getAttribute('data-id');
            $.ajax({
                url: `/remove/${cartId}`, 
                type: 'DELETE', 
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                success: function (response) {
                    if (response.message === 'Product removed successfully') {
                        const productElement = $(element).closest('.product'); 
                        const totalCart = response.total; 
                        const subtotalElement = $('.cart-total-price');
                        subtotalElement.text(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalCart)); 
                        productElement.remove();
                    } else {
                        console.error(response.message);
                    }
                },
                error: function (xhr) {
                    console.error('Có lỗi xảy ra:', xhr.responseText);
                }
            });
        }

        window.addEventListener('beforeunload', function() {
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
                    console.log(response.data.data);
                        
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
                                    ${message.media_path ? `
                                        <div class="chat-media">
                                            <img src="{{ Storage::url('${message.media_path}') }}" alt="Image" style="max-width: 200px; border-radius: 8px;">
                                         </div>
                                ` : ''}
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
                                   ${message.media_path ? `
                                        <div class="chat-media">
                                            <img src="{{ Storage::url('${message.media_path}') }}" alt="Image" style="max-width: 200px; border-radius: 8px;">
                                         </div>
                                ` : ''}
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
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0]; // Lấy tệp được tải lên

            // Tạo formData để gửi tệp
            let formData = new FormData();
            formData.append('message', message);
            formData.append('receiver_id', userId);

            if (file) {
                formData.append('file', file); // Đính kèm tệp nếu có
            }

            if (message || file) {
                try {
                    let response = await axios.post('/chat/send-message', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data', // Đảm bảo gửi dưới dạng form data
                        },
                    });

                    messageInput.value = ''; // Xóa input message
                    fileInput.value = ''; // Xóa input file
                } catch (error) {
                    messageInput.value = '';
                    fileInput.value = ''; // Xóa input file

                    let view = document.getElementById('chat-content');
                    let timeElement = document.createElement('p');
                    timeElement.classList.add('text-center', 'small', 'my-1');
                    timeElement.innerHTML = formatDateTime(new Date());
                    view.appendChild(timeElement);

                    let messages = document.createElement('p');
                    messages.classList.add('text-center', 'text-danger', 'my-4', 'mb-3');
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
                                 ${data.image ? `
                                        <div class="chat-media">
                                            <img src="{{ Storage::url('${data.image}') }}" alt="Image" style="max-width: 200px; border-radius: 8px;">
                                         </div>
                                ` : ''}
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
                                     ${data.image ? `
                                        <div class="chat-media">
                                            <img src="{{ Storage::url('${data.image}') }}" alt="Image" style="max-width: 200px; border-radius: 8px;">
                                         </div>
                                ` : ''}
                                <p class="meta" style="color:#9b9b9b"><time datetime="2018">${formatDateTime(new Date())}</time></p>
                            </div>
                        </div>`;
            }
            view.insertAdjacentHTML('beforeend', chatHTML);
        }
    </script>


</html>
