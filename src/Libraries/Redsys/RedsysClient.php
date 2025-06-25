<?php

declare(strict_types=1);

namespace LeanMind\Libraries\Redsys;

use RuntimeException;

class RedsysClient
{

    /**
     * Process a payment with the given parameters.
     *
     * @param array $params The parameters for the payment.
     * @return string The result of the payment processing.
     */
    public function processPayment(array $params): string
    {
        // Here you would implement the logic to process the payment with Redsys.
        // This is just a placeholder implementation.
        throw new RuntimeException('Error processing payment with Redsys');
    }

}