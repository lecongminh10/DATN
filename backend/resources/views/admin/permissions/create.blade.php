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
                    <h1 class="h5">Thêm mới </h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf
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
                            <input type="text" class="form-control" id="permission_name" name="permission_name" >
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <input class="form-control" id="description" name="description1" ></input>
                        </div>
                        <div class="text-end my-1">
                            <button type="button" class="btn btn-secondary" id="add-more">Add Value</button>
                        </div>
                        <div id="permission-values-container">
                            <div class="row mb-3 permission-value-item">
                                <div class="col-md-6">
                                    <label for="value" class="form-label">Giá trị quyền </label>
                                    <input type="text" class="form-control" name="value[]" >
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <input class="form-control" name="description[]" ></input>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-link bg-info-subtle">Quay lại</a>
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
                        <label for="value" class="form-label">Giá trị quyền </label>
                        <input type="text" class="form-control" name="value[]" >
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Mô tả</label>
                        <input class="form-control" name="description[]" ></input>
                    </div>
                </div>`;

            // Append the new row to the container
            document.getElementById('permission-values-container').insertAdjacentHTML('beforeend', newPermissionValue);
        });
    </script>
@endsection
