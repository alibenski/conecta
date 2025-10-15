@component('mail::message')
# {{ $user_name }} is trying to reach you via the conecta app!

Here's the message:<br>
{{$msg}}<br>

Click the Connect button and log in to know more!

@if ($project_id)
@component('mail::button', ['url' => config('app.url').'/project/'.$project_id])
Connect
@endcomponent
@else
@component('mail::button', ['url' => config('app.url').'/profile/'.$user_id])
Connect
@endcomponent
@endif

Thanks,<br>
The {{ config('app.name') }} Team
@endcomponent