@extends('admin.layouts.app')

@section('title')
    Danh sách sản phẩm
@endsection
@section('style_css')
    <style>
        .description {
            display: block;
            max-height: 100px;
            overflow-y: auto;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Danh mục ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Danh mục', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="mb-sm-0">Danh mục </h4>
                        </div>

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                                                <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                            </a>
                                            <button type="button" class="btn btn-soft-danger" id="delete-selected">
                                                <i class="ri-delete-bin-2-line"></i>
                                            </button>
                                            <a href="{{ route('admin.categories.trashed') }}" class="btn btn-warning">
                                                <i class="ri-delete-bin-5-line align-bottom me-1"></i> Thùng rác
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm d-flex justify-content-end">
                                        <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex"
                                            id="search-form">
                                            <select name="parent_id" class="form-control me-2" style="max-width: 150px;"
                                                onchange="this.form.submit()">
                                                <option value="">-- Chọn Danh Mục Cha --</option>
                                                @foreach ($parentCategories as $parent)
                                                    <option value="{{ $parent->id }}"
                                                        {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control me-2" name="search"
                                                placeholder="Tìm kiếm..." value="{{ request('search') }}" id="search-input"
                                                style="max-width: 150px;">
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Tìm kiếm</button>
                                        </form>
                                    </div>
                                </div><br>
                                <form action="{{ route('admin.categories.delete-multiple') }}" method="POST" id="delete-multiple-form">
    @csrf
    @method('DELETE')

   <table class="table table-bordered align-middle table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input type="checkbox" id="checkAll"></th>
                                                <!-- Checkbox tổng -->
                                                <th scope="col">ID</th>
                                                <th scope="col">Tên</th>
                                                <th scope="col">Mô tả</th>
                                                 <th scope="col">Ảnh</th>
                                                <th scope="col">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parentCategories as $category)
                                                @include('admin.categories.partials.category-row', [
                                                    'category' => $category,
                                                    'level' => 0,
                                                ])
                                            @endforeach
                                        </tbody>
                                    </table>
</form>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $parentCategories->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.category-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

document.getElementById('delete-selected').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.category-checkbox:checked');
    const form = document.getElementById('delete-multiple-form');

    if (checkboxes.length === 0) {
        alert('Vui lòng chọn ít nhất một danh mục để xóa.');
        return;
    }

    if (confirm('Bạn có chắc chắn muốn xóa các danh mục đã chọn?')) {
        form.submit();
    }
});
        </script>
    @endsection
    @section('script_libray')
        <!-- prismjs plugin -->
        <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>
    @endsection
