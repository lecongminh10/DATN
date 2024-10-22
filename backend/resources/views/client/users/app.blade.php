<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from portotheme.com/html/porto_ecommerce/demo1.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Nov 2023 14:02:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Porto - Bootstrap eCommerce Template">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('themeclient/assets/images/icons/favicon.png') }}">


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
    <link rel="stylesheet" href="{{ asset('themeclient/assets/css/demo1.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themeclient/assets/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themeclient/assets/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
    @yield('style_css')
    <style>
        .content-container {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            height: calc(100vh - <header/footer height>);
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        @include('client.advertising_bar.index')

        @include('client.layouts.header')
        <!-- End .header -->

        <div class="content-container">
            @include('client.users.index')

            @yield('content')
        </div>

        @include('client.layouts.footer')
        <!-- End .footer -->
    </div>

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ asset('themeclient/assets/js/jquery.countdown.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('themeclient/assets/js/main.min.js') }}"></script>
    @yield('script_libray')
    @yield('script_logic')
    <script>
        (function() {
            var js =
                "window['__CF$cv$params']={r:'8205254108eb1073',t:'MTY5OTAyMDA0OC4zMzMwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/61b90d1d/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";
            var _0xh = document.createElement('iframe');
            _0xh.height = 1;
            _0xh.width = 1;
            _0xh.style.position = 'absolute';
            _0xh.style.top = 0;
            _0xh.style.left = 0;
            _0xh.style.border = 'none';
            _0xh.style.visibility = 'hidden';
            document.body.appendChild(_0xh);

            function handler() {
                var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;
                if (_0xi) {
                    var _0xj = _0xi.createElement('script');
                    _0xj.innerHTML = js;
                    _0xi.getElementsByTagName('head')[0].appendChild(_0xj);
                }
            }
            if (document.readyState !== 'loading') {
                handler();
            } else if (window.addEventListener) {
                document.addEventListener('DOMContentLoaded', handler);
            } else {
                var prev = document.onreadystatechange || function() {};
                document.onreadystatechange = function(e) {
                    prev(e);
                    if (document.readyState !== 'loading') {
                        document.onreadystatechange = prev;
                        handler();
                    }
                };
            }
        })();
    </script>
</body>


<!-- Mirrored from portotheme.com/html/porto_ecommerce/demo1.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Nov 2023 14:03:11 GMT -->

</html>
