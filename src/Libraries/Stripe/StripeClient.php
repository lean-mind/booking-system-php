<?php

declare(strict_types=1);

namespace LeanMind\Libraries\Stripe;

use RuntimeException;

class StripeClient
{
    /**
     * Process a payment with the given parameters.
     *
     * @param array $params The parameters for the payment.
     * @return string The result of the payment processing.
     */
    public function processPayment(array $params): string
    {
        // Here you would implement the logic to process the payment with Stripe.
        // This is just a placeholder implementation.
        throw new RuntimeException('Error processing payment with Redsys');
    }

}