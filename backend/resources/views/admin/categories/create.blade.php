@extends('admin.layouts.app')

@section('title')
    Thêm Danh Mục
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
                                <h5 class="card-title mb-0">Tạo danh mục mới</h5>
                            </div>
                            <div class="form-check form-switch justify-content-between form-switch-primary mt-3">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" checked value="1">
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div><br>

                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="name" class="form-label">Tên</label>
                                <input type="text" class="form-control" name="name" placeholder="" required>
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" name="description" rows="3" placeholder=""></textarea>
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <h5 class="fw-semibold mb-3">Ảnh</h5>
                                <input type="file" class="form-control" name="image" data-allow-reorder="true" data-max-file-size="25MB" data-max-files="3">
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <label for="parent_id" class="form-label">Danh mục cha</label>
                                <select class="form-select" name="parent_id" id="parent_id">
                                    <option value="">Không có</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}">
                                            {{ $parent->name }}
                                            @if($parent->children->isNotEmpty())
                                                <span class="dropdown-icon">⯆</span> <!-- Biểu tượng dropdown -->
                                            @endif
                                        </option>
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;  {{ $child->name }} <!-- Hiển thị danh mục con -->
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button class="btn btn-primary">Tạo danh mục</button>
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
