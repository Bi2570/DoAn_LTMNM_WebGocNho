@extends('layouts.shop')
@section('title', 'Trang chủ')

@section('content')

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6">
                <h1 class="hero__title">Đồ dùng học tập và góc làm việc, giao tận nơi</h1>
                <p class="hero__lead">Sổ, bút, balo và phụ kiện bàn học cho sinh viên. Đặt hôm nay, nhận trong 2 đến 3 ngày.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-primary btn-lg" href="{{ route('shop.products') }}">Xem sản phẩm</a>
                    <a class="btn btn-outline-primary btn-lg" href="{{ route('register') }}">Tạo tài khoản</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero__tiles">
                    @foreach($categories as $i => $cat)
                        @php
                            $icon = 'bi-journal-text'; // Icon mặc định
                            if (str_contains($cat->name, 'Sổ') || str_contains($cat->name, 'giấy')) {
                                $icon = 'bi-journal-text';
                            } elseif (str_contains($cat->name, 'Bút')) {
                                $icon = 'bi-pen';
                            } elseif (str_contains($cat->name, 'Balo') || str_contains($cat->name, 'túi')) {
                                $icon = 'bi-backpack2';
                            } elseif (str_contains($cat->name, 'Phụ kiện') || str_contains($cat->name, 'bàn')) {
                                $icon = 'bi-lamp';
                            }
                        @endphp

                        <a class="hero__tile" href="{{ route('shop.products') }}?category={{ $cat->id }}">
                            <span class="ph ph-{{ ($i % 4) + 1 }}"><i class="bi {{ $icon }}"></i></span>
                            <span class="hero__tilelabel">{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section pb-0">
    <div class="container">
        <div class="row g-3 perks">
            <div class="col-md-4">
                <div class="perk">
                    <i class="bi bi-truck"></i>
                    <div>
                        <h3 class="h6 mb-1">Giao hàng 2 đến 3 ngày</h3>
                        <p class="mb-0">Phí vận chuyển đồng giá {{ number_format(\App\Models\Order::SHIPPING_FEE, 0, ',', '.') }} ₫.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="perk">
                    <i class="bi bi-arrow-repeat"></i>
                    <div>
                        <h3 class="h6 mb-1">Đổi trả trong 7 ngày</h3>
                        <p class="mb-0">Sản phẩm lỗi được đổi mới.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="perk">
                    <i class="bi bi-cash-coin"></i>
                    <div>
                        <h3 class="h6 mb-1">Thanh toán khi nhận hàng</h3>
                        <p class="mb-0">Kiểm tra hàng rồi mới trả tiền.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="h3 mb-0">Sản phẩm mới</h2>
            <a href="{{ route('shop.products') }}">Xem tất cả sản phẩm</a>
        </div>
        <div class="row g-3">
            @foreach($newProducts as $product)
                @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

@endsection