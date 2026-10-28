<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sổ và giấy (category_id = 1)
        Product::create(['name' => 'Sổ lò xo A5 kẻ ngang', 'price' => 38000, 'stock' => 120, 'category_id' => 1, 'image' => 'products/so tay lo xo.jpg']);
        Product::create(['name' => 'Sổ da A6 bìa simili', 'price' => 65000, 'stock' => 74, 'category_id' => 1, 'image' => 'products/so da.jpg']);
        Product::create(['name' => 'Sổ planner 2026', 'price' => 135000, 'old_price' => 150000, 'stock' => 48, 'category_id' => 1, 'image' => 'products/so tay planner.jpg']);
        Product::create(['name' => 'Sổ sketch vẽ A4', 'price' => 95000, 'stock' => 36, 'category_id' => 1, 'image' => 'products/so tay bia kraft.jpg']);
        Product::create(['name' => 'Giấy ghi chú 5 màu', 'price' => 22000, 'stock' => 200, 'category_id' => 1, 'image' => 'products/giay note.jpg']);

        // Bút (category_id = 2)
        Product::create(['name' => 'Bộ 10 bút gel mực xanh', 'price' => 45000, 'old_price' => 60000, 'stock' => 86, 'category_id' => 2, 'image' => 'products/but gel xanh.jpg']);
        Product::create(['name' => 'Bút chì 2B hộp 12 cây', 'price' => 36000, 'stock' => 152, 'category_id' => 2, 'image' => 'products/but chi.jpg']);
        Product::create(['name' => 'Bút highlight 6 màu', 'price' => 42000, 'stock' => 97, 'category_id' => 2, 'image' => 'products/but da quang.jpg']);
        Product::create(['name' => 'Bút lông bảng 4 màu', 'price' => 28000, 'stock' => 110, 'category_id' => 2, 'image' => 'products/but long.jpg']);
        Product::create(['name' => 'Bộ thước kẻ và compa', 'price' => 48000, 'stock' => 3, 'category_id' => 2, 'image' => 'products/thuoc va compa.jpg']);

        // Balo (category_id = 3)
        Product::create(['name' => 'Balo laptop 15.6 inch', 'price' => 389000, 'old_price' => 459000, 'stock' => 14, 'category_id' => 3, 'image' => 'products/balo lon.jpg']);
        Product::create(['name' => 'Túi tote vải canvas', 'price' => 89000, 'stock' => 68, 'category_id' => 3, 'image' => 'products/tui tote.jpg']);
        Product::create(['name' => 'Hộp bút vải canvas', 'price' => 55000, 'stock' => 63, 'category_id' => 3, 'image' => 'products/hop but.jpg']);
        Product::create(['name' => 'Túi đeo chéo mini', 'price' => 125000, 'stock' => 42, 'category_id' => 3, 'image' => 'products/tui cheo.jpg']);
        Product::create(['name' => 'Balo mini đi học', 'price' => 229000, 'stock' => 27, 'category_id' => 3, 'image' => 'products/balo mini.jpg']);

        // Phụ kiện (category_id = 4)
        Product::create(['name' => 'Đèn bàn LED chống cận', 'price' => 215000, 'stock' => 32, 'category_id' => 4, 'image' => 'products/den ban hoc mini.jpg']);
        Product::create(['name' => 'Máy tính cầm tay 12 số', 'price' => 165000, 'stock' => 41, 'category_id' => 4, 'image' => 'products/may tinh.jpg']);
        Product::create(['name' => 'Kệ đựng tài liệu 3 tầng', 'price' => 149000, 'stock' => 21, 'category_id' => 4, 'image' => 'products/ke dung tai lieu 3t.jpg']);
        Product::create(['name' => 'Kẹp giấy kim loại hộp 100', 'price' => 18000, 'stock' => 0, 'category_id' => 4, 'image' => 'products/kep giay.jpg']);
        Product::create(['name' => 'Lót chuột cỡ lớn', 'price' => 99000, 'stock' => 55, 'category_id' => 4, 'image' => 'products/lot chuot.jpg']);
    }
}
