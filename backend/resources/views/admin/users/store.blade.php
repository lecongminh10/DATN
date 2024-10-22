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
                                    <label for="firstNameinput" class="form-label">Tên</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên" id="username"
                                        name="username" value="{{ old('username') }}">
                                    @error('username')
                                        <span class="text-danger">Tên người dùng là bắt buộc.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" placeholder="Nhập mật khẩu" id="password"
                                        name="password">
                                    @error('password')
                                        <span class="text-danger">Mật khẩu phải có ít nhất 6 ký tự.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="phonenumberInput" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" placeholder="Nhập số điện thoại"
                                        id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <span class="text-danger">Số điện thoại không hợp lệ.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" placeholder="" id="date_of_birth"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                        <span class="text-danger">Ngày sinh không được để trống.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="emailidInput" class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">Email không hợp lệ.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Giới tính</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">Giới tính không được để trống.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select" aria-label="Trạng thái người dùng">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Chưa
                                            kích hoạt</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Bị
                                            cấm</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">Trạng thái không được để trống.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Quyền</label>
                                    <select name="permissions" class="form-select">
                                        @foreach ($permissionsValues as $permissions)
                                            <option value="{{ $permissions->id }}">{{ $permissions->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-info">Danh sách người dùng</a>
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
