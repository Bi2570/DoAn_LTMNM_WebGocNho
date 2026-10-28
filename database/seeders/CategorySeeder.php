<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Sổ và giấy', 'description' => 'Sổ tay, giấy ghi chú']);
        Category::create(['name' => 'Bút và dụng cụ viết', 'description' => 'Bút bi, bút gel']);
        Category::create(['name' => 'Balo và túi', 'description' => 'Balo laptop, hộp bút']);
        Category::create(['name' => 'Phụ kiện bàn làm việc', 'description' => 'Đèn bàn, máy tính']);
    }
}
