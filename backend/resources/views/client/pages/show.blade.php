@extends('client.layouts.app')
@section('content')
<div class="header-bottom sticky-header d-none d-lg-block bg-gray" data-sticky-options="{'mobile': false}">
    <div class="container">
        <div class="header-left">
            <a href="demo1.html" class="logo">
                <img src="assets/images/logo.png" alt="Porto Logo">
            </a>
        </div>
        <div class="header-center">
            @include('client.layouts.nav')
        </div>
    </div><!-- End .container -->
</div><!-- End .header-bottom -->
</header><!-- End .header -->

<main class="main about">
<div class="page-header page-header-bg text-left"
    style="background: 50%/cover #D4E1EA url('assets/images/page-header-bg.jpg');">
    <div class="container">
        <h1><span>{{$pages->name}}</span>
            {{$pages->description}}</h1>
        {{-- <a href="" class="btn btn-dark">liên hệ</a> --}}
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('client')}}"><i class="icon-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pages->name}}</li>
        </ol>
    </div><!-- End .container -->
</nav>

<div class="about-section">
    <div class="container">
        <h2 class="subtitle">{{$pages->name}}</h2>
        <p>{!! $pages->content !!}</p>
    </div><!-- End .container -->
</div><!-- End .about-section -->

<div class="features-section bg-gray">
    <div class="container">
        <h2 class="subtitle">TẠI SAO BẠN NÊN CHỌN CHÚNG TÔI</h2>
        <div class="row">
            <div class="col-lg-4">
                <div class="feature-box bg-white">
                    <i class="icon-shipped"></i>

                    <div class="feature-box-content p-0">
                        <h3>Miễn Phí Giao Hàng</h3>
                        <p>Chúng tôi cung cấp dịch vụ giao hàng miễn phí cho mọi đơn hàng, giúp bạn tiết kiệm chi phí và thời gian.</p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-lg-4 -->

            <div class="col-lg-4">
                <div class="feature-box bg-white">
                    <i class="icon-us-dollar"></i>

                    <div class="feature-box-content p-0">
                        <h3>Hoàn Tiền 100% Đảm Bảo</h3>
                        <p>Cam kết hoàn tiền 100% nếu sản phẩm không đạt chất lượng hoặc có bất kỳ lỗi nào từ phía chúng tôi.</p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-lg-4 -->

            <div class="col-lg-4">
                <div class="feature-box bg-white">
                    <i class="icon-online-support"></i>

                    <div class="feature-box-content p-0">
                        <h3>Hỗ Trợ Trực Tuyến 24/7</h3>
                        <p>Đội ngũ hỗ trợ khách hàng luôn sẵn sàng phục vụ bạn mọi lúc, mọi nơi, bất kể thời gian.</p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div><!-- End .features-section -->
{{-- <div class="testimonials-section">
    <div class="container">
        <h2 class="subtitle text-center">KHÁCH HÀNG HÀI LÒNG</h2>

        <div class="testimonials-carousel owl-carousel owl-theme images-left" data-owl-options="{
            'margin': 20,
            'lazyLoad': true,
            'autoHeight': true,
            'dots': false,
            'responsive': {
                '0': {
                    'items': 1
                },
                '992': {
                    'items': 2
                }
            }
        }">
            <div class="testimonial">
                <div class="testimonial-owner">
                    <figure>
                        <img src="assets/images/clients/client1.png" alt="Khách hàng">
                    </figure>

                    <div>
                        <strong class="testimonial-title">Nguyễn Văn An</strong>
                        <span>CEO CÔNG TY ABC</span>
                    </div>
                </div><!-- End .testimonial-owner -->

                <blockquote>
                    <p>Sản phẩm và dịch vụ rất tuyệt vời! Tôi rất hài lòng với trải nghiệm mua sắm tại đây. Chắc chắn sẽ quay lại.</p>
                </blockquote>
            </div><!-- End .testimonial -->

            <div class="testimonial">
                <div class="testimonial-owner">
                    <figure>
                        <img src="assets/images/clients/client2.png" alt="Khách hàng">
                    </figure>

                    <div>
                        <strong class="testimonial-title">Trần Thị Hoa</strong>
                        <span>CEO CÔNG TY XYZ</span>
                    </div>
                </div><!-- End .testimonial-owner -->

                <blockquote>
                    <p>Đội ngũ hỗ trợ rất chuyên nghiệp và nhiệt tình. Tôi đã nhận được giải pháp nhanh chóng cho vấn đề của mình.</p>
                </blockquote>
            </div><!-- End .testimonial -->
        </div><!-- End .testimonials-slider -->
    </div><!-- End .container -->
</div><!-- End .testimonials-section --> --}}
</main><!-- End .main -->
@endsection
@section('scripte_logic')
    <script>
        if (window.location.hash === "#_=_") {
            window.location.hash = "";
        }
    </script>
@endsection
