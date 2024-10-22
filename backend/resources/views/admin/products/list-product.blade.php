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
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Danh sách Sản phẩm</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                            <li class="breadcrumb-item active">Danh sách Sản phẩm</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title mb-0">Danh sách</h5>
                                        <div>
                                        {{-- <a href="#" class="btn btn-danger mb-3"><i class="fa-solid fa-trash-can"></i></a> --}}
                                        <a href="{{ route('admin.products.addProduct') }}" class="btn btn-primary mb-3">Thêm mới</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="example"
                                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                                style="width:100%">

                                            <thead>
                                            <tr>
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
                                            @foreach($products as $index=> $value)
                                            <?php
                                                    $avatar="";
                                                    if(isset($value->galleries) && count($value->galleries)>0){
                                                        foreach($value->galleries as $valuegalary){
                                                           if($valuegalary->is_main){
                                                            $avatar= $valuegalary->image_gallery;
                                                           }
                                                        }
                                                    }
                                            ?>
                                            <tr>
                                                <td>{{ $index+1}}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td><img src="{{Storage::url($avatar)}}" alt="" style="max-height: 100px !important; max-width:100px !important"></td>
                                                <td>{{ $value->category_name }}</td>
                                                <td>{{ $value->slug }}</td>
                                                <td>{{ $value->price_regular }}</td>
                                                <td>{{ $value->price_sale }}</td>
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="{{ route('admin.products.showProduct', $value->id) }}" class="dropdown-item"><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item view-variants" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">
                                                                    <i class="ri-list-check align-bottom me-2 text-muted"></i> View Variants
                                                                </a>
                                                            </li>
                                                            <li><a href="{{ route('admin.products.updateProduct', $value->id) }}" class="dropdown-item edit-item-btn"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                Edit</a></li>
                                                            <li>
                                                                <form action="#" method="post"> 
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        onclick="return confirm('Chắc chắn không?')"
                                                                        type="submit" class="dropdown-item remove-item-btn"> <i class="ri-delete-bin-fill align-bottom me-2 text-mute"></i>Delete</button>
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
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Product Variants</h5>
                    <div class="ms-auto d-flex align-items-center">
                        <input type="text" id="search" placeholder="Search variants..." class="form-control me-2" style="width: 250px;" />
                        <button id="search-btn" class="btn btn-primary">Search</button>
                    </div>
                </div>
                
                <div class="modal-body" id="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Stt</th>
                                <th>Mã</th>
                                <th>Giá gốc</th>
                                <th>Giá khuyến mãi</th>
                                <th>Trạng thái</th>
                                <th>Số lượng</th>
                                <th>Hình ảnh</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" >
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="closeModalVariant" type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripte_logic')
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
                fetch(`/admin/products/${productId}/variants?page=${page}&per_page=${perPage}&search=${searchTerm}`)
                    .then(response => response.json())
                    .then(data => {
                        displayVariants(data);
                    })
                    .catch(error => console.error('Error fetching variants:', error));
            }

            function displayVariants(data) {
                const variantsBody = document.getElementById('tbody');
                let variantsHtml = '';

                if (data.data.length) {
                    let index = 1; // Đếm từ 1 cho ID
                    data.data.forEach(variant => {
                        variantsHtml += `
                            <tr>
                                <td>${index++}</td>
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
                    variantsBody.innerHTML = variantsHtml + paginationHtml; // Thêm vào tbody

                    // Gán sự kiện click cho các nút phân trang
                    const pageButtons = document.querySelectorAll('.page-btn');
                    pageButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const page = this.getAttribute('data-page');
                            if (page) {
                                currentPage = page;
                                fetchVariants(currentPage, searchInput.value); // Gửi từ khóa tìm kiếm nếu có
                            }
                        });
                    });
                } else {
                    variantsBody.innerHTML = '<p class="text-center " style="text-align: center; margin: 0 auto; padding: 20px 0;">No variants available for this product.</p>'; // Thông báo không có biến thể
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

                                return `
                                    <li class="page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}">
                                        <button class="page-link page-btn" data-page="${link.url ? new URL(link.url).searchParams.get('page') : ''}" ${!link.url ? 'disabled' : ''}>
                                            ${label}
                                        </button>
                                    </li>
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

@endsection