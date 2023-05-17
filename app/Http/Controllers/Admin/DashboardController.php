<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')->get(['products.*', 'categories.name AS cate_title']);
        $revenueMonth = Order::where('status', 2)->whereMonth('created_at', Carbon::now()->month)->sum('total');
        $revenueYear = Order::where('status', 2)->whereYear('created_at', Carbon::now()->year)->sum('total');
        $userTotal = User::count();
        $productTotal = Product::count();
        return view('admin.dashboard.index', compact('products', 'revenueMonth', 'revenueYear', 'userTotal', 'productTotal'));
    }

    public function fillterOrder(Request $request)
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')->get(['products.*', 'categories.name AS cate_title']);
        $revenueMonth = Order::where('status', 2)->whereMonth('created_at', Carbon::now()->month)->sum('total');
        $revenueYear = Order::where('status', 2)->whereYear('created_at', Carbon::now()->year)->sum('total');
        $userTotal = User::count();
        $productTotal = Product::count();
        $startDate = $request->start_date_revenue;
        $endDate = $request->end_date_revenue;
        $orders = Order::where('status', 2)->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->orderBy('created_at','DESC')->get();
        $orderTotal = Order::where('status', 2)->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('total');
        return view('admin.dashboard.index', compact('products', 'revenueMonth', 'revenueYear', 'userTotal', 'productTotal', 'orders', 'orderTotal'));
    }
}