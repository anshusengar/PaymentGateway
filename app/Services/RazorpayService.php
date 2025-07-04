<?php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService implements PaymentGatewayInterface
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    public function charge($amount, $data)
    {
        $payment = $this->api->payment->fetch($data['payment_id']);
        return $payment->capture(['amount' => $amount * 100]);
    }
}
