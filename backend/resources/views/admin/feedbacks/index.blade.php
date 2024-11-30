@extends('admin.layouts.app')

@section('content')
    <style>
        .custom-link {
            text-decoration: none;
            /* Loại bỏ gạch chân mặc định */
            color: rgb(0, 132, 255);
            /* Sử dụng màu hiện tại của văn bản */
            transition: color 0.3s ease, text-decoration 0.3s ease;
            /* Hiệu ứng mượt */
        }

        .custom-link:hover {
            text-decoration: underline;
            /* Thêm gạch chân khi hover */
            color: rgb(0, 106, 255);
            /* Chuyển màu xanh khi hover */
        }
    </style>

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @include('admin.layouts.component.page-header', [
                'title' => 'Phản hồi',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Phản hồi', 'url' => '#'],
                ],
            ])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="customerList">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title "><a class="text-dark"
                                                        href="{{ route('admin.feedbacks.index') }}">Danh sách</a></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-2">
                                                <form method="GET" action="{{ route('admin.feedbacks.index') }}">
                                                    <input type="text" class="form-control search" name="search"
                                                        placeholder="Nhập từ khóa tìm kiếm..."
                                                        value="{{ request()->input('search') }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="listjs-table" id="customerList">
                                    <div class="card-header border-0 mt-1">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h1 class="card-title fw-semibold mb-0"></h1>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-soft-danger" id="deleteMultipleBtn"
                                                    style="display: none;">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </button>
                                                {{-- <a class="btn btn-success add-btn ms-2"
                                                    href="">
                                                    <i class="ri-add-box-fill"></i> Thêm
                                                </a> --}}
                                                {{-- <a href="{{ route('admin.feedbacks.deleted') }}"
                                                    class="btn btn-soft-danger ms-2">
                                                    <i class="ri-delete-bin-2-line"></i>Thùng rác
                                                </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-card mt-1">
                                        <table class="table align-middle">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                                value="option">
                                                        </div>
                                                    </th>
                                                    <th>Stt</th>
                                                    <th>Tên </th>
                                                    <th>Email </th>
                                                    <th>Điện thoại </th>
                                                    <th>Ngày tạo</th>
                                                    <th class="status">Trạng thái</th>
                                                    <th class="text-center">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($feedbacks as $index => $item)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="{{ $item->feedback_id }}">
                                                            </div>
                                                        </th>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.feedbacks.show', $item->feedback_id) }}"
                                                                class="dropdown-item custom-link">
                                                                {{ $item->full_name }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.feedbacks.show', $item->feedback_id) }}"
                                                                class="dropdown-item custom-link">
                                                                {{ $item->email  }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.feedbacks.show', $item->feedback_id) }}"
                                                                class="dropdown-item custom-link">
                                                                {{ $item->phone_number  }}
                                                            </a>
                                                        </td>
                                                        <td> {{ $item->date_submitted   }}</td>
                                                        <td class="status">
                                                            <span
                                                                class="badge 
                                                                    {{ $item->status == 'Chưa xử lý' ? 'bg-warning-subtle text-warning' : 
                                                                       ($item->status == 'Đang xử lý' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success') }} 
                                                                    text-uppercase">
                                                                {{ $item->status }}
                                                            </span>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <div class="dropdown d-inline-block">
                                                                    <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill align-middle"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="{{ route('admin.feedbacks.show', $item->feedback_id) }}"
                                                                                class="dropdown-item"><i
                                                                                    class="ri-eye-fill align-bottom me-2 fs-16"></i>
                                                                                Xem</a></li>
                                                                        
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('admin.feedbacks.destroy', $item->feedback_id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button
                                                                                    onclick="return confirm('Bạn có chắc chắn không?')"
                                                                                    type="submit"
                                                                                    class="dropdown-item remove-item-btn">
                                                                                    <i
                                                                                        class="ri-delete-bin-5-fill fs-16 align-bottom me-2"></i>
                                                                                    Xóa
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <div class="results-info ms-3">
                                <p class="pagination mb-0">
                                    Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of
                                    {{ $feedbacks->total() }} results
                                </p>
                            </div>
                            <div class="pagination-wrap me-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if ($feedbacks->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $feedbacks->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    Previous
                                                </a>
                                            </li>
                                        @endif
                                        @foreach ($feedbacks->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <span class="page-link">{{ $element }}</span>
                                                </li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $feedbacks->currentPage())
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
                                        @if ($feedbacks->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $feedbacks->nextPageUrl() }}"
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
                </div><!-- end card -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
