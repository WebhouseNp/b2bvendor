<div class="ibox">
    <div class="ibox-body">
        <table class="table table-responsive table-borderless" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <td class="text-muted">Transaction ID</td>
                    <td class="text-muted">Transaction Date</td>
                    <td class="text-muted">Remarks</td>
                    <td class="text-muted text-right">Amount</td>
                    <td class="text-muted text-right">Status</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($codTransactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                    <td>{{ $transaction->remarks }}</td>
                    <td class="text-right text-success">{{ formatted_price($transaction->amount) }}</td>
                    <td class="text-right"><i class="fa fa-circle mr-2 {{ $transaction->is_settled ? 'text-success' : 'text-danger' }}"></i>{{ $transaction->is_settled ? 'Settled' : 'Not Settled' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>