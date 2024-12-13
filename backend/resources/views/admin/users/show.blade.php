@extends('admin.layouts.app')

@section('title')
    Chi tiết tài khoản: {{  $user->username}}
@endsection
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
                    <div class="p-3">
                        <div class="py-2 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0 text-primary">Chi tiết người dùng</h4>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Cột trái -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh</label>
                                    <ul class="list-group">
                                        <img src="{{ Storage::url($user->profile_picture) }}" alt="Ảnh đại diện" width="150px" height="130px" style="border-radius: 5px;">
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tên</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->username }}</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->phone_number }}</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ngày sinh</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ \Carbon\Carbon::parse($user->date_of_birth)->format('d-m-Y') }}</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->email }}</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Cột phải -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ str_repeat('•', strlen($user->password)) }}</li>
                                        </ul>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Điểm khách hàng thân thiết</label>
                                        <ul class="list-group">
                                            <li class="list-group-item">{{ $user->loyalty_points }}</li>
                                        </ul>
                                    </div>
                                    <label class="form-label">Hạng thành viên</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->membership_level }}</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Giới tính</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->gender }}</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $user->status }}</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quyền</label>
                                    <ul class="list-group">
                                        @foreach ($permissions as $permission)
                                            <li class="list-group-item">{{ $permission->value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 text-start">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    </div>
@endsection
