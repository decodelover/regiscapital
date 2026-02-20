{{-- blade-formatter-disable --}}
@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '60px'])

# Hello {{ $demo->receiver_name }},

This is to notify you that your investment plan ({{ $demo->receiver_plan }} plan)  has expired and your capital for this plan has been added to your account for withdrawal. <br>

<strong>Plan:</strong> {{ $demo->receiver_plan }} <br>

<strong>Amount:</strong> {{ $demo->received_amount }} <br>

<strong>Date:</strong> {{ $demo->date }} <br>

Kind regards,<br>
{{ isset($settings) ? $settings->site_name : $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
