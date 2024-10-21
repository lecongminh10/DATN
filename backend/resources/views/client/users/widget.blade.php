@extends('client.users.app')

@section('content')
    <style>
        .profile-content {
            width: 80%;
            padding: 20px;
            min-width: 500px;
        }

        .dashboard-widgets {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .dashboard-section h2{
            margin-left: 25px
        }

        .widget-card {
            background-color: #f8f8f8;
            padding: 20px;
            flex: 1;
            border-radius: 10px;
            text-align: center;
            min-width: 200px;
        }

        .widget-card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .widget-card p {
            margin: 15px 0;
            font-size: 16px;
        }

        .view-details {
            color: #386ce6;
            font-weight: bold;
        }
        
        .profile-section h5 {
            font-size: 24px;
            color: #386ce6;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            border-bottom: 2px solid #386ce6;
            padding-bottom: 10px;
        }

        .profile-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-details p {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
        }

        .edit-btn {
            padding: 10px 20px;
            background-color: #386ce6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-btn:hover {
            background-color: #5a9eff;
        }

        /* Icon Section */
        .icon-section {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .icon-item {
            text-align: center;
            position: relative;
            text-decoration: none;
            color: #333;
            width: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .icon {
            width: 60px;
            height: 60px;
            background-color: #eaf3ff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 8px;
        }

        .icon i {
            font-size: 28px;
            color: #333;
        }

        .label {
            font-size: 14px;
            color: #333;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 3px;
            font-weight: bold;
        }

        .badge-hot {
            background-color: #ff0000;
            color: white;
        }

        .badge-new {
            background-color: #ff0000;
            color: white;
        }

        .icon-item:hover {
            color: #87a5eb;
        }

        .icon-item:hover .icon {
            background-color: #87a5eb;
        }

        .icon-item:hover .badge {
            background-color: #87a5eb;
        }
    </style>

    <section class="profile-content">
        <div id="dashboard" class="dashboard-section">
            <h2>Trang chủ</h2>
            <div class="dashboard-widgets">
                <div class="widget-card">
                    <h3>Tổng số đơn hàng</h3>
                    <p>Đơn hàng cá nhân</p>
                    <a href="{{ route('users.showOrder', Auth::user()->id) }}" class="view-details">Xem chi tiết</a>
                </div>
                <div class="widget-card">
                    <h3>Điểm thưởng</h3>
                    <p>500 điểm sẵn có</p>
                    <a href="#rewards" class="view-details">Đổi điểm</a>
                </div>
                <div class="widget-card">
                    <h3>Hạng thành viên</h3>
                    <p>Hạng 1</p>
                    <a href="#profile" class="view-details">Cập nhật hạng</a>
                </div>
            </div>
        </div>

        <div id="profile" class="profile-section mt-7">
            <h5>Thông tin cá nhân</h5>

            @if (Auth::check())
                <div class="profile-info">
                    <div class="user-details">
                        <p><strong>Tên:</strong> {{ Auth::user()->username }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone_number }}</p>
                        <p><strong>Điểm khách hàng thân thiết:</strong> {{ Auth::user()->loyalty_points }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="icon-section">
            <a href="#order-history" class="icon-item">
                <div class="icon"><i class="fas fa-history"></i></div>
                <span class="label">Lịch sử mua hàng</span>
            </a>
            <a href="#s-student" class="icon-item">
                <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                <span class="label">Hỗ trợ</span>
            </a>
            <a href="#discounts" class="icon-item">
                <div class="icon"><i class="fas fa-ticket-alt"></i></div>
                <span class="label">Mã giảm giá</span>
                <span class="badge badge-hot">HOT</span>
            </a>
            <a href="#membership" class="icon-item">
                <div class="icon"><i class="fas fa-medal"></i></div>
                <span class="label">Hạng thành viên</span>
                <span class="badge badge-new">MỚI</span>
            </a>
            <a href="#account-link" class="icon-item">
                <div class="icon"><i class="fas fa-link"></i></div>
                <span class="label">Liên kết tài khoản</span>
                <span class="badge badge-new">MỚI</span>
            </a>
        </div>

    </section>
@endsection
