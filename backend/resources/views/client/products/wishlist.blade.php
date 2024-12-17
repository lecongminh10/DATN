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
            <div class="row" style="margin-top: -5px">
                @foreach ($wishLists as $item)
                    <div class="col-5 col-sm-3">
                        <div class="product-default">
                            <figure>
                                <a href="{{ route('client.showProduct', $item->product->id) }}" class="product-image">
                                    @php
                                        if ($item->productVariant && !empty($item->productVariant->variant_image)) {
                                            $url = $item->productVariant->variant_image; 
                                        } else {
                                            $mainImage = $item->product->getMainImage(); 
                                            $url = $mainImage && !empty($mainImage->image_gallery) ? $mainImage->image_gallery : 'default-image-path.jpg';
                                        }
                                    @endphp
                                    <img src="{{ $url ? Storage::url($url) : asset('default-image-path.jpg') }}" 
                                         alt="{{ $item->product->name ?? 'No image available' }}" />
                                </a>
                            </figure>
            
                            <div class="label-group">
                                @if ($item->is_hot_deal == 1)
                                    <div class="product-label label-hot">HOT</div>
                                @endif
                            </div>
            
                            <div class="product-details">
                                <h3 class="product-title">
                                    <a href="{{ route('client.showProduct', $item->product->id) }}">{{ $item->product->name }}</a>
                                </h3>
            
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:{{ $item->product->rating * 20 }}%"></span>
                                        <span class="tooltiptext tooltip-top">{{ $item->product->rating }} </span>
                                    </div>
                                </div>

                                @php
                                    if (isset($item->product->variants) && $item->product->variants->isNotEmpty()) {
                                        $minPrice = $item->product->variants->filter(function ($variant) {
                                            return $variant->price_modifier !== null;
                                        })->isNotEmpty()
                                            ? $item->product->variants->min('price_modifier')
                                            : $item->product->variants->min('original_price');
                                        
                                        $maxPrice = $item->product->variants->filter(function ($variant) {
                                            return $variant->price_modifier !== null;
                                        })->isNotEmpty()
                                            ? $item->product->variants->max('price_modifier')
                                            : $item->product->variants->max('original_price');
                                    } else {
                                        $minPrice = $item->price_sale;
                                        $maxPrice = $item->price_regular;
                                    }
                                @endphp
            
                                <div class="price-box">
                                    <span class="new-price" style="color: #08c; font-size: 1em;">
                                        <span class="new-price" style="color: #08c;  font-size: 1em;">{{number_format($minPrice, 0, ',', '.')}} đ ~ {{number_format($maxPrice, 0, ',', '.')}} đ</span>
                                    </span>
                                </div>
            
                                <div class="product-action">
                                    <a href="#" class="btn-icon btn-add-cart add-cart" data-product-id="{{ $item->product->id }}" data-toggle="modal">
                                        <i class="fa fa-arrow-right"></i><span>Thêm vào giỏ hàng</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
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