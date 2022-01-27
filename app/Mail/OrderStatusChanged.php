<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Package;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $package;
    public function __construct(Package $package)
    {
        $this->package = $package;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.order-notice-status')
        ->with([
            'product_name' => $this->package->product->name,
            'status' => $this->package->status,
            'name' => $this->package->order->customer->name,

        ]);
    }
}
