@extends('layouts.shop')
@section('title', 'Giỏ hàng')

@section('content')
<div class="container section">
    <nav aria-label="breadcrumb" class="crumbs"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('shop.home') }}">Trang chủ</a></li><li class="breadcrumb-item active">Giỏ hàng</li></ol></nav>
    <h1 class="h3 mb-4">Giỏ hàng <span class="text-muted fw-normal">({{ count($cart) }} sản phẩm)</span></h1>

    @if(empty($cart))
        <div class="empty">
            <h2 class="h5">Giỏ hàng đang trống</h2>
            <p>Chọn vài sản phẩm để bắt đầu.</p>
            <a class="btn btn-primary" href="{{ route('shop.products') }}">Xem sản phẩm</a>
        </div>
    @else
        <form method="post" action="{{ route('shop.cart.checkout') }}">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="table-responsive panel">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th style="width: 2.5rem;"><span class="visually-hidden">Chọn</span></th>
                                <th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th><th><span class="visually-hidden">Xóa</span></th>
                            </tr></thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $item)
                                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                    <tr>
                                        <td><input class="form-check-input item-check" type="checkbox" name="items[]" value="{{ $id }}" data-price="{{ $item['price'] }}"></td>
                                        <td><div class="d-flex align-items-center gap-3">
                                            <span class="ph ph-{{ ($id % 6) + 1 }} ph-sm"><i class="bi bi-journal-text"></i></span>
                                            <div>
                                                <a class="fw-semibold text-decoration-none" href="{{ route('shop.product.show', $id) }}">{{ $item['name'] }}</a>
                                            </div>
                                        </div></td>
                                        <td class="text-nowrap">{{ number_format($item['price']) }} ₫</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <input class="form-control form-control-sm qty" type="number" name="quantity[{{ $id }}]" min="1" value="{{ $item['quantity'] }}">
                                                <button class="btn btn-sm btn-outline-primary" type="submit" formaction="{{ route('shop.cart.update') }}" name="update_id" value="{{ $id }}">Cập nhật</button>
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-semibold">{{ number_format($subtotal) }} ₫</td>
                                        <td>
                                            <button class="btn btn-sm btn-link text-danger" type="submit" formaction="{{ route('shop.cart.remove') }}" name="remove_id" value="{{ $id }}">Xóa</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                        <a href="{{ route('shop.products') }}"><i class="bi bi-arrow-left"></i> Tiếp tục mua sắm</a>
                        <p class="text-muted mb-0 small"><i class="bi bi-info-circle"></i> Tick chọn sản phẩm muốn mua, sau đó bấm <strong>Thanh toán</strong>.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel summary">
                        <h2 class="h5">Tóm tắt đơn hàng</h2>
                        <dl class="summary__list" id="summary-box" data-ship="{{ \App\Models\Order::SHIPPING_FEE }}">
                            <div><dt>Tạm tính</dt><dd id="subtotal-val">0 ₫</dd></div>
                            <div><dt>Phí vận chuyển</dt><dd>{{ number_format(\App\Models\Order::SHIPPING_FEE, 0, ',', '.') }} ₫</dd></div>
                            <div class="summary__total"><dt>Tổng cộng</dt><dd id="total-val">0 ₫</dd></div>
                        </dl>
                        <button type="submit" class="btn btn-primary w-100">Thanh toán</button>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.item-check');
        const subtotalEl = document.getElementById('subtotal-val');
        const totalEl = document.getElementById('total-val');

        function updateTotals() {
            let subtotal = 0;
            let checkedCount = 0;
            
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    checkedCount++;
                    const price = parseFloat(cb.dataset.price);
                    const qtyInput = document.querySelector(`input[name="quantity[${cb.value}]"]`);
                    const qty = qtyInput ? parseInt(qtyInput.value) : 1;
                    subtotal += price * qty;
                }
            });

            const ship = checkedCount > 0 ? Number(document.getElementById('summary-box').dataset.ship) : 0;
            
            subtotalEl.innerText = new Intl.NumberFormat('vi-VN').format(subtotal) + ' ₫';
            totalEl.innerText = new Intl.NumberFormat('vi-VN').format(subtotal + ship) + ' ₫';
        }

        // Lắng nghe sự kiện tick chọn
        checkboxes.forEach(cb => cb.addEventListener('change', updateTotals));
        
        // Lắng nghe sự kiện thay đổi số lượng (để cập nhật tiền ngay lập tức)
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', updateTotals);
        });
        
        // Chạy lần đầu khi load trang
        updateTotals();
    });
</script>
@endsection