@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

You have successfully registered in Sasto Wholesale as a Vendor. So as to login, account activation is required.

Click the button below to activate your account.

@component('mail::button', ['url' => $link])
Activate Now
@endcomponent

@component('mail::panel')
You can also activate your account via this code: {{ $otp }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent