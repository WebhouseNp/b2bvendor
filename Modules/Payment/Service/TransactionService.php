<?php

namespace Modules\Payment\Service;

use Modules\Payment\Entities\Transaction;

class TransactionService
{
    public function deposit($vendorId, $amount, $isCod, $remarks = null)
    {
        try {
            $currentBalance = $this->getCurrentBalance($vendorId);
            $transaction = new Transaction();
            $transaction->vendor_user_id = $vendorId;
            $transaction->type = 1;
            $transaction->amount = $amount;
            $transaction->running_balance = $currentBalance + $amount;
            $transaction->remarks = $remarks;
            if($isCod == 'cod') {
                $transaction->is_cod = true;
            }
            $transaction->save();
        } catch (\Throwable $th) {
            report($th);
            throw $th;
        }
    }

    public function withdraw($vendorId, $amount, $remarks = null)
    {
        $currentBalance = Transaction::where('vendor_user_id', $vendorId)->latest()->first()->running_balance ?? 0;
        $transaction = new Transaction();
        $transaction->type = 0;
        $transaction->vendor_user_id = $vendorId;
        $transaction->amount = $amount;
        $transaction->running_balance = $currentBalance - $amount;
        $transaction->remarks = $remarks;
        $transaction->save();
    }

    public function getCurrentBalance($vendorId)
    {
        return Transaction::where('vendor_user_id', $vendorId)
        ->where('is_cod', false)
        ->orWhereNull('is_cod')
        ->latest()->first()->running_balance ?? 0;
    }
}
