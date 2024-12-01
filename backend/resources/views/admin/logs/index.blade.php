@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5>Nhật ký hoạt động</h5>
                </div>
                <div class="card-body">
                    <div class="container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người thực hiện</th>
                                    <th>Hoạt động</th>
                                    <th>Chi tiết</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->user ? $value->user->username : 'Không có tên' }}</td>
                                        <td>{{ $value->activity_type }}</td>
                                        <td>{{ $value->detail }}</td>
                                        <td>{{ $value->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Không có nhật ký nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
@endsection
