@php
    $bannerExtra = App\Models\bannerExtra::first(); // Lấy dữ liệu từ DB
@endphp
<div class="banner banner1 banner-hover-shadow d-flex align-items-center mb-2 w-100 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="500">
    <figure class="w-100">
        <img src="{{ Storage::url($bannerExtra->image_1) }}" style="background-color: #dadada;" alt="banner">
    </figure>
    <div class="banner-layer">
        <h3 class="m-b-2" style="color: #fff">{{ $bannerExtra->title_1 }}</h3>
        <h4 class="text-light fs-4" >{{ number_format($bannerExtra->price_1, 0,',', '.') }} ₫</h4>
        <a href="#" class="text-light text-uppercase ls-10" style="color: #fff">{{ $bannerExtra->title_button_1 }}</a>
    </div>
</div>
<!-- End .banner -->
<div class="banner banner2 text-uppercase banner-hover-shadow d-flex align-items-center mb-2 w-100 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">
    <figure class="w-100">
        <img src="{{ Storage::url($bannerExtra->image_2) }}" style="background-color: #dadada;" alt="banner">
    </figure>
    <div class="banner-layer text-center">
        <h3 class="m-b-1 ls-n-20" style="color: #fff">{{ $bannerExtra->title_2 }}</h3>
        <h4 class="text-light" style="color: #fff">{{ number_format($bannerExtra->price_2, 0,',', '.') }} ₫</h4>
        <a href="#" class="text-light text-uppercase ls-10" style="color: #fff">{{ $bannerExtra->title_button_2 }}</a>
    </div>
</div>
<!-- End .banner -->
<div class="banner banner3 banner-hover-shadow d-flex align-items-center mb-2 w-100 appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="500">
    <figure class="w-100">
        <img src="{{ Storage::url($bannerExtra->image_3) }}" style="background-color: #dadada;" alt="banner">
    </figure>
    <div class="banner-layer text-right">
        <h3 class="m-b-2" style="color: #fff">{{ $bannerExtra->title_3 }}</h3>
        <h4 class="mb-3 text-light text-uppercase">{{ number_format($bannerExtra->price_3, 0,',', '.') }} ₫</h4>
        <a href="#" class="text-light text-uppercase ls-10" style="color: #fff">{{ $bannerExtra->title_button_3 }}</a>
    </div>
</div>