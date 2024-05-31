<?php

namespace App\Services\Payment;

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalPaymentProvider implements PaymentProvider {
    protected $apiContext;

    public function __construct() {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET')
            )
        );
    }

    public function processPayment($amount) {
        try {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setTotal($amount);
            $amount->setCurrency('USD');

            $transaction = new Transaction();
            $transaction->setAmount($amount);
            $transaction->setDescription('Payment description');

            $payment = new Payment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions([$transaction]);

            $payment->create($this->apiContext);

            return $payment->getState() == 'approved';
        } catch (\Exception $e) {
            return false;
        }
    }
}
