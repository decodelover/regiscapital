@php
    $maxHeight = $maxHeight ?? '60px';
    $logoSrc = null;
    $logoAlt = isset($settings) && !empty($settings->site_name) ? $settings->site_name : config('app.name');
    $primaryLogoPath = $brandLogoPath ?? base_path('main logo for email.png');

    if (isset($message) && file_exists($primaryLogoPath)) {
        try {
            $logoSrc = $message->embed($primaryLogoPath);
        } catch (\Throwable $e) {
            $logoSrc = null;
        }
    }
@endphp

@if($logoSrc)
<img src="{{ $logoSrc }}" alt="{{ $logoAlt }}" style="max-height: {{ $maxHeight }}; margin-bottom: 20px;">
@elseif(!empty($showSiteNameFallback))
<span style="font-size: 26px; font-weight: 700; text-decoration: none;">{{ $logoAlt }}</span>
@endif
