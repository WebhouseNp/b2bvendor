<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Transaction;

class ReleasePaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            logger('saving payment');
            $isCod = $this->order->payment_type == 'cod' ? true : false;
            $currentBalance = Transaction::where('vendor_id', $this->order->vendor_id)
                ->where('is_cod', false)
                ->latest()->first()->running_balance ?? 0;

            $transaction = new Transaction();
            $transaction->vendor_id = $this->order->vendor_id;
            $transaction->type = 1;
            $transaction->amount = $this->order->total_price;
            $transaction->running_balance = $isCod
                ? $this->order->total_price
                : ($currentBalance + $this->order->total_price);
            $transaction->remarks = 'Order #' . $this->order->id;
            $transaction->is_cod = $isCod;
            $transaction->save();
        } catch (\Throwable $th) {
            report($th);
            logger('Failed to release payment of order #' . $this->order->id);
            throw $th;
        }
    }
}
