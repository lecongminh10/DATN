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
            <img src="{{Storage::url($item)}}" alt="" class="d-block" style="max-width:100% ; max-heigth:100%" />
        </div>
        @endforeach
    @endif
</div>