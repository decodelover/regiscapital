{{-- blade-formatter-disable --}}
@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '60px'])

# Welcome to {{ isset($settings) ? $settings->site_name : $demo->sender }}!
Your registration is successful and we are really excited to welcome you to {{ isset($settings) ? $settings->site_name : $demo->sender }} community! <br>

<p style="font-size:12px">Your system generated password: <strong>{{ $demo->password }}</strong></p><br>
<p style="font-size:12px">Please do well to change this password to your prefered one.</p><br>

If you need any help, do not hesitate to reach out to us at <br> {{ isset($demo->contact_email) ? $demo->contact_email : ($settings->contact_email ?? 'support@platform.com') }} <br><br>

Kind regards,<br>
{{ isset($settings) ? $settings->site_name : $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
