<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đơn hàng của bạn đã hoàn thành</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .invoice-container {
            max-width: 700px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 28px;
            color: #0066cc;
            font-weight: bold;
        }

        .invoice-header p {
            margin: 10px 0 0;
            font-size: 14px;
            color: #555;
        }

        /* .order-info {
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .order-info p {
            font-size: 16px;
            margin: 8px 0;
            color: #4a5568;
        } */

        ul {
            list-style: none;
            padding: 0;
            margin: 25px 0;
        }

        ul li {
            background: #edf2f7;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            color: #2d3748;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        ul li strong {
            margin-right: 15px;
        }

        .highlight {
            font-weight: bold;
            color: #3182ce;
        }

        .order-details {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .order-details th, .order-details td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .order-details th {
            background-color: #f0f8ff;
            color: #2d3748;
            font-weight: bold;
            text-align: center;
        }

        .order-details td {
            background-color: #ffffff;
            color: #333;
        }

        td {
            font-weight: normal; /* Chữ mỏng đều */
            line-height: 1.5; /* Đảm bảo khoảng cách dòng đồng đều */
        }

        td .text {
            color: #6c757d; /* Màu chữ nhạt cho dòng "Loại:" */
            font-size: 14px; /* Điều chỉnh kích thước nhỏ hơn */
            margin: 5px 0; /* Khoảng cách trên dưới */
        }

        td .product-details {   
            margin-top: 10px;
        }

        td .attribute-list {
            padding: 0; 
            margin: 0; /* Loại bỏ khoảng cách mặc định */
        }

        td .attribute-item {
            margin: 8px 0; /* Đặt khoảng cách trên dưới cho từng mục */
            font-size: 12px; /* Kích thước chữ nhỏ hơn cho các thuộc tính */
        }

        td .attribute-item strong {
            font-weight: bold; /* In đậm tên thuộc tính */
        }

        td .attribute-item span {
            font-weight: normal;
            color: #333; /* Màu chữ dễ nhìn */
        }

        .product-details {
            font-size: 14px; /* Giảm kích thước chữ */
            color: #333; /* Đặt màu chữ dễ nhìn */
        }

        .attribute-list {
            padding: 0;
            margin: 0;
        }

        .attribute-item {
            font-size: 12px; /* Giảm kích thước chữ cho từng thuộc tính */
            margin: 5px 0; /* Đặt khoảng cách trên dưới đồng đều */
        }

        /* .attribute-item strong {
            font-weight: bold; In đậm tên thuộc tính
        } */

        .attribute-item span {
            font-weight: normal; /* Chữ mỏng cho giá trị thuộc tính */
            color: #555; /* Màu chữ nhạt hơn */
        }


        .order-details img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .order-summary {
            margin-top: 20px;
            margin-left: 460px;
            font-size: 16px;
            color: #4a5568;
        }

        .order-summary p {
            margin: 5px 0;  
            font-weight: bold;
            display: flex;
            justify-content: space-between; /* Căn lề giữa tên mục và giá trị */
            width: 100%; /* Đảm bảo độ rộng của mỗi dòng đủ để hiển thị */
        }

        .order-summary span {
            font-weight: bold;
            /* min-width: 120px; Thiết lập chiều rộng tối thiểu cho span để giá trị không bị lệch */
            text-align: right; /* Căn giá trị về bên phải */
        }
        
        .subTotal{
            margin-left:20px;
        }

        .ship{
            margin-left:72px;
        }

        .discount{
            margin-left:58px;
        }

        .total{
            margin-left:54px;
        }

        .address-info {
            margin-top: 25px;
            padding: 15px;
            color: #4a5568;
            border-radius: 10px;
            border: 1px solid  #0066cc;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .address-info p {
            font-size: 14px;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Cảm ơn bạn đã mua hàng!</h1>
            <p>Chi tiết hóa đơn của bạn</p>
        </div>

        <ul>
            <li><strong>Mã đơn hàng:</strong> <span class="highlight">{{ $order->code }}</span></li>
            <li><strong>Khách hàng:</strong> <span class="highlight">{{ $order->user->username }}</span></li>
            <li><strong>Số điện thoại:</strong> <span class="highlight">{{ $order->user->phone_number }}</span></li>
        </ul>

        <table class="order-details">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $key => $item)
                <tr>
                    <td style="text-align: center;">
                        <img src="{{ $message->embed($images[$key]) }}" alt="{{ $item->product->name }}">
                    </td>
                    <td>{{ $item->product->name }}
                        <div class="text">Loại: </div>
                        @if ($item->productVariant)
                            <div class="product-details">
                                <div class="attribute-list">
                                    @if ($item->productVariant->attributeValues)
                                        @foreach ($item->productVariant->attributeValues as $attributeValue)
                                            <p class="attribute-item">
                                                <span>{{ $attributeValue->attribute->attribute_name }}:</span>
                                                <strong>{{ $attributeValue->attribute_value }}</strong>
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </td>
                    <td style="text-align: end;">
                        @if ($item->productVariant)
                            @if (!empty($item->productVariant->price_modifier))
                                @php $price = $item->productVariant->price_modifier; @endphp
                                {{ number_format($price, 0, ',', '.') }} ₫
                            @else
                                @php $price = $item->productVariant->original_price; @endphp
                                {{ number_format($price, 0, ',', '.') }} ₫
                            @endif
                        @else
                            @if (!empty($item->product->price_sale))
                                @php $price = $item->product->price_sale; @endphp
                                {{ number_format($price, 0, ',', '.') }} ₫
                            @else
                                @php $price = $item->product->price_regular; @endphp
                                {{ number_format($price, 0, ',', '.') }} ₫
                            @endif
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: end;">{{ number_format($price * $item->quantity, 0, ',', '.') }} ₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-summary">
            <p>Tổng tiền hàng: 
                <span class="subTotal">
                    {{ number_format(
                        $order->items->sum(function($item) {
                            $itemPrice = $item->productVariant 
                                ? ($item->productVariant->price_modifier ?? $item->productVariant->original_price) 
                                : ($item->product->price_sale ?? $item->product->price_regular);
                            return $itemPrice * $item->quantity;
                        }), 
                    0, ',', '.') }} ₫
                </span>
            </p>
            <p>Phí ship: <span class="ship">{{ number_format($shippingFee, 0, ',', '.') }} ₫</span></p>
            @if ($discount > 0)
                <p>Giảm giá: <span class="discount">- {{ number_format($discount, 0, ',', '.') }} ₫</span></p>
            @endif
            <p>Tổng cộng: <span class="total">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span></p>
        </div>

        <div class="address-info">
            <p><strong>Địa chỉ giao hàng:</strong></p>
            <p>{{ $order->locations->first()->address }}, {{ $order->locations->first()->district }}, {{ $order->locations->first()->city }}</p>
        </div>

        <p class="footer">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi! Chúc bạn một ngày tốt lành.</p>
    </div>
</body>
</html>