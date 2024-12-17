@extends('client.layouts.app')
@section('style_css')
<style>
.card-header img {
    border: 2px solid #007bff; 
}
.custom-select {
    width: 100%;
    padding: 0.5rem; 
    border: 1px solid #ced4da; 
    border-radius: 0.25rem; 
    background-color: #ffffff; 
    font-size: 1rem; 
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    max-height: 46px !important;
}

.custom-select:focus {
    border-color: #80bdff; 
    outline: 0; 
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); 
}

.custom-select option {
    padding: 1rem; 
}


</style>
@endsection
@section('content')
<main class="main home">
    <div class="container mb-2">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <?php
                            $image = Auth::user()->profile_picture ?? 'https://www.transparentpng.com/thumb/user/gray-user-profile-icon-png-fP8Q1P.png';
                        ?>
                        @if ($image)
                        <img src="{{ Storage::url($image) }}" 
                            alt="{{ Auth::user()->username }}" 
                            class="rounded-circle me-2" 
                            style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                        
                        <h5 class="mb-0 mx-2">{{ Auth::user()->username }}</h5>
                    </div>                  
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.updateClient', Auth::user()->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="user-info mb-3 p-4 border rounded bg-light shadow-sm">
                                <div class="mb-2">
                                    <label for="username" class="form-label fw-bold">Họ và tên  <span class="text-secondary">*</span></label>
                                    <input type="text" id="username" name="username" class="form-control" 
                                           value="{{ Auth::user()->username }}">
                                    @error('username')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                <div class="mb-2">
                                    <label for="email" class="form-label fw-bold">Email  <span class="text-secondary">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" 
                                           value="{{ Auth::user()->email }}">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="gender" class="form-label fw-bold">Giới tính <span class="text-secondary">*</span></label>
                                    <select name="gender" id="gender" class="form-control" style="height: 46px;">
                                        <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                                        <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                </div>                                
                            
                                <div class="mb-2">
                                    <label for="phone_number" class="form-label fw-bold">Số điện thoại  <span class="text-secondary">*</span></label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control" 
                                           value="{{ Auth::user()->phone_number }}">
                                    @error('phone_number')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                <div class="mb-2">
                                    <label for="date_of_birth" class="form-label fw-bold">Ngày sinh <span class="text-secondary">*</span></label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" 
                                           value="{{ Auth::user()->date_of_birth ?? '' }}">
                                    @error('date_of_birth')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="profile_picture" class="form-label fw-bold">Ảnh đại diện <span class="text-secondary">*</span></label>
                                    <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                                    @error('profile_picture')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                
                            </div>
                            
                            <div class="float-rigth">
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                                <a href="{{ route('users.indexClient') }}" class="btn btn-secondary">Quay về</a>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
            @include('client.users.left_menu')
        </div>
    </div>
</main>
@endsection
