@extends('client.layouts.app')
@section('style_css')
<style>
        .orders-page .nav-bar {
            display: flex;
            justify-content: space-between;
            background-color: #0088cc;
            padding: 10px 20px;
            color: white;
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 5px;
        }

        .orders-page .nav-bar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            margin: 0 5px;
            transition: background-color 0.3s;
        }

        .orders-page .nav-bar a.active,
        .orders-page .nav-bar a:hover {
            background-color: white;
            color: #5a9eff;
            border-radius: 5px;
        }

        .orders-page .container {
            margin: 30px auto;
            background-color: #fff;
            padding: 20px 5px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .orders-page .total-orders {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
            color: #333;
        }

        .detail {}

        .orders-page .order-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .orders-page .order-item h4 {
            margin: 0;
            font-size: 18px;
        }

        .orders-page .order-item p {
            margin: 5px 0;
        }

        .orders-page .order-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .orders-page .order-item a {
            text-decoration: none;
            color: #5a9eff;
            font-weight: bold;
            transition: color 0.3s;
        }

        .orders-page .order-item a:hover {
            color: #386ce6;
        }
</style>
@endsection
@section('content')
<main class="main home">
    <div class="container mb-2">
        <div class="row">
            <div class="col-lg-9">
                <div class="profile-content">
                    <div class="orders-page">
                        <div class="nav-bar">
                            <a href="?status=all" class="{{ $status == 'all' ? 'active' : '' }}">Tất cả</a>
                            <a href="?status=Chờ xác nhận" class="{{ $status == 'Chờ xác nhận' ? 'active' : '' }}">Chờ xác nhận</a>
                            <a href="?status=Đang giao" class="{{ $status == 'Đang giao' ? 'active' : '' }}">Đang giao</a>
                            <a href="?status=Đã xác nhận" class="{{ $status == 'Đã xác nhận' ? 'active' : '' }}">Đã xác nhận</a>
                            <a href="?status=Hoàn thành" class="{{ $status == 'Hoàn thành' ? 'active' : '' }}">Hoàn thành</a>
                            <a href="?status=Đã hủy" class="{{ $status == 'Đã hủy' ? 'active' : '' }}">Đã hủy</a>
                            <a href="?status=Hàng thất lạc" class="{{ $status == 'Hàng thất lạc' ? 'active' : '' }}">Hàng thất lạc</a>
                        </div>
            
                        <div class="container">
                            <div class="total-orders">
                                Tổng số đơn hàng: {{ $totalOrders }}
                            </div>
            
                            @foreach ($orders as $key => $value)
                                <div class="detail">
                                    <div class="order-item">
                                        <h4>Đơn hàng #{{ $value->code }}</h4>
                                        <p>Tổng giá: {{ number_format($value->total_price, 0, ',', '.') }} VNĐ</p>
                                        <p>Trạng thái: {{ $value->status }}</p>
                                        <a href="{{ route('users.showDetailOrder', $value->id) }}">Chi tiết</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @include('client.users.left_menu')
        </div>
    </div>
</main>
@endsection
