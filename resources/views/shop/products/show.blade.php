@extends('layouts.shop')
@section('title', $product->name)

@section('content')
<div class="container section">
    <nav aria-label="breadcrumb" class="crumbs"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('shop.home') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.products') }}">Sản phẩm</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.products') }}?category={{ $product->category->id }}">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol></nav>

    <div class="row g-4 g-lg-5">
        <div class="col-md-6">
            <div class="detail__img" style="position: relative; overflow: hidden; width: 100%; aspect-ratio: 1 / 1; border: 1px solid var(--line); border-radius: .5rem; display: flex; align-items: center; justify-content: center; background-color: var(--paper);">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                        alt="{{ $product->name }}" 
                        style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                @else
                    <i class="bi bi-journal-text" style="font-size: 6rem; color: var(--ink);"></i>
                @endif

                @if($product->old_price)
                    <span class="tag-sale" style="position: absolute; top: .6rem; left: .6rem; z-index: 10;">
                        -{{ round((1 - $product->price / $product->old_price) * 100) }}%
                    </span>
                @endif
            </div>
            <ul class="list-unstyled policy mt-4 mb-0">
                <li><i class="bi bi-truck"></i> Giao hàng 2 đến 3 ngày</li>
                <li><i class="bi bi-arrow-repeat"></i> Đổi trả trong 7 ngày nếu lỗi</li>
                <li><i class="bi bi-cash-coin"></i> Thanh toán khi nhận hàng</li>
            </ul>
        </div>
        <div class="col-md-6">
            <p class="text-muted mb-1">{{ $product->category->name }}</p>
            <h1 class="h2">{{ $product->name }}</h1>
            <p class="detail__price">
                <span class="price">{{ number_format($product->price) }} ₫</span>
                @if($product->old_price)<span class="price-old">{{ number_format($product->old_price) }} ₫</span>@endif
            </p>
            <p class="stock stock--{{ $product->stock > 5 ? 'ok' : ($product->stock > 0 ? 'low' : 'out') }}">
                <i class="bi bi-check2-circle"></i>
                @if($product->stock > 0) Còn hàng ({{ $product->stock }} sản phẩm) @else Hết hàng @endif
            </p>

            <h2 class="h5 mt-4 mb-2">Mô tả chi tiết</h2>
            <p>{{ $product->description ?? 'Chưa có mô tả.' }}</p>

            <h2 class="h5 mt-4 mb-2">Thông tin sản phẩm</h2>
            <div class="table-responsive">
                <table class="table table-bordered bg-white detail__spec mb-0">
                    <tbody>
                        <tr><th scope="row">Loại sản phẩm</th><td>{{ $product->category->name }}</td></tr>
                        <tr><th scope="row">Tồn kho</th><td>{{ $product->stock }}</td></tr>
                        <tr><th scope="row">Mã sản phẩm</th><td>SP{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                @if($product->stock > 0)
                    {{-- NẾU CÒN HÀNG: Hiển thị form mua --}}
                    <form method="post" action="{{ route('shop.cart.add', $product->id) }} data-ajax-cart">
                        @csrf
                        <label class="form-label" for="qty">Số lượng (Còn {{ $product->stock }} sản phẩm)</label>
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('qty').stepDown()">−</button>
                            
                            {{-- Thuộc tính max giúp chặn không cho bấm nút [+] vượt quá tồn kho --}}
                            <input id="qty" class="form-control text-center" type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1">
                            
                            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('qty').stepUp()">+</button>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-lg flex-grow-1" type="submit"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</button>
                            <button class="btn btn-primary btn-lg flex-grow-1" type="submit" name="buy_now" value="1">Mua ngay</button>
                        </div>
                    </form>
                @else
                    {{-- NẾU HẾT HÀNG: Hiển thị thông báo và nút bị vô hiệu hóa --}}
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-exclamation-triangle-fill"></i> Sản phẩm này hiện đã tạm hết hàng.
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-secondary btn-lg w-100" type="button" disabled>Hết hàng</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <h2 class="h4 mt-5 mb-3">Sản phẩm cùng loại</h2>
        <div class="row g-3">
            @foreach($relatedProducts as $relatedProduct)
                @include('shop.partials.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    @endif
</div>
@endsection