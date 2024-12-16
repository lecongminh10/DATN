{{-- @php
    $popuphome = App\Models\Popuphome::first();
@endphp

<div style="display: ; 
      height:400px; 
     background: no-repeat center/cover url('{{ Storage::url($popuphome->image) }}');"
    class="newsletter-popup mfp-hide bg-img" id="newsletter-popup-form">

    <div class="content">
        <h2 style="color:white">{{ $popuphome->title }}</h2>

        <p style="color:white">
            {{ $popuphome->description }}
        </p>
    </div>

    <button title="Close (Esc)" type="button" class="mfp-close" onclick="closePopup()">×</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popupForm = document.getElementById('newsletter-popup-form');

        // Kiểm tra trạng thái popup từ sessionStorage
        const popupDisplayed = sessionStorage.getItem('popupDisplayed');

        // Hiển thị popup nếu chưa từng hiển thị trong phiên làm việc này
        if ({{ $popuphome->active ? 'true' : 'false' }} && !popupDisplayed) {
            popupForm.style.display = 'block';
            sessionStorage.setItem('popupDisplayed', 'true'); // Lưu trạng thái vào sessionStorage
        }
    });

    function closePopup() {
        const popupForm = document.getElementById('newsletter-popup-form');
        let mfpNewsletter=document.querySelector('.mfp-newsletter');
        popupForm.style.display = 'none'; // Ẩn popup khi người dùng đóng
        mfpNewsletter.style.display = 'none';
    }
</script> --}}