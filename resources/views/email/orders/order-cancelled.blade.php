@component('mail::message')
## Hi {{ $customerName }}

Sorry to be the bearer of bad news, but your order #{{ $order->id }} was cancelled.

@component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
