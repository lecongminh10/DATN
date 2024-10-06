@extends('admin.layouts.app')

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
                                                <th>Category</th>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Price Regular</th>
                                                <th>Price Sale</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($products as $value)
                                            <tr>
                                                <td>{{ $value->id}}</td>
                                                <td>{{ $value->category_name }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->name }}</td>
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
@endsection