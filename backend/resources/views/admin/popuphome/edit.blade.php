@extends('admin.layouts.app')

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
                                    <input type="file" name="image" id="image" class="form-control"
                                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="1">
                                    @if ($popuphome->image)
                                        <img src="{{ Storage::url($popuphome->image) }}" width="50" height="50"
                                            alt="Current Image" style="margin-top: 10px;">
                                    @endif
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="active">Kích Hoạt</label>
                                    <input type="checkbox" name="active" id="active"
                                        {{ $popuphome->active ? 'checked' : '' }}>
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
