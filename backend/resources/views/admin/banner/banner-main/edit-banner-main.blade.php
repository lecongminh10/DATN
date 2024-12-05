@extends('admin.layouts.app')

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
                'title' => 'Quản lý Banner Main',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Sửa Banner Main', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Quản lý Banner Main</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.banner.banner_main_update', $bannerMain->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST') <!-- Hoặc PUT nếu bạn muốn sử dụng PUT -->
                                
                                <!-- Các trường thông tin -->
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $bannerMain->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="sub_title">Phụ đề</label>
                                    <input type="text" name="sub_title" id="sub_title" class="form-control" value="{{ old('sub_title', $bannerMain->sub_title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">Giá</label>
                                    <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $bannerMain->price) }} ">
                                </div>
                                <div class="form-group">
                                    <label for="title_button">Tiêu đề nút</label>
                                    <input type="text" name="title_button" id="title_button" class="form-control" value="{{ old('title_button', $bannerMain->title_button) }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Ảnh</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    <img src="{{Storage::url($bannerMain->image)}}" class="mt-3 mb-3" style="width: 80px;height: 80px; border-radius: 5px" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="active">Hiển thị</label>
                                    <input type="checkbox" name="active" id="active" {{ $bannerMain->active ? 'checked' : '' }}>
                                </div>
                                <a href="{{ route('admin.banner.list_banner_main') }}" class="btn btn-success">Quay lại</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                // container.style.height = '200px'; // Đặt chiều cao cho vùng chứa ảnh
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
