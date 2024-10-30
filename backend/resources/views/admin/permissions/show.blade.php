@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Phân quyền  ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Phân quyền ', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h5 mb-0">Chi Tiết Permission</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="permission_name" class="form-label fw-bold">Tên Permission :</label>
                                            <p class="form-control-plaintext">{{ $permission->permission_name }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="form-label fw-bold">Mô Tả :</label>
                                            <p class="form-control-plaintext">{{ $permission->description }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="created_at" class="form-label fw-bold">Ngày Tạo :</label>
                                            <p class="form-control-plaintext">
                                                {{ $permission->created_at->format('d/m/Y H:i:s') }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="updated_at" class="form-label fw-bold">Ngày Cập Nhật :</label>
                                            <p class="form-control-plaintext">
                                                {{ $permission->updated_at->format('d/m/Y H:i:s') }}</p>
                                        </div>

                                        <div class="mb-4">
                                            <h5 class="fw-bold">Danh Sách Permission Values :</h5>
                                            <ul class="list-group">
                                                @foreach ($permission->permissionValues as $item)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span
                                                            class="badge bg-primary-subtle text-primary">{{ $item->value }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div> <!-- end card -->
                            </div>
                        </div>
                        <div class="float-end mt-4">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary"> Quay lại
                            </a>
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-warning">Chỉnh
                                sửa</a>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
