@extends('client.layouts.app')
@section('content')

<main class="main home">
    <div class="container mb-2">
        <div class="info-boxes-container row row-joined mb-2 font2">
            <div class="info-box info-box-icon-left col-lg-4">
                <i class="icon-shipping"></i>

                <div class="info-box-content">
                    <h4>FREE SHIPPING &amp; RETURN</h4>
                    <p class="text-body">Free shipping on all orders over $99</p>
                </div>
                <!-- End .info-box-content -->
            </div>
            <!-- End .info-box -->

            <div class="info-box info-box-icon-left col-lg-4">
                <i class="icon-money"></i>

                <div class="info-box-content">
                    <h4>MONEY BACK GUARANTEE</h4>
                    <p class="text-body">100% money back guarantee</p>
                </div>
                <!-- End .info-box-content -->
            </div>
            <!-- End .info-box -->

            <div class="info-box info-box-icon-left col-lg-4">
                <i class="icon-support"></i>

                <div class="info-box-content">
                    <h4>ONLINE SUPPORT 24/7</h4>
                    <p class="text-body">Lorem ipsum dolor sit amet.</p>
                </div>
                <!-- End .info-box-content -->
            </div>
            <!-- End .info-box -->
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="home-slider slide-animate owl-carousel owl-theme mb-2" data-owl-options="{
                    'loop': false,
                    'dots': true,
                    'nav': false
                }">
                @include('client.advertising_bar.slide-home')
                    <!-- End .home-slide -->
                </div>
                <!-- End .home-slider -->

                <div class="banners-container m-b-2 owl-carousel owl-theme" data-owl-options="{
                    'dots': false,
                    'margin': 20,
                    'loop': false,
                    'responsive': {
                        '480': {
                            'items': 2
                        },
                        '768': {
                            'items': 3
                        }
                    }
                }">
                    @include('client.banner.banner2')
                    <!-- End .banner -->
                    @include('client.components-home.sidebar')
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->
</main>
@endsection

@section('script_libray')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
@endsection

@section('scripte_logic')
    <script>
        if (window.location.hash === "#_=_") {
            window.location.hash = "";
        }
    </script>


<script>
    // Thêm cart
    $(document).ready(function() {
        $('.btn-add-cart').on('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

            // Lấy thông tin sản phẩm từ thẻ cha của nút
            var productElement = $(this).closest('.product-default');
            var productId = productElement.data('product-id'); // Đảm bảo bạn có data-product-id trong HTML
            var productVariantId = productElement.data('product-variant-id'); // Nếu cần
            var quantity = 1; // Hoặc lấy từ một input nếu cần

            $.ajax({
                url: '{{ route('addCart') }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    product_variants_id: productVariantId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}' // Đừng quên CSRF token
                },
                success: function(response) {
                    // Xử lý thành công, có thể hiện thông báo hoặc cập nhật giỏ hàng
                    // alert(response.message);
                    // location.reload();
                },
                error: function(xhr) {
                    // Xử lý lỗi
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value[0]); // Hiển thị thông báo lỗi đầu tiên
                        });
                    } else {
                        // alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                }
            });
        });
    });

// Thêm vào yêu thích
function addToWishlist(productId, productVariantId) {
    $.ajax({
        type: "POST",
        url: "{{ route('addWishList') }}",
        data: {  
            product_id: productId,
            product_variants_id: productVariantId,
            _token: '{{ csrf_token() }}'      
        },
        success: function(response) {
            // Thay đổi trạng thái của icon-heart (ví dụ: đổi màu)
            const icon = $(`[data-product-id="${productId}"] .btn-icon-wish i`);
            if (response.success.includes('removed')) {
                icon.removeClass('active'); // Xóa class khi bị xóa khỏi wishlist
            } else {
                icon.addClass('active'); // Thêm class khi được thêm vào wishlist
            }
        }
        // Bỏ qua phần error nếu không cần xử lý thông báo
    });
}

</script>
@endsection
