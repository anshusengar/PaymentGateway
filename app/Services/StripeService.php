<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;

class StripeService implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge($amount, $data)
    {
        return Charge::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'source' => $data['token'],
            'description' => 'Invoice Payment',
        ]);
    }
}
