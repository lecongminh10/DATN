@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Carrier</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Edit Carrier</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Edit Carrier</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button type="button" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Import</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="update-carrier-form" method="POST"
                            action="{{ route('admin.carriers.update', $carrier->id) }}" autocomplete="off"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT') 
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-name-input">Tên nhà vận
                                                chuyển</label>
                                            <input type="text" class="form-control" id="carrier-name-input"
                                                name="name" placeholder="Nhập tên nhà vận chuyển"
                                                value="{{ old('name', $carrier->name) }}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-api-url-input">URL API của nhà vận
                                                chuyển</label>
                                            <input type="url" class="form-control" id="carrier-api-url-input"
                                                name="api_url" placeholder="Nhập URL API"
                                                value="{{ old('api_url', $carrier->api_url) }}" required>
                                            @error('api_url')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-api-token-input">Token API của nhà
                                                vận chuyển</label>
                                            <input type="text" class="form-control" id="carrier-api-token-input"
                                                name="api_token" placeholder="Nhập Token API"
                                                value="{{ old('api_token', $carrier->api_token) }}">
                                            @error('api_token')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-phone-input">Số điện thoại của nhà
                                                vận chuyển</label>
                                            <input type="text" class="form-control" id="carrier-phone-input"
                                                name="phone" placeholder="Nhập số điện thoại"
                                                value="{{ old('phone', $carrier->phone) }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-email-input">Email của nhà vận
                                                chuyển</label>
                                            <input type="email" class="form-control" id="carrier-email-input"
                                                name="email" placeholder="Nhập email"
                                                value="{{ old('email', $carrier->email) }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-status-input">Trạng thái</label>
                                            <select class="form-select" id="carrier-status-input" name="is_active" required>
                                                <option value="active"
                                                    {{ $carrier->is_active === 'active' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="inactive"
                                                    {{ $carrier->is_active === 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                            @error('is_active')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-end me-3 mb-3">
                                        <button type="submit" class="btn btn-success w-sm"><i
                                                class="ri-check-double-line me-2"></i>Update</button>
                                        <a href="{{ route('admin.carriers.index') }}" class="btn btn-secondary btn w-sm">
                                            <i class="ri-arrow-left-line"></i> Quay lại danh sách
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
