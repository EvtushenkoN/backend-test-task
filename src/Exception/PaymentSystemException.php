<?php

namespace App\Exception;

use Throwable;

class PaymentSystemException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Payment system error: ' . $message, $code, $previous);
    }
}