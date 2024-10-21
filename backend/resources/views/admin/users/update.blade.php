@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Người dùng  ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Người dùng ', 'url' => '#']
                ]
            ])
            <div class="row">
                <div class="card">
                    <div class="p-4" style="min-height: 800px;">
                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0 text-primary">Cập nhật người dùng</h4>
                            </div>
                        </div>
                        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="firstNameinput" class="form-label">Tên</label>
                                        <input type="text" class="form-control" placeholder="Nhập tên" name="username" value="{{ $user->username }}">
                                        @error('username')
                                            <span class="text-danger">Tên người dùng là bắt buộc.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lastNameinput" class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password">
                                        @error('password')
                                            <span class="text-danger">Mật khẩu phải có ít nhất 6 ký tự.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" placeholder="Nhập số điện thoại" value="{{ $user->phone_number }}" name="phone_number">
                                        @error('phone_number')
                                            <span class="text-danger">Số điện thoại không hợp lệ.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="address1ControlTextarea" class="form-label">Ngày sinh</label>
                                        <input type="date" class="form-control" placeholder="" value="{{ $user->date_of_birth }}" name="date_of_birth">
                                        @error('date_of_birth')
                                            <span class="text-danger">Ngày sinh không được để trống.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailidInput" class="form-label">Email</label>
                                        <input type="email" class="form-control" placeholder="example@gmail.com" value="{{ $user->email }}" name="email">
                                        @error('email')
                                            <span class="text-danger">Email không hợp lệ.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Giới tính</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Khác</option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">Giới tính không được để trống.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Trạng thái</label>
                                        <select name="status"  class="form-select">
                                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Chưa kích hoạt</option>
                                            <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Bị cấm</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">Trạng thái không được để trống.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Quyền</label>
                                        <select name="id_permissions" class="form-select">
                                            @foreach ($permissionsValues as $permission1)
                                                <option value="{{ $permission1->id }}"
                                                    @foreach ($user->permissionsValues as $permission2)
                                                        {{ $permission1->id == $permission2->id ? 'selected' : '' }}
                                                    @endforeach
                                                >{{ $permission1->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_permissions')
                                            <span class="text-danger">Quyền không được để trống.</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content">
                                        <div class="text-start">
                                            <button type="submit" class="btn btn-primary me-2">Sửa</button>
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
    </div>
@endsection
