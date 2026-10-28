<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderStatusRequest;
use App\Models\Order;

class OrderController extends Controller
{
    // danh sách đơn + lọc trạng thái + tìm theo mã đơn/ tên 
    public function index(Request $request)
    {
        $query = Order::orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q  = trim($request->q);
            $id = (int) preg_replace('/\D/', '', $q); // "DH0003" -> 3

            $query->where(function ($sub) use ($q, $id) {
                $sub->where('customer_name', 'like', "%{$q}%");
                if ($id > 0) {
                    $sub->orWhere('id', $id);
                }
            });
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // chi tiết đơn 
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // đổi trạng thái đơn 
    public function updateStatus(OrderStatusRequest $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update(['status' => $newStatus]);

        // nếu admin hủy đơn hàng thì hoàn kho 
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }

        return back()->with('ok', 'Đã cập nhật trạng thái');
    }
}
