<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItemCount = 0;
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_column($cart, 'total_price'));
        foreach ($cart as $item) {
            $cartItemCount += $item['quantity'];
        }
        return view('front.checkout', compact('cart', 'totalPrice', 'cartItemCount'));
    }

    public function process(Request $request)
    {
        // Process the checkout form
    }
}