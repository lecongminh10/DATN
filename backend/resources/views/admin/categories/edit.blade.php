@extends('admin.layouts.app')

@section('title')
    Sửa Danh Mục
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
                    <form action="{{route('admin.categories.update', $data)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <!-- Header của thẻ card -->
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Tạo danh mục mới</h5>
                                <!-- Công tắc trạng thái hoạt động -->
                                <div class="form-check form-switch form-switch-primary">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                        @checked($data->is_active) value="1" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">Hoạt động</label>
                                </div>
                            </div>
                            
                            <!-- Tên danh mục -->
                            <div class="col-lg-12">
                                <label for="productName" class="form-label">Tên</label>
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                            </div><!-- end col -->
                        
                            <!-- Mô tả danh mục -->
                            <div class="col-lg-12">
                                <label for="description" class="form-label">Mô tả</label>
                                <input type="text" class="form-control" name="description" value="{{ $data->description }}">
                            </div><!-- end col -->
                        
                            <!-- Ảnh của danh mục -->
                            <div class="col-lg-12">
                                <h5 class="fw-semibold mb-3">Hình ảnh</h5>
                                <input type="file" class="form-control" multiple name="image" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="2">
                                <img src="{{ Storage::url($data->image) }}" style="max-width: 100px ; max-heigth:100px" alt="Danh mục" class="my-2">
                            </div><!-- end col -->
                        
                            <!-- Nút chỉnh sửa danh mục -->
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button class="btn btn-primary">Chỉnh sửa danh mục</button>
                                </div>
                            </div>
                        </div><!-- end row -->                        
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div><!--end row-->
@endsection
