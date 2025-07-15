<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderSuccessMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderSuccessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    /**
     * Create a new job instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Eager-load product and user
        $order = Order::with('product', 'user')->find($this->orderId);

        if ($order && $order->user) {
            \Log::info("📧 Sending order email to: " . $order->user->email);
            Mail::to($order->user->email)->send(new OrderSuccessMail($order, $order->product));
        } else {
            \Log::error('❌ Order or user not found for order ID: ' . $this->orderId);
        }
    }
}
