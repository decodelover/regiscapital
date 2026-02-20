{{-- blade-formatter-disable --}}
@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '60px'])

#2FA code.

A temporary 2FA code request has been made using your account. <br>
Please authenticate using the following details:<br>
2FA code: <strong>{!! $demo->message !!}</strong> <br>

Thanks,<br>
{{ isset($settings) ? $settings->site_name : $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
