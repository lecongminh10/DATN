@extends('admin.layouts.app')

@section('title')
    Chi Tiết Thuộc Tính: {{ $attribute->attribute_name }}
@endsection
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
            <div class="row">
                <!-- end page title -->
                <div class="card">
                    <div class="card-header border-bottom-dashed mb-4">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 "><a class="text-dark" href="{{ route('admin.attributes.index') }}">Chi tiết </a></h5>
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
                            <h6 class="form-label fw-semibold">Giá trị thuộc tính</h6>
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
                        <div class="text-start mb-3">
                            <a href="{{ route('admin.attributes.index') }}" class=" btn btn-primary btn w-sm">Quay lại</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
