@extends('admin.layouts.app')

@section('title')
    Cập Nhật Danh Mục
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        @include('admin.layouts.component.page-header', [
            'title' => 'Danh mục ',
            'breadcrumb' => [
                ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                ['name' => 'Danh mục', 'url' => '#']
            ]
        ])
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Cập nhật danh mục</h5>
                                    </div>
                                    <div class="form-check form-switch form-switch-primary mt-3">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            name="is_active" id="is_active" value="1" @checked($data->is_active)>
                                        <label class="form-check-label" for="is_active">Hoạt động</label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <label for="name" class="form-label">Tên</label>
                                    <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" name="description" rows="3" required>{{ $data->description }}</textarea>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <h5 class="fw-semibold mb-3">Ảnh</h5>
                                    <input type="file" class="form-control" name="image" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="2">
                                    @if($data->image)
                                    <img src="{{ Storage::url($data->image) }}" width="50" height="50" alt="Current Image" style="margin-top: 10px;">
                                    @endif
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <label for="parent_id" class="form-label">Danh mục cha</label>
                                    <select class="form-select" name="parent_id" id="parent_id">
                                        <option value="">Không có</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}" {{ $parent->id == $data->parent_id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                                @if($parent->children->isNotEmpty())
                                                    <span class="dropdown-icon">⯆</span> <!-- Biểu tượng dropdown -->
                                                @endif
                                            </option>
                                            @foreach($parent->children as $child)
                                                <option value="{{ $child->id }}" {{ $child->id == $data->parent_id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp; {{ $child->name }} <!-- Hiển thị danh mục con -->
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <div class="text-start">
                                        <button class="btn btn-success me-2">Cập nhật</button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quay lại</a>

                                    </div>
                                </div>
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end row-->
</div>
@endsection
