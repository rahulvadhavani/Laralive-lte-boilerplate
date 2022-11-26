@component('mail::message')

# hello,
{{$mailData['name']}}
<br>
<br>
You are receiving this email because we received a password reset request for your account.
<br>

<br>
@component('mail::panel')
Your One time password is : <b>{{$mailData['otp']}}</b>
@endcomponent
<br>
This password reset link will expire in {{$mailData['expire']}} minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
