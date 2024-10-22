@extends('admin.layouts.app')

@section('title')
    Thêm Danh Mục
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Category</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Category</a></li>
                            <li class="breadcrumb-item active">Create Category</li>
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
                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">Create New Category</h5>
                                </div>
                                <div class="form-check form-switch justify-content-between form-switch-primary mt-3">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" checked value="1">
                                    <label class="form-check-label" for="is_active">Is Active</label>
                                </div>
                            </div><br>
                            
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="" required>
                                </div><!--end col-->
                                
                                <div class="col-lg-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder=""></textarea>
                                </div><!--end col-->
                                
                                <div class="col-lg-12">
                                    <h5 class="fw-semibold mb-3">Image</h5>
                                    <input type="file" class="form-control" name="image" data-allow-reorder="true" data-max-file-size="25MB" data-max-files="3">
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <label for="parent_id" class="form-label">Parent Category</label>
                                    <select class="form-select" name="parent_id" id="parent_id">
                                        <option value="">None</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @endforeach
                                    </select>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <div class="text-end">
<<<<<<< HEAD
                                        <button class="btn btn-primary">Create Category</button>
=======
                                        <button class="btn btn-primary" >Create Category</button>
>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
                                    </div>
                                </div>
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
</div>
<<<<<<< HEAD
@endsection
=======

@endsection

>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
