@extends('client.layouts.app')

@section('style_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .voucher-icon {
        border-radius: 10px 0 0 10px;
    }
    .voucher-item {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .voucher-search .form-control{
        width: 300px; 
        height: 35px;
    }

    .voucher-search .btn-search{
        height: 35px; 
        width: 46px;
        border-radius: 2px;
        border: 0.5px solid silver;
        text-transform: uppercase;
    }
    .voucher-search .btn-search:hover{
        background-color: dimgray; 
        color: azure;
    }
    .voucher-icon{
    }
</style>
@endsection

@section('content')
<main class="main home mt-5">
    <div class="container mb-2">
        <div class="row mb-3 pb-3">
            <div class="col-lg-9">
                <!-- Voucher Header -->
                <div class="container pl-5 pr-5 pb-3 voucher-container">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <div class="voucher-header d-flex justify-content-between mt-3">
                            <h2 class="">Kho Voucher</h2>
                            <div class="voucher-search" style="height: 60px;">
                                <form method="GET" action="{{ route('users.listVoucher') }}">
                                    <input type="text" name="search_code" placeholder="Nhập mã voucher tại đây" class="form-control d-inline" value="{{ request('search_code') }}">
                                    <button type="submit" class="btn-search">Tìm</button>
                                </form>
                            </div>
                        </div>
                
                        <!-- Voucher Items -->
                        @foreach ($coupons as $key => $item)
                            <div class="voucher-items mt-3">
                                <div class="voucher-item border p-3 mb-3 d-flex">
                                    <div class="voucher-icon text-white text-center p-3" style="background-color: #20c997; width: 120px; display: flex; align-items: center; justify-content: center;">
                                        <h4 class="font-weight-bold mb-0" style="color: aliceblue">{{ $item->code }}</h4>
                                    </div>
                                    <div class="voucher-details ml-3">
                                        <h5>{{ $item->description }}</h5>
                                        <p>Đơn Tối Thiểu {{ number_format($item->min_order_value, 0, ',', '.') }} ₫</p>
                                        <p class="text-muted">
                                            <i class="fa fa-clock"></i> Hạn đến: {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
            @include('client.users.left_menu')
        </div>
    </div>
</main>
@endsection

@section('script_libray')

@endsection

@section('scripte_logic')

@endsection
