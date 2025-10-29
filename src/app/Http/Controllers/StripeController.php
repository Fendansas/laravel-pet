<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
class StripeController extends Controller
{
    public function createPaymentIntent(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $amount = $request->input('amount');
        $amountInCents = $amount * 100;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'description' => 'Replenishment of user balance' . auth()->user()->email,
            'payment_method_types' => ['card'],
            'metadata' => [
                'user_id'=> auth()->user()->id,
                'action'=> 'deposit'
            ],
        ]);

        Payment::create([
            'user_id' => auth()->id(),
            'payment_intent_id' => $paymentIntent->id,
            'amount' => $amount,
            'currency' => 'usd',
            'status' => 'created',
            'metadata' => $paymentIntent->metadata,
        ]);


        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function webhook(Request $request){

        $payload = @file_get_contents('php://input');
        $event = json_decode($payload, true);

        if(isset($event['type']) && $event['type'] == 'payment_intent.succeeded'){
            $paymentIntent = $event['data']['object'];
            $userId = $paymentIntent['metadata']['user_id'] ?? null;
            $amount = $paymentIntent['amount'] / 100;

            if ($userId && $user = User::find($userId)) {
                $user->increment('balance', $amount);

                Payment::where('payment_intent_id', $paymentIntent['id'])
                    ->update(['status' => 'succeeded']);
            }
        }

        return response()->json([
            'status' => 'success',
        ]);
    }


}
