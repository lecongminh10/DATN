@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-primary mb-4">Thêm mới người dùng</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Tên<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập tên" id="username"
                                        name="username" value="{{ old('username') }}">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Nhập mật khẩu" id="password"
                                        name="password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Số điện thoại<span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" placeholder="Nhập số điện thoại"
                                        id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Ngày sinh<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Giới tính</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ
                                        </option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Chưa
                                            kích hoạt</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Bị
                                            cấm</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="permissions" class="form-label">Quyền</label>
                                    <select name="permissions" class="form-select">
                                        @foreach ($permissionsValues as $permissions)
                                            <option value="{{ $permissions->id }}"
                                                {{ old('permissions') == $permissions->id ? 'selected' : '' }}>
                                                {{ $permissions->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                        accept="image/*">
                                    @error('profile_picture')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-info">Danh sách người
                                            dùng</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
