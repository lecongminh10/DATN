
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Thông báo Thanh Toán </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('theme/assets/images/favicon.ico')}}">

    <!-- Layout config Js -->
    <script src="{{asset('theme/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('theme/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('theme/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('theme/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('theme/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <style>

    </style>
</head>

<body>
    <?php
     if($check){
        $vnp_TmnCode = env('VNP_TMN_CODE'); 
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $code= htmlspecialchars($_GET['vnp_TxnRef']);
     }
    ?>
    {{-- @php
        dd($order)
    @endphp --}}
    <div id="layout-wrapper">
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
            <div class="page-content">
                <div class="container-fluid">   
                    <div class="row justify-content-center">
                        <div class="col-xxl-7">
                            <div class="card" id="demo">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-header border-bottom-dashed p-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <img src="{{asset('theme/assets/images/logo-dark.png')}}" class="card-logo card-logo-dark" alt="logo dark" height="17">
                                                    <img src="{{asset('theme/assets/images/logo-light.png')}}" class="card-logo card-logo-light" alt="logo light" height="17">
                                                    <div class="mt-sm-5 mt-4">
                                                        <h6 class="text-muted text-uppercase fw-semibold">Địa chỉ : 
                                                             @if ($addressShop && $addressShop['address']!==null)
                                                            {{ $addressShop['address']}}
                                                           @else
                                                            Trường CĐ FPT
                                                           @endif</h6>
                                                        <p class="text-muted mb-1" id="address-details">Số điện thoại :
                                                            @if ($addressShop && $addressShop['phone']!==null)
                                                            {{ $addressShop['phone']}}
                                                            @else
                                                            0392853609
                                                            @endif  
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-header-->
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="card-body p-4">
                                            <div class="row g-3">
                                                <div class="col-lg-3 col-6">
                                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Mã hóa đơn </p>
                                                    <h5 class="fs-14 mb-0"><span id="invoice-no">{{isset($code)? $code :$order->code}}</span></h5>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3 col-6">
                                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Thời gian </p>
                                                @php
                                                    $createdDate = \Carbon\Carbon::parse($order->created_at);
                                                @endphp 
                                                <h5 class="fs-14 mb-0">
                                                    <span id="invoice-date">{{ $createdDate->format('d M, Y') }}</span> 
                                                    <small class="text-muted" id="invoice-time">{{ $createdDate->format('h:i A') }}</small>
                                                </h5>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3 col-6">
                                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Trạng thái thanh toán</p>
                                                    @php
                                                        if($order->payment !==null){
                                                            $status =$order->payment->status;
                                                            if($status=='failed'){
                                                                $status='Đã hủy';
                                                                $style="bg-danger-subtle text-danger";
                                                            }
                                                            if( $status=='completed'){
                                                                $status='Thanh toán thành công';
                                                                $style="bg-success-subtle text-success";
                                                            }
                                                         }else{
                                                            $status='Đã hủy khi thanh toán ';
                                                            $style="bg-success-subtle text-success";
                                                        }
                                                    @endphp
                                                    <span class="badge {{$style}} fs-11" id="payment-status">{{ $status}}</span>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3 col-6">
                                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Tổng thanh toán </p>
                                                    <h5 class="fs-14 mb-0"><span id="total-amount">{{ number_format($order->total_price, 0, ',', '.') }} đ</span></h5>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-body-->
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="card-body p-4 border-top border-top-dashed">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ giao hàng </h6>
                                                    <p class="fw-medium mb-2" id="billing-name">
                                                        @if ($addressShop && $addressShop['name']!==null)
                                                            {{ $addressShop['name']}}
                                                        @else
                                                        {{ config('app.name') }}
                                                        @endif
                                                    </p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1">
                                                        @if ($addressShop && $addressShop['address']!==null)
                                                         {{ $addressShop['address']}}
                                                        @else
                                                         Trường CĐ FPT
                                                        @endif
                                                    </p>
                                                    <p class="text-muted mb-1"><span>Sđt: +</span><span id="billing-phone-no">
                                                        @if ($addressShop && $addressShop['phone']!==null)
                                                          {{ $addressShop['phone']}}
                                                        @else
                                                        0392853609
                                                        @endif    
                                                    </span></p>
                                                </div>
                                                <!--end col-->
                                                <div class="col-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ nhận hàng</h6>
                                                    <p class="fw-medium mb-2" id="shipping-name">{{Auth::user()->username}}</p>

                                                    <p class="text-muted mb-1" id="shipping-address-line-1">{{$address->specific_address}},{{$address->ward}},{{$address->district}},{{$address->city}}</p>
                                                    <p class="text-muted mb-1"><span>Sđt: +</span><span id="shipping-phone-no">{{Auth::user()->phone_number}}</span></p>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-body-->
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="card-body p-4">
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                                    <thead>
                                                        <tr class="table-active">
                                                            <th scope="col" style="width: 50px;">#</th>
                                                            <th scope="col">Sản phẩm</th>
                                                            <th scope="col">Ảnh</th>
                                                            <th scope="col">Giá</th>
                                                            <th scope="col">Số lượng</th>
                                                            <th scope="col" class="text-end">Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="products-list">
                                                        @foreach ($order->items as $key => $value)
                                                        <tr>
                                                            <th scope="row">{{ $key + 1 }}</th>
                                                            <td class="text-start">
                                                                <span class="fw-medium">{{ $value->product->name }}</span>
                                                                @php
                                                                    $variant = $value->productVariant;
                                                                @endphp
                                                                @if ($variant) <!-- Check if $variant is not null -->
                                                                    @php
                                                                        $attributes = $variant->attributeValues;
                                                                    @endphp
                                                                    @if ($attributes->isNotEmpty())
                                                                        @foreach ($attributes as $attribute)
                                                                            <p class="text-muted mb-0 " style="font-size: 12px; padding-left: 10px;">
                                                                                {{ $attribute->attribute->attribute_name }}: {{ $attribute->attribute_value }} @if (!$loop->last), @endif
                                                                            </p>
                                                                        @endforeach
                                                                    @else
                                                                        <p class="text-muted mb-0">No attributes available</p>
                                                                    @endif
                                                                @else
                                                                    <p class="text-muted mb-0">No variant available</p> <!-- Message for no variant -->
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $img="";
                                                                    $variant = $value->productVariant;
                                                                    if(!empty($variant)){
                                                                        $img = $value->productVariant->variant_image;
                                                                    }else{
                                                                        $img = $value->product->getMainImage->image_gallery;
                                                                    }
                                                                @endphp
                                                            <img src="{{Storage::url( $img)}}" alt="" style="max-height: 100px; max-width: 100px;">
                                                            </td>                                                         
                                                            @if ($variant)
                                                                @php
                                                                    // Determine the price based on variant price modifier or original price
                                                                    $price = !empty($variant->price_modifier) ? $variant->price_modifier : $variant->original_price;
                                                                @endphp
                                                            <td>{{ number_format($price, 0, ',', '.') }} đ</td>
                                                            @else
                                                                @php
                                                                    // Fallback to product prices if no variant is found
                                                                    $price = !empty($value->product->price_sale) ? $value->product->price_sale : $value->product->price_regular;
                                                                @endphp
                                                                <td>{{ number_format($price, 0, ',', '.') }} đ</td>
                                                            @endif
                                                            <td>{{ $value->quantity }}</td>
                                                            <td class="text-end price">{{ number_format($price * $value->quantity,  0, ',', '.') }} đ</td>
                                                        </tr>    
                                                        @endforeach
                                                    </tbody>
                                                </table><!--end table-->                                                
                                            </div>
                                            <div class="border-top border-top-dashed mt-2">
                                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                    <tbody>
                                                        <tr>
                                                            <td>Tổng giá gốc</td>
                                                            <td class="text-end total-price" ></td>
                                                        </tr>
                                                        @php
                                                            $price = 0;
                                                            if(count($couponUsage)>0){
                                                                foreach ($couponUsage as $key => $value) {
                                                                 {
                                                                    $price += $value->usage_discount_value;
                                                                 }
                                                                }
                                                            }
                                                        @endphp
                                                         <tr>
                                                              <td>Voucher</td>
                                                               <td class="text-end">-{{ number_format($price,  0, ',', '.') }} đ</td>
                                                        </tr>
                                                        @if (count($couponUsage)>0)
                                                            @foreach ($couponUsage as $item)
                                                            <tr>
                                                                <td style="font-size: 11px; padding-left: 30px; font-weight: 100;">{{$item->coupon_code}}</td>
                                                                <td class="text-end">{{ number_format($item->usage_discount_value,  0, ',', '.') }} đ</td>
                                                            </tr>
                                                            @endforeach
                                                        @endif
                                                        <tr>
                                                            <td>Phí vận chuyển </td>
                                                            <td class="text-end">+{{ number_format($order->shippingMethod->shipping_fee,  0, ',', '.') }} đ</td>
                                                        </tr>
                                                        <tr class="border-top border-top-dashed fs-15">
                                                            <th scope="row">Tổng giá </th>
                                                            <th class="text-end">{{ number_format($order->total_price,  0, ',', '.') }} đ</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end table-->
                                            </div>
                                            <div class="mt-3">
                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Phương thức thanh toán :</h6>
                                                @php
                                                    if($order->payment !==null){
                                                        $payment=$order->payment->paymentGateway->name;
                                                    }else{
                                                        $payment='Đã hủy ';
                                                    }
                                                @endphp
                                                <p class="text-muted mb-1">Loại thanh toán : <span class="fw-medium" id="payment-method">{{$payment}}</span></p>
                                                <p class="text-muted mb-1">Ngân hàng : <span class="fw-medium" id="card-holder-name">{{$responseData['bank_code']}}</span></p>
                                                <p class="text-muted mb-1">Loại : <span class="fw-medium" id="card-number">{{$responseData['vnp_CardType']}}</span></p>
                                                <p class="text-muted">Giá : <span class="fw-medium" id=""></span><span id="card-total-amount">{{ number_format($order->total_price,  0, ',', '.') }} đ</span></p>
                                            </div>
                                            <div class="mt-4">
                                                <div class="alert alert-info">
                                                    <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                        <span id="note">{{$order->note}}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                {{-- <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a> --}}
                                                <a href="/" class="btn btn-primary">back</a>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div><!-- container-fluid -->
            </div><!-- End Page-content -->
    </div>
    <!-- END layout-wrapper -->


    <!-- JAVASCRIPT -->
    <script src="{{asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('theme/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('theme/assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('theme/assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('theme/assets/js/plugins.js')}}"></script>

    <script src="{{asset('theme/assets/js/pages/invoicedetails.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('theme/assets/js/app.js')}}"></script>
    <script>
        const prices = document.querySelectorAll('.price');

        let total = 0;

        // Loop through each element and sum up the values
        prices.forEach(priceElement => {
            // Get the text content (e.g., "157.795 đ")
            let priceText = priceElement.textContent.trim();
            console.log(`Giá: ${priceText}`);

            // Remove the currency symbol (e.g., "đ") and change "." (thousands separator) to ""
            // Change "," (decimal separator) to "." for numeric conversion if needed
            let numericValue = parseFloat(priceText
                .replace(/[^\d,.-]/g, '') // Remove any characters that are not digits, commas, dots, or negative signs
                .replace(/\./g, '') // Remove thousands separator
                .replace(',', '.')); // Replace decimal separator with a dot

            console.log(`Numeric Giá: ${numericValue}`);
            
            // Add the value to the total (only if it's a valid number)
            if (!isNaN(numericValue)) {
                total += numericValue;
            }
        });

        function numberFormat(value, decimals = 0, decPoint = ',', thousandsSep = '.') {
            const parts = value.toFixed(decimals).split('.'); // Ensure fixed decimal places
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep); // Format thousands
            return parts[0]; // Return only the integer part
        }

        document.querySelector('.total-price').innerHTML=numberFormat(total, 2) +'đ'


    </script>

</body>

</html>