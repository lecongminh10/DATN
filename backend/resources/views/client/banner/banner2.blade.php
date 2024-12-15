@php
    $bannerExtra = App\Models\bannerExtra::first(); // Lấy dữ liệu từ DB
@endphp
@if($bannerExtra && $bannerExtra->active == 1) 
    <div class="banner banner1 banner-hover-shadow d-flex align-items-center mb-2 w-100 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="500">
        <figure class="w-100">
            <img src="{{ Storage::url($bannerExtra->image_1) }}" style="background-color: #dadada;" alt="banner">
        </figure>
        <div class="banner-layer">
            <h3 class="m-b-2" style="color: #fff">{{ $bannerExtra->title_1 }}</h3>
        </div>
    </div>
    <!-- End .banner -->
    <div class="banner banner2 text-uppercase banner-hover-shadow d-flex align-items-center mb-2 w-100 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">
        <figure class="w-100">
            <img src="{{ Storage::url($bannerExtra->image_2) }}" style="background-color: #dadada;" alt="banner">
        </figure>
        <div class="banner-layer text-center">
            <h3 class="m-b-1 ls-n-20" style="color: #fff">{{ $bannerExtra->title_2 }}</h3>
        </div>
    </div>
    <!-- End .banner -->
    <div class="banner banner3 banner-hover-shadow d-flex align-items-center mb-2 w-100 appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="500">
        <figure class="w-100">
            <img src="{{ Storage::url($bannerExtra->image_3) }}" style="background-color: #dadada;" alt="banner">
        </figure>
        <div class="banner-layer text-right">
            <h3 class="m-b-2" style="color: #fff">{{ $bannerExtra->title_3 }}</h3>
        </div>
    </div>
@endif