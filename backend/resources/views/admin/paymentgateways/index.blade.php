@extends('admin.layouts.app')

@section('title')
    Danh Sách Cổng Thanh Toán
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Danh sách cổng thanh toán</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm ...">
                                </div>
                                <a href="{{ route('admin.paymentgateways.add') }}">
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm mới
                                    </button>
                                </a>
                                <button class="btn btn-soft-danger" id="remove-actions">
                                    <i class="ri-delete-bin-2-line align-bottom"></i>
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
                                    <th data-sort="name">Tên</th>
                                    <th data-sort="api_key">Khóa API</th>
                                    <th data-sort="secret_key">Khóa bí mật</th>
                                    <th data-sort="gateway_type">Loại cổng thanh toán</th>
                                    <th data-sort="gateway_type">Hình thức</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all" id="userTableBody">
                                @foreach ($paymentGateway as $key => $value)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $value->id }}" class="user-checkbox">
                                            </div>
                                        </th>
                                        <td class="id"><a href="apps-tasks-details.html" class="fw-medium link-primary">{{ $value->id }}</a></td>
                                        <td class="project_name">{{ $value->name}}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-grow-1 tasks_name">{{ $value->api_key}}</div>
                                                <div class="flex-shrink-0 ms-4">
                                                    <ul class="list-inline tasks-list-menu mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{route('admin.paymentgateways.show', $value->id)}}">
                                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="{{route('admin.paymentgateways.edit', $value->id)}}">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button class="btn btn-link text-danger p-0" title="Xóa" onclick="confirmDelete('{{ $value->id }}', '{{ $value->name}}')">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            </button>
                                                            <form id="deleteForm-{{ $value->id }}" action="{{ route('admin.paymentgateways.delete', $value->id) }}" method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="forceDelete" id="forceDeleteInput-{{ $value->id }}" value="false">
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="client_name">{{ $value->secret_key }}</td>
                                        <td class="client_name">{{ $value->gateway_type}}</td>
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

            <div class="modal fade flip" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                            <div class="mt-4 text-center">
                                <h4 id="modalTitle">Bạn có chắc chắn muốn xóa thanh toán này?</h4>
                                <p class="text-muted fs-14 mb-4" id="modalName"></p>
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
                    alert('Vui lòng chọn ít nhất một cổng thanh toán để xóa.');
                    return;
                }

                document.getElementById('modalName').innerText = `tên: ${selectedIds.length}`;
                document.getElementById('modalTitle').innerText = 'Bạn có chắc chắn muốn xóa những cổng thanh toán này?';

                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

                confirmDeleteBtn.onclick = function() {
                    const forceDeleteValue = forceDeleteCheckbox.checked ? 'true' : 'false';
                    fetch('{{ route('admin.paymentgateways.deleteMultiple') }}', {
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
                            alert('Có lỗi xảy ra khi xóa cổng thanh toán.');
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
                    const name = row.querySelector('.tasks_name').innerText.toLowerCase();
                    const api_key = row.querySelector('.client_name').innerText.toLowerCase();
                    const secret_key = row.querySelector('.status').innerText.toLowerCase();
                    
                    if (name.includes(filter) || api_key.includes(filter) || secret_key.includes(filter)) {
                        row.style.display = '';
                        noResults = false;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const noResultDiv = document.querySelector('.noresult');
                noResultDiv.style.display = noResults ? 'block' : 'none';
            });
        });

        function confirmDelete(paymentgatewayId, name ) {
            document.getElementById('modalName').innerText = `tên: ${name}`;
            const deleteBtn = document.getElementById('confirmDeleteBtn');
            const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

            deleteBtn.onclick = function() {
                const forceDeleteInput = document.getElementById(`forceDeleteInput-${paymentgatewayId}`);
                forceDeleteInput.value = forceDeleteCheckbox.checked ? 'true' : 'false';

                document.getElementById(`deleteForm-${paymentgatewayId}`).submit();
            };

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

@endsection
