<?php

declare(strict_types=1);

namespace LeanMind\Booking;

use RuntimeException;

class UnsupportedPaymentMethodException extends RuntimeException
{
    protected $message;

    public function __construct(string $paymentMethod)
    {
        $this->message = "Payment method '$paymentMethod' is not supported.";
        parent::__construct($this->message);
    }
}
