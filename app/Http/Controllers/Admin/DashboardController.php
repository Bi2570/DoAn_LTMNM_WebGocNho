<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $revenue = Order::where('status', 'done')->sum('total');
        $toHandle = Order::whereIn('status', ['pending', 'processing'])->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $recentOrders = Order::latest()->take(5)->get();
        $orderCounts = Order::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $lowStock = Product::where('stock', '<=', 5)->orderBy('stock')->take(3)->get();

        return view('admin.dashboard', compact(
            'revenue', 'toHandle', 'totalProducts', 'totalCustomers',
            'recentOrders', 'orderCounts', 'lowStock'
        ));
    }
}
