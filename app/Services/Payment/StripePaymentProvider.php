<?php

namespace App\Services\Payment;

use Stripe\Stripe;
use Stripe\Charge;

class StripePaymentProvider implements PaymentProvider {
    public function __construct() {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function processPayment($amount) {
        try {
            $charge = Charge::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'source' => request()->stripeToken,
                'description' => 'Payment description',
            ]);

            return $charge->status == 'succeeded';
        } catch (\Exception $e) {
            return false;
        }
    }
}
