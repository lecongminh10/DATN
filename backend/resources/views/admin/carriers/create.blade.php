@extends('admin.layouts.app')

@section('title')
    Thêm Mới Đơn Vị Vận Cuyển
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Vận chuyển ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Vận chuyển', 'url' => '#']
                ]
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Thêm đơn vị vận chuyển </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="create-carrier-form" method="POST" action="{{ route('admin.carriers.store') }}" >
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-name-input">Tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="carrier-name-input"
                                                name="name" placeholder="Nhập tên nhà vận chuyển" >
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-code-input">Mã vận chuyển <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="carrier-code-input"
                                                name="code" placeholder="Nhập tên nhà vận chuyển" >
                                            @error('code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-api-url-input">URL API <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('api_url') is-invalid @enderror" id="carrier-api-url-input"
                                                name="api_url" placeholder="Nhập URL API">
                                            @error('api_url')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-api-token-input">Token API <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('api_token') is-invalid @enderror" id="carrier-api-token-input"
                                                name="api_token" placeholder="Nhập Token API">
                                            @error('api_token')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-phone-input">Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="carrier-phone-input"
                                                name="phone" placeholder="Nhập số điện thoại">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-email-input">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="carrier-email-input"
                                                name="email" placeholder="Nhập email">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label" for="carrier-status-input">Trạng thái</label>
                                            <select class="form-select" id="carrier-status-input" name="is_active">
                                                <option value="active" selected>Hoạt động</option>
                                                <option value="inactive">Không hoạt động</option>
                                            </select>
                                            @error('is_active')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-start ms-3 mb-3">
                                        <button type="submit" class="btn btn-success w-sm me-2">Thêm mới</button>
                                        <a href="{{ route('admin.carriers.index') }}" class="btn btn-primary btn w-sm">Quay lại
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
