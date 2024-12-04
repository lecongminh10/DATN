@extends('admin.layouts.app')
@section('style_css')
    <style>
        .cke_notification {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Thêm mới Blog',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thêm mới Blog', 'url' => '#'],
                ],
            ])

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session()->has('success') && session()->get('success'))
                <div class="alert alert-primary" role="alert">
                    <strong>Thao Tác Thành Công</strong>
                </div>
            @endif

            @if (session()->has('success') && !session()->get('success'))
                <div class="alert alert-danger" role="alert">
                    <strong>Thao Tác Không Thành Công</strong> {{ session()->get('error') }}
                </div>
            @endif

            <form id="create-blog-form" method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data"
                autocomplete="off" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Thêm mới bài viết</h5>
                            </div>
                            <div class="card-body">
                                <!-- Blog Title -->
                                <div class="mb-3">
                                    <label class="form-label" for="blog-title-input">Tiêu đề </label>
                                    <input type="text" class="form-control" id="blog-title-input" name="title"
                                        placeholder="Nhập tiêu đề bài viết" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Slug -->
                                <div class="mb-3">
                                    <label class="form-label" for="slug-input">Slug </label>
                                    <input type="text" class="form-control" id="slug-input" name="slug"
                                        placeholder="Nhập slug cho bài viết" required>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Meta Title -->
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Tiêu đề SEO </label>
                                    <input type="text" class="form-control" id="meta-title-input" name="meta_title"
                                        placeholder="Nhập meta title cho bài viết" required>
                                    @error('meta_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Meta Description -->
                                <div class="mb-3">
                                    <label class="form-label" for="meta-description-input">Mô tả SEO </label>
                                    <textarea class="form-control" id="meta-description-input" name="meta_description"
                                        placeholder="Nhập meta description cho bài viết" required></textarea>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Content -->
                                <div class="mb-3">
                                    <label class="form-label" for="content">Nội dung </label>
                                    <textarea class="form-control" id="editor-container" name="content" placeholder="Nhập nội dung bài viết" required></textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Thumbnail -->
                                <div class="mb-3">
                                    <label class="form-label" for="thumbnail">Hình ảnh đại diện</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail"
                                        accept="image/*">
                                </div>

                                
                                <!-- Is Published -->
                                <div class="mb-3">
                                    <label class="form-label" for="is_published">Trạng thái</label>
                                    <select class="form-select" id="is_published" name="is_published" required>
                                        <option value="0" {{ old('is_published', 0) == 0 ? 'selected' : '' }}>Chưa xuất bản</option>
                                        <option value="1" {{ old('is_published', 0) == 1 ? 'selected' : '' }}>Đã xuất bản</option>
                                        <option value="2" {{ old('is_published', 0) == 2 ? 'selected' : '' }}>Bản nháp</option>
                                    </select>
                                    @error('is_published')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                        
                            </div>
                            <!-- Submit Button -->
                            <div class="text-end mb-3">
                                <button type="submit" class="btn btn-success w-sm"><i
                                        class="ri-check-double-line me-2"></i>Gửi</button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary w-sm"><i
                                        class="ri-arrow-left-line"></i> Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripte_logic')
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor-container');
</script>
    <script>
        function addTag() {
            const tagsDiv = document.getElementById('blog-tags');
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="tags[]" placeholder="Nhập thẻ" required>
                <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">Xóa</button>
            `;
            tagsDiv.appendChild(newInputGroup);
        }

        function removeTag(button) {
            button.parentElement.remove();
        }
    </script>
@endsection
