<style>
    .img-brand img{
        max-width: 140px;
        max-height: 100px;
        background-color:transparent ;
    }
</style>
<div class="brands-slider owl-carousel owl-theme images-center appear-animate" data-animation-name="fadeIn"
    data-animation-duration="700"
    data-owl-options="{
    'margin': 0,
    'responsive': {
        '768': {
            'items': 4
        },
        '991': {
            'items': 4
        },
        '1200': {
            'items': 5
        }
    }
}">
    @foreach ($brands as $item)
        <div class="img-brand">
            @if ($item->active == 1)
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}">
            @endif

        </div>
    @endforeach

    {{-- <img src="{{ asset('themeclient/assets/images/brands/small/brand1.png') }}" width="140" height="60"
        alt="brand">
    <img src="{{ asset('themeclient/assets/images/brands/small/brand2.png') }}" width="140" height="60"
        alt="brand">
    <img src="{{ asset('themeclient/assets/images/brands/small/brand3.png') }}" width="140" height="60"
        alt="brand">
    <img src="{{ asset('themeclient/assets/images/brands/small/brand4.png') }}" width="140" height="60"
        alt="brand">
    <img src="{{ asset('themeclient/assets/images/brands/small/brand5.png') }}" width="140" height="60"
        alt="brand">
    <img src="{{ asset('themeclient/assets/images/brands/small/brand6.png') }}" width="140" height="60"
        alt="brand"> --}}
</div>
