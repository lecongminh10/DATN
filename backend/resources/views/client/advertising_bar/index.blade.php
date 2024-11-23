
@php
    $announcement = App\Models\Announcement::first();
@endphp
<div style ="display:{{($announcement->active) ? 'block':'none'}}" class="top-notice text-white bg-dark">
    <div class="container text-center">
        <h5 class="d-inline-block mb-0">{{$announcement->message}} <b>{{ $announcement->discount_percentage }}% </b> cho </h5>
        <a href="#" class="category">{{ $announcement->category }}</a>
        <small>* Limited time only.</small>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div>
    <!-- End .container -->
</div>