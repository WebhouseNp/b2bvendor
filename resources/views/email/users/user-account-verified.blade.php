@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your Account has been verified. 

@if(!$isVendor)
Enjoy shopping with Sasto Wholesale.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
