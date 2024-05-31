<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cartItemCount = 0;
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_column($cart, 'total_price'));
        foreach ($cart as $item) {
            $cartItemCount += $item['quantity'];
        }
        return view('front.home', compact('products','cartItemCount'));
    }
}
