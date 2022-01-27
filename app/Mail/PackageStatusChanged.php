<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Package;

class PackageStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $package, $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        $this->order = $this->package->order;
        $this->order->load('customer');

        return $this->subject('Your package has been ' . $this->package->status . '.')
            ->markdown('email.package-status-changed')
            ->with([
                'customerName' => $this->order->customer->name,
                'checkStatusLink' => config('constants.customer_app_url') . '/my-orders/' . $this->order->id
            ]);
    }
}
