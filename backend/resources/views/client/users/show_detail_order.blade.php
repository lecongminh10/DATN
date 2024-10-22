@extends('client.layouts.app')
@section('style_css')
<style>

</style>
@endsection
@section('content')
<main class="main home">
    <div class="container mb-2">
        <div class="row">
            <div class="col-lg-9">
                <div class="profile-content">
                    <div class="profile-header mb-4">
                        <h2>{{ $orders->code }}</h2>
                    </div>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <label for="code" class="fw-bold">Mã vận chuyển:</label>
                            <span id="code">{{ $orders->code }}</span>
                        </li>
                        <li class="list-group-item">
                            <label for="total_price" class="fw-bold">Tổng giá sản phẩm:</label>
                            <span id="total_price">{{ $orders->total_price }}</span>
                        </li>
                        <li class="list-group-item">
                            <label for="status" class="fw-bold">Trạng thái:</label>
                            <span id="status">{{ $orders->status }}</span>
                        </li>
                        <li class="list-group-item">
                            <label for="tracking_number" class="fw-bold">Mã theo dõi nhà vận chuyển:</label>
                            <span id="tracking_number">{{ $orders->tracking_number }}</span>
                        </li>
                        <li class="list-group-item">
                            <label for="note" class="fw-bold">Ghi chú:</label>
                            <span id="note">{{ $orders->note }}</span>
                        </li>
                        <li>
                            @if ($orders->status=='Chờ xác nhận')
                            <a href="" class="btn">Hủy đơn hàng</a>
                            @endif
                        </li>
                    </ul>
            
                    <div class="card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                                <div class="flex-shrink-0 mt-2 mt-sm-0">
                                    <a href="javascript:void(0);" class="btn btn-soft-info btn-sm mt-2 mt-sm-0"><i class="ri-map-pin-line align-middle me-1"></i> {{ $orders->status }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach ($locations as $item)
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="heading{{ $loop->index }}">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-0 fw-semibold"> <span class="fw-normal">{{ $item->address }}</span></h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body ms-2 ps-5 pt-0">
                                                    <h6 class="mb-1">Địa chỉ: {{ $item->address }}</h6>
                                                    <p class="text-muted">Thành phố: {{ $item->city }} | Quận/Huyện: {{ $item->district }} | Phường: {{ $item->ward }}</p>
                                                    <p class="text-muted">Vĩ độ: {{ $item->latitude }} | Kinh độ: {{ $item->longitude }}</p>
                                                    <p class="text-muted">Ngày tạo: {{ $item->created_at->format('D, d M Y - H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>            
            @include('client.users.left_menu')
        </div>
    </div>
</main>
@endsection
