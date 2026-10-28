@extends('layouts.shop')
@section('title', 'Chi tiết đơn hàng #DH' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="container section">
    <nav aria-label="breadcrumb" class="crumbs"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('shop.home') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.orders') }}">Đơn hàng của tôi</a></li>
        <li class="breadcrumb-item active">#DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</li>
    </ol></nav>
    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
        <h1 class="h3 mb-0">Đơn hàng #DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h1>
        <span class="status status--{{ $order->status }}">{{ ['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'][$order->status] }}</span>
    </div>
    <ol class="stepper">
        @php $steps = ['pending' => 1, 'processing' => 2, 'shipping' => 3, 'done' => 4, 'cancelled' => 0]; $currentStep = $steps[$order->status] ?? 0; @endphp
        <li class="{{ $currentStep >= 1 ? 'is-done' : '' }}">Đã đặt hàng</li>
        <li class="{{ $currentStep >= 2 ? 'is-done' : '' }}">Đã xác nhận</li>
        <li class="{{ $currentStep >= 3 ? 'is-done' : '' }}">Đang giao</li>
        <li class="{{ $currentStep >= 4 ? 'is-done' : '' }}">Đã giao</li>
    </ol>
    <div class="row g-4 mt-1">
        <div class="col-lg-8">
            <div class="table-responsive panel">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th class="text-end">Thành tiền</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td><div class="d-flex align-items-center gap-3"><span class="ph ph-{{ ($item->product_id % 6) + 1 }} ph-sm"><i class="bi bi-journal-text"></i></span><span>{{ $item->product->name }}</span></div></td>
                                <td class="text-nowrap">{{ number_format($item->price) }} ₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-nowrap text-end">{{ number_format($item->price * $item->quantity) }} ₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" class="text-end">Tạm tính</td><td class="text-end">{{ number_format($order->total - \App\Models\Order::SHIPPING_FEE) }} ₫</td></tr>
                        <tr><td colspan="3" class="text-end">Phí vận chuyển</td><td class="text-end">{{ number_format(\App\Models\Order::SHIPPING_FEE, 0, ',', '.') }} ₫</td></tr>
                        <tr class="fw-bold"><td colspan="3" class="text-end">Tổng cộng</td><td class="text-end">{{ number_format($order->total) }} ₫</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel mb-3">
                <h2 class="h6">Giao đến</h2>
                <p class="mb-0">{{ $order->customer_name }}<br>{{ $order->phone }}<br>{{ $order->address }}</p>
            </div>
            <div class="panel mb-3">
                <h2 class="h6">Thanh toán</h2>
                <p class="mb-0">{{ ['cod' => 'Thanh toán khi nhận hàng (COD)', 'vietqr' => 'VietQR', 'wallet' => 'Ví điện tử'][$order->payment_method] ?? $order->payment_method }}</p>
            </div>
            @if($order->status === 'pending')
                <form method="post" action="{{ route('shop.order.cancel', $order->id) }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100" type="submit" onclick="return confirm('Bạn chắc chắn muốn hủy đơn?')">Hủy đơn hàng</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection