@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-header text-white">
                        <h1 class="h5 mb-0">Chi Tiết Permission</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="permission_name" class="form-label">Tên Permission :</label>
                                        <p class="form-control-plaintext">{{ $permission->permission_name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả :</label>
                                        <p class="form-control-plaintext">{{ $permission->description }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="created_at" class="form-label">Ngày Tạo :</label>
                                        <p class="form-control-plaintext">
                                            {{ $permission->created_at->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updated_at" class="form-label">Ngày Cập Nhật :</label>
                                        <p class="form-control-plaintext">
                                            {{ $permission->updated_at->format('d/m/Y H:i:s') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h5>Danh Sách Permission Values :</h5>
                                        <ul class="list-group">
                                            @foreach ($permission->permissionValues as $item)
                                                <li class="list-group-item">
                                                    <h2 class="badge bg-primary-subtle text-primary">{{ $item->value }}</h2>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div> <!-- end card -->
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary"><i class="las la-backward"></i>Quay lại</a>
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
