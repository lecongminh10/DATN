@extends('admin.layouts.app')

@section('title')
    Danh Sách Quyền
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
                @include('admin.layouts.component.page-header', [
                    'title' => 'Phân quyền ',
                    'breadcrumb' => [
                        ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                        ['name' => 'Phân quyền ', 'url' => '#']
                    ]
                ])
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 me-3">Danh sách Quyền</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center ">
                                    <form action="" method="GET" class="d-flex align-items-center flex-grow-1">
                                        <div class="input-group me-2" style="max-width: 300px;">
                                            <input type="text" id="search" name="search" class="form-control"
                                                placeholder="Nhập từ khóa tìm kiếm" value="{{ request('search') }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-equalizer-fill fs-13 align-bottom"></i> Tìm
                                        </button>
                                    </form>
                                    <div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-success me-2">
                                                    <i class="ri-add-line align-bottom "></i> Thêm mới
                                            </a>
                                            <button class="btn btn-soft-danger" onClick="deleteMultiplePermissions()">
                                                <i class="ri-delete-bin-2-line align-bottom"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if (session('success'))
                                    <div class="w-full alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                @endif
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
                                            <th data-ordering="false">STT</th>
                                            <th data-ordering="false">Tên</th>
                                            <th data-ordering="false">Mô tả</th>
                                            <th data-ordering="false">Ngày tạo</th>
                                            <th data-ordering="false">Ngày cập nhật</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $key => $item)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            name="ids[]" value="{{ $item->id }}">
                                                    </div>
                                                </th>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $item->permission_name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->created_at->format('H:i d-m-Y') }}</td>
                                                <td>{{ $item->updated_at->format('H:i d-m-Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" role="button" id="dropdownMenuLink"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('admin.permissions.show', $item->id) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 fs-16"></i> Xem
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('admin.permissions.edit', $item->id) }}">
                                                                    <i class="las la-braille me-2"></i> Sửa
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                   onclick="event.preventDefault(); confirmDeletePermission('{{ $item->id }}', '{{ $item->permission_name }}');">
                                                                    <i class="ri-delete-bin-2-line me-2"></i> Xóa
                                                                </a>
                                                            </li>
                                                        </ul>                                                        
                                                    </div>
                                                    <!-- Soft delete form -->
                                                    <form id="soft-delete-permission-{{ $item->id }}"
                                                        action="{{ route('admin.permissions.destroyPermission', $item->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <form id="hard-delete-permission-{{ $item->id }}"
                                                        action="{{ route('admin.permissions.destroyPermissionHard', $item->id) }}"
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
                                    {{ $permissions->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
                <!-- Modal xác nhận xóa -->
                <div class="modal fade" id="deletePermissionModal" tabindex="-1"
                    aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
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
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal cảnh báo --}}
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-warning" id="alertModalLabel">Cảnh báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vui lòng chọn ít nhất một quyền để xóa.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripte_logic')
    <script>

        // Chọn tất cả
        document.getElementById('checkAllPermissions').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked; // Đồng bộ trạng thái với checkbox "chọn tất cả"
            });
        });

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

        if (selectedIds.length === 0) {
            // Hiển thị modal cảnh báo
            const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            alertModal.show();
        } else {
            // Hiển thị modal xác nhận xóa
            document.getElementById('modalPermissionName').innerText = `Bạn có chắc chắn muốn xóa ${selectedIds.length} quyền?`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deletePermissionModal'));
            deleteModal.show();

            document.getElementById('confirmDeleteBtn').onclick = function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.permissions.destroyMultiple') }}';

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
            };
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
                        '{{ route('admin.permissions.destroyMultipleValues') }}';

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
