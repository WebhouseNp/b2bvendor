@component('mail::message')
## Hi {{ $customerName }}

Your payment for the order #{{ $order->id }} has been refunded.

Keep shopping from Sasto Wholesale.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
