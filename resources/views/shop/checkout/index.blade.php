@extends('layouts.shop')
@section('title', 'Thanh toán')

@section('content')
<div class="container section">
    <nav aria-label="breadcrumb" class="crumbs"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('shop.home') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.cart') }}">Giỏ hàng</a></li>
        <li class="breadcrumb-item active">Thanh toán</li>
    </ol></nav>
    <h1 class="h3 mb-4">Thanh toán</h1>
    <form method="post" action="{{ route('shop.checkout.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <section class="panel mb-4">
                    <h2 class="h5 mb-3">Thông tin nhận hàng</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="fullname">Họ và tên</label>
                            <input id="fullname" class="form-control @error('customer_name') is-invalid @enderror" type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Số điện thoại</label>
                            <input id="phone" class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="city">Tỉnh hoặc thành phố</label>
                            <select id="city" class="form-select" name="city">
                                <option>TP. Hồ Chí Minh</option><option>Hà Nội</option><option>Đà Nẵng</option><option>Cần Thơ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="address">Địa chỉ cụ thể</label>
                            <input id="address" class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') }}" placeholder="Số nhà, đường, phường" required>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="note">Ghi chú (không bắt buộc)</label>
                            <textarea id="note" class="form-control" name="note" rows="3">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <h2 class="h5 mb-3">Phương thức thanh toán</h2>
                    <fieldset class="pay-options">
                        <legend class="visually-hidden">Chọn phương thức</legend>
                        <label class="pay-option"><input type="radio" name="payment_method" value="cod" checked><span class="pay-option__body"><i class="bi bi-cash-coin pay-ic pay-ic--cod"></i> Thanh toán khi nhận hàng (COD)</span></label>
                        <label class="pay-option"><input type="radio" name="payment_method" value="vietqr"><span class="pay-option__body"><i class="bi bi-qr-code-scan pay-ic pay-ic--qr"></i> Thanh toán qua App Ngân hàng (VietQR)</span></label>
                        <label class="pay-option"><input type="radio" name="payment_method" value="wallet"><span class="pay-option__body"><i class="bi bi-wallet2 pay-ic pay-ic--card"></i> Ví điện tử (MoMo, ZaloPay,...)</span></label>
                    </fieldset>
                </section>
            </div>
            <div class="col-lg-5">
                <div class="panel summary">
                    <h2 class="h5">Đơn hàng của bạn</h2>
                    <ul class="summary__items">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                            <li><span>{{ $item['name'] }} <span class="text-muted">x {{ $item['quantity'] }}</span></span><span>{{ number_format($subtotal) }} ₫</span></li>
                        @endforeach
                    </ul>
                    <dl class="summary__list">
                        <div><dt>Tạm tính</dt><dd>{{ number_format($total) }} ₫</dd></div>
                        <div><dt>Phí vận chuyển</dt><dd>{{ number_format(\App\Models\Order::SHIPPING_FEE, 0, ',', '.') }} ₫</dd></div>
                        <div class="summary__total"><dt>Tổng cộng</dt><dd>{{ number_format($total + \App\Models\Order::SHIPPING_FEE) }} ₫</dd></div>
                    </dl>
                    <button class="btn btn-primary w-100" type="submit">Đặt hàng</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection