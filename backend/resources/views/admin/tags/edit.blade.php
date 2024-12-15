@extends('admin.layouts.app')

@section('title')
    Cập Nhật Thẻ
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Thẻ ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Thẻ', 'url' => '#']
                ]
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Cập nhật thẻ </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="create-carrier-form" method="POST" action="{{ route('admin.tags.update',$tags->id) }}"
                            autocomplete="off" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <div class="mb-1">
                                            <label class="form-label" for="carrier-name-input">Tên</label>
                                            <input type="text" class="form-control" id="carrier-name-input"
                                                name="name" placeholder="Nhập tên thẻ" value="{{$tags->name}}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-start ms-3 mb-3">
                                        <button type="submit" class="btn btn-success w-sm me-2">Cập nhật</button>
                                        <a href="{{ route('admin.tags.index') }}" class="btn btn-primary btn w-sm">Quay lại
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
