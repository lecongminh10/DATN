@extends('client.layouts.app')

@section('style_css')
    <link rel="stylesheet" href="{{ asset('css/client/checkout.css') }}">
@endsection
@section('content')

    @php
        Auth::check() ? Auth::user()->id : '';
    @endphp

    @include('client.layouts.nav')

    <main class="main main-test">
        <div class="container checkout-container">
            <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li>
                    <a href="{{ route('shopping-cart') }}">Giỏ hàng</a>
                </li>
                <li class="active">
                    <a href="{{ route('checkout') }}">Thanh toán đơn hàng</a>
                </li>
                <li class="disabled">
                    <a href="#">Đơn hàng hoàn tất</a>
                </li>
            </ul>

            <div class="checkout-discount">
                <h4>Mã giảm giá?
                    <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                        aria-controls="collapseTwo" class="btn btn-link btn-toggle">Nhập ở đây</button>
                </h4>
                <div id="collapseTwo" class="collapse">
                    <div class="feature-box">
                        <div class="feature-box-content row">
                            <div class="col-6">
                                <p>Nếu bạn có mã giảm giá, hãy nhập mã vào ô bên dưới.</p>
                                <form id="couponForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm w-auto"
                                            placeholder="Nhập mã" required name="coupon_code" id="coupon_code" />
                                        <div class="input-group-append">
                                            <button class="btn btn-sm mt-0" type="button" onclick="applyCoupon()"
                                                data-toggle="modal" data-target="#messageapplyCoupone"
                                                id="messageAlert">Nhập
                                                mã giảm giá</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div id="discount-info" style="display: {{ session('coupons') ? 'block' : 'none' }};">
                                    @if (session('coupons'))
                                        @foreach (session('coupons') as $coupon)
                                            <div class="alert-info position-relative">
                                                <p class="end position-absolute top-0 end-0 m-0"
                                                    style="right: 10px; color: #b7062ef2;">Đang áp dụng</p>
                                                <p><strong class="mx-2">Mã giảm giá:</strong>{{ $coupon['code'] }}</p>
                                                <p><strong class="mx-2">Giá trị giảm giá:</strong>
                                                    {{ $coupon['discount_type'] == 'percentage'
                                                        ? $coupon['discount_value'] . ' %'
                                                        : number_format($coupon['discount_amount'], 0, ',', '.') . ' đ' }}
                                                </p>
                                                <p><strong class="mx-2">Số tiền được giảm:</strong>
                                                    {{ number_format($coupon['discount_amount'], 0, ',', '.') }}đ</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div> <!-- Hiển thị thông tin giảm giá -->
                                <button id="applyDiscountBtn" class="btn btn-primary mt-3" style="display:none;"
                                    onclick="applyDiscountToOrder()">Áp dụng giảm giá</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('addOrder') }}" method="post" id="checkout-form">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <ul class="checkout-steps">
                            <li>
                                <h2 class="step-title mb-2">Địa chỉ nhận hàng</h2>
                                <div class="form-group mb-1 pb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="name-phone">
                                            <div class="name me-2">
                                                <strong>{{ Auth::check() ? Auth::user()->username : 'Chưa có tên' }}</strong>
                                            </div>
                                            <div class="phone me-2">
                                                <strong>{{ Auth::check() ? Auth::user()->phone_number : 'Chưa có số điện thoại' }}</strong>
                                            </div>
                                        </div>
                                        <div class="address">
                                            @php
                                                if (Auth::check()) {
                                                    $displayAddress = Auth::user()->addresses;
                                                }
                                                $hasAddress =
                                                    Auth::check() &&
                                                    !empty(Auth::user()->addresses) &&
                                                    count($displayAddress) > 0;
                                                $checkdisable = $hasAddress ? true : false;
                                            @endphp
                                            @if (count($displayAddress))
                                                @foreach ($displayAddress as $address)
                                                    @if ($address->active == true)
                                                        <div>
                                                            <span id="displayAddress"> {{ $address->specific_address }},
                                                                {{ $address->ward }}, {{ $address->district }},
                                                                {{ $address->city }}</span>
                                                        </div>
                                                        <br>
                                                        <span class="small-text ms-2 my-2" style="color: #2a78b0">Mặc
                                                            Định</span>
                                                        <a href="#editAddressModal" class="small-link ms-2 my-2"
                                                            data-bs-toggle="modal">Thay Đổi</a>
                                                        <input type="hidden" name="shipping_address_id"
                                                            value="{{ $address->id }}">
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Địa chỉ --}}
                                @include('client.orders.modal.index')

                                <div class="form-group">
                                    <label class="order-comments">Sản phẩm</label>
                                </div>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cartCheckout as $item)
                                    <div class="product-container">
                                        <div class="product-image">
                                            @php
                                                if (
                                                    $item->productVariant &&
                                                    !empty($item->productVariant->variant_image)
                                                ) {
                                                    $url = $item->productVariant->variant_image;
                                                } else {
                                                    $mainImage = $item->product->getMainImage();
                                                    $url = $mainImage
                                                        ? $mainImage->image_gallery
                                                        : 'default-image-path.jpg';
                                                }
                                            @endphp
                                            <img src="{{ Storage::url($url) }}" alt="{{ $item->product->name }}"
                                                class="img-thumbnail" style="width: 120px;height: 100px;">
                                        </div>
                                        <div class="product-info">
                                            <div class="d-flex justify-content-between mt-1">
                                                <div class="namePro">
                                                    <span class="product-name">{{ $item->product->name }}</span>
                                                    <div class="text-muted">Loại: </div>
                                                    @if ($item->productVariant)
                                                        <div class="product-details">
                                                            <div class="attribute-list">
                                                                @if ($item->productVariant->attributeValues)
                                                                    @foreach ($item->productVariant->attributeValues as $attributeValue)
                                                                        <p class="attribute-item">
                                                                            <strong>{{ $attributeValue->attribute->attribute_name }}:</strong>
                                                                            <span>{{ $attributeValue->attribute_value }}</span>
                                                                        </p>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-muted">Đơn giá</span>
                                                    <div class="fw-bold" style="width: 100px">
                                                        @if ($item->productVariant)
                                                            @if (!empty($item->productVariant->price_modifier))
                                                                {{ number_format($item->productVariant->price_modifier, 0, ',', '.') }}
                                                                đ
                                                            @else
                                                                {{ number_format($item->productVariant->original_price, 0, ',', '.') }}
                                                                đ
                                                            @endif
                                                        @else
                                                            @if (!empty($item->product->price_sale))
                                                                {{ number_format($item->product->price_sale, 0, ',', '.') }}
                                                                đ
                                                            @else
                                                                {{ number_format($item->product->price_modifier, 0, ',', '.') }}
                                                                đ
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="product-quantity">
                                                    <span class="text-muted">Số lượng</span>
                                                    <div class="fw-bold">{{ $item->quantity }}</div>
                                                </div>
                                                @php
                                                    $price = 0;

                                                    // Check if productVariant exists
                                                    if ($item->productVariant) {
                                                        // Check if price_modifier is not empty or null
                                                        if (!empty($item->productVariant->price_modifier)) {
                                                            $price = $item->productVariant->price_modifier; // Use price_modifier if available
                                                        } else {
                                                            // Use original_price if price_modifier is not set
                                                            $price = $item->productVariant->original_price;
                                                        }
                                                    } else {
                                                        // Handle case where productVariant is null
                                                        if (!empty($item->product->price_sale)) {
                                                            $price = $item->product->price_sale; // Use price_sale if available
                                                        } else {
                                                            // Fallback to price_regular or handle if neither is set
                                                            $price = $item->product->price_regular ?? 0; // Use price_regular if available
                                                        }
                                                    }

                                                    // Calculate total
                                                    $total = $price * $item->quantity;
                                                @endphp

                                                <div class="product-total">
                                                    <span class="text-muted">Thành tiền</span>
                                                    <div class="fw-bold"> {{ number_format($total, 0, ',', '.') }}
                                                        đ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="form-group">
                                    <label class="order-comments">Ghi chú</label>
                                    <textarea id="note" class="form-control" name="note" placeholder="Bạn có gì muốn dặn dò shop không ?"
                                        cols="30" rows="10"></textarea>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-4">
                        <div class="order-summary">

                            <h3>ĐƠN HÀNG CỦA BẠN</h3>

                            <table class="table table-mini-cart">
                                <thead>
                                    <tr>
                                        <th colspan="2">Sản Phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subTotal = 0;
                                        $quantity = 0;
                                    @endphp
                                    @foreach ($cartCheckout as $key => $value)
                                        <tr>
                                            <td class="product-col">
                                                <h3 class="product-title">
                                                    {{ $value->product->name }}
                                                    <span class="product-qty">× {{ $value->quantity }}</span>
                                                    <input type="hidden"
                                                        name="order_item[{{ $key }}][product_id]"
                                                        value="{{ $value->product_id }}">
                                                    <input type="hidden"
                                                        name="order_item[{{ $key }}][product_variant_id]"
                                                        value="{{ $value->product_variants_id }}">
                                                    <input type="hidden"
                                                        name="order_item[{{ $key }}][quantity]"
                                                        value="{{ $value->quantity }}">
                                                    <input type="hidden" name="order_item[{{ $key }}][price]"
                                                        value="{{ $value->total_price }}">
                                                    <input type="hidden" name="order_item[{{ $key }}][id_cart]"
                                                        value="{{ $value->id }}">
                                                </h3>
                                            </td>
                                            <td class="price-col">
                                                <span>
                                                    @if ($value->productVariant)
                                                        @if (!empty($value->productVariant->price_modifier))
                                                            <span
                                                                class="">{{ number_format($value->productVariant->price_modifier, 0, ',', '.') }}
                                                                đ</span>
                                                        @else
                                                            <span
                                                                class="">{{ number_format($value->productVariant->original_price, 0, ',', '.') }}
                                                                đ</span>
                                                        @endif
                                                    @else
                                                        @if (!empty($value->product->price_sale))
                                                            <span
                                                                class="">{{ number_format($value->product->price_sale, 0, ',', '.') }}
                                                                đ</span>
                                                        @else
                                                            <span
                                                                class="">{{ number_format($value->product->price_regular, 0, ',', '.') }}
                                                                đ</span>
                                                        @endif
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @php
                                            $subTotal += $value->total_price; // Assuming total_price is already price * quantity
                                            $quantity += $value->quantity;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="border:none">
                                        <td>
                                            <h4>Số lượng</h4>
                                        </td>
                                        <td class="quantity-col">
                                            <span class="quantity">×{{ $quantity }}</span>
                                        </td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <td style="margin-top: 10px">
                                            <h4>Tổng phụ</h4>
                                        </td>
                                        <td class="price-col">
                                            <span>{{ number_format($subTotal, 0, ',', '.') }} đ</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="margin-top: 10px">
                                            <h4>Mã giảm giá</h4>
                                        </td>
                                        <td class="price-col"></td>
                                    </tr>
                                    <tr id="couponInfo">
                                        @php
                                            //  dd(session('coupons'));
                                        @endphp
                                        @if (session('coupons'))
                                            @foreach (session('coupons') as $key => $coupon)
                                    <tr>
                                        <td style="padding-left: 5px;">
                                            <h5 style="font-weight: 100; font-size: 11px; padding-left: 20px;margin: 0px;">
                                                {{ $coupon['code'] }}</h5>
                                        </td>
                                        <td class="price-col price-coupone">
                                            {{ number_format($coupon['discount_amount'], 0, ',', '.') }}đ</td>
                                    </tr>
                                    <input type="hidden" name="coupons[{{ $key }}][code]"
                                        value="{{ $coupon['code'] }}" />
                                    <input type="hidden" name="coupons[{{ $key }}][discount_amount]"
                                        value="{{ $coupon['discount_amount'] }}" />
                                    @endforeach
                                    @endif
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <h4>Vận chuyển</h4>
                                            <div class="form-group form-group-custom-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input shipp-fe"
                                                        name="shipp[{{ $dataShippingMethod['value'] }}]"
                                                        value="{{ $dataShippingMethod['shipp'] }}" checked
                                                        onchange="updateTotal()">
                                                    <label class="custom-control-label">
                                                        {{ $dataShippingMethod['message'] }}
                                                        (
                                                        {{ is_numeric($dataShippingMethod['shipp']) ? number_format((float) $dataShippingMethod['shipp'], 0, ',', '.') : 'N/A' }}
                                                        đ
                                                        )
                                                    </label>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr class="order-shipping">
                                        <td class="text-left" colspan="2">
                                            <h4 class="m-b-sm">Phương thức thanh toán</h4>
                                            <div class="form-group form-group-custom-control">
                                                <div class="custom-control custom-checkbox d-flex">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="payment-online" name="radio_pay" value="VNPay"
                                                        onclick="selectPayment(this)" />
                                                    <label class="custom-control-label" for="payment-online">Thanh toán
                                                        VNPay</label>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-custom-control mb-0">
                                                <div class="custom-control custom-checkbox d-flex mb-0">
                                                    <input type="checkbox" class="custom-control-input" id="payment-cash"
                                                        name="radio_pay" value="Cash" onclick="selectPayment(this)"
                                                        checked />
                                                    <label class="custom-control-label" for="payment-cash">Thanh toán sau
                                                        khi nhận hàng</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="order-total">
                                        <td>
                                            <h4>Tổng </h4>
                                        </td>
                                        <td>
                                            <b class="total-price"><span id="totalPriceDisplay" style="font-size: 2rem"
                                                    name="price">{{ number_format($subTotal, 0, ',', '.') }}
                                                    đ</span></b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            {{-- <div class="payment-methods">
                                    <h4 class="">Payment methods</h4>
                                    <div class="info-box with-icon p-0">
                                        <p>
                                            Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.
                                        </p>
                                    </div>
                                </div> --}}

                            <input type="hidden" name="price" id="totalAmountInput" value="{{ $subTotal }}">
                            <button type="submit" class="btn btn-dark btn-place-order" form="checkout-form"
                                {{ $checkdisable ? '' : 'disabled' }}>
                                Đặt hàng
                            </button>
                        </div>
                        <!-- End .cart-summary -->
                    </div>
                    <!-- End .col-lg-4 -->
                </div>
            </form>
            <!-- End .row -->
        </div>
        <!-- End .container -->


    </main>
    {{-- Modal thông báo lỗi khi áp dụng mã giảm giá --}}
    @include('client.orders.modal.message')
    <!-- Modal -->

@endsection


@section('script_libray')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endsection

@section('scripte_logic')
    <script>
        let check = {{ $hasAddress ? 'false' : 'true' }};
        console.log(check);
        if (check === true) {
            let modal = new bootstrap.Modal(document.getElementById('editAddressModal'));
            modal.show();
        }
        $(document).ready(function() {
            $('#applyToCoupon button[data-dismiss="modal"]').on('click', function() {
                $('#applyToCoupon').modal('hide'); // Đóng modal
                location.reload(); // Tải lại trang
            });

            // Khi nhấn ra ngoài modal để đóng modal và tải lại trang
            $('#applyToCoupon').on('click', function(e) {
                if ($(e.target).hasClass('modal')) {
                    $('#applyToCoupon').modal('hide'); // Đóng modal nếu người dùng nhấn ngoài modal
                    location.reload(); // Tải lại trang
                }
            });
        });

        // Chọn checkbox
        function selectPayment(selectedCheckbox) {
            // Lấy tất cả checkbox trong cùng nhóm
            const checkboxes = document.querySelectorAll('input[name="radio_pay"]');

            checkboxes.forEach(checkbox => {
                // Nếu checkbox không phải là checkbox đã được chọn
                if (checkbox !== selectedCheckbox) {
                    // Bỏ chọn tất cả checkbox khác
                    checkbox.checked = false;
                }
            });
        }

        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            const number = Number(value).toFixed(2); // Đảm bảo giá trị luôn có 2 chữ số thập phân
            const [whole, decimal] = number.split('.');
            const formattedWhole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Định dạng phân cách hàng nghìn
            return `${formattedWhole} đ`;
        }
        // Hàm định dạng giá trị giảm giá
        function formatCurrency2(value) {
            const number = Number(value).toFixed(2);
            const [whole, decimal] = number.split('.');
            const formattedWhole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return `${formattedWhole}`;
        }

        // Hàm cập nhật tổng tiền với phí vận chuyển và giảm giá nếu có
        function calculateTotal(subtotal, discount = 0, shippingCost = 0) {
            const total = subtotal - discount + shippingCost; // Tính tổng tiền sau khi trừ giảm giá và cộng phí ship
            document.getElementById('totalPriceDisplay').textContent = formatCurrency(total); // Hiển thị tổng tiền
            document.getElementById('totalAmountInput').value = total; // Cập nhật giá trị tổng vào input ẩn
        }

        // Hàm cập nhật phí vận chuyển
        function updateShipping() {
            const shippingCost = parseFloat(document.querySelector('input[name="radio-ship"]:checked').value);
            console.log('phí vận chuyển là ', shippingCost);

            const subtotal = parseFloat('{{ $subTotal }}'); // Giá trị tổng phụ từ server
            const discount = parseFloat(document.getElementById('discountAmountInput')?.value ||
            0); // Lấy giá trị giảm giá từ input (nếu có)
            calculateTotal(subtotal, discount, shippingCost); // Tính tổng với giá trị giảm giá và phí vận chuyển
        }

        function updateTotal() {
            const subtotal = parseFloat('{{ $subTotal }}');
            const shippingCost = parseFloat(document.querySelector('input.shipp-fe:checked').value);
            let discountTotal = 0;

            // Tính tổng giảm giá từ các mã giảm giá
            @if (session('coupons'))
                @foreach (session('coupons') as $coupon)
                    discountTotal += {{ $coupon['discount_amount'] }};
                @endforeach
            @endif

            let total = subtotal + shippingCost - discountTotal;
            if (total < 0) {
                total = 0;
            }

            document.getElementById('totalPriceDisplay').textContent = formatCurrency(total);
            document.getElementById('totalAmountInput').value = total;
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });

        // Hàm áp dụng mã giảm giá
        let appliedCoupons = []; // Mảng lưu trữ các voucher đã áp dụng
let totalDiscount = 0; // Tổng giảm giá của tất cả các mã giảm giá đã áp dụng

// Hàm áp dụng mã giảm giá
function applyCoupon() {
    const couponCode = document.getElementById("coupon_code").value.trim();

    if (!couponCode) {
        document.querySelector("#messageapplyCoupone .modal-body").innerHTML =
            `<p style="color: red;">Vui lòng nhập mã giảm giá</p>`;
        return;
    }

    const shippingCost = parseFloat(document.querySelector('input.shipp-fe:checked').value);

    if (appliedCoupons.includes(couponCode)) {
        document.querySelector("#messageapplyCoupone .modal-body").innerHTML =
            `<p style="color: red;">Mã giảm giá này đã được áp dụng</p>`;
        return;
    }

    // Gửi yêu cầu tới server để kiểm tra mã giảm giá
    fetch("/apply-coupon", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({
                coupon_code: couponCode
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("coupon_code").value = "";

            if (data.success) {
                const discountInfo = document.getElementById("discount-info");
                discountInfo.style.display = "block";
                const couponInfo = document.getElementById("couponInfo");

                // Lưu mã giảm giá vào danh sách đã áp dụng
                appliedCoupons.push(couponCode);

                // Cộng dồn giá trị giảm giá vào tổng giảm giá
                totalDiscount += parseFloat(data.coupon.discount_amount);

                // Hiển thị thông tin giảm giá
                discountInfo.innerHTML += `
                    <div class="alert-info position-relative">
                        <p class="end position-absolute top-0 end-0 m-0" style="right: 10px; color: #b7062ef2;">Đang áp dụng</p>
                        <p><strong>Mã giảm giá:</strong> ${data.coupon.code}</p>
                        <p><strong>Giá trị giảm giá:</strong> ${formatCurrency2(data.coupon.discount_value)} ${data.coupon.discount_type === 'percentage' ? '%' : 'đ'}</p>
                        <p><strong>Số tiền được giảm:</strong> ${formatCurrency(data.coupon.discount_amount)}</p>
                    </div>`;

                const newRow = `
                    <tr>
                        <td style="padding-left: 5px;">
                            <h5 style="font-weight: 100; font-size: 11px; padding-left: 20px;margin: 0px;">${data.coupon.code}</h5>
                        </td>
                        <td class="price-col price-coupone">${formatCurrency(data.coupon.discount_amount)}</td>
                    </tr>
                    <input type="hidden" name="coupons[${data.coupon.code}][code]" value="${data.coupon.code}"/>
                    <input type="hidden" name="coupons[${data.coupon.code}][discount_amount]" value="${data.coupon.discount_amount}"/>
                `;
                couponInfo.insertAdjacentHTML('beforebegin', newRow);

                document.querySelector("#messageapplyCoupone .modal-body").innerHTML = `<p>${data.message}</p>`;

                // Tính tổng mới sau khi áp dụng voucher
                const subtotal = parseFloat('{{ $subTotal }}');
                const shippingCost = parseFloat(document.querySelector('input.shipp-fe:checked').value);

                let newTotal = subtotal + shippingCost - totalDiscount;
                if (newTotal < 0) {
                    newTotal = 0;
                }

                document.getElementById("totalPriceDisplay").innerText = formatCurrency(newTotal);

            } else {
                document.querySelector("#messageapplyCoupone .modal-body").innerHTML =
                    `<p style="color: red;">${data.message}</p>`;
            }
        })
        .catch(error => {
            document.getElementById("coupon_code").value = "";
            document.querySelector("#messageapplyCoupone .modal-body").innerHTML =
                `<p style="color: red;">Đã có lỗi khi thêm mã giảm giá</p>`;
        });
}



        // Gọi hàm updateShipping() khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            updateShipping();
        });

        // Sự kiện thay đổi phí vận chuyển
        document.querySelectorAll('input[name="radio-ship"]').forEach(radio => {
            radio.addEventListener('change', updateShipping);
        });

        // Nút cập nhật địa chỉ
        document.querySelectorAll('.edit-address-link').forEach(link => {
            link.addEventListener('click', function(event) {
                const addressData = event.target.dataset; // Lấy thông tin địa chỉ từ thuộc tính dữ liệu

                // Cập nhật thông tin vào form
                document.getElementById('updateName').value = addressData.name;
                document.getElementById('updatePhone').value = addressData.phone;
                document.getElementById('updateAddress').value = addressData.specificAddress;

                // Cập nhật ID địa chỉ
                document.getElementById('id_address').value = addressData.id;

                // Hiển thị modal cập nhật
                $('#editAddressModal').modal('hide'); // Ẩn modal cũ
                $('#updateAddressModal').modal('show'); // Hiện modal cập nhật
            });
        });

        document.getElementById('btnBackToEdit').addEventListener('click', function() {
            $('#updateAddressModal').modal('hide'); // Ẩn modal cập nhật
            $('#editAddressModal').modal('show'); // Hiện lại modal cũ
        });



        // Modal thêm mới địa chỉ
        document.addEventListener("DOMContentLoaded", function() {
            const btnAddAddress = document.getElementById('btnAddAddress');
            const addAddressForm = document.getElementById('new-address-form');
            const updateAddressForm = document.getElementById('update-address-form');
            const btnAdd = document.getElementById('btnAdd');
            const btnBack = document.getElementById('btnBack');
            const btnHuy = document.getElementById('btnHuy');

            // Nút thêm địa chỉ mới
            btnAddAddress.addEventListener('click', function() {
                $('#editAddressModal').modal('show');
                let isUpdating = false;
                const newCitySelect = document.querySelector("#newCity");
                const newDistrictSelect = document.querySelector("#newDistrict");
                const newWardSelect = document.querySelector("#newWard");
                const newAddressInput = document.querySelector("#newAddress");

                // Disable selects initially
                [newDistrictSelect, newWardSelect].forEach(select => {
                    select.disabled = true;
                });

                // Fetch and populate cities
                function getCities(selectElement, isSelected = '') {
                    if (isUpdating) return;
                    isUpdating = true;
                    fetch("https://provinces.open-api.vn/api/p/")
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch cities');
                            return response.json();
                        })
                        .then(data => {
                            selectElement.innerHTML = '<option value="">Tỉnh/Thành phố</option>';
                            data.forEach(city => {
                                const selected = city.name === isSelected ? ' selected' : '';
                                selectElement.innerHTML +=
                                    `<option value="${city.code}"${selected}>${city.name}</option>`;
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error))
                        .finally(() => {
                            isUpdating = false;
                        });
                }

                // Fetch districts based on selected city
                function getDistricts(cityCode, isSelected = '') {
                    if (isUpdating) return;
                    isUpdating = true;
                    fetch(`https://provinces.open-api.vn/api/p/${cityCode}?depth=2`)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch districts');
                            return response.json();
                        })
                        .then(data => {
                            newDistrictSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                            data.districts.forEach(district => {
                                const selected = district.name === isSelected ? ' selected' :
                                '';
                                newDistrictSelect.innerHTML +=
                                    `<option value="${district.code}"${selected}>${district.name}</option>`;
                            });
                            newDistrictSelect.disabled = false;
                            newWardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                            newWardSelect.disabled = true;
                        })
                        .catch(error => console.error('Error fetching districts:', error))
                        .finally(() => {
                            isUpdating = false;
                        });
                }

                // Fetch wards based on selected district
                function getWards(districtCode, isSelected = '') {
                    if (isUpdating) return;
                    isUpdating = true;
                    fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch wards');
                            return response.json();
                        })
                        .then(data => {
                            newWardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                            data.wards.forEach(ward => {
                                const selected = ward.name === isSelected ? ' selected' : '';
                                newWardSelect.innerHTML +=
                                    `<option value="${ward.code}"${selected}>${ward.name}</option>`;
                            });
                            newWardSelect.disabled = false;
                        })
                        .catch(error => console.error('Error fetching wards:', error))
                        .finally(() => {
                            isUpdating = false;
                        });
                }

                // Reset district and ward selects
                function resetDistrictAndWard() {
                    newDistrictSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                    newWardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                    newDistrictSelect.disabled = true;
                    newWardSelect.disabled = true;
                }

                // Update address input
                function updateAddressInput() {
                    const city = newCitySelect.options[newCitySelect.selectedIndex]?.text || '';
                    const district = newDistrictSelect.options[newDistrictSelect.selectedIndex]?.text || '';
                    const ward = newWardSelect.options[newWardSelect.selectedIndex]?.text || '';
                    newAddressInput.value = '';
                }

                // Event listener for city selection
                newCitySelect.addEventListener("change", function() {
                    const cityCode = this.value;
                    if (cityCode) {
                        resetDistrictAndWard();
                        getDistricts(cityCode);
                    } else {
                        resetDistrictAndWard();
                        updateAddressInput();
                    }
                });

                // Event listener for district selection
                newDistrictSelect.addEventListener("change", function() {
                    const districtCode = this.value;
                    if (districtCode) {
                        newWardSelect.innerHTML = '<option value="">Loading...</option>';
                        getWards(districtCode);
                    } else {
                        resetDistrictAndWard();
                        updateAddressInput();
                    }
                });

                // Event listener for ward selection
                newWardSelect.addEventListener("change", updateAddressInput);

                // Fetch cities on modal open
                getCities(newCitySelect);
            });


            // Nút trở lại
            btnBack.addEventListener('click', function() {
                // Ẩn form thêm và quay lại trang hiển thị địa chỉ
                addAddressForm.style.display = 'none';
                updateAddressForm.style.display = 'none';
                btnBack.style.display = 'none';
                btnHuy.style.display = 'inline-block';
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            // Elements for the update form
            const updateCitySelect = document.querySelector("#city");
            const updateDistrictSelect = document.querySelector("#district");
            const updateWardSelect = document.querySelector("#ward");
            const tam = '';

            // Disable district and ward selects initially
            [updateDistrictSelect, updateWardSelect].forEach(select => {
                select.disabled = true;
            });

            // Function to fetch and populate cities
            function getCities(selectElement, isSelected = '') {
                fetch("https://provinces.open-api.vn/api/p/")
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch cities');
                        return response.json();
                    })
                    .then(data => {
                        selectElement.innerHTML = '<option value="">Tỉnh/Thành phố</option>';
                        data.forEach(city => {
                            const selected = city.name === isSelected ? ' selected' : '';
                            selectElement.innerHTML +=
                                `<option value="${city.code}"${selected}>${city.name}</option>`;
                        });
                        selectElement.dispatchEvent(new Event('change'));
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }

            // Function to fetch districts based on selected city
            function getDistricts(cityCode, districtSelect, wardSelect, isSelected = '') {
                fetch(`https://provinces.open-api.vn/api/p/${cityCode}?depth=2`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch districts');
                        return response.json();
                    })
                    .then(data => {
                        districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                        data.districts.forEach(district => {
                            const selected = district.name === isSelected ? ' selected' : '';
                            districtSelect.innerHTML +=
                                `<option value="${district.code}"${selected}>${district.name}</option>`;
                        });
                        districtSelect.disabled = false;
                        let tam = updateDistrictSelect.value;
                        if (wardSelect !== '') {
                            updateWardSelect.disabled = false;
                            getWards(tam, updateWardSelect, wardSelect)
                        } else {
                            wardSelect.innerHTML = '<option value="">Phường/Xã</option>'; // Reset wards
                            updateWardSelect.disabled = false; // Disable until district is selected
                        }
                    })
                    .catch(error => console.error('Error fetching districts:', error));
            }

            // Function to fetch wards based on selected district
            function getWards(districtCode, updateWardSelect, isSelected) {

                fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch wards');
                        return response.json();
                    })
                    .then(data => {

                        updateWardSelect.innerHTML = '<option value="">Phường/Xã</option>'; // Reset options
                        data.wards.forEach(ward => {
                            const selected = ward.name === isSelected ? ' selected' :
                                ''; // Set selected
                            updateWardSelect.innerHTML +=
                                `<option value="${ward.code}"${selected}>${ward.name}</option>`;
                        });

                        // Enable dropdown after data is loaded
                        updateWardSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching wards:', error);
                        wardSelect.disabled = true; // Disable dropdown if error occurs
                    });
            }


            // Reset function for district and ward selects
            function resetDistrictAndWard(districtSelect, wardSelect) {
                districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                districtSelect.disabled = true;
                wardSelect.disabled = true;
            }

            // Reset form when modal is hidden
            $('#update-address-form').on('hidden.bs.modal', function() {
                resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
            });

            document.querySelectorAll('.edit-address-link').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const id_address = this.dataset.id;
                    const name = this.dataset.name;
                    const phone = this.dataset.phone;
                    const specificAddress = this.dataset.specificAddress;
                    const ward = this.dataset.ward;
                    const district = this.dataset.district;
                    const city = this.dataset.city;
                    document.getElementById('id_address').value = id_address
                    document.getElementById('updateName').value = name;
                    document.getElementById('updatePhone').value = phone;
                    document.getElementById('updateAddress').value = specificAddress;

                    getCities(updateCitySelect, city); // Update city select

                    const cityChangeHandler = function() {
                        const cityCode = this.value;
                        if (cityCode) {
                            getDistricts(cityCode, updateDistrictSelect, ward,
                                district);
                        } else {
                            resetDistrictAndWard(updateDistrictSelect, updateWardSelect);
                        }
                    };

                    const districtChangeHandler = function() {
                        const districtCode = this.value;
                        console.log('Selected district code:', districtCode);

                        if (districtCode) {
                            getWards(districtCode, updateWardSelect,
                                ward); // Fetch wards and set the selected ward
                        } else {
                            resetDistrictAndWard(updateWardSelect);
                        }
                    };

                    // Update event listeners
                    updateCitySelect.removeEventListener("change", cityChangeHandler);
                    updateCitySelect.addEventListener("change", cityChangeHandler);

                    updateDistrictSelect.removeEventListener("change", districtChangeHandler);
                    updateDistrictSelect.addEventListener("change", districtChangeHandler);

                    // Trigger fetching districts after city selection
                    updateCitySelect.dispatchEvent(new Event('change'));
                });
            });
        });




        document.addEventListener("DOMContentLoaded", function() {
            const addAddressForm = document.querySelector("#addAddressForm");
            const btnAdd = document.querySelector("#btnAdd");

            function getSelectedText(selectElement) {
                return selectElement.selectedOptions[0].textContent;
            }


            btnAdd.addEventListener("click", function(event) {
                event.preventDefault();

                const formData = new FormData(addAddressForm);
                const newName = document.getElementById("newName");
                const newPhone = document.getElementById("newPhone");
                const citySelect = document.querySelector("#newCity");
                const districtSelect = document.querySelector("#newDistrict");
                const wardSelect = document.querySelector("#newWard");
                const specific_address = document.querySelector("#newAddress");
                const displayAddress = document.querySelector("#displayAddress");
                if (citySelect && districtSelect && wardSelect) {
                    formData.append('city', getSelectedText(citySelect));
                    formData.append('district', getSelectedText(districtSelect));
                    formData.append('ward', getSelectedText(wardSelect));
                    formData.append('specific_address', specific_address.value);
                    formData.append('username', newName.value);
                    formData.append('phone_number', newPhone.value);
                }
                fetch('addresses', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        $('#addAddressModal').modal('hide');
                        document.querySelector("#applyToCoupon .modal-body").innerHTML = '';
                        if (data.message) {
                            document.querySelector("#applyToCoupon .modal-body").innerHTML =
                                `<p class='text-primary'>${data.message}</p>`
                            $('#applyToCoupon').modal('show');
                        }
                        location.reload();
                    })
                    .catch(error => {
                        $('#addAddressModal').modal('hide');
                        document.querySelector("#applyToCoupon .modal-body").innerHTML = '';
                        if (error) {
                            document.querySelector("#applyToCoupon .modal-body").innerHTML =
                                `<p style="color: red;">${error}</p>`
                            $('#applyToCoupon').modal('show');
                        }
                        location.reload();
                    });
            });
        });

        document.getElementById('btnConfirm').addEventListener('click', function() {
            const selectedCheckbox = document.querySelector('.address-checkbox:checked');

            if (selectedCheckbox) {
                const addressId = selectedCheckbox.value;

                fetch(`/addresses/set-default/${addressId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            addressId: addressId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll('.address-checkbox').forEach(cb => cb.checked = false);
                            selectedCheckbox.checked = true; // Keep the selected checkbox checked
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert('Có lỗi xảy ra khi cập nhật địa chỉ mặc định.');
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            } else {
                alert('Vui lòng chọn một địa chỉ để cập nhật.');
            }
        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // or from hidden input
                }
            });

            function getSelectedText(selectElement) {
                return selectElement.selectedOptions[0].textContent;
            }
            $('#btnConfirmUpdate').on('click', function(e) {

                e.preventDefault();
                let formData = {
                    id_address: $('#id_address').val(),
                    name: $('#updateName').val(),
                    phone: $('#updatePhone').val(),
                    city: getSelectedText(document.getElementById('city')),
                    district: getSelectedText(document.getElementById('district')),
                    ward: getSelectedText(document.getElementById('ward')),
                    address: $('#updateAddress').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '/update-address',
                    data: formData,
                    success: function(response) {
                        $('#addAddressModal').modal('hide');
                        document.querySelector("#applyToCoupon .modal-body").innerHTML = '';
                        if (response.success) {
                            document.querySelector("#applyToCoupon .modal-body").innerHTML =
                                `<p class='text-primary'>${response.success}</p>`
                            $('#applyToCoupon').modal('show');
                        }
                    },
                    error: function(xhr) {
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
