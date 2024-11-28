<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('theme/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('theme/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Chính</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Quản lí </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarCalendar" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCalendar" data-key="t-calender">
                                    Đơn hàng
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCalendar">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.orders.listOrder') }}" class="nav-link"
                                                data-key="t-main-calender">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.refunds.index') }}" class="nav-link"
                                                data-key="t-main-refund">Hoàn trả</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            {{-- Quản lý bình luận --}}
                            <li class="nav-item">
                                <a href="#sidebarComment" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarComment" data-key="t-comment">
                                    Bình luận
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarComment">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.comment.index') }}" class="nav-link"
                                                data-key="t-main-list">Danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Quản lý danh mục -->
                            <li class="nav-item">
                                <a href="#sidebarCategory" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCategory" data-key="t-category">
                                    Danh mục
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCategory">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.categories.index') }}" class="nav-link"
                                                data-key="t-category-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.categories.create') }}" class="nav-link"
                                                data-key="t-category-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Quản lý sản phẩm -->
                            <li class="nav-item">
                                <a href="#sidebarProduct" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarProduct" data-key="t-product">
                                    Sản phẩm
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarProduct">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.products.listProduct') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.products.addProduct') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAttribute" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarAttribute"
                                    data-key="t-product">
                                    Thuộc tính
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAttribute">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.attributes.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.attributes.create') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCarrier" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCarrier" data-key="t-product">
                                    Vận chuyển
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCarrier">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.carriers.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.carriers.create') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCoupon" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCoupon" data-key="t-product">
                                    Khuyến mãi
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCoupon">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.coupons.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.coupons.create') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarBlog" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarBlog" data-key="t-product">
                                    Bài viết
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarBlog">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.blogs.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.blogs.create') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarAccount" data-key="t-product">
                                    Tài khoản
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAccount">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.add') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarPermission" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarPermission"
                                    data-key="t-product">
                                    Quyền
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPermission">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permissions.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permissions.create') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarPayment" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarPayment" data-key="t-product">
                                    Thanh Toán
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPayment">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.paymentgateways.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.paymentgateways.add') }}" class="nav-link"
                                                data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarTag" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarTag" data-key="t-product">
                                    Thẻ
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarTag">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.tags.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                            <a href="{{ route('admin.paymentgateways.index') }}" class="nav-link"
                                                data-key="t-product-list">Danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarPage" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarPage" data-key="t-product">
                                    Trang
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPage">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.pages.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.pages.create') }}" class="nav-link" data-key="t-product-list">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebarStatistic" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarStatistic" data-key="t-product">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing"> Thống kê</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarStatistic">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.statistics.index') }}" class="nav-link">
                                    Thống kê sản phẩm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.statistics') }}" class="nav-link">
                                    Thống kê đơn hàng
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebar-display-management" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="#sidebar-display-management">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing">Quản lí hiển thị</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-display-management">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebar-client" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebar-client" data-key="t-client">
                                    Giao diện người dùng
                                </a>
                                <div class="collapse menu-dropdown" id="sidebar-client">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#sidebar-header" class="nav-link" data-bs-toggle="collapse"
                                                role="button" aria-expanded="false" aria-controls="sidebar-header"
                                                data-key="t-header">
                                                Header
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebar-header">
                                                <!-- Thay đổi ID ở đây -->
                                                <a href="{{ route('admin.announcement.edit') }}" class="nav-link" data-key="t-client">Thông báo</a>
                                                <a href="{{ route('admin.info_boxes.edit') }}" class="nav-link" data-key="t-client">Hộp thông tin</a>
                                                <a href="{{ route('admin.popuphome.edit') }}" class="nav-link" data-key="t-client">Popup home</a>

                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.footer.edit') }}" class="nav-link"
                                                data-key="t-client">Footer</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Quản lý danh mục -->
                            <li class="nav-item">
                                <a href="#sidebar-admin" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebar-admin" data-key="t-admin">
                                    Giao diện admin
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                {{-- <li class="nav-item">
                    <a href="#sidebar-display-management" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-display-management" data-key="t-product">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing"> Quản lí hiển thị </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-display-management">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Giao diện người dùng
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCalendar">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.orders.listOrder') }}" class="nav-link"
                                                data-key="t-main-calender">Danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Giao diện người quản lí
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a href="#sidebar-comments-questions" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-comments-questions" data-key="t-product">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing">Gớp ý và câu hỏi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-comments-questions">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Góp ý
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Câu hỏi
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebar-sale-seo" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-sale-seo" data-key="t-product">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing">Quảng cáo</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-sale-seo">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.seo.index')}}" class="nav-link" >
                                    SEO
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    SALE
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebar-post" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-post" data-key="t-product">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing">Bài viết </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-post">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Danh mục
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Sản phẩm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Tin tức
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebar-message" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-message" data-key="t-product">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing">Thông báo </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-message">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Email
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    Trò chuyện
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebar-profile" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-profile" data-key="t-product">
                        <i class="ri-pages-line"></i> <span data-key="t-landing">Hồ sơ </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-profile">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.profile.index') }}" class="nav-link">
                                    Thông tin
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.profile.edit') }}" class="nav-link">
                                    Cài đặt
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.export-import.view-export-import') }}" class="nav-link"  role="button"
                        aria-expanded="false" aria-controls="sidebar-message" data-key="t-product">
                        <i class="ri-rocket-line"></i><span>Xuất và Nhập</span>
                    </a>
                </li>
                <div>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<div class="sidebar-background"></div>
</div>
