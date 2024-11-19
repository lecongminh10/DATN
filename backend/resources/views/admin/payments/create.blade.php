@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4" style="min-height: 800px;">
                    <h4 class="text-primary mb-4">Thêm mới thanh toán</h4>
                    <form action="{{ route('admin.payments.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Order_id</label>
                                    <input type="text" class="form-control" placeholder="Nhập id đơn hàng" id="order_id " name="order_id" value="{{ old('order_id ') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="paymentGatewaySelect" class="form-label">Cổng Thanh Toán</label>
                                    <select class="form-select" id="paymentGatewaySelect" name="payment_gateway_id">
                                        <option value="">Chọn cổng thanh toán</option>
                                        @foreach($paymentGateways as $gateway)
                                            <option value="{{ $gateway->id }}" {{ old('payment_gateway_id') == $gateway->id ? 'selected' : '' }}>
                                                {{ $gateway->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Số lượng</label>
                                    <input type="text" class="form-control" placeholder="Nhập số lượng" id="amount" name="amount" value="{{ old('amount') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="emailidInput" class="form-label">Transaction_id </label>
                                    <input type="text" class="form-control" placeholder="Nhập id giao dịch"  id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Đang giải quết</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                                        <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
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
