@extends('admin.layouts.app')

@section('title')
    Popuphome
@endsection
@section('style_css')
    <style>
        .image{
            margin-top: 10px; 
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Popuphome',
                'breadcrumb' => [['name' => 'Quản lí', 'url' => 'javascript: void(0);'], ['name' => 'Popuphome', 'url' => '#']],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-4">Quản lý Popuphome</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.popuphome.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề </label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ $popuphome->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        value="{{ $popuphome->description ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Hình nền</label>
                                    <br>
                                    @if ($popuphome && $popuphome->image)
                                        <img src="{{ Storage::url($popuphome->image) }}" width="100" height="100"
                                                alt="Current Image" class="mb-3 image">
                                    @else
                                        Không có ảnh
                                    @endif
                                    
                                    <input type="file" name="image" id="image" class="form-control"
                                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="1">
                                   
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="active">Kích Hoạt</label>
                                    <input type="checkbox" name="active" id="active"
                                    {{ isset($popuphome) && $popuphome->active ? 'checked' : '' }}>
                                </div>
                                <div class="button mb-2">
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
