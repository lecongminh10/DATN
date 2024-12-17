@extends('admin.layouts.app')

@section('title')
    Chi Tiết Đơn Hàng: {{ $data->code }}
@endsection
@section('libray_css')

@endsection


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Đơn hàng</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí</a></li>
                            <li class="breadcrumb-item active">Đơn hàng</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Order {{ $data->code }}</h5>
                            {{-- <div class="flex-shrink-0">
                                <a href="apps-invoices-details.html" class="btn btn-success btn-sm me-2"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                            </div> --}}
                            <div class="flex-shrink-0">
                                <a href="{{ route('admin.orders.listOrder') }}" class="btn btn-primary "> Quay lại</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle table-borderless mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">Chi tiết sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col"></th>
                                        <th scope="col" class="text-center">Số lượng</th>
                                        {{-- <th scope="col">Đánh giá</th> --}}
                                        <th scope="col" class="text-end">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandTotal = 0;
                                    @endphp
                                    @foreach ($orderItems as $value)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    @php
                                                        if ($value->productVariant && !empty($value->productVariant->variant_image)) {
                                                            $url = $value->productVariant->variant_image; 
                                                        } else {
                                                            $mainImage = $value->product->getMainImage(); 
                                                            $url = $mainImage ? $mainImage->image_gallery : 'default-image-path.jpg';
                                                        }
                                                    @endphp
                                                <img src="{{ Storage::url($url) }}" class="img-fluid d-block" alt="{{ $value->product->name }}">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15"><a href="#" class="link-primary">{{ $value->product->name }}</a></h5>
                                                    <div class="text">Loại: </div>
                                                    @if ($value->productVariant)
                                                        <div class="product-details  mt-2" style="font-size: 10px;">
                                                            <div class="attribute-list">
                                                                @if ($value->productVariant->attributeValues)
                                                                    @foreach ($value->productVariant->attributeValues as $attributeValue)
                                                                        <p class="attribute-value">
                                                                            <span>{{ $attributeValue->attribute->attribute_name }}:</span>
                                                                            <strong>{{ $attributeValue->attribute_value }}</strong>
                                                                        </p>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($value->productVariant)
                                                {{ number_format($value->productVariant->price_modifier, 0, ',', '.') }} ₫
                                            @else
                                                {{ number_format($value->product->price_sale ?? $value->product->price_regular, 0, ',', '.') }} ₫
                                            @endif
                                        </td>
                                        <td></td>
                                        <td class="text-center">{{ $value->quantity }}</td>
                                        <td class="fw-medium text-end">
                                            @php
                                                // Lấy giá cơ bản của sản phẩm
                                                $basePrice = $value->product->price_sale ?? $value->product->price_regular;

                                                // Tính giá sản phẩm
                                                $itemPrice = $value->productVariant 
                                                    ? $value->productVariant->price_modifier * $value->quantity 
                                                    : $basePrice * $value->quantity;

                                                // Cộng vào tổng giá trị đơn hàng
                                                $grandTotal += $itemPrice;
                                            @endphp
                                            {{ number_format($itemPrice, 0, ',', '.') }} ₫
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="border-top border-top-dashed">
                                        <td colspan="4"></td>
                                        <td colspan="2" class="fw-medium p-0">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Tổng phụ:</td>
                                                        <td class="text-end">{{ number_format($grandTotal, 0, ',', '.') }} ₫</td>
                                                    </tr>
                                                    @if ($discount > 0)
                                                        <tr>
                                                            <td>Giảm giá <span class="text-muted">()</span>:</td>
                                                            <td class="text-end">-{{ number_format($discount, 0, ',', '.') }} ₫</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Phí ship:</td>
                                                        <td class="text-end">{{ number_format($shippingFee, 0, ',', '.') }} ₫</td>
                                                    </tr>
                                                    @php
                                                        $totalPrice = $grandTotal - $discount + $shippingFee
                                                    @endphp
                                                    <tr class="border-top border-top-dashed">
                                                        <th scope="row">Tổng:</th>
                                                        <th class="text-end">{{ number_format($totalPrice, 0, ',', '.') }} ₫</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>Địa chỉ giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14">{{ $user->username }}</li>
                            <li>{{ $user->phone_number }}</li>
                            <li>{{ $address->specific_address }}</li>
                            <li>{{ $address->ward }} - {{ $address->district }}</li>
                            <li>{{ $address->city }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>Chi tiết thanh toán</h5>
                    </div>
                    <div class="card-body">
                        @if ($payment)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Giao dịch:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">
                                        {{ substr($payment->transaction_id, 0, 20) }}...
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Phương thức thanh toán:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    @php
                                        if($paymentGateway->name == 'Cash'){
                                            $paymentGateway = 'Thanh toán sau khi nhận hàng ';
                                        }else{
                                            $paymentGateway = 'Thanh toán online VNPay';
                                        }
                                    @endphp
                                        <h6 class="mb-0">{{ $paymentGateway }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Trạng thái thanh toán:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    @php
                                        if($payment->status=='completed'){
                                            $payementStatus = 'Đã thanh toán';
                                        }
                                        if($payment->status=='pending')
                                        {
                                            $payementStatus = 'Chưa thanh toán';
                                        }
                                        if($payment->status=='failed')
                                        {
                                            $payementStatus = 'Đã hủy thanh toán';
                                        }
                                        if($payment->status=='refunded')
                                        {
                                            $payementStatus = 'Đã hoàn trả';
                                        }
                                    @endphp
                                    <h6 class="mb-0">{{$payementStatus}}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Tổng số tiền:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ number_format($payment->amount, 0, ',', '.') }} ₫</h6>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> Trạng thái</h5>
                            <div class="flex-shrink-0">
                                <a href="javascript:void(0);" class="badge bg-primary text-light fs-11" >{{ $data->status}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:80px;height:80px"></lord-icon>
                            {{-- <h5 class="fs-16 mt-2">RQK Logistics</h5> --}}
                            <p class="text-muted mb-0">Order: {{ $data->code }}</p>
                            <p class="text-muted mb-0">Phương thức thanh toán : {{ $payment->paymentGateway->name }}</p>
                        </div>
                    </div>
                </div>
                <!--end card-->

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">Khách hàng</h5>
                            <div class="flex-shrink-0">
                                <a href="#" class="link-secondary">Xem hồ sơ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        {{-- @if ()
                                            <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}" alt="" class="avatar-sm rounded">
                                        @else
                                        @endif => logic hiển ảnh --}}
                                        <img src="https://media.istockphoto.com/id/1337144146/vector/default-avatar-profile-icon-vector.jpg?s=612x612&w=0&k=20&c=BIbFwuv7FxTWvh5S3vB6bkT0Qv8Vn8N5Ffseq84ClGI=" class="avatar-sm rounded">

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1"></h6>
                                        <p class="text-muted mb-0">{{ $user->username }}</p>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $user->email }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $user->phone_number }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Địa chỉ cửa hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14">ZonMart</li>
                            <li>09864736527</li>
                            <li>13 P. Trịnh Văn Bô</li>
                            <li>Trường Cao đẳng FPT Polytechnic</li>
                            <li>Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
                
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div><!-- container-fluid -->
</div><!-- End Page-content -->

@endsection

@section('script_libray')
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('scripte_logic')
   <script>
     document.addEventListener('DOMContentLoaded', function() {
        const ratings = document.querySelectorAll('.rating');

        ratings.forEach(rating => {
            const value = parseFloat(rating.getAttribute('data-rating'));
            const maxStars = 5;
            let starsHtml = '';

            for (let i = 1; i <= maxStars; i++) {
                if (i <= value) {
                    starsHtml += '<i class="ri-star-fill" style="color: #ffc107;"></i>';
                } else if (i - value < 1) {
                    starsHtml += '<i class="ri-star-half-fill" style="color: #ffc107;"></i>';
                } else {
                    starsHtml += '<i class="ri-star-line" style="color: #ffc107;"></i>';
                }
            }

            rating.innerHTML = starsHtml;
        });
    });
   </script>
@endsection
