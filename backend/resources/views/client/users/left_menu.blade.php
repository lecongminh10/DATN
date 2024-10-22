
<aside class="sidebar sidebar-home col-lg-3 order-lg-first mobile-sidebar">
    <div class="side-menu-wrapper text-uppercase mb-2 d-none d-lg-block">
        <div class="side-nav">
            <ul class="menu menu-vertical sf-arrows">
                <li class="{{ request()->routeIs('users.indexClient') ? 'active' : '' }}"><a href="{{route('users.indexClient')}}" ><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="{{ request()->routeIs('users.showClient') ? 'active' : '' }}"><a href="{{ route('users.showClient', Auth::user()->id) }}"><i class="fas fa-user"></i> Thông tin tài
                        khoản</a></li>
                <li class="{{ request()->routeIs('users.showOrder') ? 'active' : '' }}"><a href="#orders"><i class="fas fa-shopping-bag"></i> Lịch sử mua hàng</a></li>
                <li class=""><a href="#rewards"><i class="fas fa-gift"></i> Ưu đãi</a></li>
                <li class=""><a href="#settings"><i class="fas fa-medal"></i> Hạng thành viên</a></li>
                <li class=""><a href="#support"><i class="fas fa-headset"></i> Hỗ trợ</a></li>
                <li class=""><a href="#logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</aside>
   
