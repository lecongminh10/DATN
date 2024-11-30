@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Quản lý thông báo',
                'breadcrumb' => [
                    ['name' => 'Quản lý giao diện', 'url' => 'javascript:void(0);'],
                    ['name' => 'Thông báo', 'url' => '#'],
                ],
            ])

            <div class="card">
                <div class="card-header">
                    <h3>Cập nhật thông báo</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.announcement.update') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="message">Thông Báo</label>
                            <textarea id="message" name="message" class="form-control">{{ $announcement->message ?? '' }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="discount_percentage">Phần Trăm Giảm Giá</label>
                            <input type="number" id="discount_percentage" name="discount_percentage" class="form-control"
                                value="{{ $announcement->discount_percentage ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Danh Mục</label>
                            <input type="text" id="category" name="category" class="form-control"
                                value="{{ $announcement->category ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="start_date">Ngày Bắt Đầu</label>
                            <input type="datetime-local" id="start_date" name="start_date" class="form-control"
                                value="{{ $announcement->start_date ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="end_date">Ngày Kết Thúc</label>
                            <input type="datetime-local" id="end_date" name="end_date" class="form-control"
                                value="{{ $announcement->end_date ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="active">Kích Hoạt</label>
                            <input type="checkbox" name="active" id="active"
                                {{ $announcement->active ? 'checked' : '' }}>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
