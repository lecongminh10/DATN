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
            top: calc(100% + -1px);
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

        .btn-close {
            padding: 0;
            margin-left: 5px;
            font-size: 9px;
            font-weight: bold;
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
                        <h4 class="mb-sm-0">Coupons</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Update Coupon</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Update Coupon</h5>
                        </div>
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <form id="update-coupon-form" method="POST"
                            action="{{ route('admin.coupons.update', $coupon->id) }}" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="code-input">Mã giảm giá</label>
                                            <input type="text" class="form-control" id="code-input" name="code"
                                                value="{{ old('code', $coupon->code) }}" placeholder="Nhập mã giảm giá"
                                                required>
                                            @error('code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="description-input">Mô tả mã giảm giá</label>
                                            <textarea class="form-control" id="description-input" name="description" placeholder="Nhập mô tả">{{ old('description', $coupon->description) }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label" for="discount-type-input">Loại giảm giá</label>
                                                <select class="form-select" id="discount-type-input" name="discount_type"
                                                    required>
                                                    <option value="percentage"
                                                        {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Phần
                                                        trăm</option>
                                                    <option value="fixed_amount"
                                                        {{ $coupon->discount_type == 'fixed_amount' ? 'selected' : '' }}>Số
                                                        tiền cố định</option>
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
                                                    value="{{ old('discount_value', $coupon->discount_value) }}"
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
                                                    value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}"
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
                                                    value="{{ old('min_order_value', $coupon->min_order_value) }}"
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
                                                    name="start_date"
                                                    value="{{ old('start_date', $coupon->start_date ? $coupon->start_date : '') }}">
                                                @error('start_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="end-date-input">Thời gian kết thúc</label>
                                                <input type="datetime-local" class="form-control" id="end-date-input"
                                                    name="end_date"
                                                    value="{{ old('end_date', $coupon->end_date ? $coupon->end_date : '') }}">
                                                @error('end_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-7">
                                                <label class="form-label" for="usage-limit-input">Số lần mã có thể được sử
                                                    dụng</label>
                                                <input type="number" class="form-control" id="usage-limit-input"
                                                    name="usage_limit"
                                                    value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                                    placeholder="Nhập số lần sử dụng tối đa">
                                                @error('usage_limit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label" for="per-user-limit-input">Số lần tối đa mỗi
                                                    người dùng có thể sử dụng mã</label>
                                                <input type="number" class="form-control" id="per-user-limit-input"
                                                    name="per_user_limit"
                                                    value="{{ old('per_user_limit', $coupon->per_user_limit) }}"
                                                    placeholder="Nhập số lần tối đa cho mỗi người dùng">
                                                @error('per_user_limit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="is-active-input">Trạng thái hoạt
                                                        động</label>
                                                    <div
                                                        class="form-check form-switch form-switch-custom form-switch-danger mb-3">
                                                        <input type="hidden" name="is_active" value="0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="is-active-input" name="is_active" value="1"
                                                            {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                                    </div>
                                                    @error('is_active')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="is-stackable-input">Có thể dùng chung
                                                        với mã
                                                        khác?</label>
                                                    <div class="form-check form-switch form-switch-success">
                                                        <input type="hidden" name="is_stackable" value="0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="is-stackable-input" name="is_stackable" value="1"
                                                            {{ old('is_stackable', $coupon->is_stackable) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="is-stackable-input">Có</label>
                                                    </div>
                                                    @error('is_stackable')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="eligible-users-only-input">Chỉ dành cho
                                                        một số
                                                        người dùng?</label>
                                                    <div class="form-check form-switch form-switch-success">
                                                        <input type="hidden" name="eligible_users_only" value="0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="eligible-users-only-input" name="eligible_users_only"
                                                            value="1"
                                                            {{ old('eligible_users_only', $coupon->eligible_users_only) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="eligible-users-only-input">Có</label>
                                                    </div>
                                                    @error('eligible_users_only')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label" for="applies-to-input">Phạm vi áp dụng</label>
                                                <select class="form-select" id="applies-to-input" name="applies_to"
                                                    onchange="updateDynamicValue()" required>
                                                    <option value="all"
                                                        {{ $coupon->applies_to === 'all' ? 'selected' : '' }}>All</option>
                                                    <option value="category"
                                                        {{ $coupon->applies_to === 'category' ? 'selected' : '' }}>Category
                                                    </option>
                                                    <option value="product"
                                                        {{ $coupon->applies_to === 'product' ? 'selected' : '' }}>Product
                                                    </option>
                                                    <option value="user"
                                                        {{ $coupon->applies_to === 'user' ? 'selected' : '' }}>User
                                                    </option>
                                                </select>
                                                @error('applies_to')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div id="dynamicSelect" class="col-md-3 position-relative">
                                                <label class="form-label" for="search-input">Chọn giá trị</label>
                                                <input type="text" id="search-input" class="form-control"
                                                    placeholder="Tìm kiếm giá trị..." oninput="filterResults()" required>
                                                <div id="result" style="display: none" class="dropdown-menu w-100">
                                                </div>
                                                @error('dynamic_value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <input type="hidden" id="dynamic-select" name="dynamic_value" required>
                                            </div>

                                            <div class="col-md-7">
                                                <label class="form-label" for="selected-values">Giá trị</label>
                                                <div id="selected-values" class="form-control">
                                                    @if ($coupon->applies_to === 'category')
                                                        @foreach ($coupon->categories as $category)
                                                            <span class="badge bg-primary me-1"
                                                                data-id="{{ $category->id }}">{{ $category->name }}
                                                                <button type="button"
                                                                    class="btn-close btn-close-white btn-close-sm"
                                                                    aria-label="Close"
                                                                    onclick="removeValue(this)"></button>

                                                            </span>
                                                            <input type="hidden" name="data-id-value"
                                                                class="data-id-value"
                                                                value="data-id-value['category'][{{ $category->id }}][{{ $category->name }}]">
                                                        @endforeach
                                                    @elseif($coupon->applies_to === 'product')
                                                        @foreach ($coupon->products as $product)
                                                            <span class="badge bg-primary me-1"
                                                                data-id="{{ $product->id }}">{{ $product->name }}
                                                                <button type="button"
                                                                    class="btn-close btn-close-white btn-close-sm"
                                                                    aria-label="Close"
                                                                    onclick="removeValue(this)"></button>

                                                            </span>
                                                            <input type="hidden" name="data-id-value"
                                                                class="data-id-value"
                                                                value="data-id-value['product'][{{ $product->id }}][{{ $product->name }}]">
                                                        @endforeach
                                                    @elseif($coupon->applies_to === 'user')
                                                        @foreach ($coupon->users as $user)
                                                            <span class="badge bg-primary me-1"
                                                                data-id="{{ $user->id }}">{{ $user->username }}
                                                                <button type="button"
                                                                    class="btn-close btn-close-white btn-close-sm"
                                                                    aria-label="Close"
                                                                    onclick="removeValue(this)"></button>

                                                            </span>
                                                            <input type="hidden" name="data-id-value"
                                                                class="data-id-value"
                                                                value="data-id-value['user'][{{ $user->id }}][{{ $user->name }}]">
                                                        @endforeach
                                                    @elseif($coupon->applies_to === 'all')
                                                        <span class="badge bg-primary">Áp dụng toàn bộ cửa hàng</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end me-3 mb-3">
                                        <button type="submit" class="btn btn-success w-sm">
                                            <i class="ri-check-double-line me-2"></i>Cập nhật
                                        </button>
                                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn w-sm">
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
@section('script_libray')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            updateHiddenInput(); // Cập nhật giá trị cho hidden input khi trang tải lần đầu
        });

        let savedValues = []; // Biến toàn cục để lưu giá trị ID và name

        document.getElementById('applies-to-input').addEventListener('change', function() {
            const selectedOption = this.value;
            const inputMessage = document.getElementById('search-input');
            let url = '';

            const id_value_selected = '';

            // Xác định URL dựa trên tùy chọn đã chọn
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

            // Fetch dữ liệu từ URL đã xác định
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const resultDropdown = document.getElementById('result');
                    resultDropdown.style.display = 'block';
                    resultDropdown.innerHTML = data.length > 0 ? data.map(item =>
                        `<button type="button" class="dropdown-item" data-id="${item.id}" data-name="${item.name}">${item.name}</button>`
                    ).join('') : `<div class="dropdown-item disabled">Không có kết quả</div>`;

                    // Thêm sự kiện click cho các item trong dropdown
                    document.querySelectorAll('#result .dropdown-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const selectedId = this.getAttribute('data-id');
                            const selectedName = this.getAttribute('data-name');
                            addSelectedValue(selectedId, selectedName); // Thêm giá trị đã chọn
                            resultDropdown.style.display = 'none';
                            document.getElementById('search-input').value = '';
                        });
                    });

                    // Lấy danh sách giá trị ID và name đã lưu
                    const id_value_selected = savedValues;
                    console.log(id_value_selected);

                    // Nếu có giá trị đã chọn, gọi hàm addSelectedValue
                    if (id_value_selected.length > 0) {
                        id_value_selected.forEach(item => {
                            addSelectedValue(item.id, item.name); // Gọi hàm với ID và name
                        });
                    }

                })
                .catch(error => console.error('Error loading JSON data:', error));
        });
        window.addEventListener("load", function() {

            const selectedOption = document.getElementById("applies-to-input").value;
            const inputMessage = document.getElementById('search-input');
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
                    resultDropdown.innerHTML = data.length > 0 ? data.map(item =>
                        `<button type="button" class="dropdown-item" data-id="${item.id}" data-name="${item.name}">${item.name}</button>`
                    ).join('') : `<div class="dropdown-item disabled">Không có kết quả</div>`;
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
            if (document.querySelector(`#selected-values [data-id="${id}"]`)) {
                return;
            }
            const valueContainer = document.createElement('span');
            valueContainer.className = 'badge bg-primary me-1';
            valueContainer.setAttribute('data-id', id);
            valueContainer.innerHTML =
                `${name} <button type="button" class="btn-close btn-close-white btn-close-sm" aria-label="Close" onclick="removeValue(this)"></button>`;
            selectedValues.appendChild(valueContainer);
            updateHiddenInput();
        }

        function updateHiddenInput() {
            const selectedIds = Array.from(document.querySelectorAll('#selected-values .badge')).map(item => item
                .getAttribute('data-id'));
            document.getElementById('dynamic-select').value = selectedIds.join(',');
        }

        document.getElementById('search-input').addEventListener('focus', function() {
            const resultDropdown = document.getElementById('result');
            if (this.value) {
                filterResults();
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

        function removeValue(element) {
            const badge = element.parentElement;
            const id = badge.getAttribute('data-id');
            const dynamicSelect = document.getElementById('dynamic-select');
            let currentValues = dynamicSelect.value ? dynamicSelect.value.split(',') : [];
            currentValues = currentValues.filter(value => value !== id);
            dynamicSelect.value = currentValues.join(',');
            badge.remove();
        }

        function updateDynamicValue() {
            const appliesTo = document.getElementById('applies-to-input').value;
            console.log(appliesTo);
            const dynamicSelect = document.getElementById('dynamic-select');
            const selectedValues = document.getElementById('selected-values');
            selectedValues.innerHTML = '';
        }


        function updateDynamicValue() {
            const appliesTo = document.getElementById('applies-to-input').value;
            console.log(appliesTo);

            const dynamicSelect = document.getElementById('dynamic-select');
            const selectedValues = document.getElementById('selected-values');
            selectedValues.innerHTML = ''; // Xóa nội dung hiện tại

            // Gọi hàm để lấy giá trị ID và name
            //  savedValues = getValuesFromDataIdValues(getDataIdValues()); // Lưu trữ giá trị vào biến toàn cục
        }

        function getDataIdValues() {
            const dataValues = [];
            const inputs = document.querySelectorAll('.data-id-value');

            inputs.forEach(input => {
                dataValues.push(input.value);
            });

            return getValuesFromDataIdValues(dataValues); // Trả về danh sách các giá trị
        }

        // Lấy ID và name từ các giá trị, đồng thời lấy loại (category, product, user)
        function getValuesFromDataIdValues(dataValues) {
            const results = dataValues.map(value => {
                // Sử dụng regex để tìm và lấy loại, ID và name trong chuỗi
                const matches = value.match(/data-id-value\['(\w+)'\]\[(\d+)\]\[(.+)\]/); // Tìm loại, ID và name
                return matches ? {
                    type: matches[1],
                    id: matches[2],
                    name: matches[3]
                } : null; // Nếu tìm thấy, trả về đối tượng với loại, ID và name
            }).filter(result => result !== null); // Lọc ra các giá trị không null

            return results; // Nếu cần, trả về mảng
        }


        savedValues = getDataIdValues();
        console.log(savedValues);
    </script>
@endsection
