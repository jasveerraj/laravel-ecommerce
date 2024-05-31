<?php

namespace App\Services\Payment;

class PaymentContext {
    private $paymentProvider;

    public function __construct(PaymentProvider $paymentProvider) {
        $this->paymentProvider = $paymentProvider;
    }

    public function processPayment($amount) {
        return $this->paymentProvider->processPayment($amount);
    }
}
