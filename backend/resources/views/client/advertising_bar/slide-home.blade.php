
@foreach ($bannerMain as $banner)
    <div class="home-slide home-slide2 banner banner-md-vw banner-sm-vw d-flex align-items-center">
        <img class="slide-bg" style="background-color: #dadada;" src="{{ Storage::url($banner->image) }}" width="880" height="428" alt="home-slider">
        <div class="banner-layer text-uppercase appear-animate" data-animation-name="fadeInUpShorter">
            <h2 class="m-b-3" style="color: #fff">{{ $banner->title }}</h2>
            </h5>
            <a href="{{route('client.products')}}" class="btn btn-dark btn-md ls-10">{{  $banner->title_button }}</a>
        </div>
        <!-- End .banner-layer -->
    </div> 
@endforeach