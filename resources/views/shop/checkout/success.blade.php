@extends('layouts.shop')
@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container section">
    <div class="panel text-center mx-auto" style="max-width: 42rem;">
        <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--ok);"></i>
        <h1 class="h3 mt-3">Đặt hàng thành công!</h1>
        <p class="text-muted mb-4">Cảm ơn bạn, <strong>{{ $order->customer_name }}</strong>. Đơn hàng đã được ghi nhận.</p>
        <dl class="summary__list text-start mb-0">
            <div><dt>Mã đơn hàng</dt><dd>#DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</dd></div>
            <div><dt>Ngày đặt</dt><dd>{{ $order->created_at->format('d/m/Y') }}</dd></div>
            <div><dt>Phương thức thanh toán</dt><dd>{{ ['cod' => 'Thanh toán khi nhận hàng (COD)', 'vietqr' => 'VietQR', 'wallet' => 'Ví điện tử'][$order->payment_method] ?? $order->payment_method }}</dd></div>
            <div><dt>Giao đến</dt><dd class="text-end">{{ $order->address }}</dd></div>
            <div><dt>Dự kiến giao</dt><dd>Trong 2 đến 3 ngày</dd></div>
            <div class="summary__total"><dt>Tổng cộng</dt><dd>{{ number_format($order->total) }} ₫</dd></div>
        </dl>
    </div>
    @if($order->payment_method === 'vietqr')
        @php $orderCode = 'DH' . str_pad($order->id, 4, '0', STR_PAD_LEFT); @endphp
        <div class="panel text-center mx-auto mt-4" style="max-width: 42rem;">
            <h2 class="h6 mb-3">Quét mã để thanh toán</h2>
            <img src="{{ $order->vietqrUrl() }}" alt="Mã VietQR thanh toán đơn {{ $orderCode }}"
                class="img-fluid" style="max-width: 18rem;">
            <p class="small mt-3 mb-1">
                Số tiền: <strong>{{ number_format($order->total) }} ₫</strong>
                &middot; Nội dung: <strong>{{ $orderCode }}</strong>
            </p>
            <p class="small text-muted mb-0">Mở app ngân hàng, chọn quét mã QR. Số tiền và nội dung đã được điền sẵn. (Mã mô phỏng cho đồ án, dùng tài khoản mẫu.)</p>
        </div>
    @endif
    <div class="panel mx-auto mt-4" style="max-width: 42rem;">
        <h2 class="h6 mb-3">Sản phẩm trong đơn</h2>
        <ul class="summary__items mb-0">
            @foreach($order->items as $item)
                <li><span>{{ $item->product->name }} <span class="text-muted">x {{ $item->quantity }}</span></span><span>{{ number_format($item->price * $item->quantity) }} ₫</span></li>
            @endforeach
        </ul>
    </div>
    <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
        <a class="btn btn-primary" href="{{ route('shop.orders') }}"><i class="bi bi-receipt"></i> Xem đơn hàng của tôi</a>
        <a class="btn btn-outline-primary" href="{{ route('shop.products') }}"><i class="bi bi-bag"></i> Tiếp tục mua sắm</a>
    </div>
</div>
@endsection