@extends('admin.layouts.app')

@section('title')
    Cập Nhật Cổng Thanh Toán
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0 text-primary">Cập nhật cổng thanh toán</h4>
                        </div>
                    </div>
                    <form action="{{ route('admin.paymentgateways.update', $paymentGateway->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Tên<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $paymentGateway->name) }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="phonenumberInput" class="form-label">Khóa API</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('api_key', $paymentGateway->api_key) }}" name="api_key">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Khóa bí mật </label>
                                    <input type="text" class="form-control"
                                        value="{{ old('secret_key', $paymentGateway->secret_key) }}" name="secret_key">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Loại cổng thanh toán<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        value="{{ old('gateway_type', $paymentGateway->gateway_type) }}"
                                        name="gateway_type">
                                    @if ($errors->has('gateway_type'))
                                        <span class="text-danger">{{ $errors->first('gateway_type') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Sửa</button>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.paymentgateways.index') }}" class="btn btn-info">Quay
                                            lại</a>
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
