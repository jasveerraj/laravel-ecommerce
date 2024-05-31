<?php

namespace App\Services\Payment;

interface PaymentProvider {
    public function processPayment($amount);
}