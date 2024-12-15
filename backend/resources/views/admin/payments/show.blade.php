@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0 text-primary">Chi tiết thanh toán</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="firstNameinput" class="form-label">Order_id</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $payments->order_id}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="lastNameinput" class="form-label">Cổng thanh toán</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $payments->paymentGateway->name}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="phonenumberInput" class="form-label">Số lượng</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $payments->amount}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="address1ControlTextarea" class="form-label">Trạng thái</label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $payments->status}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="emailidInput" class="form-label">Transaction_id </label>
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $payments->transaction_id }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-end">
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-info">Danh sách thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
