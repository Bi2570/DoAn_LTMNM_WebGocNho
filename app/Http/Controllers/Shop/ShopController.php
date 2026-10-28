<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // tìm theo tên 
        $query->when($request->filled('q'), function ($builder) use ($request) {
            $keyword = trim((string) $request->input('q'));
            $builder->where('name', 'like', '%' . $keyword . '%');
        });

        // lọc theo danh mục 
        $query->when($request->filled('category'), function ($builder) use ($request) {
            $builder->where('category_id', $request->input('category'));
        });

        // sắp xếp danh sách theo 
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('shop.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->latest()
            ->take(4)
            ->get();
            
        return view('shop.products.show', compact('product', 'relatedProducts'));
    }
}
