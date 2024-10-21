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
            margin-bottom: 220px;
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
            <h2>{{ $orders->code }}</h2>
        </div>
        <ul class="user-info">
            <li>
                <label for="code">Mã vận chuyển:</label>
                <span id="code">{{ $orders->code }}</span>
            </li>

            <li>
                <label for="total_price">Tổng giá sản phẩm:</label>
                <span id="total_price">{{ $orders->total_price }}</span>
            </li>

            <li>
                <label for="status">Trạng thái:</label>
                <span id="status">{{ $orders->status }}</span>
            </li>

            <li>
                <label for="tracking_number">Mã theo dõi nhà vận chuyển:</label>
                <span id="tracking_number">{{ $orders->tracking_number }}</span>
            </li>

            <li>
                <label for="note">Ghi chú:</label>
                <span id="note">{{ $orders->note }}</span>
            </li>

            <li>
                @if ($location)
                    <a href="{{ route('users.showLocationOrder', $location->id) }}" class="location-btn">Xem vị trí</a>
                @else
                    <p>Không có thông tin vị trí cho đơn hàng này.</p>
                @endif
            </li>
        </ul>

    </div>
@endsection
