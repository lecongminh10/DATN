@extends('client.layouts.app')

@section('style_css')
    <style>
        .product-details {
            padding: 10px;
            /* Khoảng cách bên trong */
            margin-bottom: 15px;
            /* Khoảng cách giữa các sản phẩm */
            border-radius: 5px;
            /* Góc bo tròn */
        }

        .product-name {
            font-weight: bold;
            /* Làm đậm tên sản phẩm */
            font-size: 1em;
            /* Kích thước chữ lớn hơn */
            color: #333;
            /* Màu chữ */
        }

        .attribute-list {
            margin-top: 10px;
            /* Khoảng cách giữa tên sản phẩm và thuộc tính */
            padding-left: 15px;
            /* Khoảng cách bên trái cho thuộc tính */
        }

        .attribute-list p {
            margin-bottom: 0px !important;
        }

        .attribute-item {
            font-size: 0.9em;
            /* Kích thước chữ nhỏ hơn cho thuộc tính */
            color: #555;
            /* Màu chữ nhạt hơn */
        }

        .attribute-item strong {
            color: #000;
            /* Màu chữ cho tên thuộc tính */
        }

        .product-price {
            text-align: right;
            /* Aligns prices to the right */
        }

        .price-sale {
            color: #0088cc;
            /* Bootstrap Danger color for sale prices */
            font-weight: bold;
            /* Makes sale price bold */
            font-size: 11px !important;
            /* Slightly larger font for emphasis */
        }

        .price-original {
            color: #999;
            /* Light gray color for original prices */
            text-decoration: line-through;
            /* Adds a strikethrough effect */
            font-size: 10px !important;
            /* Regular size for original prices */
            margin-left: 10px;
            /* Adds space between sale and original prices */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-price {
                text-align: left;
                /* Align left on smaller screens */
            }
        }

        .product-title .product-details {
            padding-left: 10px;
        }

        .product-title .attribute-item {
            font-size: 12px !important;
            margin-bottom: 5px !important;
        }

        .product-title .text-muted {
            font-size: 12px !important;
        }

        .product-title .attribute-item strong {
            color: rgba(0, 0, 0, 0.6);
            font-weight: 300;
            font-size: 12px !important;
        }
    </style>
@endsection
@section('content')

    @include('client.layouts.nav')

    <main class="main">
        <div class="container">
            <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li class="active">
                    <a href="{{ route('shopping-cart') }}">Giỏ hàng</a>
                </li>
                <li>
                    <a href="{{ route('checkout') }}">Thanh toán</a>
                </li>
                <li class="disabled">
                    <a href="#">Đơn hàng hoàn tất</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-lg-9">
                    <div class="cart-table-container">
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th class="thumbnail-col"></th>
                                    <th>Tên sản phẩm </th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalAmount = 0;
                                $totalQuantity = null;
                                ?>
                                @foreach ($carts as $value)
                                    <tr class="product-row">
                                        <td>
                                            <figure class="product-image-container">
                                                <a href="{{ route('client.showProduct', $value->product->id) }}"
                                                    class="product-image">
                                                    @php
                                                        if (
                                                            $value->productVariant &&
                                                            !empty($value->productVariant->variant_image)
                                                        ) {
                                                            $url = $value->productVariant->variant_image;
                                                        } else {
                                                            $mainImage = $value->product->getMainImage();
                                                            $url = $mainImage
                                                                ? $mainImage->image_gallery
                                                                : 'default-image-path.jpg';
                                                        }
                                                    @endphp
                                                    <img src="{{ Storage::url($url) }}" alt="{{ $value->product->name }}">
                                                </a>

                                                <a href="#" class="btn-remove icon-cancel" title="Remove Product"
                                                    data-id="{{ $value->id }}" onclick="removeFromCart(this)"></a>
                                            </figure>
                                        </td>
                                        <td class="product-col">
                                            <h5 class="product-title">
                                                <a href="{{ route('client.showProduct', $value->product->id) }}">
                                                    @if ($value->productVariant)
                                                        <div class="product-details">
                                                            <span
                                                                class="product-name py-2">{{ $value->product->name }}</span>
                                                            <div class="text-muted">Loại: </div>
                                                            <div class="attribute-list">
                                                                @if ($value->productVariant->attributeValues)
                                                                    @foreach ($value->productVariant->attributeValues as $attributeValue)
                                                                        <p class="attribute-item">
                                                                            <strong>{{ $attributeValue->attribute->attribute_name }}:</strong>
                                                                            <span>{{ $attributeValue->attribute_value }}</span>
                                                                        </p>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="product-name">{{ $value->product->name }}</span>
                                                    @endif
                                                </a>
                                            </h5>
                                        </td>
                                        <td class="product-price">
                                            @if ($value->productVariant)
                                                @if (!empty($value->productVariant->price_modifier) && $value->productVariant->price_modifier !== null)
                                                    <span
                                                        class="">{{ number_format($value->productVariant->price_modifier, 0, ',', '.') }}
                                                        đ</span>
                                                    <del class="">{{ number_format($value->productVariant->original_price, 0, ',', '.') }}
                                                        đ</del>
                                                @else
                                                    <span
                                                        class="">{{ number_format($value->productVariant->original_price, 0, ',', '.') }}
                                                        đ</span>
                                                @endif
                                            @else
                                                @if (!empty($value->product->price_sale) && $value->product->price_sale !== null)
                                                    <span
                                                        class="">{{ number_format($value->product->price_sale, 0, ',', '.') }}
                                                        đ</span>
                                                    <del class="">{{ number_format($value->product->price_regular, 0, ',', '.') }}
                                                        đ</del>
                                                @else
                                                    <span
                                                        class="">{{ number_format($value->product->price_regular, 0, ',', '.') }}
                                                        đ</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="product-single-qty">
                                                <input class="horizontal-quantity form-control" type="number"
                                                    min="1"
                                                    data-price="{{ $value->productVariant
                                                        ? (!empty($value->productVariant->price_modifier)
                                                            ? $value->productVariant->price_modifier
                                                            : $value->productVariant->original_price)
                                                        : ($value->product
                                                            ? ($value->product->price_sale ?:
                                                                $value->product->price_regular)
                                                            : 0) }}"
                                                    value="{{ $value->quantity }}"
                                                    data-stock="{{ $value->productVariant && $value->productVariant->stock ? $value->productVariant->stock : 0 }}"
                                                    onchange="updateSubtotal(this)">

                                            </div>
                                        </td>
                                        <?php
                                        $price = 0;
                                        $subTotal = 0;
                                        if ($value->product) {
                                            if ($value->productVariant) {
                                                // Use price modifier if it exists, otherwise use original price
                                                if (!empty($value->productVariant->price_modifier) && $value->productVariant->price_modifier !== null) {
                                                    $price = $value->productVariant->price_modifier; // Use price modifier
                                                } else {
                                                    $price = $value->productVariant->original_price; // Use original price
                                                }
                                            } else {
                                                if (!empty($value->product->price_sale) && $value->product->price_sale !== null) {
                                                    $price = $value->product->price_sale;
                                                } else {
                                                    $price = $value->product->price_regular;
                                                }
                                            }

                                            $subTotal = $price * $value->quantity;
                                        } else {
                                            $subTotal = 0; // Default to 0 if no product
                                        }

                                        // Accumulate total amount and quantity
                                        $totalAmount += $subTotal; // Accumulate total amount
                                        $totalQuantity += $value->quantity; // Accumulate total quantity
                                        ?>
                                        <td class="text-right">
                                            <span class="subtotal-price">{{ number_format($subTotal, 0, ',', '.') }}
                                                đ</span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="clearfix">


                                        <div class="float-right">
                                            @if ($carts && count($carts) > 0)
                                                <button type="submit" class="btn btn-shop btn-update-cart">
                                                    Cập nhật giỏ hàng
                                                </button>
                                            @else
                                                {{-- {{ "Không có sản phẩm trong giỏ hàng" }} --}}
                                            @endif
                                        </div><!-- End .float-right -->
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- End .cart-table-container -->
                </div><!-- End .col-lg-8 -->

                <div class="col-lg-3">
                    <div class="cart-summary">
                        <h3>Tổng giỏ hàng</h3>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <p>Số lượng</p>
                                <p>Tổng giá</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <p>× {{ $totalQuantity }}</p>
                                <p>{{ number_format($totalAmount, 0, ',', '.') }} đ</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <td>Tổng cộng</td>
                                <?php $toTal = $totalAmount; ?>
                                <span id="totalAmountDisplay" class="mx-3"
                                    style="padding-left:30px">{{ number_format($toTal, 0, ',', '.') }} đ</span>
                            </div>
                        </div>
                        <div class="checkout-methods">
                            <a href="{{ route('checkout') }}" class="btn btn-block btn-dark">Thanh toán
                                <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div><!-- End .cart-summary -->
                </div><!-- End .col-lg-4 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-6"></div><!-- margin -->
    </main><!-- End .main -->
    <div class="modal fade" id="stockAlertModal" tabindex="-1" aria-labelledby="stockAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockAlertModalLabel">Thông Báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="stock-alert-message">Số lượng bạn nhập vượt quá giới hạn kho.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script_libray')
@endsection

@section('scripte_logic')
    <script>
        // Cập nhật số lượng + giá tiền
        function updateSubtotal(inputElement) {
            const price = parseFloat(inputElement.getAttribute('data-price')) || 0;
            const quantity = parseInt(inputElement.value);
            const maxStock = parseInt(inputElement.getAttribute('data-stock'));

            console.log(quantity);

            // Kiểm tra nếu số lượng vượt quá kho
            if (quantity > maxStock) {
                // Hiển thị thông báo trong modal
                const stockAlertMessage = document.getElementById('stock-alert-message');

                // Hiển thị modal
                const stockAlertModal = new bootstrap.Modal(document.getElementById('stockAlertModal'));
                stockAlertModal.show();

                inputElement.value = maxStock;
                return; // Không tính tổng nếu vượt quá kho
            }

            const subTotal = price * quantity;

            function formatCurrency(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ';
            }

            const subTotalElement = inputElement.closest('tr').querySelector('.subtotal-price');
            subTotalElement.textContent = formatCurrency(subTotal);
        }



        // Xóa khỏi giỏ hàng
        function removeCart(element) {
            const cartId = element.getAttribute('data-id'); // Lấy ID của sản phẩm từ data-id

            // Gửi yêu cầu xóa sản phẩm
            fetch(`remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'), // CSRF token
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Xóa hàng ra khỏi DOM
                        const row = element.closest('tr'); // Tìm dòng sản phẩm tương ứng
                        row.remove(); // Xóa dòng sản phẩm khỏi bảng
                    } else {
                        alert('Có lỗi xảy ra khi xóa sản phẩm');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Update cart
        document.querySelector('.btn-update-cart').addEventListener('click', function() {
            const cartItems = [];

            document.querySelectorAll('.product-row').forEach(row => {
                const id = row.querySelector('.btn-remove').getAttribute('data-id'); // Lấy ID sản phẩm
                const quantity = row.querySelector('.horizontal-quantity').value; // Lấy số lượng

                cartItems.push({
                    id,
                    quantity
                }); // Đưa vào mảng cartItems
            });

            // Gửi yêu cầu cập nhật
            fetch('update-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'), // CSRF token
                    },
                    body: JSON.stringify({
                        cartItems
                    }) // Gửi mảng cartItems
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // alert(data.message); // Hiển thị thông báo thành công
                        location.reload(); // Tải lại trang để cập nhật giỏ hàng
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
