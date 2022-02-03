@component('mail::message')
## Hi {{ $name }}

Your Vendor Status has been changed to #{{ $status }}.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
