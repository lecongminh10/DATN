@extends('admin.layouts.app')

@section('title')
    Thêm Mới Danh Mục
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @include('admin.layouts.component.page-header', [
            'title' => 'Danh mục ',
            'breadcrumb' => [
                ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                ['name' => 'Danh mục', 'url' => '#']
            ]
        ])
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Thêm mới danh mục</h5>
                                @if (session('success'))
                                <div class="w-full alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                            </div>
                            <div class="form-check form-switch justify-content-between form-switch-primary mt-3">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" checked value="1">
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div><br>
                    
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Tên danh mục" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    
                            <div class="col-lg-12">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Mô tả">{{ old('description') }}</textarea>
                            </div><!--end col-->
                    
                            <div class="col-lg-12">
                                <label class=" mb-3">Ảnh</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" data-allow-reorder="true" data-max-file-size="25MB" data-max-files="3">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div><!--end col-->
                    
                            <div class="col-lg-12">
                                <label for="parent_id" class="form-label">Danh mục cha</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror" name="parent_id" id="parent_id">
                                    <option value="">Không có</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                            @if($parent->children->isNotEmpty())
                                                <span class="dropdown-icon">⯆</span> <!-- Biểu tượng dropdown -->
                                            @endif
                                        </option>
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}" {{ old('parent_id') == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;  {{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div><!--end col-->
                    
                            <div class="col-lg-12">
                                <div class="text-start">
                                    <button class="btn btn-success me-2">Thêm mới</button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quay lại</a>
                                </div>
                            </div>
                        </div><!--end row-->
                    </form>
                    
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div>
@endsection
