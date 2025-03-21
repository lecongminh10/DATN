@extends('admin.layouts.app')

@section('title')
    Thêm banner Left
@endsection
@section('style_css')
<style>
   .d-none {
        display: none;
    }

    .custom-file-button {
        cursor: pointer;
        font-size: 16px;
        padding: 8px 16px;
        border: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .custom-file-button:hover {
        background-color: #0056b3;
    }

    .preview-image {
        width: 100px;
        height: 100px;
        border-radius: 5px;
    }

    .preview-container {
        width: 150px; /* Đặt kích thước khung ảnh */
        height: 150px;
        border: 1px solid #ddd; /* Viền khung */
        border-radius: 5px; /* Bo góc */
        background-size: cover; /* Ảnh vừa khung */
        background-position: center; /* Ảnh căn giữa */
        display: none; /* Ẩn khung trước khi chọn tệp */

    }

    /* .preview-container .img{
        filter: blur(20px); Làm mờ ảnh với độ mờ 5px
    } */

    /* .banner{
        display: flex;
        justify-content: space-around;
    } */

    .banner button{
        width: 150px;
    }

    .banner .form-label{
        text: center;
    }
</style>

@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Quản lý Banner Trái',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Sửa Banner Left', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Sửa Banner Trái</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.banner.banner_left_update', $bannerLeft->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="banner gap-3">
                                    <!-- Image -->
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Ảnh banner</label>
                                        <br>
                                        <button type="button" class="btn btn-primary custom-file-button" onclick="document.getElementById('image').click()">Chọn tệp</button>
                                        <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="previewImageAsBackground(event, 'preview-container-1')">
                                        <div id="preview-container-1" class="preview-container mt-2">
                                            @if(isset($bannerLeft->image))
                                                <img src="{{ Storage::url($bannerLeft->image) }}" class="img-fluid" style="max-width: 100px;">
                                            @else
                                                <span>Chưa có ảnh</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $bannerLeft->title ?? '') }}" >
                                </div>

                                <!-- Sub Title -->
                                <div class="mb-3">
                                    <label for="sub_title" class="form-label">Phụ đề</label>
                                    <input type="text" name="sub_title" id="sub_title" class="form-control" value="{{ old('sub_title', $bannerLeft->sub_title ?? '') }}" >
                                </div>

                                <!-- Sale -->
                                <div class="mb-3">
                                    <label for="sale" class="form-label">Sale (%)</label>
                                    <input type="text" name="sale" id="sale" class="form-control" value="{{ old('sale', $bannerLeft->sale ?? '') }}" >
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $bannerLeft->description ?? '') }}" >
                                </div>

                                <!-- Active Checkbox -->
                                <div class="form-group">
                                    <label for="active">Kích Hoạt</label>
                                    <input type="checkbox" name="active" id="active" {{ old('active', $bannerLeft->active ?? 0) ? 'checked' : '' }}>
                                </div>

                                <button type="submit" class="btn btn-success me-2">Sửa</button>
                                <a href="{{ route('admin.banner.index') }}" class="btn btn-primary">Quay lại</a>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripte_logic')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Gắn sự kiện cho tất cả input type="file"
        document.querySelectorAll("input[type='file']").forEach(input => {
            input.addEventListener('change', (event) => {
                const containerId = event.target.id.replace('image', 'preview-container');
                previewImageAsBackground(event, containerId);
            });
        });
    });

    function previewImageAsBackground(event, containerId) {
        const input = event.target;
        const container = document.getElementById(containerId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                container.style.backgroundImage = `url('${e.target.result}')`;
                container.style.backgroundSize = 'cover'; // Đảm bảo ảnh bao phủ vùng chứa
                container.style.backgroundPosition = 'center'; // Căn giữa ảnh
                container.style.display = 'block'; // Hiển thị vùng chứa khi có ảnh
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.backgroundImage = '';
            container.style.display = 'none'; // Ẩn vùng chứa nếu không có ảnh
        }
    }


</script>
@endsection
