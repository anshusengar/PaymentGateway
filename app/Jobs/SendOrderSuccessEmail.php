<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderSuccessMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
class SendOrderSuccessEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */



  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

   public function handle()
{
   $order = Order::with('product', 'user')->find($orderId);

    if ($order && $order->user) {
        \Log::info("Sending email to: " . $order->user->email);
        Mail::to($order->user->email)->send(new OrderSuccessMail($order));
    } else {
        \Log::error('Order or user not found for order ID: ' . $this->order->id);
    }
}
}
