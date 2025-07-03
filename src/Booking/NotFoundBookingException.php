<?php

declare(strict_types=1);

namespace LeanMind\Booking;

use RuntimeException;

class NotFoundBookingException extends RuntimeException
{
    protected $message;

    public function __construct(string $bookingId)
    {
        $this->message = "Booking with ID $bookingId not found.";
        parent::__construct($this->message);
    }
}
