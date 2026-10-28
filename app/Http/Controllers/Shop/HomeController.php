<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $newProducts = Product::with('category')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $categories = Category::orderBy('name')->get();
        
        return view('shop.home', compact('newProducts', 'categories'));
    }
}
