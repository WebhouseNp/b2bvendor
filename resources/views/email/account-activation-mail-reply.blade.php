@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your email address has been verified successfully!!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
