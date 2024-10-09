@extends('admin.layouts.app')

@section('title')
    Sửa Danh Mục
@endsection

@section('content')
<br><br><br><br><br>
<div class="container">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Category</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Category</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
        <div class="row">
        <div class="col-lg-12">
            <div class="card">
                
                <div class="card-body">
                    <form action="{{route('categories.update', $data)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                   <h5 class="card-title mb-0">Create New Category</h5> 
                                </div>
                                <div class="form-check  form-switch form-switch-primary mt-3">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                    @checked($data->is_active) value="1"
                                           name="is_active" id="is_active" checked value="1">
                                    <label class="form-check-label" for="is_active">Is Active</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <label for="productName" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label for="discription" class="form-label">Description</label>
                                <input class="form-control" name="description" rows="3" value="{{ $data->description }}"></input>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <h5 class="fw-semibold mb-3">Image</h5>
                                <input type="file" class="form-control" multiple name="image" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="2">
                                <img src="{{Storage::url($data->image)}}" width="50" height="50" alt="">
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button class="btn btn-primary">Edit Category</button>
                                </div>
                            </div>
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
