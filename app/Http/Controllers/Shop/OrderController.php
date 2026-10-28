<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // danh sách đơn của khách đang đăng nhập
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10); 
        
            return view('shop.orders.index', compact('orders'));
    }

    // chi tiết 1 đơn (chỉ xem được đơn của chính mình)
    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        
        return view('shop.orders.show', compact('order'));
    }

    // hủy đơn chỉ hủy được khi đang "chờ xác nhận"
    public function cancel($id)
    {
        $order = Order::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ hủy được đơn đang chờ xác nhận');    
        }

        $order->update(['status' => 'cancelled']);

        // hoàn kho nếu hủy
        foreach ($order->items as $item) {
            $product = \App\Models\Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        return back()->with('ok', 'Đã hủy đơn hàng');
    }
}
