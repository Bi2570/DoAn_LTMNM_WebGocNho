<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User; 

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('role', 'customer')->first();
        if (!$customer) return;

        $products = Product::take(5)->get();

        // Đơn đã giao
        $order1 = Order::create([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'phone' => '0901234567',
            'address' => '140 Lê Trọng Tấn, TP.HCM',
            'payment_method' => 'cod', 
            'status' => 'done',
            'total' => 500000,
        ]);
        
        $order1->items()->create(['product_id' => $products[0]->id, 'quantity' => 2, 'price' => $products[0]->price]); // SỬA QUANTITY
        $order1->items()->create(['product_id' => $products[1]->id, 'quantity' => 1, 'price' => $products[1]->price]); // SỬA QUANTITY

        // Đơn chờ xác nhận
        $order2 = Order::create([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'phone' => '0901234567',
            'address' => '140 Lê Trọng Tấn, TP.HCM',
            'payment_method' => 'vietqr', 
            'status' => 'pending',
            'total' => 350000,
        ]);
        $order2->items()->create(['product_id' => $products[2]->id, 'quantity' => 1, 'price' => $products[2]->price]); // SỬA QUANTITY

        // Đơn đang giao
        $order3 = Order::create([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'phone' => '0901234567',
            'address' => '140 Lê Trọng Tấn, TP.HCM',
            'payment_method' => 'wallet', 
            'status' => 'shipping',
            'total' => 200000,
        ]);
        $order3->items()->create(['product_id' => $products[3]->id, 'quantity' => 3, 'price' => $products[3]->price]); // SỬA QUANTITY
    }
}