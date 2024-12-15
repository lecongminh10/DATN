@extends('admin.layouts.app')

@section('title')
    Banner phụ
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
        height: 100px;
        border: 1px solid #ddd; /* Viền khung */
        border-radius: 5px; /* Bo góc */
        background-size: cover; /* Ảnh vừa khung */
        background-position: center; /* Ảnh căn giữa */
        display: none; /* Ẩn khung trước khi chọn tệp */
        
    }

    /* .preview-container .img{
        filter: blur(20px); Làm mờ ảnh với độ mờ 5px
    } */

    .banner{
        display: flex;
        justify-content: space-around;
    }

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
                'title' => 'Quản lý Banner Phụ',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Banner Phụ', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Quản lý Banner Phụ</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.banner.banner_extra_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="banner gap-3">
                                    <!-- Image 1 -->
                                    <div class="mb-3">
                                        <label for="image_1" class="form-label">Ảnh banner 1</label>
                                        <br>
                                        <div class="mt-3 mb-3">
                                            <label for="image-old">Ảnh cũ</label>
                                            <br>
                                            @if($bannerExtra && $bannerExtra->image_1)
                                                <img src="{{ Storage::url($bannerExtra->image_1) }}" class="img-fluid" style="width: 150px; height: 100px;  border-radius: 5px">
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary custom-file-button" onclick="document.getElementById('image_1').click()">Chọn tệp</button>
                                        <input type="file" name="image_1" id="image_1" class="d-none" accept="image/*" onchange="previewImageAsBackground(event, 'preview-container-1')">
                                        <div id="preview-container-1" class="preview-container mt-3"> </div>
                                    </div>
                                
                                    <!-- Image 2 -->
                                    <div class="mb-3">
                                        <label for="image_2" class="form-label">Ảnh banner 2</label>
                                        <br>
                                        <div class="mt-3 mb-3">
                                            <label for="image-old">Ảnh cũ</label>
                                            <br>
                                            @if($bannerExtra && $bannerExtra->image_2)
                                                <img src="{{ Storage::url($bannerExtra->image_2) }}" class="img-fluid" style="width: 150px; height: 100px;  border-radius: 5px">
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary custom-file-button" onclick="document.getElementById('image_2').click()">Chọn tệp</button>
                                        <input type="file" name="image_2" id="image_2" class="d-none" accept="image/*" onchange="previewImageAsBackground(event, 'preview-container-2')">
                                        <div id="preview-container-2" class="preview-container mt-3"> </div>
                                    </div>
                                
                                    <!-- Image 3 -->
                                    <div class="mb-3">
                                        <label for="image_3" class="form-label">Ảnh banner 3</label>
                                        <br>
                                        <div class="mt-3 mb-3">
                                            <label for="image-old">Ảnh cũ</label>
                                            <br>
                                            @if($bannerExtra && $bannerExtra->image_3)
                                                <img src="{{ Storage::url($bannerExtra->image_3) }}" class="img-fluid" style="width: 150px; height: 100px;  border-radius: 5px">
                                            @endif 
                                        </div>
                                        <button type="button" class="btn btn-primary custom-file-button" onclick="document.getElementById('image_3').click()">Chọn tệp</button>
                                        <input type="file" name="image_3" id="image_3" class="d-none" accept="image/*" onchange="previewImageAsBackground(event, 'preview-container-3')">
                                        <div id="preview-container-3" class="preview-container mt-3"> </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <!-- Title 1 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="title_1" class="form-label">Tiêu đề 1</label>
                                        <input type="text" name="title_1" id="title_1" class="form-control" value="{{ $bannerExtra->title_1 ?? '' }}">
                                    </div>
                                    
                                    <!-- Title 2 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="title_2" class="form-label">Tiêu đề 2</label>
                                        <input type="text" name="title_2" id="title_2" class="form-control" value="{{ $bannerExtra->title_2 ?? '' }}">
                                    </div>
                                    
                                    <!-- Title 3 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="title_3" class="form-label">Tiêu đề 3</label>
                                        <input type="text" name="title_3" id="title_3" class="form-control" value="{{ $bannerExtra->title_3 ?? '' }}">
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <!-- Price 1 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="price_1" class="form-label">Giá 1</label>
                                        <input type="text" name="price_1" id="price_1" class="form-control" value="{{ $bannerExtra->price_1 ?? '' }}">
                                    </div>
                            
                                    <!-- Price 2 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="price_2" class="form-label">Giá 2</label>
                                        <input type="text" name="price_2" id="price_2" class="form-control" value="{{ $bannerExtra->price_2 ?? '' }}">
                                    </div>
                            
                                    <!-- Price 3 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="price_3" class="form-label">Giá 3</label>
                                        <input type="text" name="price_3" id="price_3" class="form-control" value="{{ $bannerExtra->price_3 ?? '' }}">
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <!-- Title Button 1 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="title_button_1" class="form-label">Tiêu đề nút 1</label>
                                        <input type="text" name="title_button_1" id="title_button_1" class="form-control" value="{{ $bannerExtra->title_button_1 ?? '' }}">
                                    </div>
                                    
                                    <!-- Title Button 2 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="title_button_2" class="form-label">Tiêu đề nút 2</label>
                                        <input type="text" name="title_button_2" id="title_button_2" class="form-control" value="{{ $bannerExtra->title_button_2 ?? '' }}">
                                    </div>
                                    
                                    <!-- Title Button 3 -->
                                    <div class="col-md-4 mb-3">
                                        <label for="title_button_3" class="form-label">Tiêu đề nút 3</label>
                                        <input type="text" name="title_button_3" id="title_button_3" class="form-control" value="{{ $bannerExtra->title_button_3 ?? '' }}">
                                    </div>
                                </div>
                            
                                <!-- Active Checkbox -->
                                <div class="form-group">
                                    <label for="active">Kích Hoạt</label>
                                    <input type="checkbox" name="active" id="active" {{ !empty($bannerExtra->active) ? 'checked' : '' }}>
                                </div>
                            
                                <button type="submit" class="btn btn-success">Cập nhật</button>
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
