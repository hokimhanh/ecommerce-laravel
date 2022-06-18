<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Product, Order};
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();

        $products = Product::count();

        $pendingOrders = Order::where('status',1)->count();

        $income = Order::where('status',4)->sum('total');

        $featuredProducts = Product::select([
            'name','price','discount','is_in_stock',])
            ->withSum(['orders' => function ($query) {
                $query->whereMonth('orders.created_at',Carbon::now()->month);               
            }],'order_details.quantity')
            ->orderByDesc('orders_sum_order_detailsquantity')
            ->take(10)
            ->get();
        
        return view('admin.dashboard',
            compact('users','products','pendingOrders','income','featuredProducts'));

    }
}
