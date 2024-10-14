@php
$allImages = [];
foreach ($galleries as $gallery) {
    if (isset($gallery->image_gallery)) {
        $allImages[] = $gallery->image_gallery;
    }
}

foreach ($variants as $variant) {
    if (isset($variant->variant_image)) {
        $allImages[] = $variant->variant_image;
    }
}
@endphp
<div class="swiper-wrapper">
    @if ($allImages==!'')
        @foreach ($allImages as $item)
        <div class="swiper-slide">
            <div class="nav-slide-item">
            <img src="{{Storage::url($item)}}" alt="" class="img-fluid d-block" />
            </div>
        </div>
        @endforeach
    @endif
</div>