
@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '70px'])

# Welcome to {{ $settings->site_name }}, {{ $user->name }}!

We’re excited to have you on board. Your account has been successfully created, and you can now access our secure banking services.

## Your Account Details:
- **Name:** {{ $user->name }}
- **Username:** {{ $user->username }}
- **Account Number:** {{ $user->usernumber }}
- **Account Type:** {{$user->	accounttype}}


@component('mail::button', ['url' => url('/login')])
Login to Your Account
@endcomponent

## 🔒 Security Tips:
- Never share your login details or PIN with anyone.
- Always verify emails from us before clicking any links.

If you need any assistance, feel free to contact our support team at [{{$settings->contact_email}}](mailto:{{$settings->contact_email}}).


Best regards,
**{{ $settings->site_name }}**
@endcomponent
