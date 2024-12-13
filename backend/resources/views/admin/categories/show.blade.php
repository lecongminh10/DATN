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
                        <h5 class="card-title mb-0">Chi tiết danh mục</h5>
                    </div>
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div>
                                        <label for="name" class="form-label">Tên</label>
                                        <input disabled type="text" class="form-control" name="name" id="name" value="{{ $data['name'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="description" class="form-label">Mô tả</label>
                                        <input disabled type="text" class="form-control" name="description" value="{{ $data['description'] }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="parent_id" class="form-label">Danh mục cha</label>
                                    <input type="text" disabled name="parent_id" class="form-control" value="{{ optional($data->parent)->name ?? 'No parent' }}">
                                </div>
                                <div class="col-md-6">
                                    {!! $data->is_active ? '<span class="badge bg-success"> Hoạt động </span>' : '<span class="badge bg-danger"> Không hoạt động </span>' !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="created_at" class="form-label ">Ngày tạo</label>
                                    <input disabled type="text" class="form-control mb-3" value="{{ $data['created_at'] }}">
                                    <label for="updated_at" class="form-label">Ngày cập nhật</label>
                                    <input disabled type="text" class="form-control" value="{{ $data['updated_at'] }}">
                                </div>
                                 <div class="col-md-6 mt-3">
                                    <label class="form-label">Ảnh</label>
                                    <div class="border p-2 rounded">
                                        <img src="{{ Storage::url($data->image) }}" style="max-width: 100%; max-height: 100px;" alt="">
                                    </div>
                                </div>
                                <div class="text-start">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quay lại</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
@endsection
