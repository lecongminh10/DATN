@extends('client.layouts.app')

@section('style_css')
    <style>
        .profile-content {
            background-color: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            font-size: 30px;
            font-weight: 700;
            color: rgb(37, 196, 196);
            margin-bottom: 25px;
        }

        .membership-level {
            display: inline-block;
            background-color: #ffd2d2;
            padding: 8px 18px;
            border-radius: 20px;
            color: rgb(37, 196, 196);
            font-weight: bold;
            margin-left: 15px;
            font-size: 16px;
        }

        .profile-info h6 {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
            font-weight: 500;
        }

        .membership-container {
            margin-top: 40px;
        }

        .membership-options {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .membership-option {
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            padding: 15px 25px;
            border-radius: 8px;
            text-align: center;
            width: 22%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .membership-option:hover {
            background-color: rgb(37, 196, 196);
            color: white;
            border-color: rgb(37, 196, 196);
        }

        .membership-option label {
            font-size: 16px;
            font-weight: 600;
        }

        .content-display {
            margin-top: 30px;
            padding: 25px;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #555;
            text-align: center;
        }

        .progress-bar-container {
            margin-top: 40px;
            text-align: center;
        }

        .progress-bar {
            position: relative;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            width: 100%;
        }

        .progress {
            height: 100%;
            width: 0;
            background-color: rgb(37, 196, 196);
            border-radius: 10px;
            text-align: center;
            color: white;
            font-weight: bold;
            line-height: 20px;
        }

        .target-text {
            margin-top: 10px;
            color: #555;
            font-size: 14px;
        }

        .hoten {
            display: flex;
            color: black;
            font-weight: bold;
        }

        .hoten h5 {
            color: rgb(37, 196, 196);
        }

        .sdt {
            display: flex;
            color: black;
            font-weight: bold;
        }

        .sdt h5 {
            color: rgb(37, 196, 196);
        }

        .diem {
            display: flex;
            color: black;
            font-weight: bold;
        }

        .diem h5 {
            color: rgb(37, 196, 196);
        }

        .hang {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin-top: 15px;
        }

        .hang p {
            color: rgb(37, 196, 196);
        }
    </style>
@endsection



@section('content')
    <main class="main home">
        <div class="container mb-2">
            <div class="row">
                <div class="col-lg-9">
                    <div class="profile-content">

                        <div class="">
                            <h3>Hạng thành viên</h3>
                        </div>
                        <div>
                            <div class="hoten">
                                Họ tên : <h5> {{ Auth::user()->username }}</h5>
                            </div>
                            <div class="sdt">
                                Số điện thoại : <h5> {{ Auth::user()->phone_number }}</h5>
                            </div>
                            <div class="diem">
                                Điểm hạng : <h5> {{ Auth::user()->loyalty_points }}</h5>
                            </div>
                        </div>
                        <div class="hang">
                            Hạng thành viên: <p>{{ Auth::user()->membership_level }}</p>
                        </div>
                        <div class="membership-container">
                            <div class="membership-options">
                                <div class="membership-option" onclick="showContent('Bronze')">
                                    <label>Bronze</label>
                                </div>
                                <div class="membership-option" onclick="showContent('Silver')">
                                    <label>Silver</label>
                                </div>
                                <div class="membership-option" onclick="showContent('Gold')">
                                    <label>Gold</label>
                                </div>
                                <div class="membership-option" onclick="showContent('Platinum')">
                                    <label>Platinum</label>
                                </div>
                            </div>
                        </div>
                        <div id="dynamic-content" class="content-display">
                            <!-- Nội dung sẽ thay đổi dựa trên lựa chọn -->
                            Vui lòng chọn hạng thành viên để xem chi tiết.
                        </div>
                    </div>
                </div>
                @include('client.users.left_menu')
            </div>
        </div>
    </main>

    <script>
        function showContent(type) {
            let content = "";

            switch (type) {
                case 'Bronze':
                    content =
                        "<strong>Bronze:</strong> Là hạng thành viên khởi đầu, đặc biệt dành cho học sinh và sinh viên đang tìm kiếm các ưu đãi tiết kiệm nhất.<br> " +
                        "Khách hàng hạng Bronze sẽ được hưởng những chương trình giảm giá đặc biệt khi mua sắm các sản phẩm cơ bản và phụ kiện.<br> " +
                        "Ngoài ra, hạng thành viên này cũng cung cấp ưu đãi độc quyền trong các chương trình khuyến mãi theo mùa, " +
                        "giúp bạn tiết kiệm tối đa chi phí mà vẫn có thể sở hữu các sản phẩm chất lượng.";
                    break;
                case 'Silver':
                    content =
                        "<strong>Silver:</strong> Là hạng thành viên trung cấp với các ưu đãi vượt trội hơn dành cho khách hàng thân thiết.<br> " +
                        "Thành viên Silver có thể tận dụng mức chiết khấu cao hơn cho một số dòng sản phẩm cụ thể và nhận được ưu tiên " +
                        "trong các chương trình mua sắm sớm hoặc giảm giá đặc biệt.<br> Bên cạnh đó, dịch vụ hậu mãi được nâng cấp giúp " +
                        "thành viên Silver nhận được hỗ trợ nhanh chóng và chu đáo hơn.";
                    break;
                case 'Gold':
                    content =
                        "<strong>Gold:</strong> Là hạng thành viên cao cấp dành cho khách hàng thường xuyên và có nhiều hoạt động mua sắm tại hệ thống.<br> " +
                        "Hạng Gold mang lại những ưu đãi hấp dẫn như giảm giá lớn hơn cho các sản phẩm chủ lực, " +
                        "quyền lợi đổi trả linh hoạt hơn và tham gia vào các sự kiện độc quyền.<br> Khách hàng Gold cũng được hưởng ưu đãi đặc biệt " +
                        "trong các dịp lễ, sự kiện và nhận thông báo sớm nhất về các đợt giảm giá lớn, giúp tối ưu hóa trải nghiệm mua sắm.";
                    break;
                case 'Platinum':
                    content =
                        "<strong>Platinum:</strong> Là hạng thành viên cao cấp nhất, dành cho những khách hàng trung thành và có giá trị mua sắm lớn.<br> " +
                        "Hạng Platinum mang đến những quyền lợi đặc biệt như chiết khấu cao nhất, dịch vụ chăm sóc khách hàng ưu tiên " +
                        "với đội ngũ hỗ trợ riêng.<br> Thành viên Platinum có quyền truy cập sớm vào các sản phẩm mới và giảm giá mạnh cho " +
                        "các sản phẩm cao cấp.<br> Khách hàng còn được mời tham gia các sự kiện VIP, chương trình trải nghiệm sản phẩm đặc biệt, " +
                        "tạo nên một trải nghiệm mua sắm đẳng cấp và khác biệt.";
                    break;
                default:
                    content = "Vui lòng chọn hạng thành viên để xem chi tiết.";
            }

            // Cập nhật nội dung trong phần hiển thị
            document.getElementById('dynamic-content').innerHTML = content;
        }
    </script>
@endsection
