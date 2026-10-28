<header class="shop-head">
    <div class="container">
        <div class="shop-head__row">
            <a class="brand" href="{{ route('shop.home') }}"><span class="brand__mark"><i class="bi bi-pencil-fill"></i></span>Góc Nhỏ</a>
            <form class="shop-search" role="search" method="get" action="{{ route('shop.products') }}">
                <div class="input-group">
                    <input type="search" class="form-control" name="q" placeholder="Tìm sổ, bút, balo..." aria-label="Tìm sản phẩm" value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit" aria-label="Tìm kiếm"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <nav class="shop-nav" aria-label="Điều hướng chính">
                <details class="nav-dropdown">
                    <summary class="shop-link"> Sản phẩm <i class="bi bi-chevron-down"></i></summary>
                    <ul>
                        <li><a href="{{ route('shop.products') }}">Tất cả</a></li>
                        @foreach($globalCategories ?? [] as $cat)
                            <li><a href="{{ route('shop.products') }}?category={{ $cat->id }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </details>
            </nav>
            <a class="shop-link" href="{{ route('shop.cart') }}"><i class="bi bi-cart3"></i> Giỏ hàng
                @php $cartCount = count(session('cart', [])); @endphp
                <span id="cart-count" class="badge text-bg-primary {{ $cartCount > 0 ? '' : 'd-none' }}">{{ $cartCount }}</span>
            </a>
            <div class="shop-account">
                @guest
                    <a class="shop-link" href="{{ route('login') }}">Đăng nhập</a>
                    <a class="shop-link" href="{{ route('register') }}">Đăng ký</a>
                @endguest
                @auth
                    <details class="nav-dropdown">
                        <summary class="shop-link">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            <i class="bi bi-chevron-down"></i>
                        </summary>
                        <ul>
                            {{-- Chỉ tài khoản Khách hàng mới thấy nút Đơn hàng của tôi --}}
                            @if(auth()->user()->role === 'customer')
                                <li><a href="{{ route('shop.orders') }}"><i class="bi bi-receipt"></i> Đơn hàng của tôi</a></li>
                            @endif

                            {{-- Chỉ Admin mới thấy nút Quản trị --}}
                            @if(auth()->user()->role === 'admin')
                                <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Quản trị</a></li>
                            @endif

                            {{-- Nút Đăng xuất ai cũng thấy --}}
                            <li>
                                <form method="post" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button class="shop-link shop-link--btn" type="submit"><i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </details>
                @endauth
            </div>
        </div>
    </div>
</header>