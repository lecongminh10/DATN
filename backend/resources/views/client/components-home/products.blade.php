<!-- resources/views/components/productcomponent.blade.php -->

<h2 class="section-title ls-n-10 m-b-4 appear-animate" data-animation-name="fadeInUpShorter">
    {{ $title }}
</h2>

<div class="products-slider owl-carousel owl-theme dots-top dots-small m-b-1 pb-1 appear-animate"
    data-animation-name="fadeInUpShorter">

    @foreach ($products as $item)
        <div class="product-default inner-quickview inner-icon">
            <figure class="img-effect">
                <a href="{{ route('client.showProduct', $item->id) }}">
                    @php
                        $mainImage = $item->galleries->where('is_main', true)->first();
                        $otherImages = $item->galleries->where('is_main', false)->take(1);
                    @endphp

                    @if ($mainImage)
                        <img src="{{ \Storage::url($mainImage->image_gallery) }}" width="205" height="205" alt="{{ $item->name }}" />
                    @endif

                    @foreach ($otherImages as $value)
                        <img src="{{ \Storage::url($value->image_gallery) }}" width="205" height="205" alt="{{ $item->name }}" />
                    @endforeach
                </a>
                <div class="label-group">
                    @if ($item->is_hot_deal == 1)
                        <div class="product-label label-hot">HOT</div> 
                    @endif

                    @php
                        // Xác định giá sản phẩm
                        if (isset($item->productVariant)) {
                            // Nếu có product_variant, lấy giá từ biến thể  
                            $price = $item->productVariant->price_modifier;
                        } else {
                            // Nếu không có product_variant, kiểm tra giá sale của sản phẩm
                            $price = ($item->price_sale !== null && $item->price_sale < $item->price_regular)
                                ? $item->price_sale // Lấy giá sale nếu có
                                : $item->price_regular; // Nếu không có giá sale, lấy giá thường
                        }

                        // Tính toán phần trăm giảm giá nếu có giá sale hợp lệ
                        $discountPercentage = null;
                        if ($item->price_sale !== null && $item->price_sale < $item->price_regular) {
                            $discountPercentage = round(
                                (($item->price_regular - $item->price_sale) / $item->price_regular) * 100
                            );
                        }
                    @endphp

                    @if ($discountPercentage !== null)
                        <div class="product-label label-sale">- {{ $discountPercentage }}%</div>
                    @endif
                </div>
                <div class="btn-icon-group">
                    <a href="#" title="Add To Cart" class="btn-icon btn-add-cart product-type-simple">
                        <i class="icon-shopping-cart"></i>
                    </a>
                </div>
                <a href="{{ route('client.showProduct', $item->id) }}" title="Quick View"><button class="btn-quickview" style="cursor: pointer">Chi tiết</button></a>
            </figure>
            <div class="product-details">
                <div class="category-wrap">
                    <div class="category-list">
                        <a href="{{ route('client.showProduct', $item->id) }}" class="product-category">
                            {{ $item->category->name }}
                        </a>
                    </div>
                    <a href="wishlist.html" title="Add to Wishlist" class="btn-icon-wish">
                        <i class="icon-heart"></i>
                    </a>
                </div>
                <h3 class="product-title">
                    <a href="">{{ $item->name }}</a>
                </h3>
                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:{{ $item->rating * 20 }}%"></span>
                        <span class="tooltiptext tooltip-top">{{ $item->rating }}</span>
                    </div>
                </div>
                <div class="price-box">
                    {{-- @if ($item->price_sale < $item->price_regular)
                        <span class="product-price" style="text-decoration: line-through; font-size: 0.8em;">
                            {{ number_format($item->price_regular, 0, ',', '.') }} VNĐ
                        </span>
                        <br>
                        <span class="product-sale-price" style="color: #08c; font-size: 1.2em;">
                            {{ number_format($item->price_sale, 0, ',', '.') }} VNĐ
                        </span>
                    @else
                        <span class="product-price" style="color: #08c;">
                            {{ number_format($item->price_regular, 0, ',', '.') }} VNĐ
                        </span>
                    @endif --}}

                    @if ($item->price_sale == null)
                        <span class="old-price"></span>
                        <br>
                        <span class="new-price" style="color: #08c; font-size: 1.2em;">{{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                    @else
                        <span class="old-price">{{ number_format($item->price_regular, 0, ',', '.') }} ₫</span>
                        <br>
                        <span class="new-price" style="color: #08c;  font-size: 1.2em;">{{ number_format($item->price_sale, 0, ',', '.') }} ₫</span>
                    @endif  
                </div>
            </div>
        </div>
    @endforeach
</div>

@section('scripte_logic')
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