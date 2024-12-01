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

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-family: Arial, sans-serif;
        }

        .table .thead {
            background-color: rgb(198, 223, 233);
            color: #000;
            font-weight: bold;
        }

        .table th {
            padding: 12px;
            border-bottom: 2px solid #ccc;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .table.text-center td,
        .table.text-center th {
            text-align: center;
            vertical-align: middle;
        }

        .table td img {
            max-width: 50px;
            border-radius: 4px;
        }

        .table td:last-child {
            font-weight: bold;
        }

        .table-borderless td,
        .table-borderless th {
            border: none;
        }

        .table-nowrap {
            white-space: nowrap;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .status-pending {
            color: #ffeb3b;
            font-weight: bold;
        }

        .status-confirming {
            color: #2196f3;
            font-weight: bold;
        }

        .status-canceled {
            color: #f44336;
            font-weight: bold;
        }

        .status-confirmed {
            color: #4caf50;
            font-weight: bold;
        }

        .status-completed {
            color: #8bc34a;
            font-weight: bold;
        }

        .status-lost {
            color: #9e9e9e;
            font-weight: bold;
        }

        .pagination-wrapper {
            text-align: center;
            margin-top: 20px;
        }

        .pagination {
            display: inline-flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #0088cc;
            transition: background-color 0.3s;
        }

        .pagination li a:hover,
        .pagination li span.active {
            background-color: #0088cc;
            color: white;
            border-color: #0088cc;
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
                                <a href="?status=Chờ xác nhận" class="{{ $status == 'Chờ xác nhận' ? 'active' : '' }}">Chờ
                                    xác nhận</a>
                                <a href="?status=Đang giao" class="{{ $status == 'Đang giao' ? 'active' : '' }}">Đang
                                    giao</a>
                                <a href="?status=Đã xác nhận" class="{{ $status == 'Đã xác nhận' ? 'active' : '' }}">Đã xác
                                    nhận</a>
                                <a href="?status=Hoàn thành" class="{{ $status == 'Hoàn thành' ? 'active' : '' }}">Hoàn
                                    thành</a>
                                <a href="?status=Đã hủy" class="{{ $status == 'Đã hủy' ? 'active' : '' }}">Đã hủy</a>
                                <a href="?status=Hàng thất lạc"
                                    class="{{ $status == 'Hàng thất lạc' ? 'active' : '' }}">Hàng thất lạc</a>
                            </div>

                            <div class="container ">
                                <div class="total-orders">
                                    Tổng số đơn hàng: {{ $totalOrders }}
                                </div>

                                <div class="order-details">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="thead">
                                                <th scope="col">STT</th>
                                                <th scope="col">Mã CODE</th>
                                                <th scope="col">Ảnh sản phẩm</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái</th>
                                                <th scope="col">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->code }}</td>
                                                    <td>
                                                        @php
                                                            foreach ($value->items as $val) {
                                                                $img = '';
                                                                $variant = $val->productVariant;
                                                                if (!empty($variant)) {
                                                                    $img = $val->productVariant->variant_image;
                                                                } else {
                                                                    $img = $val->product->getMainImage()->image_gallery;
                                                                }
                                                            }
                                                        @endphp
                                                        <img src="{{ Storage::url($img) }}" alt="Ảnh sản phẩm"
                                                            width="100px" height="100px">
                                                    </td>
                                                    <td>{{ number_format($value->total_price, 0, ',', '.') }} VNĐ</td>
                                                    <td
                                                        class="
                                                            @if ($value->status === 'Đang giao') status-pending
                                                            @elseif($value->status === 'Chờ xác nhận') status-confirming
                                                            @elseif($value->status === 'Đã hủy') status-canceled
                                                            @elseif($value->status === 'Đã xác nhận') status-confirmed
                                                            @elseif($value->status === 'Hoàn thành') status-completed
                                                            @elseif($value->status === 'Hàng thất lạc') status-lost @endif
                                                        ">
                                                        {{ $value->status }}
                                                    </td>
                                                    <td><a class=""
                                                            href="{{ route('users.showDetailOrder', $value->id) }}">Chi
                                                            tiết</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="pagination-wrapper">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('client.users.left_menu')
            </div>
        </div>
    </main>
@endsection
