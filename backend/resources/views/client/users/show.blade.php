@extends('client.layouts.app')
@section('style_css')
<style>
.card-header img {
    border: 2px solid #007bff; /* Change to your desired color */
    /* Add other custom styles here if needed */
}
.custom-select {
    width: 100%; /* Full width */
    padding: 0.5rem; /* Padding for spacing */
    border: 1px solid #ced4da; /* Light gray border */
    border-radius: 0.25rem; /* Slightly rounded corners */
    background-color: #ffffff; /* White background */
    font-size: 1rem; /* Font size */
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; /* Transition for effects */
    max-height: 46px !important;
}

.custom-select:focus {
    border-color: #80bdff; /* Blue border on focus */
    outline: 0; /* Remove default outline */
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Add a shadow effect */
}

/* Optional: Styling for the option elements (not all browsers support this) */
.custom-select option {
    padding: 1rem; /* Padding for options */
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
                        <img src="{{ Storage::url(Auth::user()->profile_image_url) }}" alt="{{ Auth::user()->profile_image_url}}" class="rounded-circle me-2" width="50" height="50">
                        <h5 class="mb-0 mx-2">{{ Auth::user()->username }}</h5>
                    </div>                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.updateClient', Auth::user()->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="user-info mb-3">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Họ và tên:</label>
                                    <input type="text" id="username" name="username" class="form-control" value="{{ Auth::user()->username }}">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Giới tính:</label>
                                    <select name="gender" id="gender" class="custom-select">
                                        <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                                        <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                </div>
                                        
                    
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Số điện thoại:</label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}">
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ:</label>
                                    <input type="text" id="address" name="address" class="form-control" value="{{ $address->address_line }}">
                                </div>
                    
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Ngày sinh:</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                                        value="{{ Auth::user()->date_of_birth ?? '' }}">
                                    @error('date_of_birth')
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
