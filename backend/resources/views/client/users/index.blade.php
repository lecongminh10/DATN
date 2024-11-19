@extends('client.layouts.app')
@section('style_css')
<style>
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
@endsection
@section('content')
<main class="main home">
    <div class="container mb-2">
        <div class="row">
            <div class="col-lg-9">
                <section class="profile-content">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            @if (empty(Auth::user()->profile_image_url) || !Storage::exists(Auth::user()->profile_image_url))
                                <img src="https://www.transparentpng.com/thumb/user/gray-user-profile-icon-png-fP8Q1P.png" alt="" class="rounded-circle me-2" width="50" height="50">
                            @else
                                <img src="{{ Storage::url(Auth::user()->profile_image_url) }}" alt="{{ Auth::user()->profile_image_url}}" class="rounded-circle me-2" width="50" height="50">
                            @endif
                            <h5 class="mb-0 mx-2">{{ Auth::user()->username }}</h5>
                        </div> 
                        <div id="dashboard" class="dashboard-section">
                            <div class="dashboard-widgets">
                                <div class="widget-card">
                                    <h4 style="font-size: 17px">Tổng số đơn hàng</h4>
                                    <p  >Đơn hàng cá nhân</p>
                                    <a href="{{ route('users.showOrder', Auth::user()->id) }}" class="view-details">Xem chi tiết</a>
                                </div>
                                <div class="widget-card">
                                    <h4 style="font-size: 17px">Điểm thưởng</h4>
                                    <p style="font-size: 15px">500 điểm sẵn có</p>
                                    <a href="#rewards" class="view-details">Đổi điểm</a>
                                </div>
                                <div class="widget-card">
                                    <h4 style="font-size: 17px">Hạng thành viên</h4>
                                    <p style="font-size: 15px">Hạng {{ Auth::user()->membership_level }}</p>
                                    <a href="{{ route('users.showRank', Auth::user()->id) }}" class="view-details">Cập nhật hạng</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="profile" class="profile-section mt-7">
                                <h5 style="font-size: 15px">Thông tin cá nhân</h5>
                    
                                @if (Auth::check())
                                    <div class="profile-info">
                                        <div class="user-details">
                                            <p><strong>Tên:</strong> {{ Auth::user()->username }}</p>
                                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                            <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone_number }}</p>
                                            <p><strong>Hạng thành viên: </strong> {{ Auth::user()->membership_level }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
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
                                <a href="{{ route('users.showRank', Auth::user()->id) }}" class="icon-item">
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
                        </div>
                    </div>
            
                  
            
                </section>
            </div>
            @include('client.users.left_menu')
        </div>
    </div>
</main>
@endsection