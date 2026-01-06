<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
class StripeController extends Controller
{
    public function createPaymentIntent(Request $request, StripeService $stripeService, PaymentService $paymentService){
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $amount = $data['amount'];
        $amountInCents =  ($amount * 100);
        $user = Auth::user();

        $paymentIntent = $stripeService->createPaymentIntent(
            $amountInCents,
            [
                'user_id' => $user->id,
                'action' => 'deposit',
            ],
            'Replenishment of user balance: ' . $user->email
        );

        $paymentService->create(
            $user->id,
            $paymentIntent->id,
            $amount,
            $paymentIntent->metadata->toArray()
        );


        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function webhook(Request $request, PaymentService $paymentService){

        $payload = $request->getContent();
        $event = json_decode($payload, true);

        if (
            isset($event['type']) &&
            $event['type'] === 'payment_intent.succeeded'
        ) {
            $paymentIntent = $event['data']['object'];

            $userId = $paymentIntent['metadata']['user_id'] ?? null;
            $amount = $paymentIntent['amount'] / 100;

            if ($userId) {
                $paymentService->handleSuccess(
                    $paymentIntent['id'],
                    $amount,
                    (int) $userId
                );
            }
        }

        return response()->json(['status' => 'success']);
    }


}
