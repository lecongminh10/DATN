@extends('admin.layouts.app')

@section('title')
    Thêm Mới Trang
@endsection
@section('libray_css')
    <!-- dropzone css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dropzone/dropzone.css') }}" type="text/css" />
    <!-- Filepond css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/addProduct.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.1.0/styles/choices.min.css" />
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
@endsection
@section('style_css')
    <style>
        .dropzone {
            border: 1px solid rgb(212 212 212 / 80%);
        }

        #searchInput {
            position: relative;
        }

        .seo-preview {
            font-family: Arial, sans-serif;
            max-width: 600px;
            border: 1px solid #e0e0e0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .seo-title {
            font-size: 18px;
            color: #1a0dab;
            margin: 0;
            line-height: 1.4;
            font-weight: bold;
        }

        .seo-url {
            font-size: 14px;
            color: #006621;
            margin: 5px 0;
        }

        .seo-description {
            font-size: 13px;
            color: #545454;
            line-height: 1.5;
        }
        .cke_notification {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Trang ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Trang', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col">
                    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm" class="dropzone">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Thêm mới trang</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="live-preview">
                                            <div class="row gy-4">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">Tên <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" id="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="description" class="form-label">Mô tả</label>
                                                    <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                    <label for="permalink" class="form-label">Liên kết cố định <span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control @error('permalink') is-invalid @enderror" name="permalink" id="permalink" readonly>{{ old('permalink') }}</textarea>
                                                    @error('permalink')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Status and Template selection -->
                                                <div class="col-md-4 mt-3">
                                                    <div class="card mt-3">
                                                        <div class="card-header">
                                                            <h4 class="card-title mb-0">Trạng thái <span class="text-danger">*</span></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active">
                                                                <option value="" disabled {{ old('is_active') ? '' : 'selected' }}>-- Chọn Trạng thái --</option>
                                                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Không kích hoạt</option>
                                                            </select>
                                                            @error('is_active')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card mt-3">
                                                        <div class="card-header">
                                                            <h4 class="card-title mb-0">Bản mẫu<span
                                                                    class="text-danger">*</span></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <select
                                                                class="form-select @error('template') is-invalid @enderror"
                                                                id="templateSelect" name="template">
                                                                <option value="" disabled selected>-- Chọn bản mẫu --
                                                                </option>
                                                                <option value="default"
                                                                    {{ old('template') == 'default' ? 'selected' : '' }}>
                                                                    Mặc định</option>
                                                                <option value="coming_soon"
                                                                    {{ old('template') == 'coming_soon' ? 'selected' : '' }}>
                                                                   Ra mắt</option>
                                                                <option value="blog"
                                                                    {{ old('template') == 'blog' ? 'selected' : '' }}>Bài viết 
                                                                </option>
                                                            </select>
                                                            @error('template')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="card mt-3">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0">Nội dung <span class="text-danger">*</span></h4>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="content" id="editor-container" style="height: 300px;">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Mục ảnh Trang<span class="text-danger">*</span></h4>
                                    </div>
                                    <div class="card-body">
                                        <input type="file" name="image" id="pages" class="hidden"
                                            multiple />
                                    </div>
                                </div>

                                <div class="card mt-3 shadow-sm border-0">
                                    <div class="card-header">
                                        <h5 class="mb-0">SEO</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content text-muted mt-4 mt-md-0">
                                            <div class="btn btn-primary my-2" id="addSeo" data-bs-toggle="modal"
                                                data-bs-target="#seoModal">Thêm</div>
                                            <div id="seoOutput" class="mt-3" style="display: none;">
                                                <div class="seo-preview">
                                                    <p class="seo-title" id="outputTitle" name="seo_title"></p>
                                                    <p class="seo-url" id="outputUrl"></p>
                                                    <p class="seo-description" id="outputDescription" name="seo_description"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="card mt-3">
                                    <div class="card-header align-items-center d-flex">
                                        <button class="btn btn-success me-2" type="submit" id="uploadButton" style="cursor: pointer;">Thêm mới</button>
                                        <a href="{{ route('admin.pages.index') }}" class="btn btn-primary mx-2" style="cursor: pointer;">Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Modal -->
    <div class="modal fade" id="seoModal" tabindex="-1" aria-labelledby="seoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seoModalLabel">Nhập thông tin SEO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="seoTitle" class="form-label">Tiêu đề SEO</label>
                        <input type="text" class="form-control @error('seo_title') is-invalid @enderror" id="seoTitle" name="seo_title" value="{{ old('seo_title') }}">
                        @error('seo_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="seoDescription" class="form-label">Mô tả SEO</label>
                        <textarea class="form-control @error('seo_description') is-invalid @enderror" id="seoDescription" name="seo_description" rows="3">{{ old('seo_description') }}</textarea>
                        @error('seo_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" id="saveSeo">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Initialize Quill editor -->

@section('script_libray')
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.1.0/choices.min.js"></script>

    <!-- filepond js -->
    <script src="{{ asset('theme/assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
@section('scripte_logic')
    {{-- <script src="{{ asset('theme/assets/js/addProduct.js') }}"></script> --}}
    <script>
        CKEDITOR.replace('editor-container');
    </script>
    <script>
        document.getElementById('name').addEventListener('input', function () {
            // Hàm chuyển đổi tất cả các ký tự có dấu thành không dấu
            const removeAccents = (str) => {
                return str
                    .normalize("NFD") // Chuẩn hóa Unicode để tách ký tự gốc và dấu
                    .replace(/[\u0300-\u036f]/g, "") // Loại bỏ các dấu (như sắc, huyền, hỏi, ngã, nặng)
            };

            const name = this.value.trim();
            const slug = removeAccents(name) // Loại bỏ dấu
                .toLowerCase() // Chuyển thành chữ thường
                .replace(/[^a-zA-Z0-9]+/g, '-') // Thay thế các ký tự không hợp lệ bằng dấu '-'
                .replace(/^-+|-+$/g, ''); // Xóa dấu '-' ở đầu và cuối chuỗi

            document.getElementById('permalink').textContent = `http://127.0.0.1:8000/${slug}`;
        });

    </script>
    <script>
        // Get a reference to the modal element
        document.getElementById('saveSeo').addEventListener('click', function() {
            const seoTitle = document.getElementById('seoTitle').value;
            const seoDescription = document.getElementById('seoDescription').value;

            if (seoTitle && seoDescription) {
                document.getElementById('outputTitle').textContent = seoTitle;
                document.getElementById('outputDescription').textContent = seoDescription;
                document.getElementById('outputUrl').textContent = document.getElementById('permalink').textContent;

                document.getElementById('seoOutput').style.display = 'block';

                $('#seoModal').modal('hide');
            } else {
                alert('Vui lòng nhập đầy đủ thông tin SEO!');
            }
        });
    </script>

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
@endsection
