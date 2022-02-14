@component('mail::message')
## Hi {{ $customerName }}

The order #{{ $order->id }} was cancelled.

@component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
