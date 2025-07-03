# Booking System Kata

This is a minimal booking system that allows users to pay a booking. It is designed to demonstrate the principles of
Separation of Concerns (SoC) and Dependency Inversion Principle (DIP) in software design.

## Problem Statement

A user can pay a booking by providing a payment method. The system should handle the payment process and return a
confirmation of the booking. The system should also be able to handle different payment methods, Redsys and Stripe.

Looking at the code, you will see that the `BookingController` is responsible for handling the payment process:

```php
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
            'message' => "Payment for booking $bookingId processed successfully using $paymentMethod."
        ];
    }
}
```

As you can see, the `BookingController` is injecting the `EntityManager`, `RedsysClient`, and `StripeClient` directly
through Framework's `load` method. This tightly couples the controller to these specific implementations, making it
difficult to test and maintain. Look at the example test:

```php
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
```

## Requirements

Your task is to refactor the `BookingController` to adhere to the principles of Separation of Concerns (SoC) and
Dependency Inversion Principle (DIP), allowing for easier testing and maintenance.

Provide tests to ensure the functionality of the refactored code.
