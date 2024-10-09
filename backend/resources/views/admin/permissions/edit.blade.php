@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
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
                        <h1><label for="permission_name" class="form-label">Update Permission</label></h1>
                    </div>
                    <div class="mb-3">
                        <label for="permission_name" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="permission_name" name="permission_name"
                            value="{{ $permission->permission_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description1" rows="3" required>{{ $permission->description }}</textarea>
                    </div>
                    <div id="permission-values-container">
                        @foreach ($permission->permissionValues as $item)
                            <div class="row mb-3 permission-value-item">
                                <div class="col-md-5">
                                    <label for="value" class="form-label">Permission Value</label>
                                    <input type="text" class="form-control" name="value[]" value="{{ $item->value }}"
                                        required>
                                </div>
                                <div class="col-md-5">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description[]" rows="3">{{ $item->description }}</textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <!-- Nút xóa -->
                                    {{-- <button type="button" class="btn btn-danger remove-item">Xóa</button> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="add-more">Add Value</button>

                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-more').addEventListener('click', function() {
            // Template for a new row of permission values
            var newPermissionValue = `
                <div class="row mb-3 permission-value-item">
                    <div class="col-md-6">
                        <label for="value" class="form-label">Permission Value</label>
                        <input type="text" class="form-control" name="value[]">
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description[]" rows="3"></textarea>
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
