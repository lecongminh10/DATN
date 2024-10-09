@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Danh sách Quyền</h5>
                                    <div class="flex-shrink-0">
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('permissions.create') }}">
                                                <button class="btn btn-danger add-btn" data-bs-toggle="modal"
                                                    data-bs-target="#showModal">
                                                    <i class="ri-add-line align-bottom me-1"></i>Thêm mới
                                                </button>
                                            </a>
                                            <button class="btn btn-danger" onClick="deleteMultiplePermissions()">
                                                <i class="ri-delete-bin-2-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example"
                                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="checkAllPermissions">
                                                </div>
                                            </th>
                                            <th data-ordering="false">id.</th>
                                            <th data-ordering="false">Permission_name</th>
                                            <th data-ordering="false">Description</th>
                                            <th data-ordering="false">Created_at</th>
                                            <th data-ordering="false">Updated_at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $item)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            name="ids[]" value="{{ $item->id }}">
                                                    </div>
                                                </th>
                                                <th scope="row">{{ $item->id }}</th>
                                                <td>{{ $item->permission_name }}</td>
                                                <td>{{ $item->description }}</td>
                                                {{-- <td>{{ $item->deleted_at }}</td> --}}
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->updated_at }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" role="button" id="dropdownMenuLink"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>

                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('permissions.show', $item->id) }}">Detail</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('permissions.edit', $item->id) }}">Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="event.preventDefault(); confirmDeletePermission('{{ $item->id }}', '{{ $item->permission_name }}');">
                                                                    Xóa
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Soft delete form -->
                                                    <form id="soft-delete-permission-{{ $item->id }}"
                                                        action="{{ route('permissions.destroyPermission', $item->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <!-- Hard delete form -->
                                                    <form id="hard-delete-permission-{{ $item->id }}"
                                                        action="{{ route('permissions.destroyPermissionHard', $item->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $permissions->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Danh sách Giá trị Quyền</h5>
                                    <div class="flex-shrink-0">
                                        <div class="d-flex flex-wrap gap-2">
                                            {{-- <a href="{{route('permissions.create')}}">
                                                <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                                    <i class="ri-add-line align-bottom me-1"></i>Thêm mới
                                                </button>
                                            </a> --}}
                                            <button class="btn btn-danger" onClick="deleteMultiplePermissionValues()">
                                                <i class="ri-delete-bin-2-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example"
                                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAllValues">
                                                </div>
                                            </th>
                                            <th data-ordering="false">Id.</th>
                                            <th data-ordering="false">Permissions_id.</th>
                                            <th data-ordering="false">Value</th>
                                            <th data-ordering="false">Description</th>
                                            <th data-ordering="false">Created_at</th>
                                            <th data-ordering="false">Updated_at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissionValues as $value)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input value-checkbox" type="checkbox"
                                                            name="value_ids[]" value="{{ $value->id }}">

                                                    </div>
                                                </th>
                                                <th scope="row">{{ $value->id }}</th>
                                                <td>{{ $value->permissions_id }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary-subtle text-primary">{{ $value->value }}</span>
                                                </td>
                                                <td>{{ $value->description }}</td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->updated_at }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" role="button" id="dropdownMenuLink"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>

                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="event.preventDefault(); confirmDeleteValue('{{ $value->id }}', '{{ $value->value }}');">
                                                                    Xóa
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Soft delete form -->
                                                    <form id="soft-delete-value-{{ $value->id }}"
                                                        action="{{ route('permissions.destroyPermissionValue', $value->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <!-- Hard delete form -->
                                                    <form id="hard-delete-value-{{ $value->id }}"
                                                        action="{{ route('permissions.destroyPermissionValueHard', $value->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div class="d-flex justify-content-center mt-4">
                                    {{ $permissionValues->links('pagination::bootstrap-4') }}
                                </div> --}}
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <!-- Modal xác nhận xóa -->
                <div class="modal fade" id="deletePermissionModal" tabindex="-1"
                    aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletePermissionModalLabel">Xác nhận xóa quyền</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="modalPermissionName"></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="forceDeleteCheckbox">
                                    <label class="form-check-label" for="forceDeleteCheckbox">Xóa vĩnh viễn</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripte_logic')
    <script>
        let deletePermissionId = null; // Biến lưu ID của permission cần xóa
        let deleteValueId = null; // Biến lưu ID của permission value cần xóa

        function confirmDeletePermission(permissionId, permissionName) {
            deletePermissionId = permissionId; // Lưu lại ID của permission cần xóa
            document.getElementById('modalPermissionName').innerText =
                `Bạn có chắc chắn muốn xóa quyền: ${permissionName}?`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deletePermissionModal'));
            deleteModal.show();

            document.getElementById('confirmDeleteBtn').onclick = function() {
                const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

                if (forceDeleteCheckbox.checked) {
                    document.getElementById(`hard-delete-permission-${deletePermissionId}`).submit();
                } else {
                    document.getElementById(`soft-delete-permission-${deletePermissionId}`).submit();
                }

                deleteModal.hide();
            };
        }


        function confirmDeleteValue(valueId, permissionName) {
            deleteValueId = valueId; // Lưu lại ID của value cần xóa
            document.getElementById('modalPermissionName').innerText =
                `Bạn có chắc chắn muốn xóa giá trị: ${permissionName}?`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deletePermissionModal'));
            deleteModal.show();

            document.getElementById('confirmDeleteBtn').onclick = function() {
                const forceDeleteCheckbox = document.getElementById('forceDeleteCheckbox');

                if (forceDeleteCheckbox.checked) {
                    document.getElementById(`hard-delete-value-${deleteValueId}`).submit();
                } else {
                    document.getElementById(`soft-delete-value-${deleteValueId}`).submit();
                }

                deleteModal.hide();
            };
        }


        document.getElementById('checkAllValues').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.value-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.getElementById('checkAllPermissions').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {});
        });

        // Hàm xóa nhiều quyền
        function deleteMultiplePermissions() {
            const selectedIds = Array.from(document.querySelectorAll('.permission-checkbox:checked'))
                .map(checkbox => checkbox.value);
            if (selectedIds.length > 0) {
                const confirmation = confirm(`Bạn có chắc chắn muốn xóa ${selectedIds.length} quyền?`);
                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('permissions.destroyMultiple') }}';
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const idsInput = document.createElement('input');
                    idsInput.type = 'hidden';
                    idsInput.name = 'ids';
                    idsInput.value = JSON.stringify(selectedIds);

                    form.appendChild(csrfInput);
                    form.appendChild(idsInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            } else {
                alert('Vui lòng chọn ít nhất một quyền để xóa.');
            }
        }

        function deleteMultiplePermissionValues() {
            const selectedValueIds = Array.from(document.querySelectorAll('.value-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedValueIds.length > 0) {
                const confirmation = confirm(`Bạn có chắc chắn muốn xóa ${selectedValueIds.length} giá trị?`);
                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action =
                        '{{ route('permissions.destroyMultipleValues') }}';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const idsInput = document.createElement('input');
                    idsInput.type = 'hidden';
                    idsInput.name = 'value_ids';
                    idsInput.value = JSON.stringify(selectedValueIds);

                    form.appendChild(csrfInput);
                    form.appendChild(idsInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            } else {
                alert('Vui lòng chọn ít nhất một giá trị để xóa.');
            }
        }
    </script>
@endsection
