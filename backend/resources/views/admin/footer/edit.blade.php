@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Quản lí hiển thị ',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Footer', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Quản lý Footer</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.footer.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="about_us" class="form-label">About Us</label>
                                    <textarea name="about_us" id="about_us" class="form-control" rows="3">{{ $footer->about_us ?? '' }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        value="{{ $footer->address ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-control"
                                        value="{{ $footer->phone ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $footer->email ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="working_hours" class="form-label">Working Hours</label>
                                    <input type="text" name="working_hours" id="working_hours" class="form-control"
                                        value="{{ $footer->working_hours ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="customer_service" class="form-label">Customer Service</label>
                                    <textarea name="customer_service" id="customer_service" class="form-control" rows="5">{{ $footer->customer_service ?? '' }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Cập nhật Footer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
