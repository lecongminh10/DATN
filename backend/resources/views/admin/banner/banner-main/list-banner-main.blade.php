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
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('admin.banner.banner_main_view_add') }}" class="btn btn-success">
                                                <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                            </a>
                                            {{-- <button type="button" class="btn btn-soft-danger" id="delete-selected">
                                                <i class="ri-delete-bin-2-line"></i>
                                            </button>
                                            <a href="{{ route('admin.categories.trashed') }}" class="btn btn-warning">
                                                <i class="ri-delete-bin-5-line align-bottom me-1"></i> Thùng rác
                                            </a> --}}
                                        </div>
                                    </div>
                                    <div class="col-sm d-flex justify-content-end">
                                    </div> 
                                </div><br>
                                     <table class="table table-bordered align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Ảnh</th>
                                                    <th scope="col">Tiêu đề</th>
                                                    <th scope="col">Phụ đề</th>
                                                    <th scope="col">Giá</th>
                                                    <th scope="col">Tiêu đề nút</th>
                                                    <th scope="col">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($parentBanner as $banner)
                                                    <tr>
                                                        <td scope="col">{{$banner->id}}</td>
                                                        <td scope="col"><img src="{{Storage::url($banner->image)}}" style="width: 80px;height: 80px; border-radius: 5px" alt=""></td>
                                                        <td scope="col">{{$banner->title}}</td>
                                                        <td scope="col">{{$banner->sub_title}}</td>
                                                        <td scope="col">{{number_format($banner->price, 0, ',', '.')}}</td>
                                                        <td scope="col">{{$banner->title_button}}</td>
                                                        <td scope="col">
                                                            {{-- <a href="" class="btn text-primary d-inline-block edit-item-btn">Sửa</a> --}}
                                                            <a href="{{ route('admin.banner.banner_main_edit', $banner->id) }}">
                                                                <button type="button" class="btn btn-outline-secondary waves-effect waves-light">Sửa</button>
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