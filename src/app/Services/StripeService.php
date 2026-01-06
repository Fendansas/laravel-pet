<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent(
        int $amountInCents,
        array $metadata,
        string $description
    ): PaymentIntent {
        return PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }
}
