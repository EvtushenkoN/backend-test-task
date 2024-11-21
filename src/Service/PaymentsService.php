<?php

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentsService
{
    public function paypal(float $price): string
    {
        $paypalPaymentProcessor = new PaypalPaymentProcessor();
        try {
            $paypalPaymentProcessor->pay($price);
        } catch (\Throwable $exception) {
            // We can alter error messages if we don't want the user to know responses from payment systems
            return $exception->getMessage();
        }
        return "success";
    }

    public function stripe(float $price): string
    {
        $stripePaymentProcessor = new StripePaymentProcessor();
        if ($price < 100) {
            return "Price must be greater or equal to 100";
        }
        if (!$stripePaymentProcessor->processPayment($price)) {
            return "Unspecified payment system error";
        }
        return "success";
    }
}