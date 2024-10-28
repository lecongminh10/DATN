<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('theme/assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/assets/images/logo-dark.png')}}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('theme/assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/assets/images/logo-light.png')}}" alt="" height="17">
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
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
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
                                <a href="#sidebarCalendar" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarCalendar"
                                    data-key="t-calender">
                                    Đơn hàng
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
                            <!-- Quản lý danh mục -->
                            <li class="nav-item">
                                <a href="#sidebarCategory" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCategory" data-key="t-category">
                                    Danh mục
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCategory">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('admin.categories.index')}}" class="nav-link" data-key="t-category-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admin.categories.create')}}" class="nav-link" data-key="t-category-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.products.listProduct') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.products.addProduct') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAttribute" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarAttribute" data-key="t-product">
                                    Thuộc tính
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAttribute">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.attributes.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.attributes.create') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.carriers.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.carriers.create') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.coupons.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.coupons.create') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
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
                                            <a href="{{ route('admin.users.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.add') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarPermission" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarPermission" data-key="t-product">
                                    Quyền
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPermission">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permissions.index') }}" class="nav-link" data-key="t-product-list">Danh sách</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permissions.create') }}" class="nav-link" data-key="t-product-add">Thêm mới</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <div>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
    <div class="sidebar-background"></div>
</div>
