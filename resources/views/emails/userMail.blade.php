@component('mail::message')
# Registered User

Dear {{$user->name}}, Thanks for registering with us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
