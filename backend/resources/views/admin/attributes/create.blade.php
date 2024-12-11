@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Thuộc tính ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thuộc tính', 'url' => '#']
                ]
            ])
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success') && session()->get('success'))
                <div class="alert alert-primary" role="alert">
                    <strong>Thao Tác Thành Công</strong>
                </div>
            @endif

            @if (session()->has('success') && !session()->get('success'))
                <div class="alert alert-primary" role="alert">
                    <strong>Thao Tác Không Thành Công</strong> {{ session()->get('error') }}
                </div>
            @endif --}}
            <form id="create-attribute-form" method="POST" action="{{ route('admin.attributes.store') }}"
                autocomplete="off" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0">Thêm mới</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex flex-wrap align-items-start gap-2">
                                            <button type="button" class="btn btn-info"><i
                                                    class="ri-file-download-line align-bottom me-1"></i> Nhập</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Attribute Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="attribute-name-input">Tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="attribute-name-input"
                                        name="attribute_name" placeholder="Enter thuộc tính" required>
                                    @error('attribute_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Attribute Description -->
                                <div class="mb-3">
                                    <label class="form-label" for="attribute-description-input">Mô tả </label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter mô tả"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Attribute Values -->
                                <div class="mb-3">
                                    <label class="form-label">Giá trị của thuộc tính <span class="text-danger">*</span></label>
                                    <div id="attribute-values">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="attribute_value[]"
                                                placeholder="Enter giá trị thuộc tính " required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="addAttributeValue()">Thêm </button>
                                        </div>
                                        @if ($errors->has('attribute_value.*'))
                                            @foreach ($errors->get('attribute_value.*') as $messages)
                                                @foreach ($messages as $message)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                                                    <!-- Submit Button -->
                            <div class="text-end mb-3">
                                <button type="submit" class="btn btn-success w-sm"><i class="ri-check-double-line me-2"></i>Gửi</button>
                                <a href="{{ route('admin.attributes.index') }}" class=" btn btn-secondary btn w-sm"><i
                                        class="ri-arrow-left-line"></i> Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripte_logic')
    <script src="/bower/tinymce/tinymce.min.js">
        tinymce.init({
            selector: '#content'
        });
    </script>
    <script>
        function addAttributeValue() {
            const attributeValuesDiv = document.getElementById('attribute-values');
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="attribute_value[]" placeholder="Enter Attribute Value" required>
                <button type="button" class="btn btn-outline-danger" onclick="removeAttributeValue(this)">Remove</button>
            `;
            attributeValuesDiv.appendChild(newInputGroup);
        }

        function removeAttributeValue(button) {
            button.parentElement.remove();
        }
    </script>
@endsection
