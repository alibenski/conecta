@component('mail::message')
# Hello!

Please click the button below to verify your email address.

@component('mail::button', ['url' => config('app.url').'/verifyemail/'.$user_id.'/'.$code])
Verify Email Address
@endcomponent


If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser: <a href="{{ config('app.url') }}/verifyemail/{{ $user_id }}/{{ $code }}">{{ config('app.url') }}/verifyemail/{{ $user_id }}/{{ $code }}</a>

<hr>


If you did not create an account, no further action is required. This code will expire in 48 hours.


The {{ config('app.name') }} Team
@endcomponent