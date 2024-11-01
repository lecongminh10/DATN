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