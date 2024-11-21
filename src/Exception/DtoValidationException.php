<?php

namespace App\Exception;

use Throwable;

class DtoValidationException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Input data is not valid: ' . $message, $code, $previous);
    }
}