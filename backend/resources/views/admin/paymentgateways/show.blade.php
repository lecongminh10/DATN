@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4" style="min-height: 800px;">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0 text-primary">Chi tiết cổng thanh toán</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="firstNameinput" class="form-label">Tên</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $paymentGateway->name}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="phonenumberInput" class="form-label">Khóa API</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $paymentGateway->api_key}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="address1ControlTextarea" class="form-label">Khóa bí mật</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $paymentGateway->secret_key}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="emailidInput" class="form-label">Loại cổng thanh toán</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $paymentGateway->gateway_type }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-end">
                            <a href="{{ route('admin.paymentgateways.index') }}" class="btn btn-info">Danh sách thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
