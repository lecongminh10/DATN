@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Người dùng  ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Người dùng ', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="card">
                    <div class="p-4" style="min-height: 800px;">
                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0 text-primary">Chi tiết người dùng</h4>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Tên</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->username }}</li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lastNameinput" class="form-label">Mật khẩu</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->password }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Ảnh </label>
                                        <ul class="list-group">
                                            <img src="{{ Storage::url($user->profile_picture) }}" alt="Ảnh đại diện"
                                                width="150px" height="150px">
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Số điện thoại</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->phone_number }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Điểm khách hàng thân thiết</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->loyalty_points }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Hạng thành viên</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->membership_level }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="address1ControlTextarea" class="form-label">Ngày sinh</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->date_of_birth }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailidInput" class="form-label">Email</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->email }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="genderInput" class="form-label">Giới tính</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->gender }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="genderInput" class="form-label">Trạng thái</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->status }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="permissionList" class="form-label">Quyền</label>
                                        <ul class="list-group">
                                            @foreach ($permissions as $permission)
                                                <li class="list-group-item">{{ $permission->value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-end">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-info">Danh sách người
                                        dùng</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
