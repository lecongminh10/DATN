@extends('admin.layouts.app')

@section('title')
    Hộp thông tin footer
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Quản lý Info Boxes Footer',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Info Boxes Footer', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Quản lý Info Boxes Footer</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.info_boxes_footer.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title_1" class="form-label">Tiêu đề 1</label>
                                    <input type="text" name="title_1" id="title_1"
                                        class="form-control" value="{{ $infoBoxFooter->title_1 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="title_2" class="form-label">Tiêu đề 2</label>
                                    <input type="text" name="title_2" id="title_2"
                                        class="form-control" value="{{ $infoBoxFooter->title_2 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="title_3" class="form-label">Tiêu đề 3</label>
                                    <input type="text" name="title_3" id="title_3"
                                        class="form-control" value="{{ $infoBoxFooter->title_3 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="sub_title_1" class="form-label">Phụ đề 1</label>
                                    <input type="text" name="sub_title_1" id="sub_title_1"
                                        class="form-control" value="{{ $infoBoxFooter->sub_title_1 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="sub_title_2" class="form-label">Phụ đề 2</label>
                                    <input type="text" name="sub_title_2" id="sub_title_2"
                                        class="form-control" value="{{ $infoBoxFooter->sub_title_2 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="sub_title_3" class="form-label">Phụ đề 3</label>
                                    <input type="text" name="sub_title_3" id="sub_title_3"
                                        class="form-control" value="{{ $infoBoxFooter->sub_title_3 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description_support" class="form-label">Mô tả 1</label>
                                    <input type="text" name="description_support" id="description_support"
                                        class="form-control" value="{{ $infoBoxFooter->description_support ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="description_payment" class="form-label">Mô tả 2</label>
                                    <input type="text" name="description_payment" id="description_payment"
                                        class="form-control" value="{{ $infoBoxFooter->description_payment ?? '' }}">
                                </div>

                                <div class="mb-3"></div>
                                <label for="description_return" class="form-label">Mô tả 3</label>
                                <input type="text" name="description_return" id="description_return"
                                    class="form-control" value="{{ $infoBoxFooter->description_return ?? '' }}">
                        </div>
                        <div class="form-group" style="margin-left: 16px">
                            <label for="active">Kích Hoạt</label>
                            <input type="checkbox" name="active" id="active" {{ !empty($infoBoxFooter->active) ? 'checked' : '' }}>
                        </div>
                        <div class="button ms-3 mb-4">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
