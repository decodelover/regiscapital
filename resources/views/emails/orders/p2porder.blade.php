{{-- blade-formatter-disable --}}
@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '60px'])

# P2P Order Notification

Hello {{ $name }},

{!! $message !!}

Best regards,<br>
{{ isset($settings) ? $settings->site_name : 'Our Team' }}
@endcomponent
{{-- blade-formatter-disable --}}
