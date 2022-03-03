@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your Account has been verified. 

Thanks,<br>
{{ config('app.name') }}
@endcomponent
