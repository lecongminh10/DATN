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
                                <li class="breadcrumb-item active">Attribute</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if ($errors->any())
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
            @endif
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
                                            <h5 class="card-title mb-0">Create Attribute</h5>
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
                                <!-- Attribute Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="attribute-name-input">Attribute Name</label>
                                    <input type="text" class="form-control" id="attribute-name-input"
                                        name="attribute_name" placeholder="Enter Attribute" required>
                                    @error('attribute_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Attribute Description -->
                                <div class="mb-3">
                                    <label class="form-label" for="attribute-description-input">Attribute
                                        Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Attribute Description"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Attribute Values -->
                                <div class="mb-3">
                                    <label class="form-label">Attribute Values</label>
                                    <div id="attribute-values">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="attribute_value[]"
                                                placeholder="Enter Attribute Value" required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="addAttributeValue()">Add More</button>
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
                        </div>
                        <!-- Submit Button -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm"><i class="ri-check-double-line me-2"></i>Submit</button>
                            <a href="{{ route('admin.attributes.index') }}" class=" btn btn-secondary btn w-sm"><i
                                    class="ri-arrow-left-line"></i> Quay lại danh
                                sách</a>
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
