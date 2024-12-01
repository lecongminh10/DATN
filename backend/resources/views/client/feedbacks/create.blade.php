@extends('client.layouts.app')

@section('style_css')
    <style>
        /* Form Container */
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            color: #386ce6;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }

        .form-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #386ce6;
            box-shadow: 0 0 5px rgba(56, 108, 230, 0.5);
        }

        .form-control.error {
            border-color: #ff4d4d;
        }

        .form-text {
            font-size: 12px;
            color: #777;
        }

        .btn-primary {
            background-color: #386ce6;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #5a9eff;
        }

        .alert {
            font-size: 14px;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #e6ffe6;
            color: #2d7d2d;
            border: 1px solid #c2eac2;
        }

        .alert-danger {
            background-color: #ffe6e6;
            color: #7d2d2d;
            border: 1px solid #eac2c2;
        }

        .form-container {
            width: 100%;
            max-width: 800px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        iframe {
            width: 100%;
            height: 600px;
            border: none;
        }

        .form-container .iframe-wrapper {
            position: relative;
            padding-top: 75%;
            /* Giữ tỷ lệ khung hình */
        }

        .form-container .iframe-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content')
    <main class="main home">
        <div class="container mb-2">
            <div class="row">
                <div class="col-lg-9">
                    <section class="profile-content">
                        <div class="form-container">
                            <div class="iframe-wrapper">
                                <iframe src="https://forms.gle/HXFGDpCtNmHKBM1X6" allowfullscreen>
                                    Loading...
                                </iframe>
                            </div>
                        </div>
                    </section>
                </div>
                @include('client.users.left_menu')
            </div>
        </div>
    </main>
@endsection
