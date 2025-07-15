<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductStockPriceUpdated implements ShouldBroadcast
{
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function broadcastOn()
    {
        return ['products']; // Channel name
    }

    public function broadcastAs()
    {
        return 'product.stockprice.updated';
    }
}
