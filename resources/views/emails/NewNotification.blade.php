{{-- blade-formatter-disable --}}
@component('mail::message')
@include('emails.partials.logo', ['maxHeight' => '60px'])

# {{ $salutaion ? $salutaion : "Hello" }} {{ $recipient}},

@if ($attachment != null)
    @php
        $attachmentPath = storage_path('app/public/' . ltrim($attachment, '/'));
    @endphp
    @if(file_exists($attachmentPath))
        <img src="{{ $message->embed($attachmentPath) }}">
    @endif
@endif
{!! $body !!}

Thanks,
{{ isset($settings) ? $settings->site_name : config('app.name') }}

@endcomponent
{{-- blade-formatter-disable --}}
