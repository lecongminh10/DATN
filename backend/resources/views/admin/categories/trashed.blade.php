@extends('admin.layouts.app')

@section('title')
   Thùng Rác
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
                            <h4 class="mb-sm-0">Thùng rác</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            @if (session('success'))
                                <div class="w-full alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="live-preview">
                                    <div class="table-responsive" style="overflow-x:unset;">
                                        <div class="row g-4 mb-3">
                                            <div class="col-sm-auto">
                                                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quay lại</a>
                                                <button type="button" id="restore-selected" class="btn btn-success ms-2">
                                                    Khôi phục
                                                </button>
                                            </div>
                                            <div class="col-sm d-flex justify-content-end">
                                                <form action="{{ route('admin.categories.trashed') }}" method="GET" class="d-flex" id="search-form">
                                                    <input type="text" class="form-control me-2" name="search"
                                                        placeholder="Tìm kiếm..." value="{{ request('search') }}" id="search-input"
                                                        style="width: 230px">
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        style="padding: 0.2rem 0.5rem; font-size: 0.8rem; width: 80px;">
                                                        <i class="ri-equalizer-fill fs-13 align-bottom w-sm"></i> Tìm
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                <form id="delete-multiple-form"
                                    action="{{ route('admin.categories.trashed.hardDeleteMultiple') }}" method="POST">
                                    @csrf
                                        <table class="table table-bordered align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="select-all"></th>
                                                    <th>STT</th>
                                                    <th>Tên danh mục</th>
                                                    <th>Mô tả</th>
                                                    <th>Ảnh</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày xóa</th>
                                                    <th>Người xóa</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($trashedCategories->isEmpty())
                                                    <tr>
                                                        <td colspan="9" class="text-center">Không tìm thấy danh mục nào phù hợp.</td>
                                                    </tr>
                                                @else
                                                    @foreach ($trashedCategories as $index => $category)
                                                        <tr>
                                                            <td><input type="checkbox" class="category-checkbox" name="categories[]" value="{{ $category->id }}"></td>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $category->name }}</td>
                                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                <span class="description">{{ $category->description }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div style="width: 50px; height: 50px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ Storage::url($category->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle" style="width:70px ; font-size:13px">
                                                                @if ($category->is_active == 1)
                                                                    <span class="badge text-bg-success">Kích hoạt</span>
                                                                @else
                                                                    <span class="badge text-bg-danger">Không kích hoạt</span>
                                                                @endif
                                                            </td>
                                                            <td style="width: 170px">
                                                                {{ $category->deleted_at->format('H:i d-m-Y') }}
                                                            </td>
                                                            <td style="width: 170px">
                                                                {{ $category->deletedByUser?->username }}
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="ri-more-2-fill"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <li>
                                                                            <button type="button" class="dropdown-item restore-category-button" data-bs-toggle="modal" data-bs-target="#reStoreModal" data-category-id="{{ $category->id }}">
                                                                                Khôi phục
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <button type="button" class="dropdown-item delete-category-button text-danger" data-bs-toggle="modal" data-bs-target="#deleteHardModal" data-category-id="{{ $category->id }}">
                                                                                Xóa
                                                                            </button>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $trashedCategories->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" id="delete-selected" class="btn btn-danger">Xóa </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal khôi phục -->
        <div class="modal fade" id="reStoreModal" tabindex="-1" aria-labelledby="reStoreModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reStoreModalLabel">Khôi phục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn khôi phục danh mục này ?
                        <form id="restore-category-form" method="POST">
                            @csrf
                            @method('PATCH')
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" id="confirm-restore-category">Khôi phục</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal khôi phục nhiều -->
        <div class="modal fade" id="reStoreManyModal" tabindex="-1" aria-labelledby="reStoreManyLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reStoreManyLabel">Khôi phục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn khôi phục các danh mục này?
                        <form action="{{ route('admin.categories.trashed.restoreMultiple') }}" method="POST" id="restore-many-category-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="categories" id="restore-categories-input">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" id="confirm-restore-many-category">Khôi phục</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- Xóa 1 danh mục --}}
        <div class="modal fade" id="deleteHardModal" tabindex="-1" aria-labelledby="deleteHardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteHardModalLabel">Xóa Danh Mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa danh mục này ?
                        <form id="delete-category-form" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete-category">Xóa</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Xóa nhiều danh mục --}}
        <div class="modal fade" id="deleteManyModal" tabindex="-1" aria-labelledby="deleteManyLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteManyLabel">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa các danh mục đã chọn?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal cảnh báo --}}
        <div class="modal fade" id="noSelectionModal" tabindex="-1" aria-labelledby="noSelectionLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-warning" id="noSelectionLabel">Cảnh báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vui lòng chọn ít nhất một danh mục để thực hiện.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection

@section('scripte_logic')
<script>

    // Tìm kiếm
    // document.addEventListener('DOMContentLoaded', function () {
    //     // Lấy nút tìm kiếm
    //     const searchButton = document.querySelector('#search-form button[type="submit"]');

    //     // Lắng nghe sự kiện click vào nút Tìm
    //     searchButton.addEventListener('click', function () {
    //         const searchForm = document.getElementById('search-form');
    //         searchForm.submit();
    //     });
    // });

    // Tích chọn tất cả
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });

        // Cập nhật lại giá trị của input ẩn khi select-all thay đổi
        const selectedCheckboxes = document.querySelectorAll('.category-checkbox:checked');
        const categoryIds = [];
        selectedCheckboxes.forEach(checkbox => {
            categoryIds.push(checkbox.value);
        });
        document.getElementById('restore-categories-input').value = categoryIds.join(',');
    });
    
    // Khôi phục 1 danh mục
    document.addEventListener('DOMContentLoaded', function () {
        const restoreButtons = document.querySelectorAll('.restore-category-button'); // Dùng chung cho nút khôi phục
        const restoreForm = document.getElementById('restore-category-form');
        const confirmRestoreButton = document.getElementById('confirm-restore-category');

        let selectedCategoryId = null;

        // Khi nhấn nút Khôi phục
        restoreButtons.forEach(button => {
            button.addEventListener('click', function () {
            selectedCategoryId = this.getAttribute('data-category-id');
            const restoreUrl = `{{ route('admin.categories.restore', ':id') }}`.replace(':id', selectedCategoryId);
            restoreForm.setAttribute('action', restoreUrl);
            });
        });

        // Khi nhấn Xác nhận khôi phục
        confirmRestoreButton.addEventListener('click', function () {
           if (selectedCategoryId) {
               restoreForm.submit();
           }
        });
    });

    // Khôi phục nhiều
    document.getElementById('restore-selected').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.category-checkbox:checked');
        if (checkboxes.length === 0) {
            // Hiển thị modal cảnh báo nếu không có danh mục nào được chọn
            const warningModal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
            warningModal.show();
        } else {
            // Hiển thị modal xác nhận nếu đã có danh mục được chọn
            const restoreModal = new bootstrap.Modal(document.getElementById('reStoreManyModal'));
            restoreModal.show();

            // Đặt giá trị cho input ẩn chứa các category ID
            const categoryIds = [];
            checkboxes.forEach(checkbox => {
                categoryIds.push(checkbox.value);
            });

            // console.log(categoryIds);

            // Điền vào input ẩn
            document.getElementById('restore-categories-input').value = categoryIds.join(',');
            console.log(categoryIds);
        }
    });

    // Xử lý khi người dùng nhấn "Khôi phục" trong modal xác nhận
    document.getElementById('confirm-restore-many-category').addEventListener('click', function () {
        const form = document.getElementById('restore-many-category-form');
        form.submit(); // Submit form chính xác
    });

    // Xóa cứng
    // Xóa cứng 1 danh mục
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
                const deleteUrl = `{{ route('admin.categories.hard-delete', ':id') }}`.replace(':id', selectedCategoryId);
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


    // Xóa cứng nhiều
    document.getElementById('delete-selected').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.category-checkbox:checked');
        if (checkboxes.length === 0) {
            // Hiển thị modal cảnh báo
            const noSelectionModal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
            noSelectionModal.show();
        } else {
            // Hiển thị modal xác nhận xóa
            const deleteManyModal = new bootstrap.Modal(document.getElementById('deleteManyModal'));
            deleteManyModal.show();
        }
    });
    // Xác nhận xóa nhiều
    document.getElementById('confirm-delete').addEventListener('click', function () {
        document.getElementById('delete-multiple-form').submit();
    });
</script>
@endsection
