@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your Account has been verified. You can login now.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
