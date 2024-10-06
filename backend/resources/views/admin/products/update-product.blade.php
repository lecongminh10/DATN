@extends('admin.layouts.app')

@section('libray_css')
<!-- dropzone css -->
<link rel="stylesheet" href="{{ asset('theme/assets/libs/dropzone/dropzone.css')}}" type="text/css" />
<!-- Filepond css -->
<link rel="stylesheet" href="{{ asset('theme/assets/libs/filepond/filepond.min.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">
<link rel="stylesheet" href="{{ asset('theme/assets/css/addProduct.css') }}">
@endsection

@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Cập nhật sản phẩm</h4>
            
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                                    <li class="breadcrumb-item active">Cập nhật</li>
                                </ol>
                            </div>
            
                        </div>
                    </div>
                </div>
            
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
            
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row gy-4">
                                            <div class="col-md-4">
                                                <div>
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="catalogue_id" class="form-label">Category</label>
                                                    <select type="text" class="form-select" name="catalogue_id" id="catalogue_id">
                                                        @foreach($category as $value)
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="code" class="form-label">CODE</label>
                                                    <input type="text" class="form-control" name="code" id="code" value="{{ $product->code }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="price_regular" class="form-label">Price Regular</label>
                                                    <input type="number" class="form-control" name="price_regular"
                                                           id="price_regular" value="{{ $product->price_regular }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="price_sale" class="form-label">Price Sale</label>
                                                    <input type="number" class="form-control" name="price_sale"
                                                           id="price_sale" value="{{ $product->price_sale }}">
                                                </div>
                                            </div>
            
                                            <div class="col-md-8">
                                                <div class="row">
                                                    @php
                                                        $is = [
                                                            'is_active' => 'primary',
                                                            'is_hot_deal' => 'danger',
                                                            'is_good_deal' => 'warning',
                                                            'is_new' => 'success',
                                                            'is_show_home' => 'info',
                                                        ];
                                                    @endphp
                                                
                                                    @foreach($is as $key => $color)
                                                        <div class="col-md-2">
                                                            <div class="form-check form-switch form-switch-{{ $color }}">
                                                                <input class="form-check-input m" type="checkbox" role="switch"
                                                                       name="{{ $key }}" value="1" id="{{ $key }}" 
                                                                       {{ $product->$key ? 'checked' : '' }}> <!-- Kiểm tra giá trị thuộc tính -->
                                                                <label class="form-check-label"
                                                                       for="{{ $key }}">{{ ucwords(str_replace('_', ' ', str_replace('is_', '', $key))) }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
            
                                                <div class="row">
                                                    <div class="mt-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea class="form-control" name="description" id="description"
                                                                  rows="2">{{ $product->short_description }}</textarea>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="material" class="form-label">Meta Title</label>
                                                        <textarea class="form-control" name="material" id="material"
                                                                  rows="2">{{ $product->meta_title }}</textarea>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="user_manual" class="form-label">Meta description</label>
                                                        <textarea class="form-control" name="user_manual" id="user_manual"
                                                                  rows="2">{{ $product->meta_description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
            
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Content</h4>
                                </div>               
                                <div class="card-body">
                                    <!-- Editor container -->
                                        <textarea name="content" id="editor-container" style="height: 300px;">{{ $product->content }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Attribute</h4>
                                    <button type="button" class="btn btn-primary" id="addAttributeButton">Thêm Attribute</button>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row" id="attributeContainer">
                                            <!-- Danh sách các attribute đã có trong database -->
                                            
                                        </div>
                                        <!-- Form để thêm attribute -->
                                        <div class="row" id="attributeForm" style="display: none;">
                                            <div class="col-lg-4">
                                                <select class="form-select mb-2" id="attributeSelect">
                                                    <option value="">Chọn Attribute</option>
                                                    <option value="attribute1">Attribute 1</option>
                                                    <option value="attribute2">Attribute 2</option>
                                                    <option value="attribute3">Attribute 3</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-input form-control mb-2" id="attributeValue" placeholder="Nhập giá trị attribute">
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="file" id="imageInput" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-secondary mb-2" id="selectImageButton">Chọn Ảnh</button>
                                            </div>
                                        </div>
                                        <!-- Dấu cộng để thêm attribute mới -->
                                        <div id="addNewAttribute" style="cursor: pointer; color: blue; margin-top: 10px; display: none;">
                                            <span>+</span> <span>Thêm Attribute</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    
            
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Gallery</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="dropzone">
                                        <div class="fallback">
                                            <input name="product_galaries[]" type="file" multiple="multiple" >
                                        </div>
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                            </div>

                                            <h4>Drop files here or click to upload.</h4>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <!-- This is used as the file preview template -->
                                            <div class="border rounded">
                                                <div class="d-flex p-2">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded">
                                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="pt-1">
                                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-3">
                                                        <label>
                                                            <input type="radio" name="is_main" class="is-main-checkbox">
                                                        </label>
                                                        <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    
                                    <!-- end dropzon-preview -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Thông tin thêm</h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="tags" class="form-label text-muted">Tags</label>
                                            <input class="form-control" id="tags" data-choices data-choices-limit="3" data-choices-removeItem type="text" placeholder="Add tags..."/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection
<!-- Initialize Quill editor -->

@section('script_libray')
    <script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>

    <script src="{{ asset('theme/assets/js/choices.min.js') }}"></script>

    <!-- dropzone min -->
    <script src="{{ asset('theme/assets/libs/dropzone/dropzone-min.js') }}"></script>
    <!-- filepond js -->
    <script src="{{ asset('theme/assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ asset('theme/assets/js/pages/form-file-upload.init.js')}}"></script>
 
@endsection



@section('scripte_logic')

<script src="{{ asset('theme/assets/js/addProduct.js')}}"></script>

<script>
    CKEDITOR.replace('editor-container');

    // function addImageGallery() {
    //     let id = 'gen' + '_' + Math.random().toString(36).substring(2, 15).toLowerCase();
    //     let html = `
    //         <div class="col-md-4" id="${id}_item">
    //             <label for="${id}" class="form-label">Image</label>
    //             <div class="d-flex">
    //                 <input type="file" class="form-control" name="product_galleries[]" id="${id}">
    //                 <button type="button" class="btn btn-danger" onclick="removeImageGallery('${id}_item')">
    //                     <span class="bx bx-trash"></span>
    //                 </button>
    //             </div>
    //         </div>
    //     `;

    //     $('#gallery_list').append(html);
    // }

    // function removeImageGallery(id) {
    //     if (confirm('Chắc chắn xóa không?')) {
    //         $('#' + id).remove();
    //     }
    // }


</script>


@endsection