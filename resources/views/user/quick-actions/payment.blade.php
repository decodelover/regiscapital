@extends('layouts.dash2')
@section('title', $title)

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-950">{{ $service['title'] }}</h1>
            <div class="mt-1 flex items-center text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
                <i data-lucide="chevron-right" class="mx-2 h-4 w-4"></i>
                <span class="font-medium text-gray-700">{{ $service['title'] }}</span>
            </div>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm">
            <p class="text-xs font-semibold text-gray-500">Available balance</p>
            <p class="text-lg font-bold text-gray-950">{{ $settings->currency }}{{ number_format(Auth::user()->account_bal, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="bg-gray-950 px-6 py-7 text-white">
                <div class="flex items-center gap-4">
                    <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 text-cyan-100">
                        <i data-lucide="{{ $service['icon'] }}" class="h-7 w-7"></i>
                    </span>
                    <div>
                        <h2 class="text-xl font-bold">{{ $service['title'] }}</h2>
                        <p class="mt-1 text-sm text-gray-300">Pay securely from your account balance.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('quick-actions.pay', $serviceKey) }}" method="post" class="space-y-5 p-6">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Provider</label>
                    <select name="provider" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        <option value="">Select provider</option>
                        @foreach($service['providers'] as $provider)
                            <option value="{{ $provider }}" {{ old('provider') === $provider ? 'selected' : '' }}>{{ $provider }}</option>
                        @endforeach
                    </select>
                    @error('provider')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">{{ $service['reference_label'] }}</label>
                    <input type="text" name="customer_reference" value="{{ old('customer_reference') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    @error('customer_reference')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Package</label>
                    <select name="package" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Select package</option>
                        @foreach($service['packages'] as $package)
                            <option value="{{ $package }}" {{ old('package') === $package ? 'selected' : '' }}>{{ $package }}</option>
                        @endforeach
                    </select>
                    @error('package')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Amount</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm font-bold text-gray-500">{{ $settings->currency }}</span>
                        <input type="number" name="amount" value="{{ old('amount') }}" min="1" step="0.01" max="{{ Auth::user()->account_bal }}" class="block w-full rounded-lg border border-gray-200 py-3 pl-10 pr-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    </div>
                    @error('amount')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Description</label>
                    <textarea name="description" rows="3" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-gray-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-gray-800">
                    <i data-lucide="check-circle" class="mr-2 h-5 w-5"></i>
                    Pay now
                </button>
            </form>
        </section>

        <aside class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-base font-bold text-gray-950">Recent {{ strtolower($service['title']) }}</h2>
            <div class="mt-4 divide-y divide-gray-100">
                @forelse($payments as $payment)
                    <div class="py-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-gray-950">{{ $payment->provider }}</p>
                                <p class="mt-1 truncate text-xs text-gray-500">{{ $payment->reference }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-950">{{ $settings->currency }}{{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <p class="mt-1 text-xs text-emerald-700">{{ $payment->status }} - {{ $payment->created_at->format('M d, Y') }}</p>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-gray-500">No payments yet.</p>
                @endforelse
            </div>
        </aside>
    </div>
</div>
@endsection
