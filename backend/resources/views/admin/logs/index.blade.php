@extends('admin.layouts.app')
@section('title')
    Nhật ký
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.layouts.component.page-header', [
                'title' => 'Nhật ký',
                'breadcrumb' => [
                    ['name' => 'Nhật ký', 'url' => 'javascript: void(0);'],
                    ['name' => 'Danh sách nhật ký', 'url' => '#'],
                ],
            ])
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
                        {{ $logs->links() }}    
                    </div>
                </div>
            </div>  
        </div>
    </div>
@endsection
