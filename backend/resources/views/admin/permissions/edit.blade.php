@extends('admin.layouts.app')

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

                        <div class="mb-3">
                            <h1><label for="permission_name" class="form-label">Cập nhật quyền </label></h1>
                        </div>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="permission_name" class="form-label">Tên </label>
                                <input type="text" class="form-control" id="permission_name" name="permission_name"
                                    value="{{ $permission->permission_name }}" >
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <input class="form-control" id="description" name="description1" value="{{ $permission->description }}"></input>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary" id="add-more">Thêm giá trị</button>
                                </div>
                            </div>
                            <div id="permission-values-container">
                                @foreach ($permission->permissionValues as $item)
                                    <div class="row mb-3 permission-value-item">
                                        <div class="col-md-6">
                                            <label for="value" class="form-label">Giá trị quyền </label>
                                            <input type="text" class="form-control" name="value[]"
                                            value="{{ $item->value }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="description" class="form-label">Mô tả </label>
                                            <input class="form-control" name="description[]"value="{{ $item->description }}"></input>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <!-- Nút xóa -->
                                            {{-- <button type="button" class="btn btn-danger remove-item">Xóa</button> --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class=" mb-3 float-end">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                                <a href="{{ route('admin.permissions.index') }}" class="btn bg-info-subtle">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-more').addEventListener('click', function() {
            // Template for a new row of permission values
            var newPermissionValue = `
                <div class="row mb-3 permission-value-item">
                    <div class="col-md-6">
                        <label for="value" class="form-label">Giá trị quyền</label>
                        <input type="text" class="form-control" name="value[]">
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Mô tả</label>
                        <input class="form-control" name="description[]" rows="3"></input>
                    </div>
                </div>`;

            // Append the new row to the container
            document.getElementById('permission-values-container').insertAdjacentHTML('beforeend',
                newPermissionValue);
        });
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                // Xóa dòng tương ứng
                e.target.closest('.permission-value-item').remove();
            }
        });
    </script>
@endsection
