    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .logout-btn {
            color: white;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #444;
        }

        /* Profile Container */
        .profile-container {
            display: flex;
            flex-wrap: wrap;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            width: 20%;
            background-color: #f0f0f0;
            padding: 20px;
            min-width: 250px;
            padding-bottom: 210px
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a {
            color: #333;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            background-color: #fff;
            border: 1px solid #ddd;
            transition: background-color 0.3s, color 0.3s, border 0.3s;
        }

        .sidebar-menu a.active,
        .sidebar-menu a:hover {
            background-color: #386ce6;
            color: white;
            border-color: transparent;
        }
    </style>

    <main class="profile-container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="{{route('users.indexClient')}}" ><i class="fas fa-home"></i> Trang chủ</a></li>
                <li><a href="{{ route('users.showClient', Auth::user()->id) }}"><i class="fas fa-user"></i> Thông tin tài
                        khoản</a></li>
                <li><a href="#orders"><i class="fas fa-shopping-bag"></i> Lịch sử mua hàng</a></li>
                <li><a href="#rewards"><i class="fas fa-gift"></i> Ưu đãi</a></li>
                <li><a href="#settings"><i class="fas fa-medal"></i> Hạng thành viên</a></li>
                <li><a href="#support"><i class="fas fa-headset"></i> Hỗ trợ</a></li>
                <li><a href="#logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </aside>
    </main>
