<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $orders = Order::select(['id','status','total'])
            ->with('products')
            ->where('user_id',$userId)
            ->latest()
            ->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }
    public function show($id)
    {
        $userId = auth()->user()->id;
        $order = Order::with('products')
            ->where('user_id',$userId)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return abort(404);
        }
        return view('user.orders.detail', compact('order'));
    }
    public function cancel($id)
    {
        $userId = auth()->user()->id;
        $order = Order::where('user_id',$userId)
            ->where('id', $id)
            ->first();

        $order->update(['status' => 0]);
        
        return back();
    }
}
