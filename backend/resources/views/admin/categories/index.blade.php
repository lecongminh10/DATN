@extends('admin.layouts.app')

@section('title')
    Danh sách sản phẩm
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="mb-sm-0">List Category</h4>
            </div><!-- end card header -->
    
            <div class="card-body">
                <div class="live-preview">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('categories.create') }}" class="btn btn-success">
                                    <i class="ri-add-line align-bottom me-1"></i> Add New
                                </a>
                                <button type="button" class="btn btn-soft-danger" id="delete-selected">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                <a href="{{ route('categories.trashed') }}" class="btn btn-warning">
                                    <i class="ri-delete-bin-5-line align-bottom me-1"></i> Thùng Rác
                                </a>
                            </div>
                        </div>
                        <div class="col-sm d-flex justify-content-end">
                            <form action="{{ route('categories.index') }}" method="GET" class="d-flex" id="search-form">
                                <input type="text" class="form-control me-2" name="search" placeholder="Search..." value="{{ request('search') }}" id="search-input" style="max-width: 150px;"> <!-- Thay đổi max-width -->
                                <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Tìm kiếm</button> <!-- Nút tìm kiếm nhỏ hơn -->
                            </form>
                        </div>
                    </div><br>
                    <form action="{{ route('categories.delete-multiple') }}" method="POST" id="delete-multiple-form">
                        @csrf
                        @method('DELETE')
                        <table class="table table-bordered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Is Active</th>
                                    <th scope="col">Action</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input category-checkbox" type="checkbox" name="categories[]" value="{{ $item->id }}" id="cardtableCheck{{ $item->id }}">
                                            <label class="form-check-label" for="cardtableCheck{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-center">  <!-- Căn giữa nội dung -->
                                        <div style="width: 50px; height: 50px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                            <img src="{{ Storage::url($item->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                                        </div>
                                    </td>
                                    <td>
                                        {!! $item->is_active ? '<span class="badge bg-success"> Hoạt động </span>' : '<span class="badge bg-danger"> Không hoạt động </span>' !!}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a href="{{ route('categories.show', $item->id) }}" class="dropdown-item">View</a></li>
                                                <li><a class="dropdown-item" href="{{ route('categories.edit', $item->id) }}">Edit</a></li>
                                                <li>
                                                    <form class="dropdown-item" action="{{ route('categories.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>     
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    <!-- Phân trang -->
                <!-- Phân trang -->
<div class="d-flex justify-content-center mt-3">
    {{ $data->links('vendor.pagination.bootstrap-5') }} <!-- Sử dụng view phân trang tùy chỉnh -->
</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
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

    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    let timeout = null;
    const searchInput = document.getElementById('search-input');

    searchInput.addEventListener('input', function() {
        clearTimeout(timeout); // Xóa timeout cũ nếu có
        timeout = setTimeout(() => {
            document.getElementById('search-form').submit(); // Gửi form sau thời gian trì hoãn
        }, 500); // Thay đổi thời gian ở đây (500ms)
    });
</script>
@endsection
@section('script_libray')
        <!-- prismjs plugin -->
        <script src="{{asset('theme/assets/libs/prismjs/prism.js')}}"></script>

@endsection
