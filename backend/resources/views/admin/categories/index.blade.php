@extends('admin.layouts.app')

@section('title')
    Danh Sách Danh Mục
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

        .toggle-subcategories {
    cursor: pointer;
    margin-left: 10px;
}

.toggle-subcategories i {
    transition: transform 0.3s;
}

.toggle-subcategories[aria-expanded="true"] i {
    transform: rotate(90deg); /* Xoay mũi tên khi mở rộng */
}

/* Tên danh mục con */
.child-prefix {
    color: #000; 
    margin-right: 5px;
}

.child-name {
    color: #007bff; 
    font-weight: 500;
}
.subchild-name {
    color: green; 
    font-weight: 500;
}

.collapse td {
    border-top: 1px solid #ddd;
    background-color: #f9f9f9;

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
                            @if (session('success'))
                                <div class="w-full alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="live-preview">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success me-2">
                                                <i class="ri-add-line align-bottom"></i> Thêm mới
                                            </a>
                                            <a href="{{ route('admin.categories.trashed') }}" class="btn btn-warning me-2">
                                                <i class="ri-delete-bin-5-line align-bottom"></i> Thùng rác
                                            </a>
                                            <button type="button" class="btn btn-soft-danger" id="delete-selected">
                                                <i class="ri-delete-bin-2-line align-bottom"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm d-flex justify-content-end">
                                        <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex"
                                            id="search-form">
                                            <input type="text" class="form-control me-2" name="search"
                                                placeholder="Tìm kiếm..." value="{{ request('search') }}" id="search-input"
                                                style="">
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="padding: 0.2rem 0.5rem; font-size: 0.8rem; width: 80px;"><i class="ri-equalizer-fill fs-13 align-bottom w-sm"></i> Tìm</button>
                                        </form>
                                    </div>
                                </div><br>
                                <form action="{{ route('admin.categories.delete-multiple') }}" method="POST" id="delete-multiple-form">
                                    @csrf
                                    @method('DELETE')
                                    <table class="table table-bordered align-middle table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input type="checkbox" id="checkAll"></th> <!-- Checkbox tổng -->
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên</th>
                                                <th scope="col">Mô tả</th>
                                                <th scope="col">Trạng thái</th>
                                                <th scope="col">Ảnh</th>
                                                <th scope="col">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $category)
                                                @include('admin.categories.partials.category-row', [
                                                    'category' => $category,
                                                    'level' => 0,
                                                    'parentId' => null,
                                                ])
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $data->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Xóa Nhiều Danh Mục -->
        <div class="modal fade" id="deleteMultipleCategoriesModal" tabindex="-1" aria-labelledby="deleteMultipleCategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMultipleCategoriesModalLabel">Xóa Danh Mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa các danh mục đã chọn ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete-multiple-categories">Xóa</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Cảnh Báo -->
        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-warning" id="warningModalLabel">Cảnh Báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vui lòng chọn ít nhất một danh mục để xóa.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <script>


        // Xóa nhiều danh mục
        document.addEventListener('DOMContentLoaded', function () {
            // Xử lý "Check All"
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.category-checkbox');

            checkAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        checkAll.checked = false;
                    } else if (Array.from(checkboxes).every(cb => cb.checked)) {
                        checkAll.checked = true;
                    }
                });
            });

            // Xóa nhiều danh mục
            document.getElementById('delete-selected').addEventListener('click', function () {
                const selectedCheckboxes = document.querySelectorAll('.category-checkbox:checked');
                if (selectedCheckboxes.length === 0) {
                    // Mở modal cảnh báo
                    new bootstrap.Modal(document.getElementById('warningModal')).show();
                    return;
                }

                // Mở modal xác nhận xóa
                const confirmButton = document.getElementById('confirm-delete-multiple-categories');
                confirmButton.onclick = function () {
                    const form = document.getElementById('delete-multiple-form');
                    form.submit(); // Gửi form để xóa các danh mục đã chọn
                };

                // Hiển thị modal xác nhận
                new bootstrap.Modal(document.getElementById('deleteMultipleCategoriesModal')).show();
            });
        });

        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Lấy tất cả các nút Xóa
                const deleteButtons = document.querySelectorAll('.delete-category-button');
                const deleteForm = document.getElementById('delete-category-form');
                const confirmDeleteButton = document.getElementById('confirm-delete-category');
        
                let selectedCategoryId = null;
        
                // Khi nhấn nút Xóa
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        selectedCategoryId = this.getAttribute('data-category-id');
                        const deleteUrl = `{{ route('admin.categories.destroy', ':id') }}`.replace(':id', selectedCategoryId);
                        deleteForm.setAttribute('action', deleteUrl);
                    });
                });
        
                // Khi xác nhận xóa
                confirmDeleteButton.addEventListener('click', function () {
                    if (selectedCategoryId) {
                        deleteForm.submit();
                    }
                });
            });
        </script>
        
    @endsection
    @section('script_libray')
        <!-- prismjs plugin -->
        <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>
    @endsection
