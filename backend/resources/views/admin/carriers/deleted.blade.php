@extends('admin.layouts.app')

@section('title')
    Thùng Rác
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Vận chuyển ',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Vận chuyển', 'url' => '#']
                ]
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                            <div id="customerList">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title mb-0 "><a class="text-dark"
                                                        href="{{ route('admin.carriers.deleted') }}">Thùng rác</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('admin.carriers.deleted') }}">
                                        <div class="row g-3">
                                            <!-- Tìm kiếm -->
                                            <div class="col-xl-6 d-flex align-items-center">
                                                <div class="search-box col-5 me-3">
                                                    <input type="text" class="form-control search" name="search"
                                                           placeholder="Nhập từ khóa tìm kiếm..."
                                                           value="{{ request()->input('search') }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                                
                                                <!-- Lọc trạng thái -->
                                                <div class="col-4">
                                                    <select class="form-select" aria-label=".form-select-sm example" name="status">
                                                        <option value="" {{ request()->input('status') == '' ? 'selected' : '' }}>Tất cả</option>
                                                        <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                                        <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                                    </select>
                                                </div>
                                                
                                                <!-- Nút tìm kiếm -->
                                                <div class="col-3 ms-3">
                                                    <button type="submit" class="btn btn-primary w-sm">
                                                        <i class="ri-equalizer-fill me-2 align-bottom"></i>Tìm
                                                    </button>
                                                </div>
                                            </div>

                                            
                                            
                                            <!-- Quay lại -->
                                            <div class="col-xl-6 d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-soft-danger me-1" id="deleteMultipleBtn"
                                                    style="display: none;">
                                                    <i class="ri-delete-bin-5-fill align-bottom"></i>
                                                </button>
                                                {{-- <a href=""
                                                    class="btn btn-success">Khôi phục
                                                </a> --}}
                                                <a href="{{ route('admin.carriers.index') }}" class="btn btn-primary">Quay lại</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @if (session('success'))
                                    <div class="w-full alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div>
                                        <div class="table-responsive table-card mb-1">
                                            <table class="table align-middle" id="carriersTable">
                                                <thead class="table-light text-muted">
                                                    <tr>
                                                        <th scope="col" style="width: 50px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th>ID</th>
                                                        <th data-sort="carrier_name">Tên nhà vận chuyển</th>
                                                        <th data-sort="api_url">API URL</th>
                                                        <th data-sort="api_token" style="width: 0px;">API Token</th>
                                                        <th data-sort="phone">Số điện thoại</th>
                                                        <th data-sort="email">Email</th>
                                                        <th data-sort="is_active">Trạng thái</th>
                                                        <th data-sort="action">Hành động</th>
                                                    </tr>
                                                </thead>
                                                @foreach ($data as $key => $item)
                                                    <tbody class="list form-check-all">
                                                        <tr>
                                                            <th scope="row">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $item->id }}">
                                                                </div>
                                                            </th>
                                                            <td>{{ $key+1 }}</td>
                                                            <td class="carrier_name">{{ $item->name }}</td>
                                                            <td class="api_url">{{ $item->api_url }}</td>
                                                            <td class="api_token">{{ $item->api_token }}</td>
                                                            <td class="phone">{{ $item->phone }}</td>
                                                            <td class="email">{{ $item->email }}</td>
                                                            <td class="is_active">
                                                                @if ($item->is_active === 'active')
                                                                    <span class="badge bg-success-subtle text-success">Hoạt động</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">Không hoạt động</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button 
                                                                    class="btn btn-sm btn-info"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#restoreModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-name="{{ $item->name }}">
                                                                    <i class="ri-pencil-fill fs-13"></i> 
                                                                </button>
                                                                <button 
                                                                    class="btn btn-sm btn-danger"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#deleteModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-name="{{ $item->name }}">
                                                                    <i class="ri-delete-bin-5-fill fs-13"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                            <div class="results-info ms-3">
                                                <p class="pagination mb-0">
                                                    Showing
                                                    {{ $data->firstItem() }}
                                                    to
                                                    {{ $data->lastItem() }}
                                                    of
                                                    {{ $data->total() }}
                                                    results
                                                </p>
                                            </div>
                                            <div class="pagination-wrap me-3">
                                                <nav aria-label="Page navigation">
                                                    <ul class="pagination mb-0">
                                                        @if ($data->onFirstPage())
                                                            <li class="page-item disabled">
                                                                <span class="page-link">Previous</span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $data->previousPageUrl() }}"
                                                                    aria-label="Previous">
                                                                    Previous
                                                                </a>
                                                            </li>
                                                        @endif

                                                        @foreach ($data->links()->elements as $element)
                                                            @if (is_string($element))
                                                                <li class="page-item disabled">
                                                                    <span class="page-link">{{ $element }}</span>
                                                                </li>
                                                            @endif

                                                            @if (is_array($element))
                                                                @foreach ($element as $page => $url)
                                                                    @if ($page == $data->currentPage())
                                                                        <li class="page-item active">
                                                                            <span class="page-link">{{ $page }}</span>
                                                                        </li>
                                                                    @else
                                                                        <li class="page-item">
                                                                            <a class="page-link"
                                                                                href="{{ $url }}">{{ $page }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach

                                                        @if ($data->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $data->nextPageUrl() }}"
                                                                    aria-label="Next">
                                                                    Next
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li class="page-item disabled">
                                                                <span class="page-link">Next</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end row -->
    </div>
    </div>

    <!-- Modal Khôi phục -->
    <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreModalLabel">Khôi phục nhà vận chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="restoreMessage"> Bạn muốn khôi phục nhà vận chuyển này!</p>
                </div>
                <div class="modal-footer">
                    <form id="restoreForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa nhà vận chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage">Bạn muốn xóa nhà vận chuyển này!</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Xóa Nhiều -->
    <div class="modal fade" id="deleteMultipleModal" tabindex="-1" aria-labelledby="deleteMultipleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMultipleModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa vĩnh viễn các nhà vận chuyển đã chọn không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" id="confirmDeleteMultipleBtn" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    

@endsection
@section('script_libray')
    <!-- Nạp jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('scripte_logic')
    <script>
        // Bộ Lọc
        function filterData() {
            var status = document.getElementById('idStatus').value;
            var url = "{{ route('admin.carriers.deleted') }}";
            if (status) {
                url += `?status=${status}`;
            }
            window.location.href = url;
        }
    </script>
    <script>
        // Khôi phục
        document.addEventListener('DOMContentLoaded', function () {
            $('#restoreModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Nút kích hoạt modal
                var id = button.data('id');
                var name = button.data('name');

                var modal = $(this);
                var form = modal.find('#restoreForm');
                // var message = modal.find('#restoreMessage');

                // Thiết lập action form và thông báo
                form.attr('action', '/admin/carriers/restore/' + id);
                // message.text('Bạn có chắc muốn khôi phục nhà vận chuyển "' + name + '"?');
            });
        });

        // Xóa 1
        document.addEventListener('DOMContentLoaded', function () {
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Nút kích hoạt modal
                var id = button.data('id'); // Lấy ID từ thuộc tính data-id
                var name = button.data('name'); // Lấy tên từ thuộc tính data-name

                var modal = $(this);
                var form = modal.find('#deleteForm'); // Tìm form trong modal
                // var message = modal.find('#deleteMessage'); // Tìm thẻ hiển thị thông báo

                // Thiết lập action cho form
                var actionUrl = '/admin/carriers/' + id + '/hard-delete';
                form.attr('action', actionUrl);

                // Hiển thị thông báo xóa
                // message.text('Bạn có chắc chắn muốn xóa vĩnh viễn nhà vận chuyển "' + name + '"?');
            });
        });

        // Xóa nhiều
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
            const checkAll = document.getElementById('checkAll');
            const confirmDeleteMultipleBtn = document.getElementById('confirmDeleteMultipleBtn');

            // Kiểm tra checkbox và hiển thị/ẩn nút xóa nhiều
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'inline-block' : 'none';
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });

            // Thêm sự kiện cho checkbox "Chọn tất cả"
            checkAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'inline-block' : 'none';
            });

            // Hiển thị modal khi bấm nút xóa
            deleteMultipleBtn.addEventListener('click', function () {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một thuộc tính để xóa.');
                    return;
                }

                // Lưu danh sách ID đã chọn vào nút xác nhận
                confirmDeleteMultipleBtn.dataset.selectedIds = JSON.stringify(selectedIds);

                // Hiển thị modal
                const deleteMultipleModal = new bootstrap.Modal(document.getElementById('deleteMultipleModal'));
                deleteMultipleModal.show();
            });

            // Gửi yêu cầu xóa khi xác nhận trong modal
            confirmDeleteMultipleBtn.addEventListener('click', function () {
                const selectedIds = JSON.parse(this.dataset.selectedIds);

                $.ajax({
                    url: `{{ route('admin.carriers.deleteMultiple') }}`,
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: 'hard_delete_carrier',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr);
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                        } else {
                            alert('Có lỗi xảy ra: ' + xhr.statusText);
                        }
                    }
                });
            });
        });

    </script>
@endsection
