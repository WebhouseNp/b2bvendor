<?php

namespace Modules\Payment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Payment\Entities\Transaction;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    Public Transaction $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have received a payment of ' . $this->transaction->amount . ' from Sasto Wholesale.',
            'url' => '#',
        ];
    }
}
