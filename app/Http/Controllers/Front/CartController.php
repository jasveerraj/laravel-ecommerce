<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cartItemCount = 0;
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_column($cart, 'total_price'));
        foreach ($cart as $item) {
            $cartItemCount += $item['quantity'];
        }

        return view('front.cart', compact('cart', 'totalPrice', 'cartItemCount'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $productId = $product->id;
        $cartItemCount = 0;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            $cart[$productId]['total_price'] += $product->price;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'total_price' => $product->price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        foreach ($cart as $item) {
            $cartItemCount += $item['quantity'];
        }
        $response = [
            'cartItemCount' => $cartItemCount,
            'productName' => $product->name
        ];

        return response()->json($response);
    }

    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }

    public function getCartData(){
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_column($cart, 'total_price'));

        return response()->json([
            'cartItems' => $cart,
            'totalAmount' => $totalPrice
        ]);
    }
}
