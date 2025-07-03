<?php

declare(strict_types=1);

namespace LeanMind\Booking;

use RuntimeException;
use LeanMind\Framework\Controller;
use LeanMind\Libraries\DB\EntityManager;
use LeanMind\Libraries\Redsys\RedsysClient;
use LeanMind\Libraries\Stripe\StripeClient;
use Throwable;

/**
 * `BookingController` handles booking-related operations.
 */
class BookingController extends Controller
{

    private EntityManager $entityManager;
    private RedsysClient $redsysClient;
    private StripeClient $stripeClient;

    public function __construct()
    {
        parent::__construct();
        $this->entityManager = (fn(): EntityManager => $this->load('EntityManager'))();
        $this->redsysClient = (fn(): RedsysClient => $this->load('RedsysClient'))();
        $this->stripeClient = (fn(): StripeClient => $this->load('StripeClient'))();
    }


    /**
     * Processes a payment for a booking.
     *
     * @param string $bookingId ID of the booking to process payment for.
     * @param string $paymentMethod Method of payment to use (e.g., 'redsys', 'stripe').
     */
    function pay(string $bookingId, string $paymentMethod): array
    {
        try {
            $booking = $this->entityManager->query(
                'SELECT * FROM bookings WHERE id = :id',
                ['id' => $bookingId]
            );

            if (empty($booking)) {
                throw new NotFoundBookingException($bookingId);
            }

            match (strtolower($paymentMethod)) {
                'redsys' => $this->redsysClient->processPayment($booking),
                'stripe' => $this->stripeClient->processPayment($booking),
                default => throw new UnsupportedPaymentMethodException($paymentMethod),
            };

            // Here you would typically update the booking status to 'paid' or similar
            $this->entityManager->execute(
                'UPDATE bookings SET status = :status, payment_method = :payment_method WHERE id = :id',
                ['status' => 'paid', 'payment_method' => $paymentMethod, 'id' => $bookingId]
            );

            return [
                'status' => 200,
                'message' => "Payment for booking $bookingId processed successfully using $paymentMethod.",
            ];
        } catch (NotFoundBookingException $e) {
            return [
                'status' => 404,
                'message' => $e->getMessage(),
            ];
        } catch (UnsupportedPaymentMethodException $e) {
            return [
                'status' => 400,
                'message' => $e->getMessage(),
            ];
        } catch (Throwable $e) {
            // Log the unexpected error
            print "Error: " . $e->getMessage();
            return [
                'status' => 500,
                'message' => "An error occurred while processing the payment",
            ];
        }
    }
}