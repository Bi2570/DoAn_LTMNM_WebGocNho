@extends('layouts.admin')
@section('title', 'Tổng quan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tổng quan</li>
@endsection

@section('content')
<h1 class="h3 mb-4">Tổng quan</h1>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="stat"><i class="bi bi-cash-stack"></i><div><p class="stat__label">Doanh thu tháng này</p><p class="stat__value">{{ number_format($revenue) }} ₫</p></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat"><i class="bi bi-bag-check"></i><div><p class="stat__label">Đơn cần xử lý</p><p class="stat__value">{{ $toHandle }}</p></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat"><i class="bi bi-boxes"></i><div><p class="stat__label">Sản phẩm đang bán</p><p class="stat__value">{{ $totalProducts }}</p></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat"><i class="bi bi-people"></i><div><p class="stat__label">Khách hàng</p><p class="stat__value">{{ $totalCustomers }}</p></div></div></div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <section class="panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Đơn hàng gần đây</h2>
                <a href="{{ route('admin.orders.index') }}">Xem tất cả đơn hàng</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Tổng tiền</th><th>Trạng thái</th><th><span class="visually-hidden">Xem</span></th></tr></thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <th scope="row">DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</th>
                                <td>{{ $order->customer_name }}</td>
                                <td class="text-nowrap">{{ number_format($order->total) }} ₫</td>
                                <td><span class="status status--{{ $order->status }}">{{ ['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'][$order->status] }}</span></td>
                                <td class="text-end"><a href="{{ route('admin.orders.show', $order->id) }}">Xem</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="col-xl-4">
        <section class="panel mb-4">
            <h2 class="h5 mb-3">Đơn theo trạng thái</h2>
            <ul class="bars">
                @php $total = $orderCounts->sum() ?: 1; @endphp
                @foreach(['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'] as $key => $label)
                    @php $count = $orderCounts[$key] ?? 0; @endphp
                    <li>
                        <div class="d-flex justify-content-between"><span>{{ $label }}</span><span class="fw-semibold">{{ $count }}</span></div>
                        <div class="bar"><span style="width:{{ round($count / $total * 100, 1) }}%"></span></div>
                    </li>
                @endforeach
            </ul>
            <p class="text-muted small mb-0 mt-3">Tổng {{ $orderCounts->sum() }} đơn hàng.</p>
        </section>
        <section class="panel">
            <h2 class="h5 mb-3">Sắp hết hàng</h2>
            <ul class="list-unstyled low-list mb-0">
                @foreach($lowStock as $product)
                    <li class="d-flex justify-content-between">
                        <span>{{ $product->name }}</span>
                        <span class="stock stock--{{ $product->stock === 0 ? 'out' : 'low' }}">{{ $product->stock === 0 ? 'Hết hàng' : 'Còn ' . $product->stock }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
</div>
@endsection