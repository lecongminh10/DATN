@extends('admin.layouts.app')
@section('title')
    Cập nhật seo
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Seo ',
                'breadcrumb' => [
                    ['name' => 'Seo', 'url' => 'javascript: void(0);'],
                    ['name' => 'Chỉnh sửa Seo', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Chỉnh sửa Seo </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="edit-seo-form" method="POST" action="{{ route('admin.seo.update', $seo->id) }}" autocomplete="off" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT') 

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <!-- Meta Title -->
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-title-input">Tiêu đề meta</label>
                                            <input type="text" class="form-control" id="meta-title-input"
                                                name="meta_title" placeholder="Nhập Meta Title"
                                                value="{{ old('meta_title', $seo->meta_title) }}">
                                            @error('meta_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-description-input">Mô tả Meta</label>
                                            <textarea class="form-control" id="meta-description-input" name="meta_description" rows="3" placeholder="Nhập Meta Description">{{ old('meta_description', $seo->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Meta Keywords -->
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Từ khóa meta</label>
                                            <input type="text" class="form-control" id="meta-keywords-input"
                                                name="meta_keywords" placeholder="Nhập Meta Keywords"
                                                value="{{ old('meta_keywords', $seo->meta_keywords) }}">
                                            @error('meta_keywords')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Canonical URL -->
                                        <div class="mb-3">
                                            <label class="form-label" for="canonical-url-input">URL chuẩn</label>
                                            <input type="text" class="form-control" id="canonical-url-input"
                                                name="canonical_url" placeholder="Nhập Canonical URL"
                                                value="{{ old('canonical_url', $seo->canonical_url) }}">
                                            @error('canonical_url')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Chọn Product ID -->
                                        <div class="mb-3">
                                            <label class="form-label  text-muted" for="choices-multiple-remove-butto">Sản phẩm</label>
                                            <select placeholder="This is a placeholder" multiple class="form-control" id="choices-multiple-remove-butto" name="product_id[]">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ in_array($product->id, old('product_id', $seo->products->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Trạng thái -->
                                        <div class="mb-3">
                                            <label class="form-label" for="status">Trạng thái</label>
                                            <select name="is_active" class="form-control">
                                                <option value="1" {{ old('is_active', $seo->is_active) == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                                <option value="0" {{ old('is_active', $seo->is_active) == 0 ? 'selected' : '' }}>Không kích hoạt</option>
                                            </select>
                                            @error('is_active')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="text-start  mb-3">
                                            <button type="submit" class="btn btn-success w-sm me-2">Cập nhật
                                            </button>
                                            <a href="{{ route('admin.seo.index') }}" class="btn btn-primary w-sm">Quay lại
                                            </a>
                                        </div>
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




