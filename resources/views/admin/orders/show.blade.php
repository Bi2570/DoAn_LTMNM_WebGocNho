@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
    <li class="breadcrumb-item active" aria-current="page">#DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</li>
@endsection

@section('content')
<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
    <h1 class="h3 mb-0">Đơn hàng #DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h1>
    <span class="status status--{{ $order->status }}">
        {{ ['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'][$order->status] }}
    </span>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <section class="panel">
            <h2 class="h5 mb-3">Sản phẩm trong đơn</h2>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th class="text-end">Thành tiền</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-nowrap">{{ number_format($item->price) }} ₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-nowrap text-end">{{ number_format($item->price * $item->quantity) }} ₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Tổng cộng</td>
                            <td class="text-end text-danger">{{ number_format($order->total) }} ₫</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>

    <div class="col-xl-4">
        <section class="panel mb-4">
            <h2 class="h5 mb-3">Cập nhật trạng thái</h2>
            <form method="post" action="{{ route('admin.orders.status', $order->id) }}">
                @csrf
                <label class="form-label">Trạng thái đơn</label>
                <select class="form-select mb-3" name="status">
                    @foreach(['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'] as $key => $label)
                        <option value="{{ $key }}" @selected($order->status == $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary w-100" type="submit">Lưu thay đổi</button>
            </form>
        </section>

        <section class="panel">
            <h2 class="h5 mb-3">Khách hàng</h2>
            <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
            <p class="mb-1">SĐT: {{ $order->phone }}</p>
            <p class="mb-3 text-muted">Giao đến: {{ $order->address }}</p>
            <p class="mb-0"><strong>Thanh toán:</strong> {{ ['cod' => 'Tiền mặt (COD)', 'vietqr' => 'Chuyển khoản VietQR', 'wallet' => 'Ví điện tử'][$order->payment_method] ?? $order->payment_method }}</p>
        </section>
    </div>
</div>
@endsection