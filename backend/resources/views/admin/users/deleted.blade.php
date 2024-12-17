@extends('admin.layouts.app')

@section('title')
    Thùng Rác
@endsection
@section('style_css')
    <style>
        #confirmAction {
            display: none;
        }

        #restoreAction {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        @include('admin.layouts.component.page-header', [
            'title' => 'Người dùng  ',
            'breadcrumb' => [
                ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                ['name' => 'Người dùng ', 'url' => '#']
            ]
        ])
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="tasksList">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">Danh sách đã xóa </h5>
                            <div class="flex-shrink-0">
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm người dùng...">
                                    </div>
                                    <button class="btn btn-soft-danger" id="remove-actions" style="display: none;">
                                        <i class="ri-delete-bin-2-line"></i>
                                    </button>
                                </div>
                            </div>
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
                                        <th data-sort="id">ID</th>
                                        <th data-sort="username">Tên</th>
                                        <th data-sort="email">Email</th>
                                        <th data-sort="permission">Quyền</th>
                                        <th data-sort="status">Trạng thái</th>
                                        <th data-sort="gender">Ngày xóa</th>
                                        <th data-sort="date_of_birth">Người xóa</th>
                                        <th data-sort="phone_number">Số Điện Thoại</th>
                                        <th data-sort="actino"></th>
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
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 tasks_name">{{ $value->username }}</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item">
                                                                <a href="{{route('admin.users.show', $value->id)}}">
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
                                            <td class="project_name">
                                                @foreach ($value->permissionsValues as $permission)
                                                    <span class="badge {{ $permission->value == 'admin_role' ? 'bg-primary' : ($permission->value == 'client_role' ? 'bg-info' : 'bg-secondary') }}">
                                                        {{ $permission->value == 'admin_role' ? 'Admin' : ($permission->value == 'client_role' ? 'Client' : 'Unknown Role') }}
                                                    </span>
                                                @endforeach 
                                            </td>                                        
                                            <td>
                                                    <span class="badge {{ $value->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $value->status == 'active' ? $value->status : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="due_date">
                                                    @if ($value->deleted_at)
                                                        {{ $value->deleted_at->format('H:i d-m-Y') }}
                                                    @else
                                                        Chưa xóa
                                                    @endif
                                                </td>

                                                <td class="due_date">
                                                    @if ($value->deleted_by)
                                                        <?php $deletedByUser = App\Models\User::find($value->deleted_by); ?>
                                                        @if ($deletedByUser)
                                                            {{ $deletedByUser->username }} <!-- Hiển thị tên người xóa -->
                                                        @else
                                                            Không xác định
                                                        @endif
                                                    @else
                                                        Không xác định
                                                    @endif
                                                </td>
                                                <td class="status">
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary text-uppercase">{{ $value->phone_number }}</span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="openModal('delete', '{{ $value->id }}');">Xóa</button>
                                                    <button class="btn btn-success btn-sm"
                                                        onclick="openModal('restore', '{{ $value->id }}');">Khôi
                                                        phục</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Xin lỗi! Không tìm thấy kết quả</h5>
                                        <p class="text-muted mb-0">Chúng tôi đã tìm kiếm hơn 200k+ nhiệm vụ nhưng không tìm
                                            thấy nhiệm vụ nào cho bạn.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
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
                            <a href="/admin/users" class="btn btn-primary float-end">Trở về</a>
                        </div>
                    </div>

                    <div class="modal fade flip" id="deleteModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 id="modalTitle">Bạn có chắc chắn muốn xóa người dùng này?</h4>
                                        <p class="text-muted fs-14 mb-4" id="modalUsername"></p>
                                        <div class="hstack gap-2 justify-content-center remove mt-3">
                                            <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal">
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
        </div>

        <div class="modal fade" id="userActionModal" tabindex="-1" role="dialog"
            aria-labelledby="userActionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userActionModalLabel">Xác nhận hành động</h5>
                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                            id="deleteRecord-close" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="modalMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-danger" id="confirmAction">Xóa</button>
                        <button type="button" class="btn btn-success" id="restoreAction">Khôi phục</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script_libray')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endsection
    @section('scripte_logic')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const checkboxes = document.querySelectorAll('input[name="chk_child"]');
                const deleteMultipleBtn = document.getElementById('remove-actions');
                const checkAll = document.getElementById('checkAll');
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                let selectedIds = [];

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                        deleteMultipleBtn.style.display = anyChecked ? 'block' : 'none';
                    });
                });

                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = checkAll.checked;
                    });
                    deleteMultipleBtn.style.display = checkAll.checked ? 'block' : 'none';
                });

                deleteMultipleBtn.addEventListener('click', function() {
                    selectedIds = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.value);

                    if (selectedIds.length === 0) {
                        alert('Vui lòng chọn ít nhất một người dùng để xóa.');
                        return;
                    }

                    document.getElementById('modalUsername').innerText =
                        `Người dùng: ${selectedIds.length} người`;
                    document.getElementById('modalTitle').innerText =
                        'Bạn có chắc chắn muốn xóa những người dùng này?';

                    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                    const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

                    confirmDeleteBtn.onclick = function() {
                        const forceDeleteValue = 'true';
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        fetch('/admin/users/deleteMultiple', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
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

                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('input', function() {
                    const filter = searchInput.value.toLowerCase();
                    const rows = document.querySelectorAll('#userTableBody tr');
                    let noResults = true;

                    rows.forEach(row => {
                        const username = row.querySelector('.tasks_name').innerText.toLowerCase();
                        const email = row.querySelector('.client_name').innerText.toLowerCase();
                        const phoneNumber = row.querySelector('.status').innerText.toLowerCase();

                        if (username.includes(filter) || email.includes(filter) || phoneNumber.includes(
                                filter)) {
                            row.style.display = '';
                            noResults = false; // Có ít nhất một kết quả
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    const noResultDiv = document.querySelector('.noresult');
                    noResultDiv.style.display = noResults ? 'block' : 'none';
                });
            });

            function confirmDelete(userId, username) {
                // Hiển thị modal
                document.getElementById('modalUsername').innerText = `Người dùng: ${username}`;
                const deleteBtn = document.getElementById('confirmDeleteBtn');
                const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

                deleteBtn.onclick = function() {
                    const forceDeleteInput = document.getElementById(`forceDeleteInput-${userId}`);
                    forceDeleteInput.value = forceDeleteCheckbox.checked ? 'true' : 'false';

                    document.getElementById(`deleteForm-${userId}`).submit();
                };

                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            }
        </script>
        <script>
            function openModal(action, userId) {
                let message = '';
                let actionType = '';

                if (action === 'delete') {
                    message = 'Bạn có chắc chắn muốn xóa người dùng này không?';
                    actionType = 'hard-delete'; 
                    document.getElementById("confirmAction").style.display = 'block';
                    document.getElementById("restoreAction").style.display = 'none';
                } else if (action === 'restore') {
                    message = 'Bạn có chắc chắn muốn khôi phục người dùng này không?';
                    actionType = 'restore'; 
                    document.getElementById("restoreAction").style.display = 'block';
                    document.getElementById("confirmAction").style.display = 'none';
                }

                // Cập nhật nội dung modal
                document.getElementById('modalMessage').innerText = message;

                // Hiển thị modal
                $('#userActionModal').modal('show');

                // Gán sự kiện cho nút xác nhận
                document.getElementById('confirmAction').onclick = function() {
                    performAction(actionType, userId);
                };

                // Gán sự kiện cho nút khôi phục
                document.getElementById('restoreAction').onclick = function() {
                    performAction('restore', userId);
                };
            }

            function performAction(action, userId) {
                let api_url = `{{ url('admin/users/manage') }}/${userId}`;

                const requestData = {
                    action: action 
                };

                fetch(api_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => response.text()) 
                    .then(data => {
                        if (data.includes('success')) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra.');
                        }
                    })
                    .catch(error => console.error('Error:', error));

                $('#userActionModal').modal('hide'); 
            }
        </script>
    @endsection
