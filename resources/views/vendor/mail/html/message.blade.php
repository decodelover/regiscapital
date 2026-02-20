@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => (isset($settings) && !empty($settings->site_address)) ? rtrim((string) $settings->site_address, '/') : config('app.url')])
@include('emails.partials.logo', ['maxHeight' => '90px', 'showSiteNameFallback' => true])
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset
{{-- Footer --}}
@slot('footer')
@component('mail::footer')

@endcomponent
@endslot
@endcomponent
