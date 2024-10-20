@extends('admin.layouts.app')

@section('title')
    Chi Tiết Danh Mục: {{ $data['name'] }}
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Chi tiết danh mục </h5>
                    </div>
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <!-- Tên -->
                                <div class="col-md-6 mt-3">
                                    <label for="name" class="form-label">Tên </label>
                                    <input disabled type="text" class="form-control" name="name" id="name" value="{{ $data['name'] }}">
                                </div>
                                <!-- Mô tả -->
                                <div class="col-md-6 mt-3">
                                    <label for="description" class="form-label">Mô tả </label>
                                    <input disabled type="text" class="form-control" name="description" value="{{ $data['description'] }}">
                                </div>
                    
                                <!-- Danh mục cha -->
                                <div class="col-md-6 mt-3">
                                    <label for="parent_id" class="form-label">Danh mục cha</label>
                                    <input type="text" disabled name="parent_id" class="form-control"
                                        value="{{ $data->parent_id ? $data->parent_id->name : 'No parent' }}">
                                </div>
                                <!-- Trạng thái hoạt động -->
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Trạng thái</label>
                                    <input type="text" disabled class="form-control" value="{{ ($data->is_active==1)? 'Active':'Unactive'}}">
                                </div>
                    
                                <!-- Ngày tạo và ngày cập nhật -->
                                <div class="col-md-6 mt-3">
                                    <label for="created_at" class="form-label">Ngày tạo </label>
                                    <input disabled type="text" class="form-control" value="{{ $data['created_at'] }}">
                    
                                    <label for="updated_at" class="form-label mt-3">Ngày cập nhật</label>
                                    <input disabled type="text" class="form-control" value="{{ $data['updated_at'] }}">
                                </div>
                    
                                <!-- Ảnh -->
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Ảnh</label>
                                    <div class="border p-2 rounded">
                                        <img src="{{ Storage::url($data->image) }}" style="max-width: 100%; max-height: 100px;" alt="">
                                    </div>
                                </div>
                    
                                <!-- Button trở lại -->
                                <div class="col-12 mt-4 d-flex justify-content-end">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Trở lại</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
@endsection
