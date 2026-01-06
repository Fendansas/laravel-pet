<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;

class PaymentService
{
    public function create(
        int $userId,
        string $paymentIntentId,
        float $amount,
        array $metadata
    ): Payment {
        return Payment::create([
            'user_id' => $userId,
            'payment_intent_id' => $paymentIntentId,
            'amount' => $amount,
            'currency' => 'usd',
            'status' => 'created',
            'metadata' => $metadata,
        ]);
    }

    public function handleSuccess(string $paymentIntentId, float $amount, int $userId): void
    {
        $user = User::find($userId);

        if (! $user) {
            return;
        }

        $user->increment('balance', $amount);

        Payment::where('payment_intent_id', $paymentIntentId)
            ->update(['status' => 'succeeded']);
    }
}
