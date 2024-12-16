@extends('client.layouts.app')
@section('meta_title')
{{ $page->seo_title }}
@endsection
@section('meta_description')
{{ $page->seo_description }}
@endsection
@section('style_css')
    <style>
        .related-products {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-top: 20px;
        }

        .related-products h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .product-default {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .product-details {
            width: 100%;
            max-width: 300px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-details:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-title {
            font-size: 1.1em;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        .product-title a {
            color: #333;
            text-decoration: none;
        }

        .product-title a:hover {
            color: #08c;
        }

        .price-box {
            text-align: center;
            margin: 10px 0;
        }

        .new-price {
            font-weight: bold;
            color: #08c;
            font-size: 1.2em;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            margin-left: 10px;
        }

        .product-action {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .product-action a {
            text-decoration: none;
            color: #333;
            font-size: 1.2em;
            transition: color 0.3s ease;
        }

        .product-action a:hover {
            color: #08c;
        }

        .btn-add-cart {
            background: #08c;
            color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            text-transform: uppercase;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-add-cart:hover {
            background: #0056b3;
            color: #fff;
        }

        .view-detail {
            border: none;
            background: transparent;
            color: #08c;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .view-detail:hover {
            color: #0056b3;
        }
    </style>
@endsection
@section('content')
    @include('client.layouts.nav')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>
                </ol>
            </div><!-- End .container -->
        </nav>
    
        <div class="container">
            <div class="row">
                <div class="col-lg-12 order-lg-1">
                    <hr class="mt-2 mb-1">
                    <div class="page-content">
                        {!! $page->content !!}  <!-- Render the page content here (supports HTML) -->
                    </div>
                    <div class="page-description">
                        <p>{{ $page->description }}</p>  <!-- Page description -->
                    </div>
                </div><!-- End .col-lg-9 -->
    
                <div class="sidebar-toggle custom-sidebar-toggle">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="sidebar-overlay"></div>
                <div class="col-lg-3 order-lg-3">
                    <div class="sidebar-wrapper" data-sticky-sidebar-options='{"offsetTop": 72}'>
                        <!-- Sidebar content goes here -->
                    </div><!-- End .sidebar-wrapper -->
                </div><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </main><!-- End .main -->
    
@endsection
@section('scripte_logic')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
@endsection
