<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $product;

    public function __construct($order, $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function build()
    {
        $pdfPath = storage_path('app/public/invoices/invoice_' . $this->order->id . '.pdf');

        return $this->subject('Order Placed Successfully')
            ->view('emails.order_success')
            ->with([
                'order' => $this->order,
                'product' => $this->product,
            ])
            ->attach($pdfPath, [
                'as' => 'Invoice.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
