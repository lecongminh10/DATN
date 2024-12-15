<!DOCTYPE html>
<html>
<head>
    <title>Google Form</title>
    <style>
        /* Reset mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
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
            padding-top: 75%; /* Giữ tỷ lệ khung hình */
        }

        .form-container .iframe-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Đánh giá từ Google Form</h1>
        <div class="iframe-wrapper">
            <!-- Nhúng iframe -->
            <iframe src="https://forms.gle/HXFGDpCtNmHKBM1X6" allowfullscreen>
                Loading...
            </iframe>
        </div>
    </div>
</body>
</html>
