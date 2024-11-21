<?php

namespace App\Tests;

use App\Service\PaymentsService;
use PHPUnit\Framework\TestCase;

class PaymentsServiceTest extends TestCase
{
    public function testCalculatePrice(): void
    {
        $paymentsService = new PaymentsService();

        $this->assertTrue($paymentsService->stripe(100));
        $this->assertTrue($paymentsService->paypal(100));
        $this->expectExceptionMessage("Price for stripe payment processor must be greater than 100");
        $paymentsService->stripe(50);

    }
}
