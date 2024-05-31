<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
       $orders = Order::all();
       $products = product::all();
       return view('dashboard', compact('orders', 'products'));
    }

    public function orders()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders')); 
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }
}
