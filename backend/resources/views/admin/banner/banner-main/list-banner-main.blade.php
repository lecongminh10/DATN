@extends('admin.layouts.app')

@section('title')
    Danh sách banner
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
                'title' => 'Quản lý Banner Main',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Danh sách Banner', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="mb-sm-0">Danh sách Banner Main</h4>
                        </div>

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row g-4 ">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('admin.banner.banner_main_view_add') }}" class="btn btn-success">
                                                <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                            </a>
                                        </div>
                                    </div>
                                </div><br>
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0 10">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                     <table class="table table-bordered align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" style="width: 50px">STT</th>
                                                    <th scope="col" style="width: 230px">Ảnh</th>
                                                    <th scope="col" style="width: 230px">Tiêu đề</th>
                                                    <th scope="col" style="width: 230px">Tiêu đề nút</th>
                                                    <th scope="col" style="width: 150px">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($parentBanner as $key => $banner)
                                                    <tr>
                                                        <td scope="col" class="text-center">{{$key+1}}</td>
                                                        <td scope="col"><img src="{{Storage::url($banner->image)}}" style="width: 190px;height: 80px; border-radius: 5px" alt=""></td>
                                                        <td scope="col">{{$banner->title}}</td>
                                                        <td scope="col">{{$banner->title_button}}</td>
                                                        <td scope="col" class="text-center">
                                                            <a href="{{ route('admin.banner.banner_main_edit', $banner->id) }}">
                                                                <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                       </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $parentBanner->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script_libray')
        <!-- prismjs plugin -->
        <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>
    @endsection