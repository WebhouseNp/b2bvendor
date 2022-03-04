@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your Account has been verified. 

Enjoy shopping with Sasto Wholesale.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
