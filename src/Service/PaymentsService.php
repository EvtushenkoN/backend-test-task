<?php

namespace App\Service;

use App\Exception\PaymentSystemException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentsService
{
    public function paypal(float $price): bool
    {
        $paypalPaymentProcessor = new PaypalPaymentProcessor();
        $paypalPaymentProcessor->pay($price);
        return true;
    }

    public function stripe(float $price): bool
    {
        $stripePaymentProcessor = new StripePaymentProcessor();
        if ($price < 100) {
            throw new PaymentSystemException("Price for stripe payment processor must be greater than 100");
        }
        if (!$stripePaymentProcessor->processPayment($price)) {
            throw new PaymentSystemException("Unspecified payment processor error");
        }
        return true;
    }
}