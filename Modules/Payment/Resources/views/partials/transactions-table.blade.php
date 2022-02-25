<div class="ibox">
    <div class="ibox-body">
        <table class="custom-table table table-responsive">
            <thead>
                <tr>
                    <td>Transaction ID</td>
                    <td>Transaction Date</td>
                    <td>Remarks</td>
                    {{-- <td class=" text-right">Withdraw</td> --}}
                    <td class="text-right">Amount</td>
                    <td class="text-right">Balance</td>
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
                    {{-- <td class="text-right text-danger">{{ $transaction->type == 0 ? formatted_price($transaction->amount) : '-' }}</td> --}}
                    <td class="text-right {{ $transaction->type == 1 ? 'text-success' : 'text-danger' }}">{{ formatted_price($transaction->amount) }}</td>
                    <td class="text-right">{{ formatted_price($transaction->running_balance) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
