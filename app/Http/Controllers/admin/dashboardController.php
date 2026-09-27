<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Carbon;

class dashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        $totalRevenue = Order::where('payment_status', true)->where('status', 3)->sum('total_amount');
        $pendingOrders = Order::where('status', 1)->count();
        $shippedOrders = Order::where('status', 2)->count();
        $completedOrders = Order::where('status', 3)->count();
        $canceledOrders = Order::where('status', 4)->count();
        $paidOrders = Order::where('payment_status', true)->count();
        $unpaidOrders = Order::where('payment_status', false)->count();
        $codOrders = Order::where('payment_method', true)->count();
        $onlineOrders = Order::where('payment_method', false)->count();
        $currentMonthRevenue = Order::where('payment_status', true)->where('status', 3)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount');
        $currentMonthOrders = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::where('payment_status', true)->where('status', 3)->whereDate('created_at', today())->sum('total_amount');
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $latestProducts = Product::with('category')->latest()->take(5)->get();

        $revenueLast7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::where('payment_status', true)->where('status', 3)->whereDate('created_at', $date)->sum('total_amount');
            $revenueLast7Days[] = [
                'date' => $date->format('d/m'),
                'revenue' => $revenue,
            ];
        }

        $ordersLast7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $orders = Order::whereDate('created_at', $date)->count();
            $ordersLast7Days[] = [
                'date' => $date->format('d/m'),
                'orders' => $orders,
            ];
        }

        return view('admin.pages.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'shippedOrders',
            'completedOrders',
            'canceledOrders',
            'paidOrders',
            'unpaidOrders',
            'codOrders',
            'onlineOrders',
            'currentMonthOrders',
            'currentMonthRevenue',
            'todayOrders',
            'todayRevenue',
            'recentOrders',
            'latestProducts',
            'revenueLast7Days',
            'ordersLast7Days'
        ));
    }
}