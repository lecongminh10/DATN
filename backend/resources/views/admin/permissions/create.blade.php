@extends('admin.layouts.app')

@section('title')
    Thêm Mới Quyền
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Phân quyền  ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Phân quyền ', 'url' => '#']
                ]
            ])
           <div class="row">
            <div class="card">
                <div class="card-header">
                    <h1 class="h5">Thêm mới </h1>
                </div>
                @if (session('error'))
                    <div class="w-full alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="permission_name" class="form-label">Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('permission_name') is-invalid @enderror" id="permission_name" name="permission_name" >
                            @error('permission_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <input class="form-control" id="description" name="description1" ></input>
                        </div>
                        <div class="text-end my-1">
                            <button type="button" class="btn btn-secondary" id="add-more">Thêm giá trị</button>
                        </div>
                        <div id="permission-values-container">
                            <div class="row mb-3 permission-value-item">
                                <div class="col-md-6">
                                    <label for="value" class="form-label">Giá trị quyền </label>
                                    <input type="text" class="form-control @error('value') is-invalid @enderror" name="value[]" >
                                    @error('value')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <input class="form-control" name="description[]" ></input>
                                </div>
                            </div>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success me-2">Thêm mới</button>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
           </div>
        </div>
    </div>

    <script>
        document.getElementById('add-more').addEventListener('click', function() {
            var newPermissionValue = `
                <div class="row mb-3 permission-value-item">
                    <div class="col-md-6">
                        <label for="value" class="form-label">Giá trị quyền </label>
                        <input type="text" class="form-control" name="value[]" >
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Mô tả</label>
                        <input class="form-control" name="description[]" ></input>
                    </div>
                </div>`;

            document.getElementById('permission-values-container').insertAdjacentHTML('beforeend', newPermissionValue);
        });
    </script>
@endsection
