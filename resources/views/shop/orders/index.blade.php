@extends('layouts.shop')
@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container section">
    <nav aria-label="breadcrumb" class="crumbs"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('shop.home') }}">Trang chủ</a></li><li class="breadcrumb-item active">Đơn hàng của tôi</li></ol></nav>
    <h1 class="h3 mb-4">Đơn hàng của tôi</h1>
    <div class="table-responsive panel">
        <table class="table align-middle mb-0">
            <thead><tr>
                <th>Mã đơn</th><th>Ngày đặt</th><th>Số sản phẩm</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái</th><th><span class="visually-hidden">Xem</span></th>
            </tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <th scope="row">#DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</th>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td class="text-nowrap">{{ number_format($order->total) }} ₫</td>
                        <td>{{ ['cod' => 'COD', 'vietqr' => 'VietQR', 'wallet' => 'Ví điện tử'][$order->payment_method] ?? $order->payment_method }}</td>
                        <td><span class="status status--{{ $order->status }}">{{ ['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'][$order->status] }}</span></td>
                        <td class="text-end"><a href="{{ route('shop.order.show', $order->id) }}">Xem chi tiết</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Bạn chưa có đơn hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection