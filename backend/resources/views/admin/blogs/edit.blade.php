@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Cập nhật Blog',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Cập nhật Blog', 'url' => '#'],
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

            <!-- Form cập nhật -->
            <form id="update-blog-form" method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data"
                autocomplete="off" class="needs-validation" novalidate>
                @csrf
                @method('PUT') <!-- Sử dụng PUT hoặc PATCH cho cập nhật -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Cập nhật bài viết</h5>
                            </div>
                            <div class="card-body">
                                <!-- Blog Title -->
                                <div class="mb-3">
                                    <label class="form-label" for="blog-title-input">Tiêu đề</label>
                                    <input type="text" class="form-control" id="blog-title-input" name="title"
                                        value="{{ old('title', $blog->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Slug -->
                                <div class="mb-3">
                                    <label class="form-label" for="slug-input">Slug</label>
                                    <input type="text" class="form-control" id="slug-input" name="slug"
                                        value="{{ old('slug', $blog->slug) }}" required>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Meta Title -->
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Tiêu đề SEO</label>
                                    <input type="text" class="form-control" id="meta-title-input" name="meta_title"
                                        value="{{ old('meta_title', $blog->meta_title) }}" required>
                                    @error('meta_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Meta Description -->
                                <div class="mb-3">
                                    <label class="form-label" for="meta-description-input">Mô tả SEO</label>
                                    <textarea class="form-control" id="meta-description-input" name="meta_description" required>{{ old('meta_description', $blog->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Content -->
                                <div class="mb-3">
                                    <label class="form-label" for="content">Nội dung</label>
                                    <textarea class="form-control" id="content" name="content" required>{{ old('content', $blog->content) }}</textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Blog Thumbnail -->
                                <div class="mb-3">
                                    <label class="form-label" for="thumbnail">Hình ảnh đại diện</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                    @if ($blog->thumbnail)
                                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Thumbnail" class="mt-2" style="max-height: 100px;">
                                    @endif
                                </div>

                                <!-- Is Published -->
                                <div class="mb-3">
                                    <label class="form-label" for="is_published">Trạng thái</label>
                                    <select class="form-select" id="is_published" name="is_published" required>
                                        <option value="1" {{ old('is_published', $blog->is_published) == 1 ? 'selected' : '' }}>Đã xuất bản</option>
                                        <option value="0" {{ old('is_published', $blog->is_published) == 0 ? 'selected' : '' }}>Chưa xuất bản</option>
                                        <option value="2" {{ old('is_published', $blog->is_published) == 2 ? 'selected' : '' }}>Bản nháp</option>
                                    </select>
                                    @error('is_published')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end mb-3">
                                <button type="submit" class="btn btn-success w-sm"><i
                                        class="ri-check-double-line me-2"></i>Lưu thay đổi</button>
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
