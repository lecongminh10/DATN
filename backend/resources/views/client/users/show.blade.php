@extends('client.users.app')

@section('content')
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .profile-content {
            width: 80%;
            max-width: 700px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            color: #343a40;
            font-size: 28px;
            margin: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #495057;
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            padding: 12px;
            border: 2px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            transition: border-color 0.3s ease;
            background-color: #ffffff;
            /* Màu nền */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #007bff;
            /* Màu viền khi chọn */
            outline: none;
            /* Ẩn viền khi có focus */
        }

        .edit-btn {
            padding: 12px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .profile-content {
                padding: 20px;
            }

            .user-info {
                gap: 10px;
            }

            .edit-btn {
                width: 100%;
            }
        }
    </style>
    <div class="profile-content">
        <div class="profile-header">
            <h2>{{ Auth::user()->username }}</h2>
        </div>
        <form method="POST" action="{{ route('users.updateClient', Auth::user()->id) }}">
            @csrf
            @method('PUT')
            <div class="user-info">
                <label for="username">Họ và tên:</label>
                <input type="text" id="username" name="username" value="{{ Auth::user()->username }}">
                @error('username')
                    <span class="text-danger">Họ và tên không được để trống.</span>
                @enderror

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}">
                @error('email')
                    <span class="text-danger">Email không được để trống.</span>
                @enderror

                <label for="gender">Giới tính:</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Khác</option>
                </select>

                <label for="phone_number">Số điện thoại:</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ Auth::user()->phone_number }}">
                @error('phone_number')
                    <span class="text-danger">Số điện thoại không được để trống.</span>
                @enderror

                <label for="phone_number">Địa chỉ:</label>
                <input type="text" id="address" name="address" value="{{ $address->address_line }}">

                <label for="date_of_birth">Ngày sinh:</label>
                <input type="date" id="date_of_birth" name="date_of_birth"
                    value="{{ Auth::user()->date_of_birth ?? '' }}">
                @error('date_of_birth')
                    <span class="text-danger">Ngày sinh không được để trống.</span>
                @enderror
            </div>
            <button type="submit" class="edit-btn">Cập nhật thông tin</button>
            <a href="{{ route('users.indexClient') }}" class="edit-btn">Quay về</a>
        </form>
    </div>
@endsection
