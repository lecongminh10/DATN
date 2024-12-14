@extends('admin.layouts.app')

@section('title')
    Danh sách Banner
@endsection

@section('style_css')
    <style>
        .description {
            display: block;
            max-height: 100px;
            overflow-y: auto;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Quản lý Banner',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Danh sách Banner', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="mb-sm-0">Danh sách Banner</h4>
                        </div>

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('admin.banner.banner_left_add') }}" class="btn btn-success">
                                                <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                            </a>
                                        </div>
                                    </div>
                                </div><br>
                                 @if (session('success'))
                                <div class="w-full alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                                <table class="table table-bordered align-middle table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Tiêu đề</th>
                                            <th scope="col">Phụ đề</th>
                                            <th scope="col">Giảm giá (%)</th>
                                            <th scope="col">Mô tả</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banners as $banner)
                                            <tr>
                                                <td>{{ $banner->id }}</td>
                                                <td><img src="{{ Storage::url($banner->image) }}"
                                                        style="width: 80px; height: 80px; border-radius: 5px"
                                                        alt="Banner Image"></td>
                                                <td>{{ $banner->title }}</td>
                                                <td>{{ $banner->sub_title }}</td>
                                                <td>{{ $banner->sale }}%</td>
                                                <td class="description">{{ $banner->description }}</td>
                                                <td>{{ $banner->active ? 'Hiển thị' : 'Ẩn' }}</td>
                                                <td>{{ $banner->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.banner.banner_left_edit', $banner->id) }}"
                                                        class="btn btn-outline-secondary">
                                                        Sửa
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div class="d-flex justify-content-center mt-3">
                                    {{ $banners->links('vendor.pagination.bootstrap-5') }}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_libray')
    <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>
@endsection
