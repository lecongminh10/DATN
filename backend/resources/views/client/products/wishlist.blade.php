@extends('client.layouts.app')

@section('style_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .stock-status1{
            border-radius:5px; 
            padding: 4px 6px;
            background-color: #de293a; 
            color: white;
            text-align: center;
            display: inline-block; /* Thay đổi display sang inline-block */
            width: 85px; /* Hoặc bất kỳ giá trị nào bạn muốn */
        }
        .stock-status2{
            border-radius:5px; 
            padding: 4px 6px;
            background-color: #29de2f; 
            color: white;
            text-align: center;
            display: inline-block; /* Thay đổi display sang inline-block */
            width: 85px; /* Hoặc bất kỳ giá trị nào bạn muốn */
        }

        .toast-message {
            position: fixed;
            top: 100px;
            right: 20px;
            background-color: #28a745; /* Màu xanh lá cây */
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .product-image img{
            width: 80px;
            height: 70px;
        }
    </style>
@endsection

@section('content')
@include('client.layouts.nav')

<main class="main">
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            {{-- <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{  route('client') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Yêu thích
                        </li>
                    </ol>
                </div>
            </nav> --}}

            <h1>Yêu thích</h1>
        </div>
    </div>

    <div class="container">
        <div class="wishlist-title">
            <h2 class="p-2">Danh sách yêu thích</h2>
        </div>
        <div class="wishlist-table-container">
            <table class="table table-wishlist mb-0">
                <thead>
                    <tr>
                        <th class="thumbnail-col"></th>
                        <th class="product-col">Sản phẩm</th>
                        <th class="price-col">Giá</th>
                        <th class="status-col">Trạng thái</th>
                        <th class="action-col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($wishLists->isEmpty())
                        <tr class="product-row">
                            <td colspan="5" class="text-center">
                                <h4>Bạn chưa có sản phẩm yêu thích</h3>
                            </td>
                        </tr>
                    @else
                        @foreach ($wishLists as $value)
                        <tr class="product-row">
                            <td>
                                <figure class="product-image-container">
                                    <a href="{{ route('client.showProduct', $value->product->id) }}" class="product-image">
                                        @php
                                        if ($value->productVariant && !empty($value->productVariant->variant_image)) {
                                            $url = $value->productVariant->variant_image; 
                                        } else {
                                            $mainImage = $value->product->getMainImage(); 
                                            $url = $mainImage && !empty($mainImage->image_gallery) ? $mainImage->image_gallery : 'default-image-path.jpg';
                                        }
                                        @endphp
                                        <img src="{{ $url ? Storage::url($url) : asset('default-image-path.jpg') }}" 
                                            alt="{{ $value->product->name ?? 'No image available' }}" />
                                    </a>

                                    <a href="javascript:void(0);" class="btn-remove icon-cancel" 
                                        title="Remove Product" data-id="{{ $value->id }}" 
                                        onclick="removeFromWishlist({{ $value->id }})"></a>
                                </figure>
                            </td>
                            <td>
                                <h5 class="product-title">
                                    <a href="product.html">{{ $value->product->name }}</a>
                                </h5>
                            </td>
                            <td class="price-box">
                                @if ($value->product && is_null($value->productVariant)) 
                                    @if (!is_null($value->product->price_sale) && $value->product->price_sale > 0) 
                                        {{ number_format($value->product->price_sale, 0, ',', '.') }} ₫
                                    @else
                                        {{ number_format($value->product->price_regular, 0, ',', '.') }} ₫
                                    @endif
                                @elseif ($value->product && $value->productVariant) 
                                    {{ number_format($value->productVariant->price_modifier, 0, ',', '.') }} ₫
                                @endif
                            </td>
                            <td>
                            @if ($value->product->stock == 0 )
                            <span class="stock-status1">Hết hàng</span>
                            @else
                            <span class="stock-status2">Còn hàng</span>
                            @endif
                                
                            </td>
                            <td class="">
                                <a href="{{ route('client.showProduct', $value->product->id) }}" 
                                    title=""><button class="btn btn-quickview mt-1 mt-md-0">Xem</button></a>
                                <button 
                                    class="btn btn-dark btn-add-cart product-type-simple btn-shop" 
                                    data-product-id="{{ $value->product->id }}" 
                                    data-product-variant-id="{{ $productVariant->id ?? '' }}">
                                    Thêm vào giỏ hàng
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div><!-- End .cart-table-container -->

        {{-- Thông báo --}}
        <div id="customToast" class="toast-message" style="display: none;">
            Sản phẩm đã được thêm vào giỏ hàng!
        </div>

    </div><!-- End .container -->

</main><!-- End .main -->

@endsection

@section('script_libray')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection

@section('scripte_logic')

<script>
// Xóa khỏi wishlist
    function removeFromWishlist(wishlistId) {
        fetch(`/wishlist/${wishlistId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Tải lại trang nếu xóa thành công
            if (data.message === 'Wishlist item deleted successfully') {
                location.reload(); // Tải lại trang
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Xử lý lỗi nếu cần thiết, nhưng không hiển thị thông báo
        });
    }

    // Thêm vào cart
    $(document).ready(function() {
        $('.btn-add-cart').on('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

            // Lấy thông tin sản phẩm từ nút
            var productId = $(this).data('product-id'); // Lấy data-product-id
            var productVariantId = $(this).data('product-variant-id'); // Lấy data-product-variant-id
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
                    // Hiển thị thông báo thành công
                    $('#customToast').fadeIn(400).delay(2000).fadeOut(400);
                },
                error: function(xhr) {
                    // Xử lý lỗi nhưng không hiển thị thông báo
                    console.error('Có lỗi xảy ra:', xhr);
                }
            });
        });
    });

</script>

@endsection