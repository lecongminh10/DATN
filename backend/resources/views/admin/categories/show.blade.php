@extends('admin.layouts.app')

@section('title')
    Chi Tiết Danh Mục: {{$data['name']}}
@endsection

@section('content')
<div class="page-content">
<div class="container">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Category</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Category</a></li>
                        <li class="breadcrumb-item active">Detail Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Category</h5>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div>
                                    <label for="name" class="form-label">Name</label>
                                    <input disabled type="text" class="form-control" name="name" id="name" value="{{ $data['name'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <input disabled type="text" class="form-control" name="description" value="{{ $data['description'] }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <input type="text" disabled name="parent_id" class="form-control" value="{{ optional($data->parent)->name ?? 'No parent' }}">
                            </div>
                            <div class="col-md-6">
                                {!! $data->is_active ? '<span class="badge bg-success"> Hoạt động </span>' : '<span class="badge bg-danger"> Không hoạt động </span>' !!}
                            </div>
                            <div class="col-md-6">
                                <label for="created_at" class="form-label">Created At</label>
                                <input disabled type="text" class="form-control" value="{{ $data['created_at'] }}">
                                <label for="updated_at" class="form-label">Updated At</label>
                                <input disabled type="text" class="form-control" value="{{ $data['updated_at'] }}">   
                            </div>
                            <div class="col-md-6">
                                <img src="{{ Storage::url($data->image) }}" style="width: 400px; height: 300px;" alt="">
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div>
</div>
@endsection
