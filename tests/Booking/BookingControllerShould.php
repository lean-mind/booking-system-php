<?php

namespace LeanMind\Tests\Booking;

use LeanMind\Booking\BookingController;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BookingControllerShould extends TestCase
{

    #[Test]
    public function pay_a_booking()
    {
        $controller = new BookingController();

        $response = $controller->pay('12345', 'redsys');

        $this->assertEquals(200, $response['status']);
        $this->assertEquals('Payment for booking 12345 processed successfully using redsys.', $response['message']);
    }
}
