<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $orders = Order::latest()->get();
           
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('actions', function($row) {
                    return '<a href="/admin/orders/'.$row['id'].'" class="btn btn-success">
							<i class="lnr lnr-eye"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.orders.index');
    }

    public function show(Order $order)
    {   
        $orderDetails = $order->load('products');
        return view('admin.orders.show', compact('orderDetails'));
    }
    
    public function update(Order $order, Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|integer|min:1|max:5'
        ]);
        $order->update(['status' => $request->status]);

        return back()->with('status','Change status of order successfully.');
    }
}
