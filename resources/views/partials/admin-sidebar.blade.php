<a class="brand brand--light" href="{{ route('admin.dashboard') }}"><span class="brand__mark"><i class="bi bi-pencil-fill"></i></span>Góc Nhỏ</a>
<p class="admin-side__label">Khu vực quản trị</p>
<nav aria-label="Quản trị">
    <ul class="admin-nav">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <i class="bi bi-speedometer2"></i>Tổng quan
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categories.index') }}" class="admin-nav__link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                <i class="bi bi-tags"></i>Loại sản phẩm
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}" class="admin-nav__link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
                <i class="bi bi-box-seam"></i>Sản phẩm
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" class="admin-nav__link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">
                <i class="bi bi-receipt"></i>Đơn hàng
            </a>
        </li>
    </ul>
</nav>
<a class="admin-side__store" href="{{ route('shop.home') }}"><i class="bi bi-box-arrow-up-right"></i> Xem cửa hàng</a>