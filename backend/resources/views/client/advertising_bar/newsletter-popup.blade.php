{{-- @php
    $popuphome = App\Models\Popuphome::first();
@endphp

<div style="display:{{ $popuphome->active ? 'block' : 'none' }}; 
      height:400px; 
     background: no-repeat center/cover url('{{ Storage::url($popuphome->image) }}');"
    class="newsletter-popup mfp-hide bg-img" id="newsletter-popup-form">

    <div class="">
        <h2 style="color:white">{{ $popuphome->title }}</h2>

        <p style="color:white">
            {{ $popuphome->description }}
        </p>
    </div>

    <button title="Close (Esc)" type="button" class="mfp-close">×</button>
</div> --}}
