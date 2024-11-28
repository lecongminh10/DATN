@extends('admin.layouts.app')

@section('title')
    Danh sách sản phẩm
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
                            <h4 class="mb-sm-0">Hoàn trả </h4>
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered">

                                <thead>
                                    
                                    <tr>
                                        <th scope="col">ID</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Tên người dùng</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Số tiền hoàn trả</th>
                                    <th scope="col">Lý do hoàn trả</th>
                                    <th scope="col">Ngày yêu cầu</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refunds as $refund)
                                        <tr>
                                            <td>{{ $refund->id }}</td>
                                            <td>{{ $refund->order->code }}</td>
                                            <td>{{ $refund->user->username }}</td>
                                            {{-- <td>{{ $refund->product->name }}</td> --}}
                                            <td>{{ $refund->quantity }}</td>
                                            <td>{{ $refund->amount }}Đ</td>
                                            <td>{{ $refund->reason }}</td>
                                            <td>{{ $refund->requested_at }}</td>
                                            <td>
                                                {{ $refund->status }}
                                            <td>
                                                <button data-bs-id="{{ $refund->id }}" type="button"
                                                    class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#refundModal">
                                                    Cập nhật
                                                </button>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Thay đổi trạng thái</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('refunds.update', $refund->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control">
                            <option value="pending" {{ $refund->status == 'pending' ? 'selected' : '' }}>Đang chờ
                            </option>
                            <option value="approved" {{ $refund->status == 'approved' ? 'selected' : '' }}>Đã duyệt
                            </option>
                            <option value="rejected" {{ $refund->status == 'rejected' ? 'selected' : '' }}>Bị từ chối
                            </option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="submit-refund">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('submit-refund').addEventListener('click', function() {
            // Lấy form trong modal
            const form = document.querySelector('#refundModal form');
            if (form) {
                form.submit(); // Gửi form
            }
        });
    </script>
@endsection
