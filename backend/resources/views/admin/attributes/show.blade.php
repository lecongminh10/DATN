@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12 ">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Attribute</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Attribute Information</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- end page title -->
                <div class="card">
                    <div class="card-header border-bottom-dashed mb-4">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 "><a class="text-dark" href="{{ route('admin.attributes.index') }}">Attribute List</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="mb-3">
                                <label for="attribute_name" class="form-label fw-semibold">Tên Thuộc tính</label>
                                <input type="text" id="attribute_name"
                                    class="form-control border-0 bg-white p-3 shadow-sm"
                                    value="{{ $attribute->attribute_name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Mô tả</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="description" class="mb-0 ">
                                            {{ $attribute->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="form-label fw-semibold">Giá trị Thuộc tính</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($attribute->attributeValues->isEmpty())
                                    <span class="badge bg-warning text-dark">Không có giá trị nào cho thuộc tính này.</span>
                                @else
                                    @foreach ($attribute->attributeValues as $value)
                                        <span class="badge bg-primary fs-6 p-2">{{ $value->attribute_value }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <a href="{{ route('admin.attributes.index') }}" class=" btn btn-secondary btn w-sm"><i
                                    class="ri-arrow-left-line"></i> Quay lại danh
                                sách</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
