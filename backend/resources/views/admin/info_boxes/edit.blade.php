@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Quản lý Info Boxes',
                'breadcrumb' => [
                    ['name' => 'Giao diện người dùng', 'url' => 'javascript: void(0);'],
                    ['name' => 'Info Boxes', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Quản lý Info Boxes</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.info_boxes.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title1" class="form-label">Tiêu đề 1</label>
                                    <input type="text" name="title1" id="title1"
                                        class="form-control" value="{{ $infoBox->title1 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="title2" class="form-label">Tiêu đề 2</label>
                                    <input type="text" name="title2" id="title2"
                                        class="form-control" value="{{ $infoBox->title2 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="title3" class="form-label">Tiêu đề 3</label>
                                    <input type="text" name="title3" id="title3"
                                        class="form-control" value="{{ $infoBox->title3 ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description_shopping" class="form-label">Mô tả 1</label>
                                    <input type="text" name="description_shopping" id="description_shopping"
                                        class="form-control" value="{{ $infoBox->description_shopping ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="description_money" class="form-label">Mô tả 2</label>
                                    <input type="text" name="description_money" id="description_money"
                                        class="form-control" value="{{ $infoBox->description_money ?? '' }}">
                                </div>

                                <div class="mb-3"></div>
                                <label for="description_support" class="form-label">Mô tả 3</label>
                                <input type="text" name="description_support" id="description_support"
                                    class="form-control" value="{{ $infoBox->description_support ?? '' }}">
                        </div>
                        <div class="form-group" style="margin-left: 16px">
                            <label for="active">Kích Hoạt</label>
                            <input type="checkbox" name="active" id="active"
                                {{ $infoBox->active ? 'checked' : '' }}>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật Info Boxes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
