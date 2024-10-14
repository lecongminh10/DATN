@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="mb-sm-0">Danh Sách Danh Mục Đã Xóa</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form id="delete-multiple-form" action="{{ route('categories.trashed.hardDeleteMultiple') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <a href="{{ route('categories.index') }}" class="btn btn-primary">
                                            <i class="ri-arrow-left-line align-bottom me-1"></i> Quay lại
                                        </a>
                                        <button type="button" id="restore-selected" class="btn btn-success ms-2" title="Khôi phục đã chọn">
                                            <i class="ri-undo-fill"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm d-flex justify-content-end">
                                        <form action="{{ route('categories.trashed.search') }}" method="GET" class="d-flex" id="search-form">
                                            <input type="text" class="form-control me-2" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}" id="search-input" style="max-width: 150px;">
                                            <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                                        </form>
                                    </div>
                                </div><br>
                                <table class="table table-bordered align-middle table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Is Active</th>
                                            <th>Deleted At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trashedCategories as $category)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="category-checkbox" name="categories[]" value="{{ $category->id }}">
                                            </td>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td class="text-center">  <!-- Căn giữa nội dung -->
                                                <div style="width: 50px; height: 50px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                    <img src="{{ Storage::url($category->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                {!! $category->is_active ? '<span class="badge bg-success"> Hoạt động </span>' : '<span class="badge bg-danger"> Không hoạt động </span>' !!}
                                            </td>
                                            <td>{{ $category->deleted_at }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <form action="{{ route('categories.restore', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục danh mục này?');">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('categories.hard-delete', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cứng danh mục này?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Xóa cứng</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $trashedCategories->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" id="delete-selected" class="btn btn-danger">Xóa cứng đã chọn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.getElementById('restore-selected').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox:checked');
            const form = document.getElementById('delete-multiple-form');

            if (checkboxes.length === 0) {
                alert('Vui lòng chọn ít nhất một danh mục để khôi phục.');
                return;
            }

            if (confirm('Bạn có chắc chắn muốn khôi phục các danh mục đã chọn?')) {
                form.action = "{{ route('categories.trashed.restoreMultiple') }}"; // Thay đổi URL hành động cho khôi phục
                form.submit();
            }
        });

        document.getElementById('delete-selected').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox:checked');

            if (checkboxes.length === 0) {
                alert('Vui lòng chọn ít nhất một danh mục để xóa cứng.');
                return;
            }

            if (confirm('Bạn có chắc chắn muốn xóa cứng các danh mục đã chọn?')) {
                // Thay đổi hành động của form cho xóa cứng
                document.getElementById('delete-multiple-form').submit();
            }
        });
    </script>
</div>
@endsection