@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Danh sách người dùng</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.users.add') }}">
                                    <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm mới
                                    </button>
                                </a>
                                <button class="btn btn-soft-danger" id="remove-actions" style="display: none;">
                                    <i class="ri-delete-bin-2-line"></i> Xóa Nhiều
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Thêm ô tìm kiếm -->
                    <div class="mt-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm người dùng...">
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 40px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="id">ID</th>
                                    <th class="sort" data-sort="permission">Quyền</th>
                                    <th class="sort" data-sort="username">Tên</th>
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="status">Status</th>
                                    <th class="sort" data-sort="gender">Giới Tính</th>
                                    <th class="sort" data-sort="date_of_birth">Ngày Sinh</th>
                                    <th class="sort" data-sort="phone_number">Số Điện Thoại</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all" id="userTableBody">
                                @foreach ($user as $key => $value)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $value->id }}" class="user-checkbox">
                                            </div>
                                        </th>
                                        <td class="id"><a href="apps-tasks-details.html" class="fw-medium link-primary">{{ $value->id }}</a></td>
                                        <td class="project_name">
                                            @foreach ($value->permissionsValues as $permission)
                                                <span>{{ $permission->value }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-grow-1 tasks_name">{{ $value->username }}</div>
                                                <div class="flex-shrink-0 ms-4">
                                                    <ul class="list-inline tasks-list-menu mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('users.show', $value->id)}}">
                                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('admin.users.edit', $value->id)}}">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button class="btn btn-link text-danger p-0" title="Xóa" onclick="confirmDelete('{{ $value->id }}', '{{ $value->username }}')">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            </button>
                                                            <form id="deleteForm-{{ $value->id }}" action="{{ route('admin.users.delete', $value->id) }}" method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="forceDelete" id="forceDeleteInput-{{ $value->id }}" value="false">
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="client_name">{{ $value->email }}</td>
                                        <td class="client_name">{{ $value->status }}</td>
                                        <td class="assignedto">{{ $value->gender }}</td>
                                        <td class="due_date">{{ $value->date_of_birth }}</td>
                                        <td class="status">
                                            <span class="badge bg-secondary-subtle text-secondary text-uppercase">{{ $value->phone_number }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Xin lỗi! Không tìm thấy kết quả</h5>
                                <p class="text-muted mb-0">Chúng tôi đã tìm kiếm hơn 200k+ nhiệm vụ nhưng không tìm thấy nhiệm vụ nào cho bạn.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal xác nhận xóa -->
            <div class="modal fade flip" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                            <div class="mt-4 text-center">
                                <h4 id="modalTitle">Bạn có chắc chắn muốn xóa người dùng này?</h4>
                                <p class="text-muted fs-14 mb-4" id="modalUsername"></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="forceDeleteCheckbox">
                                    <label class="form-check-label" for="forceDeleteCheckbox">Xóa vĩnh viễn</label>
                                </div>
                                <div class="hstack gap-2 justify-content-center remove mt-3">
                                    <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal">
                                        <i class="ri-close-line me-1 align-middle"></i> Đóng
                                    </button>
                                    <button class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('input[name="chk_child"]');
            const deleteMultipleBtn = document.getElementById('remove-actions');
            const checkAll = document.getElementById('checkAll');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            let selectedIds = [];

            // Kiểm tra checkbox và hiển thị/ẩn nút xóa nhiều
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    deleteMultipleBtn.style.display = anyChecked ? 'block' : 'none';
                });
            });

            // Thêm sự kiện cho checkbox "Chọn tất cả"
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                deleteMultipleBtn.style.display = checkAll.checked ? 'block' : 'none';
            });

            // Thêm sự kiện click cho nút xóa nhiều
            deleteMultipleBtn.addEventListener('click', function() {
                selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một người dùng để xóa.');
                    return;
                }

                // Hiển thị modal cho xóa nhiều
                document.getElementById('modalUsername').innerText = `Người dùng: ${selectedIds.length} người`;
                document.getElementById('modalTitle').innerText = 'Bạn có chắc chắn muốn xóa những người dùng này?';

                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

                // Xóa sự kiện cũ để không gán nhiều lần
                confirmDeleteBtn.onclick = function() {
                    // Gửi yêu cầu xóa nhiều người dùng
                    const forceDeleteValue = forceDeleteCheckbox.checked ? 'true' : 'false';
                    fetch('{{ route('admin.users.deleteMultiple') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            ids: JSON.stringify(selectedIds),
                            forceDelete: forceDeleteValue,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra khi xóa người dùng.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                };

                deleteModal.show();
            });

            // Chức năng tìm kiếm
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = document.querySelectorAll('#userTableBody tr');
                let noResults = true;

                rows.forEach(row => {
                    const username = row.querySelector('.tasks_name').innerText.toLowerCase();
                    const email = row.querySelector('.client_name').innerText.toLowerCase();
                    const phoneNumber = row.querySelector('.status').innerText.toLowerCase();

                    if (username.includes(filter) || email.includes(filter) || phoneNumber.includes(filter)) {
                        row.style.display = '';
                        noResults = false; // Có ít nhất một kết quả
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Hiển thị thông báo không tìm thấy kết quả nếu không có hàng nào
                const noResultDiv = document.querySelector('.noresult');
                noResultDiv.style.display = noResults ? 'block' : 'none';
            });
        });

        function confirmDelete(userId, username) {
            // Hiển thị modal
            document.getElementById('modalUsername').innerText = `Người dùng: ${username}`;
            const deleteBtn = document.getElementById('confirmDeleteBtn');
            const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

            // Xóa sự kiện cũ để không gán nhiều lần
            deleteBtn.onclick = function() {
                // Kiểm tra trạng thái checkbox và cập nhật giá trị vào form
                const forceDeleteInput = document.getElementById(`forceDeleteInput-${userId}`);
                forceDeleteInput.value = forceDeleteCheckbox.checked ? 'true' : 'false';

                // Gửi form
                document.getElementById(`deleteForm-${userId}`).submit();
            };

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

@endsection
