@component('mail::message')
# Verfiy Your email

Hello, {{$mailData['name']}}. Congratulations, Your account signup was successful. Please verify your account by clicking the "Confirm" Button below. 
@component('mail::button', ['url' => $mailData['link']])
    Confirm
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
