<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>{{ $settings->site_name }} | @yield('title')</title>
    <meta name="description" content="Swift and Secure Money Transfer to any UK bank account will become a breeze with {{$settings->site_name}}." />
    <link rel="shortcut icon" href="{{ asset('storage/app/public/' . $settings->favicon) }}?v={{ $cacheBuster }}" />
    <link rel="preload" href="path/to/GraphikRegular.otf" as="font" type="font/otf" crossorigin="anonymous">



    <!-- Initial theme colors setup (before anything else loads) -->
    <script>
        // Set CSS theme variables - these match our Tailwind theme
        document.documentElement.style.setProperty('--primary-color', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color : "#0ea5e9" }}');
        document.documentElement.style.setProperty('--primary-color-dark', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#0369a1" }}');
        document.documentElement.style.setProperty('--primary-color-light', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#38bdf8" }}');
        document.documentElement.style.setProperty('--primary-color-lightest', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#bae6fd" }}');
        document.documentElement.style.setProperty('--secondary-color', '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color : "#14b8a6" }}');
        document.documentElement.style.setProperty('--secondary-color-dark', '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#0f766e" }}');
        document.documentElement.style.setProperty('--secondary-color-light', '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#2dd4bf" }}');
        document.documentElement.style.setProperty('--accent-color', '#ec4899');
        document.documentElement.style.setProperty('--text-color', '{{ isset($appearanceSettings) ? $appearanceSettings->text_color : "#111827" }}');
        document.documentElement.style.setProperty('--bg-color', '{{ isset($appearanceSettings) ? $appearanceSettings->bg_color : "#f9fafb" }}');
        document.documentElement.style.setProperty('--sidebar-bg-color', '{{ isset($appearanceSettings) ? $appearanceSettings->sidebar_bg_color : "#1e293b" }}');
        document.documentElement.style.setProperty('--sidebar-text-color', '{{ isset($appearanceSettings) ? $appearanceSettings->sidebar_text_color : "#ffffff" }}');
        document.documentElement.style.setProperty('--card-bg-color', '{{ isset($appearanceSettings) ? $appearanceSettings->card_bg_color : "#ffffff" }}');
    </script>

    <!-- Tailwind CSS with custom color variables -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#f0f9ff" }}',
                            100: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#e0f2fe" }}',
                            200: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#bae6fd" }}',
                            300: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#7dd3fc" }}',
                            400: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#38bdf8" }}',
                            500: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color : "#0ea5e9" }}',
                            600: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color : "#0284c7" }}',
                            700: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#0369a1" }}',
                            800: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#075985" }}',
                            900: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#0c4a6e" }}',
                        },
                        secondary: {
                            50: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#f0fdfa" }}',
                            100: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#ccfbf1" }}',
                            200: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#99f6e4" }}',
                            300: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#5eead4" }}',
                            400: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#2dd4bf" }}',
                            500: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color : "#14b8a6" }}',
                            600: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color : "#0d9488" }}',
                            700: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#0f766e" }}',
                            800: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#115e59" }}',
                            900: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#134e4a" }}',
                        },
                        accent: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>

    @if(isset($appearanceSettings) && $appearanceSettings->custom_css)
    <style>
        {!! $appearanceSettings->custom_css !!}
    </style>
    @endif

    @if(isset($appearanceSettings) && $appearanceSettings->disable_animations)
    <style>
        * {
            animation: none !important;
            transition: none !important;
        }
    </style>
    @endif

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>

    <!-- Custom Fonts -->
  

    <!-- Modern Loading Animation -->
    <style>
        .page-loading {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: all .4s .2s ease-in-out;
            background-color: #ffffff;
            visibility: hidden;
            z-index: 9999;
        }
        .page-loading.active {
            opacity: 1;
            visibility: visible;
        }
        .page-loading-inner {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            text-align: center;
            transform: translateY(-50%);
            transition: opacity .2s ease-in-out;
            opacity: 0;
        }
        .page-loading.active>.page-loading-inner {
            opacity: 1;
        }

        .loading-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .loading-animation {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            position: relative;
        }

        .loading-animation .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid transparent;
            mix-blend-mode: overlay;
            animation: rotateCircle 1.5s linear infinite;
        }

        .loading-animation .circle:nth-child(1) {
            border-top-color: var(--primary-color);
            animation-delay: 0s;
        }

        .loading-animation .circle:nth-child(2) {
            border-right-color: var(--primary-color-light);
            animation-delay: 0.2s;
        }

        .loading-animation .circle:nth-child(3) {
            border-bottom-color: var(--secondary-color);
            animation-delay: 0.4s;
        }

        .loading-animation .circle:nth-child(4) {
            border-left-color: var(--primary-color-lightest);
            animation-delay: 0.6s;
        }

        .loading-animation .core {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color-light), var(--primary-color-dark));
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
            animation: pulse 1s ease-in-out infinite alternate;
        }

        .page-loading .text {
            color: var(--primary-color);
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            background: linear-gradient(90deg, var(--primary-color-dark), var(--primary-color-light), var(--primary-color-dark));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient 2s linear infinite;
        }

        @keyframes rotateCircle {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            from {
                transform: scale(0.8);
                opacity: 0.8;
            }
            to {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @laravelPWA
</head>

<body class="bg-gray-50">
    <!-- Modern Page Loader -->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="loading-container">
                <div class="loading-animation">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="core"></div>
                </div>
                <div class="text">{{ $settings->site_name }} Banking</div>
            </div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex h-screen overflow-hidden" x-data="{sidebarOpen: false, mobileMenuOpen: false, userDropdownOpen: false, notificationsOpen: false}">
        <!-- Sidebar - Desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col bg-white h-full border-r border-gray-200 shadow-sm">
            <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
                <!-- Logo -->
                <div class="flex items-center justify-center flex-shrink-0 px-4 mb-6">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ $brandLogoUrl }}?v={{ $cacheBuster }}" alt="Logo" class="h-10 w-auto">
                    </a>
                </div>

                <!-- User Info Card - Desktop Sidebar -->
                <div class="px-4 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-3">
    <div class="flex-shrink-0 mr-3">
        @if(!empty(Auth::user()->profile_photo_path))
            <img src="{{ asset('storage/app/public/photos/'.Auth::user()->profile_photo_path)}}"
                alt="{{ Auth::user()->name }}"
                class="h-10 w-10 rounded-full object-cover border-2 border-primary-100">
        @else
            @php
                $initials = strtoupper(substr(Auth::user()->name, 0, 1) . substr(Auth::user()->lastname, 0, 1));
            @endphp
            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-white font-bold border-2 border-primary-100">
                {{ $initials }}
            </div>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900 truncate">
            {{ Auth::user()->name }} {{ Auth::user()->lastname }}
        </p>
        <p class="text-xs text-gray-500 truncate">
            ID: {{ Auth::user()->usernumber }}
        </p>
    </div>
</div>


                        <!-- KYC Verification Status -->
                        <div class="mb-3">
                            @php
                                $sidebarKycStatus = strtolower((string) Auth::user()->account_verify);
                            @endphp
                            @if($sidebarKycStatus === 'verified')
                                <div class="flex items-center justify-center py-1 rounded-md bg-green-50 border border-green-100">
                                    <span class="text-xs text-green-800 font-medium flex items-center">
                                        <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i> KYC Verified
                                    </span>
                                </div>
                            @elseif($sidebarKycStatus === 'under review')
                                <div class="flex items-center justify-center py-1 rounded-md bg-yellow-50 border border-yellow-100">
                                    <span class="text-xs text-yellow-800 font-medium flex items-center">
                                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i> KYC Under Review
                                    </span>
                                </div>
                            @elseif($sidebarKycStatus === 'rejected')
                                <div class="flex items-center justify-center py-1 rounded-md bg-rose-50 border border-rose-100">
                                    <span class="text-xs text-rose-800 font-medium flex items-center">
                                        <i data-lucide="x-circle" class="h-3 w-3 mr-1"></i> KYC Rejected
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center justify-center py-1 rounded-md bg-gray-50 border border-gray-200">
                                    <span class="text-xs text-gray-700 font-medium flex items-center">
                                        <i data-lucide="alert-circle" class="h-3 w-3 mr-1"></i> KYC Pending
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('profile') }}" class="flex-1 inline-flex justify-center items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                <i data-lucide="user" class="h-3 w-3 mr-1"></i> Profile
                            </a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                                class="flex-1 inline-flex justify-center items-center px-2.5 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded text-white bg-primary-600 hover:bg-primary-700">
                                <i data-lucide="log-out" class="h-3 w-3 mr-1"></i> Logout
                            </a>
                            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <nav class="flex-1 px-4 space-y-1">
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Main Menu</p>

                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="home" class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-black' : 'text-gray-500' }}"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('accounthistory') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('accounthistory') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="activity" class="mr-3 h-5 w-5 {{ request()->routeIs('accounthistory') ? 'text-black' : 'text-gray-500' }}"></i>
                        Transactions
                    </a>

                    <!-- Cards Menu Item -->
                    <a href="{{ route('cards') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('cards*') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="credit-card" class="mr-3 h-5 w-5 {{ request()->routeIs('cards*') ? 'text-black' : 'text-gray-500' }}"></i>
                        Cards
                    </a>

                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Transfers</p>

                    <a href="{{ route('localtransfer') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('localtransfer') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="send" class="mr-3 h-5 w-5 {{ request()->routeIs('localtransfer') ? 'text-black' : 'text-gray-500' }}"></i>
                        Local Transfer
                    </a>

                    <a href="{{ route('internationaltransfer') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('internationaltransfer') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="globe" class="mr-3 h-5 w-5 {{ request()->routeIs('internationaltransfer') ? 'text-black' : 'text-gray-500' }}"></i>
                        International Wire
                    </a>

                    <a href="{{ route('deposits') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('deposits') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="download" class="mr-3 h-5 w-5 {{ request()->routeIs('deposits') ? 'text-black' : 'text-gray-500' }}"></i>
                        Deposit
                    </a>

                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Services</p>

                    <a href="{{ route('loan') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('loan') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="credit-card" class="mr-3 h-5 w-5 {{ request()->routeIs('loan') ? 'text-black' : 'text-gray-500' }}"></i>
                        Loan Request
                    </a>

                    <a href="{{ route('irs-refund') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('irs-refund*') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="receipt" class="mr-3 h-5 w-5 {{ request()->routeIs('irs-refund*') ? 'text-black' : 'text-gray-500' }}"></i>
                        IRS Tax Refund
                    </a>

                    <a href="{{ route('veiwloan') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('veiwloan') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="history" class="mr-3 h-5 w-5 {{ request()->routeIs('veiwloan') ? 'text-black' : 'text-gray-500' }}"></i>
                        Loan History
                    </a>

                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Account</p>

                    <a href="{{ route('profile') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('profile') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="settings" class="mr-3 h-5 w-5 {{ request()->routeIs('profile') ? 'text-black' : 'text-gray-500' }}"></i>
                        Settings
                    </a>

                    <a href="{{ route('support') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('support') ? 'bg-primary-50 text-black border-l-4 border-primary-500 pl-2' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i data-lucide="help-circle" class="mr-3 h-5 w-5 {{ request()->routeIs('support') ? 'text-black' : 'text-gray-500' }}"></i>
                        Support Ticket
                    </a>
                </nav>
            </div>

            <!-- App Version -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i data-lucide="shield-check" class="h-4 w-4 text-green-500 mr-2"></i>
                        <span class="text-xs text-gray-500">Secure Banking</span>
                    </div>
                    <span class="text-xs text-gray-400">v1.2.0</span>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-20">
                <div class="flex items-center justify-between px-4 py-3">
                    <!-- Mobile: Logo + Menu button -->
                    <div class="flex items-center md:hidden">
                        <button
                            @click="sidebarOpen = false; mobileMenuOpen = !mobileMenuOpen"
                            type="button"
                            class="text-gray-500 hover:text-gray-600 focus:outline-none"
                            aria-label="Toggle menu">
                            <i data-lucide="menu" class="h-6 w-6"></i>
                        </button>
                        <a href="{{ url('/') }}" class="ml-4">
                            <img src="{{ $brandLogoUrl }}?v={{ $cacheBuster }}" alt="Logo" class="h-8 w-auto">
                        </a>
                    </div>

                    <!-- Desktop: Current Date & Time + Search bar -->
                    <div class="hidden md:flex md:flex-1 md:items-center">
                        <div class="text-sm text-gray-600 flex items-center">
                            <i data-lucide="calendar" class="h-4 w-4 mr-2 text-gray-400"></i>
                            <span>{{ now()->format('l, F j, Y') }}</span>
                        </div>
                    </div>

                    <!-- Right Nav Items (Both mobile & desktop) -->
                    <div class="flex items-center space-x-4">
                        <!-- Balance indicator (desktop only) -->
                        <div class="hidden md:flex items-center px-3 py-1.5 bg-primary-50 rounded-full">
                            <i data-lucide="wallet" class="h-4 w-4 text-gray-900 mr-2"></i>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $settings->currency }}{{ number_format(Auth::user()->account_bal,0, '.', ',') }}
                            </span>
                        </div>

                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ notificationsOpen: false }">
                            <button
                                @click="notificationsOpen = !notificationsOpen; userDropdownOpen = false"
                                class="relative p-1 text-gray-500 hover:text-gray-600 focus:outline-none">
                                <i data-lucide="bell" class="h-6 w-6"></i>
                                @if(Auth::user()->unreadNotificationsCount() > 0)
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </button>

                            <!-- Notification dropdown -->
                            <div
                                x-show="notificationsOpen"
                                @click.away="notificationsOpen = false"
                                class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                        <form action="{{ route('notifications.read.all') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-black hover:text-primary-500">Mark all as read</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Notification items -->
                                <div class="max-h-60 overflow-y-auto">
                                    @php
                                        $notifications = Auth::user()->notifications()->latest()->take(5)->get();
                                    @endphp

                                    @forelse($notifications as $notification)
                                        <a
                                            href="{{ route('notifications.read', $notification->id) }}"
                                            class="block px-4 py-3 hover:bg-gray-50 transition {{ $notification->is_read ? 'opacity-60' : '' }}"
                                        >
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <div class="flex items-center justify-center h-9 w-9 rounded-full
                                                        @if($notification->type == 'success') bg-green-100 text-green-500
                                                        @elseif($notification->type == 'warning') bg-yellow-100 text-yellow-500
                                                        @elseif($notification->type == 'danger') bg-red-100 text-red-500
                                                        @else bg-blue-100 text-blue-500 @endif"
                                                    >
                                                        <i data-lucide="{{ $notification->icon ?? 'bell' }}" class="h-5 w-5"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    @if($notification->title)
                                                        <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                                    @endif
                                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $notification->message }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="py-6 text-center">
                                            <i data-lucide="inbox" class="h-8 w-8 mx-auto text-gray-300 mb-1"></i>
                                            <p class="text-sm text-gray-500">No notifications yet</p>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="px-4 py-3 border-t border-gray-100 text-center">
                                    <a href="{{ route('notifications') }}" class="text-sm font-medium text-black hover:text-primary-500">View all notifications</a>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <button
    @click="userDropdownOpen = !userDropdownOpen; notificationsOpen = false"
    class="flex items-center max-w-xs text-sm rounded-full focus:outline-none"
    id="user-menu-button"
    aria-expanded="false"
    aria-haspopup="true"
>
    <span class="sr-only">Open user menu</span>

    @if(!empty(Auth::user()->profile_photo_path))
        <img
            class="h-8 w-8 rounded-full object-cover border-2 border-gray-200"
            src="{{ asset('storage/app/public/photos/'.Auth::user()->profile_photo_path)}}"
            alt="{{ Auth::user()->name }}"
        >
    @else
        @php
            $initials = strtoupper(substr(Auth::user()->name, 0, 1) . substr(Auth::user()->lastname, 0, 1));
        @endphp
        <div class="h-8 w-8 rounded-full bg-primary-100 text-white flex items-center justify-center font-semibold border-2 border-gray-200">
            {{ $initials }}
        </div>
    @endif
</button>


                            <!-- User dropdown menu -->
                            <div
                                x-show="userDropdownOpen"
                                @click.away="userDropdownOpen = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="user-menu-button"
                                tabindex="-1"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</p>
                                    <p class="text-xs text-gray-500 mt-1">ID: {{ Auth::user()->usernumber }}</p>

                                    <!-- KYC Verification Status -->
                                    @php
                                        $headerKycStatus = strtolower((string) Auth::user()->account_verify);
                                    @endphp
                                    @if($headerKycStatus === 'verified')
                                        <div class="mt-2 flex items-center">
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 flex items-center">
                                                <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i> Verified
                                            </span>
                                        </div>
                                    @elseif($headerKycStatus === 'under review')
                                        <div class="mt-2 flex items-center">
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 flex items-center">
                                                <i data-lucide="clock" class="h-3 w-3 mr-1"></i> Under Review
                                            </span>
                                        </div>
                                    @elseif($headerKycStatus === 'rejected')
                                        <div class="mt-2 flex items-center">
                                            <span class="px-2 py-1 text-xs rounded-full bg-rose-100 text-rose-800 flex items-center">
                                                <i data-lucide="x-circle" class="h-3 w-3 mr-1"></i> Rejected
                                            </span>
                                        </div>
                                    @else
                                        <div class="mt-2 flex items-center">
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 flex items-center">
                                                <i data-lucide="alert-circle" class="h-3 w-3 mr-1"></i> Pending
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('support') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" role="menuitem">
                                    <i data-lucide="help-circle" class="h-4 w-4 mr-3 text-gray-500"></i> Support Ticket
                                </a>
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" role="menuitem">
                                    <i data-lucide="user" class="h-4 w-4 mr-3 text-gray-500"></i> My Profile
                                </a>
                                <a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"
                                    class=" block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center"
                                    role="menuitem">
                                    <i data-lucide="log-out" class="h-4 w-4 mr-3 text-gray-500"></i> Sign Out
                                </a>
                                <form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Mobile Menu Popup - Centered Floating Box -->
            <div
                x-show="mobileMenuOpen"
                class="fixed inset-0 flex items-center justify-center z-40 md:hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90">
                <!-- Overlay -->
                <div
                    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
                    aria-hidden="true"
                    @click="mobileMenuOpen = false"></div>

                <!-- Popup Content - Centered Box -->
                <div class="relative w-11/12 max-w-md bg-white rounded-2xl shadow-2xl p-5 z-50">
                    <!-- Close button -->
                    <button
                        type="button"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-500"
                        @click="mobileMenuOpen = false">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>

                    <!-- User info for mobile -->
                    <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                        <div class="flex-shrink-0 mr-3">
    @if(!empty(Auth::user()->profile_photo_path))
        <img
            src="{{ asset('storage/app/public/photos/'.Auth::user()->profile_photo_path)}}"
            alt="{{ Auth::user()->name }}"
            class="h-12 w-12 rounded-full object-cover border-2 border-primary-100">
    @else
        @php
            $initials = strtoupper(substr(Auth::user()->name, 0, 1) . substr(Auth::user()->lastname, 0, 1));
        @endphp
        <div class="h-12 w-12 rounded-full bg-primary-100 text-white flex items-center justify-center font-bold border-2 border-primary-100">
            {{ $initials }}
        </div>
    @endif
</div>

                        <div>
                            <h2 class="text-base font-semibold text-gray-900">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</h2>
                            <p class="text-sm text-gray-500">Account: {{ Auth::user()->usernumber }}</p>

                            <!-- KYC Verification Status -->
                            @php
                                $mobileKycStatus = strtolower((string) Auth::user()->account_verify);
                            @endphp
                            @if($mobileKycStatus === 'verified')
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800 inline-flex items-center">
                                        <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i> Verified
                                    </span>
                                </div>
                            @elseif($mobileKycStatus === 'under review')
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800 inline-flex items-center">
                                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i> Under Review
                                    </span>
                                </div>
                            @elseif($mobileKycStatus === 'rejected')
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-rose-100 text-rose-800 inline-flex items-center">
                                        <i data-lucide="x-circle" class="h-3 w-3 mr-1"></i> Rejected
                                    </span>
                                </div>
                            @else
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 inline-flex items-center">
                                        <i data-lucide="alert-circle" class="h-3 w-3 mr-1"></i> Pending
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <h2 class="text-2xl font-semibold text-gray-900">Navigation</h2>
                        <p class="mt-1 text-sm text-gray-500">Quick access to your main banking pages</p>
                    </div>

                    <div class="max-h-[60vh] space-y-2 overflow-y-auto pr-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="home" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('accounthistory') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('accounthistory') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('accounthistory') ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="activity" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Transactions</span>
                        </a>

                        <a href="{{ route('cards') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('cards*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('cards*') ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="credit-card" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Cards</span>
                        </a>

                        <div class="my-3 border-t border-gray-100"></div>

                        <a href="{{ route('localtransfer') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('localtransfer') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('localtransfer') ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="send" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Local Transfer</span>
                        </a>

                        <a href="{{ route('internationaltransfer') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('internationaltransfer') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('internationaltransfer') ? 'bg-cyan-100 text-cyan-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="globe" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">International Wire</span>
                        </a>

                        <a href="{{ route('deposits') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('deposits') ? 'bg-sky-50 text-sky-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('deposits') ? 'bg-sky-100 text-sky-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="download" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Deposit</span>
                        </a>

                        <a href="{{ route('loan') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('loan') ? 'bg-orange-50 text-orange-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('loan') ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="percent" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Loan Request</span>
                        </a>

                        <a href="{{ route('irs-refund') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('irs-refund*') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('irs-refund*') ? 'bg-rose-100 text-rose-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="file-text" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Tax Refund</span>
                        </a>

                        <div class="my-3 border-t border-gray-100"></div>

                        <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('profile') ? 'bg-slate-50 text-slate-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('profile') ? 'bg-slate-100 text-slate-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="settings" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Settings</span>
                        </a>

                        <a href="{{ route('support') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('support') ? 'bg-teal-50 text-teal-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('support') ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-500' }}">
                                <i data-lucide="message-circle" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Support</span>
                        </a>

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-grid').submit();"
                           class="flex items-center gap-3 rounded-2xl px-4 py-3 transition text-rose-600 hover:bg-rose-50">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                                <i data-lucide="log-out" class="h-5 w-5"></i>
                            </span>
                            <span class="flex-1 font-medium">Logout</span>
                        </a>

                        <form id="logout-form-grid" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Bar - iOS style -->
            <div class="fixed bottom-0 left-0 right-0 z-30 md:hidden">
                <div class="mx-2 mb-2 rounded-[28px] border border-white/70 bg-white/85 px-4 py-3 shadow-[0_10px_35px_rgba(15,23,42,0.12)] backdrop-blur-xl">
                    <div class="flex items-end justify-between gap-2">
                        <a href="{{ route('dashboard') }}" class="flex flex-1 flex-col items-center justify-center gap-1 text-center">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600' : 'text-slate-500' }}">
                                <i data-lucide="home" class="h-5 w-5"></i>
                            </span>
                            <span class="text-[11px] font-medium {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-slate-500' }}">Home</span>
                        </a>

                        <a href="{{ route('accounthistory') }}" class="flex flex-1 flex-col items-center justify-center gap-1 text-center">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl {{ request()->routeIs('accounthistory') ? 'bg-primary-50 text-primary-600' : 'text-slate-500' }}">
                                <i data-lucide="activity" class="h-5 w-5"></i>
                            </span>
                            <span class="text-[11px] font-medium {{ request()->routeIs('accounthistory') ? 'text-primary-600' : 'text-slate-500' }}">Activity</span>
                        </a>

                        <button type="button" @click="mobileMenuOpen = true" class="-mt-8 flex flex-1 flex-col items-center justify-center gap-1 text-center">
                            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-900 text-white shadow-lg ring-4 ring-white">
                                <i data-lucide="menu" class="h-6 w-6"></i>
                            </span>
                            <span class="text-[11px] font-medium text-slate-600">More</span>
                        </button>

                        <a href="{{ route('cards') }}" class="flex flex-1 flex-col items-center justify-center gap-1 text-center">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl {{ request()->routeIs('cards*') ? 'bg-primary-50 text-primary-600' : 'text-slate-500' }}">
                                <i data-lucide="credit-card" class="h-5 w-5"></i>
                            </span>
                            <span class="text-[11px] font-medium {{ request()->routeIs('cards*') ? 'text-primary-600' : 'text-slate-500' }}">Cards</span>
                        </a>

                        <a href="{{ route('profile') }}" class="flex flex-1 flex-col items-center justify-center gap-1 text-center">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl {{ request()->routeIs('profile') ? 'bg-primary-50 text-primary-600' : 'text-slate-500' }}">
                                <i data-lucide="user-round" class="h-5 w-5"></i>
                            </span>
                            <span class="text-[11px] font-medium {{ request()->routeIs('profile') ? 'text-primary-600' : 'text-slate-500' }}">Profile</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto pb-16 md:pb-0">
                <div class="py-6">
                    <div class="max-w-8xl mx-auto px-4 sm:px-6 md:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 hidden md:block">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 md:flex md:items-center md:justify-between">
                    <div class="flex items-center">
                        <img src="{{ $brandLogoUrl }}?v={{ $cacheBuster }}" alt="Logo" class="h-6 w-auto mr-2">
                        <p class="text-sm text-gray-500">© {{ date('Y') }} {{ $settings->site_name }}. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-700">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-700">Terms of Service</a>
                        <a href="{{ route('support') }}" class="text-sm text-gray-500 hover:text-gray-700">Contact Support</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Enhanced Page Loading Animation -->
    <script>
        window.onload = function() {
            const preloader = document.querySelector('.page-loading');

            // Add a slight delay to make loading animation more noticeable
            setTimeout(function() {
                preloader.classList.remove('active');
                setTimeout(function() {
                    preloader.remove();
                }, 500);
            }, 800);
        };
    </script>

    <!-- Date and Time Updates -->
    <script>
        // Function to update current time
        function updateDateTime() {
            const now = new Date();
            const timeElements = document.querySelectorAll('[data-current-time]');
            const dateElements = document.querySelectorAll('[data-current-date]');

            if (timeElements.length > 0) {
                const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                timeElements.forEach(el => {
                    el.textContent = timeString;
                });
            }

            if (dateElements.length > 0) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateString = now.toLocaleDateString(undefined, options);
                dateElements.forEach(el => {
                    el.textContent = dateString;
                });
            }
        }

        // Update time every minute
        updateDateTime();
        setInterval(updateDateTime, 60000);
    </script>

   


    @yield('scripts')
    @include('layouts.livechat')
    <!--@include('layouts.lang')-->


  
</body>
</html>

