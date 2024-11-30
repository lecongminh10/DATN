@php
    $footer = App\Models\Footer::first();
@endphp

<footer class="footer bg-dark position-relative">
    <div class="footer-middle">
        <div class="container position-static">
            <div class="footer-ribbon">Liên hệ</div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6 pb-2 pb-sm-0">
                    <h4 class="widget-title">giới thiệu về chúng tôi</h4>
                    <p>{{ $footer->about_us ?? 'No information available' }}</p>
                </div>
                <div class="col-lg-4 col-sm-6 pb-4 pb-sm-0">
                    <h4 class="widget-title">Thông tin liên lạc</h4>
                    <p><strong>Địa chỉ:</strong> {{ $footer->address ?? 'N/A' }}</p>
                    <p><strong>Điện thoại:</strong> {{ $footer->phone ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $footer->email ?? 'N/A' }}</p>
                    <p><strong>Thời gian làm việc:</strong> {{ $footer->working_hours ?? 'N/A' }}</p>
                </div>
                <div class="col-lg-4 col-sm-6 pb-2 pb-sm-0">
    <h4 class="widget-title">Dịch vụ khách hàng</h4>
    <p>{!! nl2br(e($footer->customer_service ?? 'No information available')) !!}</p>
</div>
            </div>
        </div>
    </div>
</footer>