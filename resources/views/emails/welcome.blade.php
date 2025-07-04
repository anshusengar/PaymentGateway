@component('mail::message')
# Welcome {{ $user->name }}

Thanks for registering on our platform.

@component('mail::button', ['url' => 'https://yourapp.com'])
Visit Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent