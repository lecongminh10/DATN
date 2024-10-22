@extends('admin.layouts.app')

@section('title')
    Sửa Danh Mục
@endsection

@section('content')
<div class="page-content">
<<<<<<< HEAD
<div class="container">
=======
  <div class="container">
>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Category</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Category</a></li>
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
                    <form action="{{ route('categories.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-0">Edit Category</h5> 
                                </div>
                                <div class="form-check form-switch form-switch-primary mt-3">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           name="is_active" id="is_active" value="1" @checked($data->is_active)>
                                    <label class="form-check-label" for="is_active">Is Active</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required>{{ $data->description }}</textarea>
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <h5 class="fw-semibold mb-3">Image</h5>
                                <input type="file" class="form-control" name="image" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="2">
                                @if($data->image)
                                    <img src="{{ Storage::url($data->image) }}" width="50" height="50" alt="Current Image" style="margin-top: 10px;">
                                @endif
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select" name="parent_id" id="parent_id">
                                    <option value="">None</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ $parent->id == $data->parent_id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
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
</div>
</div>
@endsection
