@extends('layouts.admin')
@section('title', 'Đơn hàng')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Đơn hàng</li>
@endsection

@section('content')
<h1 class="h3 mb-4">Đơn hàng</h1>

<section class="panel">
    <form class="toolbar" method="get" action="{{ route('admin.orders.index') }}">
        <input class="form-control" type="search" name="q" placeholder="Mã đơn hoặc tên khách hàng" value="{{ request('q') }}">
        <select class="form-select" name="status">
            <option value="">Mọi trạng thái</option>
            <option value="pending" @selected(request('status') == 'pending')>Chờ xác nhận</option>
            <option value="processing" @selected(request('status') == 'processing')>Đang xử lý</option>
            <option value="shipping" @selected(request('status') == 'shipping')>Đang giao</option>
            <option value="done" @selected(request('status') == 'done')>Đã giao</option>
            <option value="cancelled" @selected(request('status') == 'cancelled')>Đã hủy</option>
        </select>
        <button class="btn btn-primary" type="submit">Lọc</button>
    </form>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <th scope="row">DH{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</th>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="text-nowrap fw-semibold">{{ number_format($order->total) }} ₫</td>
                        <td>
                            <span class="status status--{{ $order->status }}">
                                {{ ['pending' => 'Chờ xác nhận', 'processing' => 'Đang xử lý', 'shipping' => 'Đang giao', 'done' => 'Đã giao', 'cancelled' => 'Đã hủy'][$order->status] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.show', $order->id) }}"><i class="bi bi-eye"></i> Xem</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Không có đơn hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $orders->withQueryString()->links() }}</div>
</section>
@endsection