<?php

namespace Modules\Payment\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Rendersable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Entities\Transaction;

class TransactionController extends Controller
{
    public function index(User $user)
    {
        if (!auth()->user()->hasAnyRole('super_admin|admin')) {
            abort_unless(auth()->id() == $user->id, 403);
        }

        $vendor = $user->vendor;
        $transactions = Transaction::where('vendor_user_id', $user->id)
            ->where('is_cod', false)
            ->latest()->get();

        $codTransactions = Transaction::where('vendor_user_id', $user->id)
            ->where('is_cod', true)
            ->latest()->get();

        return view('payment::transactions-listing', compact([
            'transactions',
            'vendor',
            'codTransactions'
        ]));
    }

    public function codTransactions()
    {

        return view('payment::cod-transactions-listing', compact(['transactions']));
    }
}
