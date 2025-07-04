<?php

namespace App;

interface PaymentGatewayInterface
{
   public function charge($amount, $data);
}
