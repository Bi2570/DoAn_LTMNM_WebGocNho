<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('checkout_cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('shop.cart')
                ->with('error', 'Vui lòng chọn sản phẩm!');
        }

        return view('shop.checkout.index', compact('cart'));
    }

    public function store(CheckoutRequest $request)
    {
        //dd($request->all());
        // Lấy giỏ hàng từ session 'checkout_cart' (những món đã tick)
        $cart = session()->get('checkout_cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('shop.cart')
                ->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán!');
        }

        $validated = $request->validated();
        $userId = $request->user()?->getAuthIdentifier();

        try {
            $order = DB::transaction(function () use ($cart, $validated, $userId) {
                $total = 0;
                $items = [];

                // Kiểm tra sản phẩm và tồn kho
                foreach ($cart as $productId => $cartItem) {
                    $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();
                    $quantity = (int) ($cartItem['quantity'] ?? 0);

                    if ($quantity < 1) {
                        throw ValidationException::withMessages([
                            'cart' => 'Số lượng sản phẩm không hợp lệ.',
                        ]);
                    }

                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'cart' => 'Sản phẩm "' . $product->name . '" không đủ số lượng tồn kho.',
                        ]);
                    }

                    $price = $product->price;
                    $total += $price * $quantity;

                    $items[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                    ];
                }

                // Tạo đơn hàng
                $order = Order::create([
                    'user_id' => $userId,
                    'customer_name' => $validated['customer_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'note' => $validated['note'] ?? null,
                    'payment_method' => $validated['payment_method'], 
                    'total' => $total + \App\Models\Order::SHIPPING_FEE, // Cộng phí vận chuyển
                    'status' => 'pending',
                ]);

                // Lưu chi tiết đơn và trừ tồn kho
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    $item['product']->decrement('stock', $item['quantity']);
                }

                return $order;
            });

            // Dọn dẹp giỏ hàng sau khi đặt hàng thành công 
            // Xóa session checkout_cart
            session()->forget('checkout_cart');

            // Xóa những món vừa mua khỏi giỏ hàng gốc (cart), giữ lại những món không tick
            $mainCart = session()->get('cart', []);
            foreach ($cart as $id => $item) {
                if (isset($mainCart[$id])) {
                    unset($mainCart[$id]);
                }
            }
            session()->put('cart', $mainCart);
            session()->save();

            return redirect()
                ->route('shop.checkout.success', ['id' => $order->id])
                ->with('ok', 'Đặt hàng thành công!');

        } catch (ValidationException $e) {
            throw $e;
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Một sản phẩm trong giỏ hàng không còn tồn tại.');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->withInput()
                ->with('error', 'Không thể đặt hàng. Vui lòng thử lại sau.');
        }
    }

    public function success($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('shop.checkout.success', compact('order'));
    }
}
