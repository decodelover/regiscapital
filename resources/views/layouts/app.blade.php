<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | {{ $title }}</title>
    <link rel="icon" href="{{ asset('storage/app/public/' . $settings->favicon) }}?v={{ $cacheBuster }}" type="image/png" />

    <!-- Ensure relative URLs resolve under subfolder deployments -->
    <base href="{{ url('/') }}/">

    @section('styles')
        <!-- FIX: Correct external script to use https -->
        <script src="https://unpkg.com/metaapi.cloud-sdk/index.js"></script>

        <!-- Fonts and icons -->
        <script src="{{ asset('dash/js/plugin/webfont/webfont.min.js') }}?v={{ $cacheBuster }}"></script>
        <!-- Sweet Alert -->
        <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }}?v={{ $cacheBuster }}"></script>

        @php
            $theme = $settings->website_theme == 'blue.css' ? 'atlantis.min.css' : $settings->website_theme;
            $dashCss = base_path('dash/css');
        @endphp

        <!-- Bootstrap CSS with CDN fallback -->
        @if (file_exists($dashCss.'/bootstrap.min.css'))
            <link rel="stylesheet" href="{{ asset('dash/css/bootstrap.min.css') }}?v={{ $cacheBuster }}">
        @else
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        @endif

        <!-- Fonts CSS with CDN fallback -->
        @if (file_exists($dashCss.'/fonts.min.css'))
            <link rel="stylesheet" href="{{ asset('dash/css/fonts.min.css') }}?v={{ $cacheBuster }}">
        @else
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        @endif

        <!-- Theme CSS with fallback to a known local theme -->
        @if (file_exists($dashCss.'/'.$theme))
            <link rel="stylesheet" href="{{ asset('dash/css/' . $theme) }}?v={{ $cacheBuster }}">
        @else
            <link rel="stylesheet" href="{{ asset('dash/css/dark.css') }}?v={{ $cacheBuster }}">
        @endif

        <!-- Optional custom styles only if present -->
        @if (file_exists($dashCss.'/customs.css'))
            <link rel="stylesheet" href="{{ asset('dash/css/customs.css') }}?v={{ $cacheBuster }}">
        @endif
        @if (file_exists($dashCss.'/style.css'))
            <link rel="stylesheet" href="{{ asset('dash/css/style.css') }}?v={{ $cacheBuster }}">
        @endif
        {{-- <link rel="stylesheet" href="{{ asset('dash/css/atlantis.min.css') }}"> --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <!-- Bootstrap Notify -->
        <script src="{{ asset('dash/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}?v={{ $cacheBuster }}"></script>
        <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }}?v={{ $cacheBuster }}"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
        <!--PayPal-->
        {{-- <script>
            // Add your client ID and secret
            var PAYPAL_CLIENT = '{{ $settings->pp_ci }}';
            var PAYPAL_SECRET = '{{ $settings->pp_cs }}';

            // Point your server to the PayPal API
            var PAYPAL_ORDER_API = 'https://api.paypal.com/v2/checkout/orders/';
        </script>
        <script src="https://www.paypal.com/sdk/js?client-id={{ $settings->pp_ci }}"></script> --}}
    @show
    @livewireStyles
</head>

<body data-background-color="light">
    <script>
        {!! $settings->tawk_to !!}
    </script>
    <div id="app">
        <div>
            <div class="wrapper">
                @yield('content')
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="text-center row copyright text-align-center">
                            <p>All Rights Reserved &copy; {{ $settings->site_name }} {{ date('Y') }}</p> <br>
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    @livewireScripts
    @section('scripts')
        <!-- jQuery (CDN still okay as primary) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper/Bootstrap JS with CDN fallback if local files missing -->
        @php $dashJsCore = base_path('dash/js/core'); @endphp
        @if (file_exists($dashJsCore.'/popper.min.js'))
            <script src="{{ asset('dash/js/core/popper.min.js') }}?v={{ $cacheBuster }}"></script>
        @else
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        @endif

        @if (file_exists($dashJsCore.'/bootstrap.min.js'))
            <script src="{{ asset('dash/js/core/bootstrap.min.js') }}?v={{ $cacheBuster }}"></script>
        @else
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
        @endif

        <!-- jQuery UI -->
        <script src="{{ asset('dash/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}?v={{ $cacheBuster }}"></script>
        <script src="{{ asset('dash/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}?v={{ $cacheBuster }}"></script>
        <!-- jQuery Scrollbar -->
        <script src="{{ asset('dash/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}?v={{ $cacheBuster }}"></script>
        <!-- jQuery Sparkline -->
        <script src="{{ asset('dash/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}?v={{ $cacheBuster }}"></script>
        <!-- Sweet Alert -->
        <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }}?v={{ $cacheBuster }}"></script>
        <!-- Bootstrap Notify -->
        <script src="{{ asset('dash/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}?v={{ $cacheBuster }}"></script>

        <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.js">
        </script>

        <script src="{{ asset('dash/js/atlantis.min.js') }}?v={{ $cacheBuster }}"></script>
        <script src="{{ asset('dash/js/atlantis.js') }}?v={{ $cacheBuster }}"></script>

        <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
        </script>

        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en'
                }, 'google_translate_element');
            }
        </script>
        <script src="{{ asset('dash/js/customs.js') }}?v={{ $cacheBuster }}"></script>
    @show

</body>

</html>
