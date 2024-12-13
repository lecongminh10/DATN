@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4" style="min-height: 800px;">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0 text-primary">Cập nhật cổng thanh toán</h4>
                        </div>
                    </div>
                    <form action="{{ route('admin.paymentgateways.update', $paymentGateway->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Tên</label>
                                    <input type="text" class="form-control" name="name" value="{{ $paymentGateway->name}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="phonenumberInput" class="form-label">Khóa API</label>
                                    <input type="text" class="form-control" value="{{ $paymentGateway->api_key}}" name="api_key">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Khóa bí mật </label>
                                    <input type="text" class="form-control" value="{{ $paymentGateway->secret_key}}" name="secret_key">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Loại cổng thanh toán</label>
                                    <input type="text" class="form-control" value="{{ $paymentGateway->gateway_type}}" name="gateway_type">
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Sửa</button>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.paymentgateways.index') }}" class="btn btn-info">Quay lại</a>
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
