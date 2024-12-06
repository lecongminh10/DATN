@extends('admin.layouts.app')

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
                                        <h5 class="card-title mb-0">Thêm Thẻ </h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button type="button" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Nhập</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="create-carrier-form" method="POST" action="{{ route('admin.tags.store') }}"
                            autocomplete="off" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="carrier-name-input">Tên</label>
                                            <input type="text" class="form-control" id="carrier-name-input"
                                                name="name" placeholder="Nhập tên thẻ" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-end me-3 mb-3">
                                        <button type="submit" class="btn btn-success w-sm"><i
                                                class="ri-check-double-line me-2"></i>Gửi</button>
                                        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary btn w-sm">
                                            <i class="ri-arrow-left-line"></i> Quay lại
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
