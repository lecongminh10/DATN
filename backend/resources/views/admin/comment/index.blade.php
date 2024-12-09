@extends('admin.layouts.app')

@section('title')
    Danh Sách Bình Luận
@endsection

@section('style_css')
    {{-- Thêm style nếu cần --}}
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Bình luận',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Bình luận', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="mb-sm-0">Danh sách bình luận</h4>
                        </div>
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm d-flex justify-content-end">
                                        <form action="{{ route('admin.comment.index') }}" method="GET" class="d-flex">
                                            <!-- Lọc theo tên sản phẩm -->
                                            <div class="me-2">
                                                <input type="text" class="form-control" name="product_name"
                                                    placeholder="Tên sản phẩm" value="{{ request('product_name') }}"
                                                    style="max-width: 200px;">
                                            </div>
                                            <!-- Lọc theo ngày bắt đầu -->
                                            <div class="me-2">
                                                <input type="date" class="form-control" name="date_from"
                                                    value="{{ request('date_from') }}" style="max-width: 150px;">
                                            </div>
                                            <!-- Lọc theo ngày kết thúc -->
                                            <div class="me-2">
                                                <input type="date" class="form-control" name="date_to"
                                                    value="{{ request('date_to') }}" style="max-width: 150px;">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="padding: 0.2rem 0.5rem; font-size: 0.8rem; width: 90px;"><i class="ri-equalizer-fill fs-13 align-bottom me-1 "></i> Tìm</button>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Người dùng</th>
                                            <th scope="col">Sản phẩm</th>
                                            {{-- <th scope="col">Loại</th> --}}
                                            <th scope="col">Xếp hạng</th>
                                            <th scope="col">Nội dung</th>
                                            <th scope="col">Hình ảnh/Video</th>
                                            <th scope="col">Trả lời</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($comment as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->user->username }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                {{-- <td>
                                                    @if ($item->productVariant->attributeValues)
                                                        @foreach ($item->productVariant->attributeValues as $attributeValue)
                                                            <p class="attribute-item">
                                                                <strong>{{ $attributeValue->attribute->attribute_name }}:</strong>
                                                                <span>{{ $attributeValue->attribute_value }}</span>
                                                            </p>
                                                        @endforeach
                                                    @endif

                                                </td> --}}
                                                <td>{{ $item->rating }}</td>
                                                <td>{{ $item->review_text }}</td>
                                                <td>
                                                    @php
                                                        if (
                                                            $item->productVariant &&
                                                            !empty($item->productVariant->variant_image)
                                                        ) {
                                                            $url = $item->productVariant->variant_image;
                                                        } else {
                                                            $mainImage = $item->product->getMainImage();
                                                            $url = $mainImage
                                                                ? $mainImage->image_gallery
                                                                : 'default-image-path.jpg';
                                                        }
                                                    @endphp
                                                    <img src="{{ Storage::url($url) }}" alt="{{ $item->product->name }}"
                                                        width="100px" height="100px">


                                                </td>
                                                <td>
                                                    {{ $item->reply_text ?? 'Chưa trả lời' }}
                                                </td>
                                                <td>
                                                    <button data-bs-id="{{ $item->id }}" type="button"
                                                        class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">
                                                        Trả lời
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $comment->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận trả lời</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reply-form" action="" method="POST">
                        @csrf
                        <textarea class="form-control" name="reply_text" id="reply_text" placeholder="Nhập trả lời..." required></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="submit-reply">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_libray')
    <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Khi nhấn vào nút "Trả lời"
            $('[data-bs-toggle="modal"]').on('click', function() {
                var commentId = $(this).data('bs-id'); // Lấy ID của bình luận
                var formAction = '{{ route('admin.comment.reply', ':id') }}'; // Định dạng URL cho action
                formAction = formAction.replace(':id', commentId); // Thay thế :id với commentId

                // Cập nhật action của form
                $('#reply-form').attr('action', formAction);
            });

            // Khi nhấn nút "Xác nhận" trong modal
            $('#submit-reply').on('click', function() {
                var replyText = $('#reply_text').val(); // Lấy nội dung trả lời

                if (replyText) {
                    // Gửi form
                    $('#reply-form').submit();
                } else {
                    alert('Vui lòng nhập nội dung trả lời!');
                }
            });
        });
    </script>
@endsection
