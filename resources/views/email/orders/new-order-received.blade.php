{{-- For vendor --}}
@component('mail::message')
## Hi 

You have received a new order #{{ $order->id }}.

Please process the order as soon as possible.

{{-- @component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent --}}

@component('mail::button', ['url' => $viewOrderLink])
Order Status
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
