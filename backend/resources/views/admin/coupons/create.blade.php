@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Coupons</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Create Coupon</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- start form -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Create Coupon</h5>
                        </div>

                        <form id="create-coupon-form" method="POST" action="{{ route('admin.coupons.store') }}"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card-body">
                                        <!-- Phạm vi áp dụng và mã giảm giá -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="applies-to-input">Phạm vi áp dụng</label>
                                                <select class="form-select" id="applies-to-input" name="applies_to"
                                                    required>
                                                    <option value="all" checked>All</option>
                                                    <option value="category">Category</option>
                                                    <option value="product">Product</option>
                                                </select>
                                                @error('applies_to')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-8">
                                                <label class="form-label" for="code-input">Mã giảm giá</label>
                                                <input value="{{ strtoupper(\Str::random(8)) }}" type="text" class="form-control" id="code-input" name="code"
                                                    placeholder="Nhập mã giảm giá" required>
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Mô tả mã giảm giá -->
                                        <div class="mb-3">
                                            <label class="form-label" for="description-input">Mô tả mã giảm giá</label>
                                            <textarea class="form-control" id="description-input" name="description" placeholder="Nhập mô tả"></textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Loại giảm giá, giá trị giảm giá, giảm giá tối đa, giá trị đơn hàng tối thiểu -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label" for="discount-type-input">Loại giảm giá</label>
                                                <select class="form-select" id="discount-type-input" name="discount_type"
                                                    required>
                                                    <option value="percentage">Phần trăm</option>
                                                    <option value="fixed_amount">Số tiền cố định</option>
                                                </select>
                                                @error('discount_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label" for="discount-value-input">Giá trị giảm
                                                    giá</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="discount-value-input" name="discount_value"
                                                    placeholder="Nhập giá trị giảm giá" required>
                                                @error('discount_value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label" for="max-discount-amount-input">Giảm giá tối
                                                    đa</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="max-discount-amount-input" name="max_discount_amount"
                                                    placeholder="Nhập giảm giá tối đa">
                                                @error('max_discount_amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label" for="min-order-value-input">Giá trị đơn hàng tối
                                                    thiểu</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="min-order-value-input" name="min_order_value"
                                                    placeholder="Nhập giá trị đơn hàng tối thiểu">
                                                @error('min_order_value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="start-date-input">Thời gian bắt đầu</label>
                                                <input type="datetime-local" class="form-control" id="start-date-input"
                                                    name="start_date">
                                                @error('start_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="end-date-input">Thời gian kết thúc</label>
                                                <input type="datetime-local" class="form-control" id="end-date-input"
                                                    name="end_date">
                                                @error('end_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="usage-limit-input">Số lần mã có thể được sử
                                                    dụng</label>
                                                <input type="number" class="form-control" id="usage-limit-input"
                                                    name="usage_limit" placeholder="Nhập số lần sử dụng tối đa">
                                                @error('usage_limit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="per-user-limit-input">Số lần tối đa mỗi
                                                    người dùng có thể sử dụng mã</label>
                                                <input type="number" class="form-control" id="per-user-limit-input"
                                                    name="per_user_limit"
                                                    placeholder="Nhập số lần tối đa cho mỗi người dùng">
                                                @error('per_user_limit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Trạng thái hoạt động -->
                                        <div class="form-check form-switch form-switch-custom form-switch-danger mb-3">
                                            <label class="form-check-label" for="is-active-input">Trạng thái hoạt
                                                động</label>
                                            <input type="hidden" name="is_active" value="0">
                                            <!-- Giá trị mặc định là 0 nếu không được check -->
                                            <input class="form-check-input" type="checkbox" id="is-active-input"
                                                name="is_active" value="1"
                                                {{ old('is_active', 1) ? 'checked' : '' }}>
                                        </div>
                                        @error('is_active')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <!-- Có thể dùng chung với mã khác? -->
                                        <div class="mb-3">
                                            <label class="form-label" for="is-stackable-input">Có thể dùng chung với mã
                                                khác?</label>
                                            <div class="form-check form-switch form-switch-success">
                                                <input type="hidden" name="is_stackable" value="0">
                                                <!-- Giá trị mặc định là 0 nếu không được check -->
                                                <input class="form-check-input" type="checkbox" id="is-stackable-input"
                                                    name="is_stackable" value="1"
                                                    {{ old('is_stackable') ? 'checked' : '' }}>
                                            </div>
                                            @error('is_stackable')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Chỉ dành cho một số người dùng? -->
                                        <div class="mb-3">
                                            <label class="form-label" for="eligible-users-only-input">Chỉ dành cho một số
                                                người dùng?</label>
                                            <div class="form-check form-switch form-switch-success">
                                                <input type="hidden" name="eligible_users_only" value="0">
                                                <!-- Giá trị mặc định là 0 nếu không được check -->
                                                <input class="form-check-input" type="checkbox"
                                                    id="eligible-users-only-input" name="eligible_users_only"
                                                    value="1" {{ old('eligible_users_only') ? 'checked' : '' }}>
                                            </div>
                                            @error('eligible_users_only')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit và quay lại danh sách -->
                                <div class="text-end me-3 mb-3">
                                    <button type="submit" class="btn btn-success w-sm">
                                        <i class="ri-check-double-line me-2"></i>Submit
                                    </button>
                                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn w-sm">
                                        <i class="ri-arrow-left-line"></i> Quay lại danh sách
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
