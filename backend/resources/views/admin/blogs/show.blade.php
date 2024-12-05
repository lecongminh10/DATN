@extends('admin.layouts.app')

@section('content')

    {{-- <style>
        .no-bullets {
            list-style-type: none;
            padding-left: 0;

        }
    </style> --}}

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Chi tiết Blog',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Blogs', 'url' => '#'],
                ],
            ])
            <div class="row">
                <!-- end page title -->
                <div class="card">
                    <div class="card-header border-bottom-dashed mb-4">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0"><a class="text-dark"
                                            href="{{ route('admin.blogs.index') }}">Chi tiết</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">Tiêu đề</label>
                                <input type="text" id="title" class="form-control border-0 bg-white p-3 shadow-sm"
                                    value="{{ $blog->title }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">Nội dung</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="content" class="mb-0">
                                            {{ $blog->content }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">Slug</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="content" class="mb-0">
                                            {{ $blog->slug }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">Tiêu đề SEO</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="content" class="mb-0">
                                            {{ $blog->meta_title }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">Mô tả SEO</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="content" class="mb-0">
                                            {{ $blog->meta_description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">Ảnh</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        @if ($blog->thumbnail)
                                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Thumbnail" class="img-fluid " width="30%">
                                        @else
                                            <p class="mb-0">Chưa có ảnh</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="author" class="form-label fw-semibold">Tác giả</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="author" class="mb-0">
                                            {{ optional($blog->user)->username ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label fw-semibold">Trạng thái</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="author" class="mb-0">
                                            @if ($blog->is_published == 1)
                                                <span class="badge bg-success">Đã xuất bản</span>
                                            @elseif ($blog->is_published == 0)
                                                <span class="badge bg-warning text-dark">Chưa xuất bản</span>
                                            @elseif ($blog->is_published == 2)
                                                <span class="badge bg-secondary">Bản nháp</span>
                                            @else
                                                <span class="badge bg-danger">Trạng thái không xác định</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label fw-semibold">Tags</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        @if ($blog->tags && $blog->tags->isNotEmpty())
                                            <ul class="mb-0 no-bullets">
                                                @foreach ($blog->tags as $tag)
                                                    <li>{{ $tag->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mb-0">Chưa có tags</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">Ngày tạo</label>
                                <div class="col-md-12">
                                    <div class="form-control border-0 bg-white p-3 shadow-sm">
                                        <p id="content" class="mb-0">
                                            {{ $blog->created_at }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mb-3">
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn w-sm"><i
                                    class="ri-arrow-left-line"></i> Quay lại</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
