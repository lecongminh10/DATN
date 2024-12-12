@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'THanh toán ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thanh toán', 'url' => '#'],
                ],
            ])
            <div class="card">
                <div class="p-4" style="min-height: 800px;">
                    <h4 class="text-primary mb-4">Thêm mới thanh toán</h4>
                    <form action="{{ route('admin.paymentgateways.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Tên<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="firstNameinput" name="name" placeholder="Nhập tên phương thức thanh toán"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Khóa API</label>
                                    <input type="text" class="form-control" placeholder="Nhập khóa API" id="api_key "
                                        name="api_key" value="{{ old('api_key') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Khóa bí mật</label>
                                    <input type="text" class="form-control" placeholder="Nhập khóa bí mật"
                                        id="secret_key" name="secret_key" value="{{ old('secret_key') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="emailidInput" class="form-label">Loại cổng thanh toán<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('gateway_type') is-invalid @enderror"
                                        placeholder="Nhập loại cổng" id="gateway_type" name="gateway_type"
                                        value="{{ old('gateway_type') }}">
                                    @error('gateway_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
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
