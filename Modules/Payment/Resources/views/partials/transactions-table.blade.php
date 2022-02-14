<div class="ibox">
    <div class="ibox-body">
        <table class="table table-responsive table-borderless" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <td class="text-muted">Transaction ID</td>
                    <td class="text-muted">Transaction Date</td>
                    <td class="text-muted">Remarks</td>
                    <td class="text-muted text-right">Withdraw</td>
                    <td class="text-muted text-right">Deposit</td>
                    <td class="text-muted text-right">Balance</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                    <td>
                        <div>
                            {{ $transaction->remarks }}
                        </div>
                        @if ($transaction->file)
                        <div>
                            <a href="{{ $transaction->fileUrl() }}" target="_blank">View attachment</a>
                        </div>
                        @endif
                    </td>
                    <td class="text-right text-danger">{{ $transaction->type == 0 ? formatted_price($transaction->amount) : '-' }}</td>
                    <td class="text-right text-success">{{ $transaction->type == 1 ? formatted_price($transaction->amount) : '-' }}</td>
                    <td class="text-right">{{ formatted_price($transaction->running_balance) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
