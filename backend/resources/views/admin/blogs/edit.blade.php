@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Bài viết',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Cập nhật bài viết', 'url' => '#'],
                ],
            ])

            <form id="update-blog-form" method="POST" action="{{ route('admin.blogs.update', $blog->id) }}"
                enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                @csrf
                @method('PUT') <!-- Sử dụng PUT hoặc PATCH cho cập nhật -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Cập nhật bài viết</h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label" for="blog-title-input">Tiêu đề</label>
                                    <input type="text" class="form-control" id="blog-title-input" name="title"
                                        value="{{ old('title', $blog->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="slug-input">Slug</label>
                                    <input type="text" class="form-control" id="slug-input" name="slug"
                                        value="{{ old('slug', $blog->slug) }}" required>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Tiêu đề SEO</label>
                                    <input type="text" class="form-control" id="meta-title-input" name="meta_title"
                                        value="{{ old('meta_title', $blog->meta_title) }}" required>
                                    @error('meta_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="meta-description-input">Mô tả SEO</label>
                                    <textarea class="form-control" id="meta-description-input" name="meta_description" required>{{ old('meta_description', $blog->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="content">Nội dung</label>
                                    <textarea class="form-control" id="content" name="content" required>{{ old('content', $blog->content) }}</textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="thumbnail">Hình ảnh đại diện</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail"
                                        accept="image/*">
                                    @if ($blog->thumbnail)
                                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Thumbnail"
                                            class="mt-2" style="max-height: 100px;">
                                    @endif
                                </div>

                                {{-- <div class="mb-3">
                                    <label class="form-label" for="tags">Thẻ bài viết</label>
                                    <div id="blog-tags" class="d-flex flex-wrap">
                                        @foreach ($blog->tags as $tag)
                                            <div class="input-group mb-2 me-2">
                                                <input type="text" class="form-control" name="tags[]"
                                                    value="{{ $tag->name }}" required>
                                                <button type="button" class="btn btn-outline-danger"
                                                    onclick="removeTag(this)">Xóa</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary" onclick="addTag()">Thêm
                                        thẻ</button>
                                    @error('tags')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="mb-3">
                                    <label class="form-label" for="tags">Thẻ bài viết</label>
                                    <div id="blog-tags" class="d-flex flex-wrap">
                                        @foreach ($blog->tags as $tag)
                                            <div class="input-group mb-2 me-2" id="tag-{{ $tag->id }}">
                                                <input type="text" class="form-control" name="tags[]"
                                                    value="{{ $tag->name }}" required>
                                                <button type="button" class="btn btn-outline-danger"
                                                    onclick="removeTag({{ $tag->id }}, '{{ $tag->name }}')">Xóa</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <button type="button" class="btn btn-outline-secondary" onclick="showAvailableTags()">Chọn thẻ có sẵn</button>
                                
                                    <!-- Danh sách thẻ có sẵn -->
                                    <div id="available-tags" class="mt-3" style="display: none;">
                                        <label class="form-label">Thẻ có sẵn</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($allTags as $tag)
                                                @if (!in_array($tag->id, $blog->tags->pluck('id')->toArray()))
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        onclick="addTag({{ $tag->id }}, '{{ $tag->name }}')">
                                                        {{ $tag->name }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                
                                    @error('tags')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                



                                <div class="mb-3">
                                    <label class="form-label" for="is_published">Trạng thái</label>
                                    <select class="form-select" id="is_published" name="is_published" required>
                                        <option value="1"
                                            {{ old('is_published', $blog->is_published) == 1 ? 'selected' : '' }}>Đã xuất
                                            bản</option>
                                        <option value="0"
                                            {{ old('is_published', $blog->is_published) == 0 ? 'selected' : '' }}>Chưa xuất
                                            bản</option>
                                        <option value="2"
                                            {{ old('is_published', $blog->is_published) == 2 ? 'selected' : '' }}>Bản nháp
                                        </option>
                                    </select>
                                    @error('is_published')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


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

    <script>
        function addTag() {
            const tagsDiv = document.getElementById('blog-tags');
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2 me-2';
            newInputGroup.innerHTML = `
            <input type="text" class="form-control" name="tags[]" placeholder="Nhập thẻ" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">Xóa</button>
        `;
            tagsDiv.appendChild(newInputGroup);
        }


        function removeTag(button) {
            button.parentElement.remove();
        }


        function showAvailableTags() {
            // Hiển thị danh sách thẻ có sẵn
            const availableTagsDiv = document.getElementById('available-tags');
            availableTagsDiv.style.display = 'block';
        }

        function addTag(tagId, tagName) {
            // Thêm thẻ vào danh sách thẻ bài viết
            const blogTagsDiv = document.getElementById('blog-tags');
            const newTagHTML = `
        <div class="input-group mb-2 me-2" id="tag-${tagId}">
            <input type="text" class="form-control" name="tags[]" value="${tagName}" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeTag(${tagId}, '${tagName}')">Xóa</button>
        </div>
    `;
            blogTagsDiv.insertAdjacentHTML('beforeend', newTagHTML);

            // Cập nhật cơ sở dữ liệu với thẻ mới
            updateDatabaseWithTag('add', tagId);

            // Ẩn danh sách thẻ có sẵn sau khi chọn thẻ
            document.getElementById('available-tags').style.display = 'none';
        }

        function removeTag(tagId, tagName) {
            // Xóa thẻ khỏi danh sách thẻ bài viết
            const tagElement = document.getElementById(`tag-${tagId}`);
            tagElement.remove();

            // Tạo lại nút thẻ trong danh sách thẻ có sẵn
            const availableTagsContainer = document.getElementById('available-tags').querySelector('.d-flex');
            const tagButton = document.createElement('button');
            tagButton.classList.add('btn', 'btn-outline-primary', 'btn-sm');
            tagButton.textContent = tagName;
            tagButton.onclick = function() {
                addTag(tagId, tagName);
            };
            availableTagsContainer.appendChild(tagButton);

            // Cập nhật cơ sở dữ liệu để xóa thẻ
            updateDatabaseWithTag('remove', tagId);
        }

        function updateDatabaseWithTag(action, tagId) {
            const formData = new FormData();
            formData.append('tag_id', tagId);
            formData.append('action', action); // 'add' hoặc 'remove'

            fetch('/update-tags', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cập nhật cơ sở dữ liệu thành công');
                    } else {
                        console.error('Cập nhật cơ sở dữ liệu thất bại');
                    }
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                });
        }
    </script>
@endsection
