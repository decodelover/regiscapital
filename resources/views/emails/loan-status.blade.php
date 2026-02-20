@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '60px'])

# Hello {{ $user->name }},

@if ($status === 'Pending')
Your loan application has been received successfully and is currently under review.
@elseif ($status === 'Processed')
Your loan request has been approved and credited to your account.
@elseif ($status === 'Rejected')
Your loan request was not approved at this time. Please contact support for more details.
@elseif ($status === 'Active')
Your loan is now active on your account.
@elseif ($status === 'Completed')
Your loan has been marked as completed.
@else
Your loan status has been updated to <strong>{{ $status }}</strong>.
@endif

<strong>Loan Details</strong><br>
Application ID: #{{ $loan->id }}<br>
Amount: {{ $settings->currency ?? '$' }}{{ number_format((float) $loan->amount, 2, '.', ',') }}<br>
Purpose: {{ $loan->purpose ?? 'N/A' }}<br>
Duration: {{ $loan->duration ?? $loan->inv_duration ?? 'N/A' }}<br>
Facility: {{ $loan->facility ?? 'N/A' }}<br>
Current Status: {{ $status }}<br>
Date: {{ \Carbon\Carbon::parse($loan->created_at)->toDayDateTimeString() }}<br>

@component('mail::button', ['url' => route('veiwloan')])
View Loan Status
@endcomponent

Thanks,<br>
{{ isset($settings) ? $settings->site_name : config('app.name') }}
@endcomponent

