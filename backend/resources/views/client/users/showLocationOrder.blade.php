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
            margin-bottom: 215px;
            margin-left: 80px
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
        input[type="date"] {
            padding: 12px;
            border: 2px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus {
            border-color: #007bff;
            outline: none;
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
            <h2>Chi tiết vị trí đơn hàng</h2>
        </div>
        <ul class="user-info">
            <li>
                <label for="address">Địa chỉ:</label>
                <span id="address">{{ $location->address }}</span>
            </li>
            <li>
                <label for="city">Thành phố:</label>
                <span id="city">{{ $location->city }}</span>
            </li>
            <li>
                <label for="district">Quận/Huyện:</label>
                <span id="district">{{ $location->district }}</span>
            </li>
            <li>
                <label for="ward">Phường/Xã:</label>
                <span id="ward">{{ $location->ward }}</span>
            </li>
            <li>
                <label for="latitude">Vĩ độ:</label>
                <span id="latitude">{{ $location->latitude }}</span>
            </li>
            <li>
                <label for="longitude">Kinh độ:</label>
                <span id="longitude">{{ $location->longitude }}</span>
            </li>
        </ul>
    </div>
@endsection
