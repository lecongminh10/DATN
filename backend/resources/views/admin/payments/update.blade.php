@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4" style="min-height: 800px;">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0 text-primary">Cập nhật người dùng</h4>
                        </div>
                    </div>
                    <form action="{{ route('admin.payments.update', $payments->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Order_id</label>
                                    <input type="text" class="form-control" name="order_id" value="{{ $payments->order_id}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="paymentGatewaySelect" class="form-label">Cổng Thanh Toán</label>
                                    <select class="form-select" id="paymentGatewaySelect" name="payment_gateway_id">
                                        <option value="">Chọn cổng thanh toán</option>
                                        @foreach($paymentGateways as $gateway)
                                            <option value="{{ $gateway->id }}" {{ $payments->payment_gateway_id == $gateway->id ? 'selected' : '' }}>
                                                {{ $gateway->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="phonenumberInput" class="form-label">Số lượng</label>
                                    <input type="text" class="form-control" value="{{ $payments->amount}}" name="amount">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Transaction_id </label>
                                    <input type="text" class="form-control" value="{{ $payments->transaction_id}}" name="transaction_id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <option value="pending" {{ $payments->status == 'pending' ? 'selected' : '' }}>Đang thực hiện</option>
                                        <option value="completed" {{ $payments->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="failed" {{ $payments->status == 'failed' ? 'selected' : '' }}>Thất bại</option>
                                        <option value="refunded" {{ $payments->status == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Sửa</button>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.payments.index') }}" class="btn btn-info">Danh sách thanh toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
