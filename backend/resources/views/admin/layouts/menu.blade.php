<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box py-3">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('logo.png') }}" alt="" width="130">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('logo.png') }}" alt="" width="130">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('logo.png') }}" alt="" width="130">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('logo.png') }}" alt="" width="130">
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
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}" 
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Trang chủ</span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @php
                    $check='';
                    $check2='';
                    if(Route::is('admin.orders.listOrder','admin.comment.index','admin.categories.*',
                    'admin.products.*','admin.attributes.*','admin.carriers.*','admin.coupons.*',
                    'admin.users.*','admin.permissions.*','admin.paymentgateways.*','admin.tags.*',
                    'admin.footer.edit' ,'admin.pages.*',
                    )){
                        $check="active";
                        $check2="show";
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu-link {{$check}}" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Quản lí </span>
                    </a>
                    <div class="collapse menu-dropdown  {{$check2}}" id="sidebarApps">
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
                                            <a href="{{ route('refunds.index') }}" class="nav-link"
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
                                            <a href="{{ route('admin.comment.index') }}" class="nav-link {{ request()->routeIs('admin.comment.index') ? 'active' : '' }}" data-key="t-main-list">
                                                Danh sách
                                            </a>
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
                                            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}" data-key="t-category-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.categories.create') }}" class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}" data-key="t-category-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.products.listProduct') }}" class="nav-link {{ request()->routeIs('admin.products.listProduct') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.products.addProduct') }}" class="nav-link {{ request()->routeIs('admin.products.addProduct') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.attributes.index') }}" class="nav-link {{ request()->routeIs('admin.attributes.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.attributes.create') }}" class="nav-link {{ request()->routeIs('admin.attributes.create') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.carriers.index') }}" class="nav-link {{ request()->routeIs('admin.carriers.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.carriers.create') }}" class="nav-link {{ request()->routeIs('admin.carriers.create') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.coupons.create') }}" class="nav-link {{ request()->routeIs('admin.coupons.create') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.add') }}" class="nav-link {{ request()->routeIs('admin.users.add') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permissions.create') }}" class="nav-link {{ request()->routeIs('admin.permissions.create') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.paymentgateways.index') }}" class="nav-link {{ request()->routeIs('admin.paymentgateways.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.paymentgateways.add') }}" class="nav-link {{ request()->routeIs('admin.paymentgateways.add') ? 'active' : '' }}" data-key="t-product-add">Thêm mới</a>
                                        </li>                                        
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.tags.index') }}" class="nav-link{{ request()->routeIs('admin.tags.index') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false">
                                    Thẻ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarPage" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarPage" data-key="t-product">
                                    Trang
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPage">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.index') ? 'active' : '' }}" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.pages.create') }}" class="nav-link {{ request()->routeIs('admin.pages.create') ? 'active' : '' }}" data-key="t-product-list">Thêm mới</a>
                                        </li>                                        
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebarStatistic" class="nav-link {{ Route::is('admin.statistics.*','admin.orders.statistics') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Route::is('admin.statistics.*') ? 'true' : 'false' }}" aria-controls="sidebarStatistic" data-key="t-product">
                        <i class="ri-numbers-line"></i> <span data-key="t-landing"> Thống kê</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.statistics.*','admin.orders.statistics') ? 'show' : '' }}" id="sidebarStatistic">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.statistics.categories') }}" class="nav-link {{ Route::is('admin.statistics.categories') ? 'active' : '' }}">
                                    Thống kê danh mục
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.statistics.index') }}" class="nav-link {{ Route::is('admin.statistics.index') ? 'active' : '' }}">
                                    Thống kê sản phẩm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.statistics') }}" class="nav-link {{ Route::is('admin.orders.statistics') ? 'active' : '' }}">
                                    Thống kê đơn hàng
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>                
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'active' : '' }}" href="#sidebar-display-management" data-bs-toggle="collapse"
                        role="button" aria-expanded="{{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'true' : 'false' }}" aria-controls="#sidebar-display-management">
                        <i class="ri-aspect-ratio-line"></i> <span data-key="t-landing">Quản lí hiển thị</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'show' : '' }}" id="sidebar-display-management">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebar-client" class="nav-link {{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'true' : 'false' }}" aria-controls="sidebar-client" data-key="t-client">
                                    Giao diện người dùng
                                </a>
                                <div class="collapse menu-dropdown {{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'show' : '' }}" id="sidebar-client">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#sidebar-header" class="nav-link {{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.popuphome.edit') ? 'active' : '' }}" data-bs-toggle="collapse"
                                                role="button" aria-expanded="false" aria-controls="sidebar-header" data-key="t-header">
                                                Header
                                            </a>
                                            <div class="collapse menu-dropdown {{ Route::is('admin.announcement.edit') || Route::is('admin.info_boxes.edit') || Route::is('admin.info_boxes_footer.edit') || Route::is('admin.popuphome.edit') ? 'show' : '' }}" id="sidebar-header">
                                                <a href="{{ route('admin.announcement.edit') }}" class="nav-link {{ Route::is('admin.announcement.edit') ? 'active' : '' }}" data-key="t-client">Thông báo</a>
                                                <a href="{{ route('admin.info_boxes.edit') }}" class="nav-link {{ Route::is('admin.info_boxes.edit') ? 'active' : '' }}" data-key="t-client">Hộp thông tin</a>
                                                <a href="{{ route('admin.info_boxes_footer.edit') }}" class="nav-link {{ Route::is('admin.info_boxes_footer.edit') ? 'active' : '' }}" data-key="t-client">Hộp thông tin footer</a>
                                                <a href="{{ route('admin.popuphome.edit') }}" class="nav-link {{ Route::is('admin.popuphome.edit') ? 'active' : '' }}" data-key="t-client">Popup home</a>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebar-banner" class="nav-link {{ Route::is('admin.banner.banner_extra_edit') || Route::is('admin.banner.banner_main_edit') ? 'active' : '' }}" 
                                               data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-banner" data-key="t-banner">
                                                Banner
                                            </a>
                                            <div class="collapse menu-dropdown {{ Route::is('admin.banner.banner_extra_edit') || Route::is('admin.banner.list_banner_main') ? 'show' : '' }}" 
                                                 id="sidebar-banner">
                                                <a href="{{ route('admin.banner.list_banner_main') }}" class="nav-link {{ Route::is('admin.banner.list_banner_main') ? 'active' : '' }}" 
                                                    data-key="t-client">Banner chính</a>
                                                <a href="{{ route('admin.banner.banner_extra_edit') }}" class="nav-link {{ Route::is('admin.banner.banner_extra_edit') ? 'active' : '' }}" 
                                                    data-key="t-client">Banner phụ</a>
                                                
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.footer.edit') }}" class="nav-link {{ Route::is('admin.footer.edit') ? 'active' : '' }}" data-key="t-client">Footer</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>                
                <li class="nav-item">
                    <a href="#sidebar-comments-questions" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-comments-questions" data-key="t-product">
                        <i class="ri-chat-1-line"></i> <span data-key="t-landing">Góp ý và đóng góp</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-comments-questions">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="https://bom.so/HNXsK3" class="nav-link">
                                    Câu hỏi và Góp ý
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#sidebar-sale-seo" class="nav-link {{ Route::is('admin.seo.index') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Route::is('admin.seo.index') ? 'true' : 'false' }}" aria-controls="sidebar-sale-seo" data-key="t-product">
                        <i class="ri-google-play-line"></i> <span data-key="t-landing">Quảng cáo</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.seo.index') ? 'show' : '' }}" id="sidebar-sale-seo">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.seo.index') }}" class="nav-link {{ Route::is('admin.seo.index') ? 'active' : '' }}">
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
                    <a href="#sidebar-post" class="nav-link {{ Route::is('admin.blogs.index') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Route::is('admin.blogs.index') ? 'true' : 'false' }}" aria-controls="sidebar-post" data-key="t-product">
                        <i class="ri-currency-line"></i> <span data-key="t-landing">Bài viết </span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.blogs.index') ? 'show' : '' }}" id="sidebar-post">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ Route::is('admin.blogs.index') ? 'active' : '' }}">
                                    Tin tức
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>                
                <li class="nav-item">
                    <a href="#sidebar-message" class="nav-link {{ Route::is('admin.email.viewEmail', 'chat.index') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Route::is('admin.email.viewEmail', 'chat.index') ? 'true' : 'false' }}" aria-controls="sidebar-message" data-key="t-product">
                        <i class="ri-notification-2-fill"></i> <span data-key="t-landing">Thông báo </span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.email.viewEmail', 'chat.index') ? 'show' : '' }}" id="sidebar-message">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.email.viewEmail') }}" class="nav-link {{ Route::is('admin.email.viewEmail') ? 'active' : '' }}">
                                    Email
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('chat.index') }}" class="nav-link {{ Route::is('chat.index') ? 'active' : '' }}">
                                    Trò chuyện
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>                
                <li class="nav-item">
                    <a href="#sidebar-profile" class="nav-link {{ Route::is('admin.profile.index', 'admin.profile.edit') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Route::is('admin.profile.index', 'admin.profile.edit') ? 'true' : 'false' }}" aria-controls="sidebar-profile" data-key="t-product">
                        <i class="ri-pages-line"></i> <span data-key="t-landing">Hồ sơ </span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.profile.index', 'admin.profile.edit') ? 'show' : '' }}" id="sidebar-profile">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.profile.index') }}" class="nav-link {{ Route::is('admin.profile.index') ? 'active' : '' }}">
                                    Thông tin
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ Route::is('admin.profile.edit') ? 'active' : '' }}">
                                    Cài đặt
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>                
                <li class="nav-item">
                    <a href="{{ route('admin.export-import.view-export-import') }}" class="nav-link {{ Route::is('admin.export-import.view-export-import') ? 'active' : '' }}" role="button"
                        aria-expanded="false" aria-controls="sidebar-message" data-key="t-product">
                        <i class="ri-upload-cloud-fill"></i><span>Xuất và Nhập</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.logs.index')}}" class="nav-link {{ Route::is('admin.logs.index') ? 'active' : '' }}" 
                        aria-expanded="false" aria-controls="sidebar-diary" data-key="t-product">
                        <i class="ri-drive-line"></i> <span data-key="t-landing">Nhật ký </span>
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
