@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Attribute</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Edit Attribute</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if (session()->has('success') && session()->get('success'))
                <div class="alert alert-primary" role="alert">
                    <strong>Thao Tác Thành Công</strong>
                </div>
            @endif

            @if (session()->has('success') && !session()->get('success'))
                <div class="alert alert-primary" role="alert">
                    <strong>Thao Tác Không Thành Công</strong> {{ session()->get('error') }}
                </div>
            @endif
            <form id="update-attribute-form" method="POST" action="{{ route('admin.attributes.update', $attribute) }}"
                autocomplete="off" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0">Edit Attribute</h5>
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
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="attribute-name-input">Attribute Name</label>
                                    <input type="text" class="form-control" id="attribute-name-input"
                                        name="attribute_name"
                                        value="{{ old('attribute_name', $attribute->attribute_name) }}"
                                        placeholder="Enter Attribute" required>
                                    @error('attribute_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="attribute-description-input">Attribute Description</label>
                                    <textarea class="form-control" id="attribute-description-input" name="description" placeholder="Enter Attribute Description" required>{{ old('description', $attribute->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                
                                <div class="mb-3">
                                    <label class="form-label">Attribute Values</label>
                                    <div id="attribute-values">
                                        @foreach ($attribute->attributeValues as $value)
                                            <div class="input-group mb-2">
                                                <input type="hidden" name="attribute_value_id[]"
                                                    value="{{ $value->id }}">
                                                <input type="text" class="form-control" name="attribute_value[]"
                                                    value="{{ $value->attribute_value }}"
                                                    placeholder="Enter Attribute Value" required>
                                                <button type="button" class="btn btn-outline-danger remove-attribute-value"
                                                    data-id="{{ $value->id }}"
                                                    onclick="removeAttributeValue(this)">Remove</button>
                                            </div>
                                            @error('attribute_value.' . $loop->index)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary" onclick="addAttributeValue()">Add More</button>
                                </div>
                            </div>
                        </div>
                        <!-- Nút submit -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm"><i class="ri-check-double-line me-2"></i>Update</button>
                            <a href="{{ route('admin.attributes.index') }}" class=" btn btn-secondary w-sm"><i
                                class="ri-arrow-left-line"></i> Quay lại danh
                            sách</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script_libray')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('scripte_logic')
    <script>
        function addAttributeValue() {
            const attributeValuesContainer = document.getElementById('attribute-values');
            const newAttributeValue = document.createElement('div');
            newAttributeValue.classList.add('input-group', 'mb-2');
            newAttributeValue.innerHTML = `
                <input type="text" class="form-control" name="attribute_value[]" placeholder="Enter Attribute Value" required>
                <button type="button" class="btn btn-outline-danger" onclick="removeAttributeValue(this)">Remove</button>
            `;
            attributeValuesContainer.appendChild(newAttributeValue);
        }

        function removeAttributeValue(button) {
            const attributeValueId = button.getAttribute('data-id');
            if (!attributeValueId) {
                button.closest('.input-group').remove();
            } else {
                if (confirm("Bạn có chắc chắn muốn xóa giá trị thuộc tính này không?")) {
                    $.ajax({
                        url: `{{ route('admin.attributeValues.destroy', '') }}/${attributeValueId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            button.closest('.input-group').remove();
                            alert(response.message);
                        },
                        error: function(xhr) {
                            alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                        }
                    });
                }
            }
        }
    </script>
@endsection
