<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Tổng thể */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px; /* Kích thước chữ nhỏ hơn */
            color: #333; /* Màu chữ tiêu chuẩn */
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9; /* Màu nền nhạt */
        }

        /* Nội dung email */
        .email-content {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Định dạng bảng nếu có */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* table th {
            background-color: #f2f2f2;
        } */

        /* Chèn hình ảnh */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Links */
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p, h1, h2, h3, h4, h5, h6 {
            margin: 0 0 10px;
            font-weight: normal; /* Không đậm */
            font-size: 14px; /* Kích thước nhỏ */
            color: #333; /* Màu chữ tiêu chuẩn */
        }
    </style>
</head>
<body>
    <h1>{!! $message !!}</h1> <!-- Hiển thị giá trị message -->
    {{-- <p>This is the content of your email.</p> --}}
</body>
</html>
