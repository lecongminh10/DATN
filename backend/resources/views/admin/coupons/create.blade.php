@extends('admin.layouts.app')
@section('style_css')
    <style>
        .dropzone {
            border: 1px solid rgb(212 212 212 / 80%);
        }

        #searchInput {
            position: relative;
        }

        #result {
            position: absolute;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 280px;
            top: calc(100% + 1px);
            /* Cách trên 1px */
            left: -14px;
            z-index: 1000;
            margin-top: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #result .dropdown-item {
            padding: 10px 15px;
            font-size: 14px;
            color: #333;
        }

        #result .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        #selected-values {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #fff;
            font-size: 15px;
            color: #6c757d;
            min-height: 35px;
            box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.1);
            padding-bottom: 10px;
        }

        #selected-values::before {
            color: #adb5bd;
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Mã Coupons</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí</a></li>
                                <li class="breadcrumb-item active">Thêm Coupon</li>
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
                            <h5 class="card-title mb-0">Thêm Coupon</h5>
                        </div>

                        <form id="create-coupon-form" method="POST" action="{{ route('admin.coupons.store') }}"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="code-input">Mã giảm giá<span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('code', strtoupper(\Str::random(8))) }}" type="text"
                                                class="form-control @error('code') is-invalid @enderror" id="code-input"
                                                name="code" placeholder="Nhập mã giảm giá">
                                            @error('code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label @error('description') is-invalid @enderror"
                                                for="description-input">Mô tả mã giảm giá</label>
                                            <textarea class="form-control" id="description-input" name="description" placeholder="Nhập mô tả"></textarea>
                                            @error('description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label @error('discount_type') is-invalid @enderror"
                                                    for="discount-type-input">Loại giảm giá</label>
                                                <select class="form-select" id="discount-type-input" name="discount_type"
                                                    required>
                                                    <option value="percentage">Phần trăm</option>
                                                    <option value="fixed_amount">Số tiền cố định</option>
                                                </select>
                                                @error('discount_type')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label @error('discount_value') is-invalid @enderror"
                                                    for="discount-value-input">Giá trị giảm
                                                    giá<span class="text-danger">*</span></label>
                                                <input value="{{ old('discount_value') }}" type="number" step="0.01"
                                                    class="form-control" id="discount-value-input" name="discount_value"
                                                    placeholder="Nhập giá trị giảm giá" required>
                                                @error('discount_value')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label @error('max_discount_amount') is-invalid @enderror"
                                                    for="max-discount-amount-input">Giảm giá tối
                                                    đa<span class="text-danger">*</span></label>
                                                <input value="{{ old('max_discount_amount') }}" type="number"
                                                    step="0.01" class="form-control" id="max-discount-amount-input"
                                                    name="max_discount_amount" placeholder="Nhập giảm giá tối đa" required>
                                                @error('max_discount_amount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label @error('min_order_value') is-invalid @enderror"
                                                    for="min-order-value-input">Giá trị đơn hàng tối
                                                    thiểu<span class="text-danger">*</span></label>
                                                <input value="{{ old('min_order_value') }}" type="number" step="0.01"
                                                    class="form-control" id="min-order-value-input" name="min_order_value"
                                                    placeholder="Nhập giá trị đơn hàng tối thiểu" required>
                                                @error('min_order_value')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label @error('start_date') is-invalid @enderror"
                                                    for="start-date-input">Thời gian bắt đầu<span
                                                        class="text-danger">*</span></label>
                                                <input value="{{ old('start_date') }}" type="datetime-local"
                                                    class="form-control" id="start-date-input" name="start_date" required>
                                                @error('start_date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label @error('end_date') is-invalid @enderror"
                                                    for="end-date-input">Thời gian kết thúc<span
                                                        class="text-danger">*</span></label>
                                                <input value="{{ old('end_date') }}" type="datetime-local"
                                                    class="form-control" id="end-date-input" name="end_date" required>
                                                @error('end_date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label @error('usage_limit') is-invalid @enderror"
                                                    for="usage-limit-input">Số lần mã có thể được sử
                                                    dụng</label>
                                                <input type="number" class="form-control" id="usage-limit-input"
                                                    name="usage_limit" placeholder="Nhập số lần sử dụng tối đa">
                                                @error('usage_limit')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label @error('per_user_limit') is-invalid @enderror"
                                                    for="per-user-limit-input">Số lần tối đa mỗi
                                                    người dùng có thể sử dụng mã</label>
                                                <input type="number" class="form-control" id="per-user-limit-input"
                                                    name="per_user_limit"
                                                    placeholder="Nhập số lần tối đa cho mỗi người dùng">
                                                @error('per_user_limit')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4"><!-- Trạng thái hoạt động -->
                                                <label class="form-label @error('is_active') is-invalid @enderror"
                                                    for="is-active-input">Trạng thái hoạt
                                                    động</label>
                                                <div
                                                    class="form-check form-switch form-switch-custom form-switch-danger mb-3">
                                                    <input type="hidden" name="is_active" value="0">
                                                    <!-- Giá trị mặc định là 0 nếu không được check -->
                                                    <input class="form-check-input" type="checkbox" id="is-active-input"
                                                        name="is_active" value="1"
                                                        {{ old('is_active', 1) ? 'checked' : '' }}>
                                                </div>
                                                @error('is_active')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-4"><!-- Có thể dùng chung với mã khác? -->
                                                <div class="mb-3">
                                                    <label class="form-label @error('is_stackable') is-invalid @enderror"
                                                        for="is-stackable-input">Dùng chung
                                                        với mã khác?</label>
                                                    <div class="form-check form-switch form-switch-success">
                                                        <input type="hidden" name="is_stackable" value="0">
                                                        <!-- Giá trị mặc định là 0 nếu không được check -->
                                                        <input class="form-check-input" type="checkbox"
                                                            id="is-stackable-input" name="is_stackable" value="1"
                                                            {{ old('is_stackable') ? 'checked' : '' }}>
                                                    </div>
                                                    @error('is_stackable')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-4"><!-- Chỉ dành cho một số người dùng? -->
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label @error('eligible_users_only') is-invalid @enderror"
                                                        for="eligible-users-only-input">Chỉ dành cho
                                                        một số
                                                        người dùng?</label>
                                                    <div class="form-check form-switch form-switch-success">
                                                        <input type="hidden" name="eligible_users_only" value="0">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="eligible-users-only-input" name="eligible_users_only"
                                                            value="1"
                                                            {{ old('eligible_users_only') ? 'checked' : '' }}>
                                                    </div>
                                                    @error('eligible_users_only')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label @error('applies_to') is-invalid @enderror"
                                                    for="applies-to-input">Phạm vi áp dụng<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="applies-to-input" name="applies_to"
                                                    required>
                                                    <option value="#" checked>Chọn phạm vi</option>
                                                    <option value="all">All</option>
                                                    <option value="category">Category</option>
                                                    <option value="product">Product</option>
                                                    <option value="user">User</option>
                                                </select>
                                                @error('applies_to')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div id="dynamicSelect" class="col-md-3 position-relative">
                                                <label class="form-label" for="search-input">Chọn giá trị</label>
                                                <input novalidate type="text" id="search-input" class="form-control"
                                                    placeholder="Tìm kiếm giá trị..." oninput="filterResults()" required>
                                                <div id="result" style="display: none" class="dropdown-menu w-100">
                                                    <!-- Các kết quả sẽ được hiển thị tại đây -->
                                                </div>
                                                @error('dynamic_value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <input type="hidden" id="dynamic-select" name="dynamic_value" required>
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label" for="search-input">Giá trị</label>
                                                <div id="selected-values" class="form-control">
                                                    <!-- Các giá trị đã chọn sẽ được hiển thị tại đây -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end me-3 mb-3">
                                    <button type="submit" class="btn btn-success w-sm">
                                        <i class="ri-check-double-line me-2"></i>Gửi
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
@section('script_libray')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
@section('scripte_logic')
    
    <script>
        document.getElementById('applies-to-input').addEventListener('change', function() {
            const selectedOption = this.value;
            const inputMessage = document.getElementById('search-input');
            document.getElementById("selected-values").innerHTML = "";
            let url = '';
            if (selectedOption === 'all') {
                if (inputMessage.value === '') {
                    inputMessage.value = 'Áp dụng toàn bộ cửa hàng';
                }
            } else if (selectedOption === 'category') {
                url = '/storage/categories.json';
            } else if (selectedOption === 'product') {
                url = '/storage/products.json';
            } else if (selectedOption === 'user') {
                url = '/storage/users.json';
            }


            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const resultDropdown = document.getElementById('result');
                    resultDropdown.style.display = 'block';

                    resultDropdown.innerHTML = data.length > 0 ?
                        data.map(item =>
                            `<button type="button" class="dropdown-item" data-id="${item.id}" data-name="${item.name}">${item.name}</button>`
                        ).join('') :
                        `<div class="dropdown-item disabled">Không có kết quả</div>`;

                    document.querySelectorAll('#result .dropdown-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const selectedId = this.getAttribute('data-id');
                            const selectedName = this.getAttribute('data-name');

                            addSelectedValue(selectedId, selectedName);

                            resultDropdown.style.display = 'none';
                            document.getElementById('search-input').value = '';
                        });
                    });
                })
                .catch(error => console.error('Error loading JSON data:', error));
        });

        function addSelectedValue(id, name) {
            const selectedValues = document.getElementById('selected-values');

            // Kiểm tra nếu đã chọn giá trị này
            if (document.querySelector(`#selected-values [data-id="${id}"]`)) {
                return;
            }

            const valueContainer = document.createElement('div');
            valueContainer.className = 'selected-value badge bg-primary text-white me-1 mb-1';
            valueContainer.setAttribute('data-id', id);
            valueContainer.innerHTML = `${name} <span class="remove-value" style="cursor:pointer;">&times;</span>`;

            selectedValues.appendChild(valueContainer);

            updateHiddenInput();

            valueContainer.querySelector('.remove-value').addEventListener('click', function() {
                valueContainer.remove();
                updateHiddenInput();
            });
        }

        function updateHiddenInput() {
            const selectedIds = Array.from(document.querySelectorAll('#selected-values .selected-value'))
                .map(item => item.getAttribute('data-id'));
            document.getElementById('dynamic-select').value = selectedIds.join(',');
        }

        document.getElementById('search-input').addEventListener('focus', function() {
            const resultDropdown = document.getElementById('result');
            if (this.value) {
                filterResults(); // Lọc theo từ khóa đã nhập
            } else {
                resultDropdown.style.display = 'block';
            }
        });

        function filterResults() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const items = document.querySelectorAll('#result .dropdown-item:not(.disabled)');
            if (!searchInput) {
                items.forEach(item => item.style.display = 'block');
                return;
            }
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(searchInput) ? 'block' : 'none';
            });
        }

        document.addEventListener('click', function(e) {
            const searchInput = document.getElementById('search-input');
            const resultDropdown = document.getElementById('result');
            if (!searchInput.contains(e.target) && !resultDropdown.contains(e.target)) {
                resultDropdown.style.display = 'none';
            }
        });
    </script>
@endsection
