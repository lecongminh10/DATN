@extends('admin.layouts.app')
{{-- @section('style_css')
    <style>

    </style>
@endsection --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- start page title -->
                    @include('admin.layouts.component.page-header', [
                        'title' => 'Sản phẩm ',
                        'breadcrumb' => [
                            ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                            ['name' => 'Sản phẩm', 'url' => '#'],
                        ],
                    ])

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title mb-0 "><a class="text-dark"
                                                        href="{{ route('admin.products.deleted') }}">Danh sách sản phẩm </a>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="search-box mb-3">
                                                <form method="GET" action="{{ route('admin.products.listProduct') }}">
                                                    <input type="text" class="form-control search" name="search"
                                                        placeholder="Nhập từ khóa tìm kiếm..."
                                                        value="{{ request()->input('search') }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </form>
                                                <div>
                                                </div>
                                                <div>
                                                </div>
                                                <div class="mt-3 float-end">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <div class="me-2"> <!-- Added margin for spacing -->
                                                            <button class="btn btn-soft-danger" id="deleteMultipleBtn"
                                                                style="display: none;">
                                                                <i class="ri-delete-bin-5-fill"></i>
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('admin.products.addProduct') }}"
                                                                class="btn btn-primary">Thêm mới</a>
                                                            <a href="{{ route('admin.products.deleted') }}"
                                                                class="btn btn-soft-danger ms-2">
                                                                <i class="ri-delete-bin-2-line"></i> Thùng rác
                                                            </a>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            {{-- <a href="#" class="btn btn-danger mb-3"><i class="fa-solid fa-trash-can"></i></a> --}}
                                        </div>
                                        <div class="card-body">
                                            <table id="example"
                                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                                style="width:100%">

                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 50px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th>STT</th>
                                                        <th>Mã</th>
                                                        <th>Tên </th>
                                                        <th>Ảnh đại diện</th>
                                                        <th>Danh mục</th>
                                                        <th>Slug</th>
                                                        <th>Giá gốc</th>
                                                        <th>Giá khuyến mãi</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($products as $index => $value)
                                                        <?php
                                                        $avatar = '';
                                                        if (isset($value->galleries) && count($value->galleries) > 0) {
                                                            foreach ($value->galleries as $valuegalary) {
                                                                if ($valuegalary->is_main) {
                                                                    $avatar = $valuegalary->image_gallery;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th scope="row">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="chk_child" value="{{ $value->id }}">
                                                                </div>
                                                            </th>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $value->code }}</td>
                                                            <td>{{ $value->name }}</td>
                                                            <td><img src="{{ Storage::url($avatar) }}" alt=""
                                                                    style="max-height: 100px !important; max-width:100px !important">
                                                            </td>
                                                            <td>{{ $value->category_name }}</td>
                                                            <td>{{ $value->slug }}</td>
                                                            <td>{{ $value->price_regular }}</td>
                                                            <td>{{ $value->price_sale }}</td>
                                                            <td>
                                                                <div class="dropdown d-inline-block">
                                                                    <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill align-middle"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="{{ route('admin.products.showProduct', $value->id) }}"
                                                                                class="dropdown-item"><i
                                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>Xem</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#"
                                                                                class="dropdown-item view-variants"
                                                                                data-id="{{ $value->id }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target=".bs-example-modal-xl">
                                                                                <i
                                                                                    class="ri-list-check align-bottom me-2 text-muted"></i>Xem
                                                                                biến thể
                                                                            </a>
                                                                        </li>
                                                                        <li><a href="{{ route('admin.products.updateProduct', $value->id) }}"
                                                                                class="dropdown-item edit-item-btn"><i
                                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                                Cập nhật</a></li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('admin.products.destroy', $value->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button
                                                                                    onclick="return confirm('Bạn có chắc chắn không?')"
                                                                                    type="submit"
                                                                                    class="dropdown-item remove-item-btn">
                                                                                    <i
                                                                                        class="ri-delete-bin-5-fill align-bottom me-2 text-mute"></i>
                                                                                    Xóa
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Product Variants</h5>
                            <div class="ms-auto d-flex align-items-center">
                                <input type="text" id="search" placeholder="Search variants..."
                                    class="form-control me-2" style="width: 250px;" />
                                <button id="search-btn" class="btn btn-primary">Search</button>
                            </div>
                        </div>

                        <div class="modal-body" id="modal-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:10px">Stt</th>
                                        <th>Giá trị</th>
                                        <th>Mã</th>
                                        <th>Giá gốc</th>
                                        <th>Giá khuyến mãi</th>
                                        <th>Trạng thái</th>
                                        <th>Số lượng</th>
                                        <th>Hình ảnh</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button id="closeModalVariant" type="button" class="btn btn-primary"
                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="messageModalLabel">Thông báo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Display the message -->
                            @if (session('message'))
                                <p>{{ session('message') }}</p>
                            @else
                                <p>No message available.</p>
                            @endif
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
                @if (session('message'))
                    var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
                    messageModal.show();
                @endif
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const viewVariantLinks = document.querySelectorAll('.view-variants');
                    const searchBtn = document.getElementById('search-btn');
                    const searchInput = document.getElementById('search');

                    viewVariantLinks.forEach(link => {
                        link.addEventListener('click', function() {
                            const productId = this.getAttribute('data-id');
                            const modalBody = document.getElementById('tbody');
                            modalBody.innerHTML = ''; // Xóa nội dung cũ

                            // Phân trang
                            let currentPage = 1;
                            const perPage = 5; // Số biến thể mỗi trang

                            function fetchVariants(page, searchTerm = '') {
                                fetch(
                                        `/admin/products/${productId}/variants?page=${page}&per_page=${perPage}&search=${searchTerm}`
                                        )
                                    .then(response => response.json())
                                    .then(data => {
                                        displayVariants(data);
                                        console.log(data);

                                    })
                                    .catch(error => console.error('Error fetching variants:', error));
                            }

                            function displayVariants(data) {
                                const variantsBody = document.getElementById('tbody');
                                let variantsHtml = '';

                                if (data.data.length) {
                                    let index = 1; // Đếm từ 1 cho ID
                                    data.data.forEach(variant => {
                                        // Tạo chuỗi cho các giá trị thuộc tính
                                        const attributes = variant.attribute_values.map(
                                            attribute => {
                                                return `${attribute.attribute.attribute_name}: ${attribute.attribute_value}`;
                                            }).join('<br>'); // Sử dụng <br> để ngắt dòng

                                        variantsHtml += `
                            <tr>
                                <td>${index++}</td>
                                <td>${attributes}</td>
                                <td>${variant.sku}</td>
                                <td>${variant.original_price !== null ? variant.original_price : 'N/A'}</td>
                                <td>${variant.price_modifier}</td>
                                <td>${variant.status}</td>
                                <td>${variant.stock}</td>
                                <td><img src="/storage/${variant.variant_image}" alt="Variant Image" style="max-width: 70px; max-height: 70px"/></td>
                            </tr>
                        `;
                                    });

                                    // Tạo nút phân trang
                                    const paginationHtml = createPagination(data.links);
                                    variantsBody.innerHTML = variantsHtml +
                                        paginationHtml; // Thêm vào tbody

                                    // Gán sự kiện click cho các nút phân trang
                                    const pageButtons = document.querySelectorAll('.page-btn');
                                    pageButtons.forEach(button => {
                                        button.addEventListener('click', function() {
                                            const page = this.getAttribute('data-page');
                                            if (page) {
                                                currentPage = page;
                                                fetchVariants(currentPage, searchInput
                                                    .value); // Gửi từ khóa tìm kiếm nếu có
                                            }
                                        });
                                    });
                                } else {
                                    variantsBody.innerHTML =
                                        '<tr><td colspan="100%" style="text-align: center; vertical-align: middle;">No variants available for this product</td></tr>';
                                }
                            }

                            function createPagination(links) {
                                return `
                    <nav aria-label="Page navigation" id="pagespostion">
                        <ul class="pagination justify-content-center">
                            ${links.map(link => {
                                let label = link.label;
                                if (label.includes('Previous')) {
                                    label = '<i class="las la-chevron-left"></i>'; // Icon trái
                                } else if (label.includes('Next')) {
                                    label = '<i class="las la-chevron-right"></i>'; // Icon phải
                                }

                                return ` <
                                    li class =
                                    "page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}" >
                                    <
                                    button class = "page-link page-btn"
                                data - page =
                                    "${link.url ? new URL(link.url).searchParams.get('page') : ''}"
                                $ {
                                    !link.url ? 'disabled' : ''
                                } >
                                $ {
                                    label
                                } <
                                /button> < /
                                li >
                                    `;
                            }).join('')}
                        </ul>
                    </nav>
                `;
                            }

                            // Gán sự kiện click cho nút tìm kiếm
                            searchBtn.addEventListener('click', function() {
                                currentPage = 1; // Đặt lại trang về 1 khi tìm kiếm mới
                                fetchVariants(currentPage, searchInput.value);
                            });

                            // Tải dữ liệu biến thể ban đầu
                            fetchVariants(currentPage);
                        });
                    });
                });
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const checkboxes = document.querySelectorAll('input[name="chk_child"]');
                    const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
                    const checkAll = document.getElementById('checkAll'); // Checkbox "Chọn tất cả"

                    // Kiểm tra checkbox và hiển thị/ẩn nút xóa nhiều
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                            deleteMultipleBtn.style.display = anyChecked ? 'block' : 'none';
                            checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                        });
                    });

                    // Thêm sự kiện cho checkbox "Chọn tất cả"
                    checkAll.addEventListener('change', function() {
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = checkAll.checked;
                        });
                        deleteMultipleBtn.style.display = checkAll.checked ? 'block' :
                            'none'; // Hiển thị/ẩn nút xóa nhiều
                    });

                    // Thêm sự kiện click cho nút xóa nhiều
                    deleteMultipleBtn.addEventListener('click', function() {
                        const selectedIds = Array.from(checkboxes)
                            .filter(checkbox => checkbox.checked)
                            .map(checkbox => checkbox.value);
                        console.log(selectedIds);
                        if (selectedIds.length === 0) {
                            alert('Vui lòng chọn ít nhất một thuộc tính để xóa.');
                            return;
                        }

                        const action = 'soft_delete';
                        if (confirm('Bạn có chắc chắn muốn xóa những thuộc tính đã chọn không?')) {
                            $.ajax({
                                url: `{{ route('admin.products.deleteMultiple') }}`,
                                method: 'POST',
                                data: {
                                    ids: selectedIds,
                                    action: action,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    alert(response.message);
                                    location.reload();
                                },
                                error: function(xhr) {
                                    console.log(xhr); // Hiển thị thông tin lỗi chi tiết
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
                                    } else {
                                        alert('Có lỗi xảy ra: ' + xhr.statusText);
                                    }
                                }
                            });
                        }
                    });
                });
            </script>
@endsection
@section('script_libray')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
