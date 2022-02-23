<?php

namespace Modules\Payment\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Rendersable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\Service\TransactionService;
use Modules\User\Entities\Vendor;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(User $user)
    {
        $vendor = $user->vendor;

        if (!auth()->user()->hasAnyRole('super_admin|admin')) {
            abort_unless(auth()->id() == $user->id, 403);
        }

        $vendor = $user->vendor;
        $transactions = Transaction::where('vendor_id', $vendor->id)
            ->where('is_cod', false)
            ->orWhereNull('is_cod')
            ->orderBy('id', 'DESC')->get();

            $codTransactions = Transaction::where('vendor_id', $vendor->id)
            ->where('is_cod', true)
            ->latest()->get();

            $vendorUser = $user;
            $currentBalance = $this->transactionService->getCurrentBalance($vendor->id);

        return view('payment::transactions-listing', compact([
            'transactions',
            'vendor',
            'codTransactions',
            'vendorUser',
            'currentBalance',
        ]));
    }

    public function recordPayment(Request $request, $vendorUserId)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $vendor = Vendor::where('user_id', $vendorUserId)->first();
        
        $request->validate([
            'amount' => 'required|numeric',
            'created_at' => 'nullable|date',
            'remarks' => 'required|string',
            'file' => 'nullable',
        ]);

        $currentBalance = $this->transactionService->getCurrentBalance($vendor->id);
        $transaction = new Transaction();
        $transaction->vendor_id = $vendor->id;
        $transaction->type = 0;
        $transaction->amount = $request->amount;
        $transaction->running_balance = $currentBalance - $request->amount;
        $transaction->remarks = $request->remarks;
        $transaction->created_at = $request->created_at ?? now();
        if ($request->hasFile('file')) {
            $transaction->file = $request->file('file')->store('transactions');
        }
        $transaction->save();

        return redirect()->route('transactions.index', $vendorUserId)->with('success', 'Payment recorded successfully.');
    }
}
