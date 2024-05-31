<?php

// app/Http/Controllers/Front/OrderController.php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Str;
use App\Services\Payment\StripePaymentProvider;
use App\Services\Payment\PayPalPaymentProvider;
use App\Services\Payment\PaymentContext;


class OrderController extends Controller
{
    // Other methods...

    public function placeOrder(Request $request)
    {

        $paymentMethod = $request->input('payment_method');
        $amount = $request->input('total_amount');

        if( config('app.name') === true ){
            if ($paymentMethod == 'credit_card') {
                $paymentProvider = new StripePaymentProvider();
            } elseif ($paymentMethod == 'paypal') {
                $paymentProvider = new PayPalPaymentProvider();
            } else {
                return redirect()->back()->withErrors('Invalid payment method.');
            }

            $paymentContext = new PaymentContext($paymentProvider);
            $success = $paymentContext->processPayment($amount);
        }else{
            $success = true;
        }

        if ($success) {

            $totalPrice = 0;
            // Validate the request data
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'address' => 'required|string',
                // Add more validation rules as needed
            ]);

            $totalPrice = $request->input('total_amount');

            if($request->input('coupon')){
                $coupon = Coupon::where('code', $request->input('coupon'))->first();
                if ($coupon) {
                    $totalPrice -= $coupon->value; 
                }
            }
            // Create a new order
            $order = new Order();
            $orderId = date('His') . '-' . Str::random(6);
            $transactionId = uniqid();;
            $order->order_id = $orderId;
            $order->name = $request->input('name');
            $order->email = $request->input('email');
            $order->phone = $request->input('phone');
            $order->address = $request->input('address');
            $order->payment_method = $request->input('payment_method');
            $order->transaction_id = $transactionId;
            $order->total_amount = $totalPrice;
            $order->coupon = $request->input('coupon');
            // Add more fields as needed
            $order->save();

            // Save order items
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $Cart = new Cart();
                $Cart->order_id = $order->id;
                $Cart->product_id = $item['id'];
                $Cart->quantity = $item['quantity'];
                $Cart->total_price = $item['total_price'];
                // Add more fields as needed
                $Cart->save();
            }

            // Clear the cart
            session()->forget('cart');
            // Redirect to the order success page
            return view('front.success', compact('orderId','transactionId'));
        } else {
            return redirect()->back()->withErrors('Payment failed. Please try again.');
        }
        
    }

    public function showOrderSuccessPage(){
        return view('front.success');
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->first();

        if ($coupon) {
            $cart = session()->get('cart');
            $totalPrice = array_sum(array_column($cart, 'total_price'));
            $newTotal = $totalPrice - $coupon->discount;

            return response()->json([
                'success' => true,
                'newTotal' => $newTotal
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }
}

