<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('shop.cart.index', compact('cart'));
    }

    public function add(CartRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = (int) $request->input('quantity', 1);
        $isAjax = $request->expectsJson(); // true khi được gọi bằng AJAX (fetch)

        // kiểm tra tồn kho
        if ($product->stock < $qty) {
            return $this->addError($isAjax, 'Sản phẩm "' . $product->name . '" chỉ còn ' . $product->stock . ' sản phẩm trong kho!');
        }

        // MUA NGAY: Chỉ lưu sản phẩm vừa chọn.
        if ($request->boolean('buy_now')) {
            session()->put('checkout_cart', [
                $product->id => [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $qty,
                ],
            ]);
            return redirect()->route('shop.checkout');
        }

        // THÊM VÀO GIỎ: Cộng dồn số lượng.
        $cart = session()->get('cart', []);
        
        // Nếu sản phẩm đã có trong giỏ, phải kiểm tra TỔNG số lượng
        $currentQtyInCart = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        if (($currentQtyInCart + $qty) > $product->stock) {
            return $this->addError($isAjax, 'Bạn đã có ' . $currentQtyInCart . ' sản phẩm này trong giỏ. Kho chỉ còn ' . $product->stock . ' sản phẩm!');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
            ];
        }
        session()->put('cart', $cart);
        // Nếu thêm sản phẩm thường, xóa trạng thái mua ngay cũ.
        session()->forget('buy_now_cart');

        // AJAX: trả JSON để trang tự cập nhật, không tải lại
        if ($isAjax) {
            return response()->json([
                'ok' => true,
                'message' => 'Đã thêm "' . $product->name . '" vào giỏ hàng',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->back()->with('ok', 'Đã thêm vào giỏ hàng');
    }

    // Hàm phụ: trả lỗi đúng kiểu (JSON cho AJAX, chuyển trang cho form thường)
    private function addError(bool $isAjax, string $message)
    {
        if ($isAjax) {
            return response()->json(['ok' => false, 'message' => $message], 422);
        }
        return back()->with('error', $message);
    }

    public function update(CartRequest $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->input('quantity', []) as $id => $qty) {
            if (isset($cart[$id])) {
                // lấy sản phẩm từ DB ra để check tồn kho 
                $product = Product::find($id);
                if ($product && $qty > $product->stock) {
                    return back()->with('error', 'Sản phẩm "' . $product->name . '" chỉ còn ' . $product->stock . ' sản phẩm. Không thể cập nhật số lượng lớn hơn!');
                }
                $cart[$id]['quantity'] = (int) $qty;
            }
        }

        session()->put('cart', $cart);

        return back()->with('ok', 'Đã cập nhật số lượng');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('remove_id');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('ok', 'Đã xóa sản phẩm');
    }

    public function checkout(Request $request)
    {
        $selectedIds = $request->input('items', []);
        $cart = session()->get('cart', []);
        
        $checkoutCart = [];
        foreach ($selectedIds as $id) {
            if (isset($cart[$id])) {
                $checkoutCart[$id] = $cart[$id];
            }
        }

        if (empty($checkoutCart)) {
            return back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
        }

        // Lưu các sản phẩm được chọn vào một session riêng để trang Checkout lấy ra dùng
        session()->put('checkout_cart', $checkoutCart);
        
        return redirect()->route('shop.checkout');
    }
}
