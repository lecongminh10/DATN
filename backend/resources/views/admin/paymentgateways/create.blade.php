@extends('admin.layouts.app')

@section('title')
    Thêm Mới Cổng Thanh Toán
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="p-4">
                    <h4 class="text-primary mb-4">Thêm mới cổng thanh toán</h4>
                    <form action="{{ route('admin.paymentgateways.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Tên</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên cổng" id="name " name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Khóa API</label>
                                    <input type="text" class="form-control" placeholder="Nhập khóa API" id="api_key " name="api_key" value="{{ old('api_key') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Khóa bí mật</label>
                                    <input type="text" class="form-control" placeholder="Nhập khóa bí mật" id="secret_key" name="secret_key" value="{{ old('secret_key') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="emailidInput" class="form-label">Loại cổng thanh toán</label>
                                    <input type="text" class="form-control" placeholder="Nhập loại cổng"  id="gateway_type" name="gateway_type" value="{{ old('gateway_type')}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-success me-2">Thêm mới</button>
                                    <a href="{{ route('admin.paymentgateways.index') }}" class="btn btn-primary">Quay lại</a>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
