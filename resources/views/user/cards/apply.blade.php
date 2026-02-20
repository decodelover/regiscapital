@extends('layouts.dash2')
@section('title', 'Apply for Virtual Card')

@section('content')
<div class="space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Card Request</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">Apply for a Virtual Card</h1>
                <p class="mt-2 text-sm text-slate-600">All requests are reviewed by admin before approval.</p>
            </div>
            <a href="{{ route('cards') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Back to cards
            </a>
        </div>
    </section>

    <form action="{{ route('cards.apply.post') }}" method="POST" class="space-y-6">
        @csrf

        <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">Card Profile</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Card Type</label>
                    <select name="card_type" class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="visa" {{ old('card_type') === 'visa' ? 'selected' : '' }}>Visa</option>
                        <option value="mastercard" {{ old('card_type') === 'mastercard' ? 'selected' : '' }}>Mastercard</option>
                        <option value="american_express" {{ old('card_type') === 'american_express' ? 'selected' : '' }}>American Express</option>
                        <option value="discover" {{ old('card_type') === 'discover' ? 'selected' : '' }}>Discover</option>
                    </select>
                    @error('card_type')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Card Level</label>
                    <select name="card_level" class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select level</option>
                        <option value="standard" {{ old('card_level') === 'standard' ? 'selected' : '' }}>Standard - ${{ number_format($issuanceFees['standard'], 2) }}</option>
                        <option value="gold" {{ old('card_level') === 'gold' ? 'selected' : '' }}>Gold - ${{ number_format($issuanceFees['gold'], 2) }}</option>
                        <option value="platinum" {{ old('card_level') === 'platinum' ? 'selected' : '' }}>Platinum - ${{ number_format($issuanceFees['platinum'], 2) }}</option>
                        <option value="black" {{ old('card_level') === 'black' ? 'selected' : '' }}>Black - ${{ number_format($issuanceFees['black'], 2) }}</option>
                    </select>
                    @error('card_level')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Currency</label>
                    <select name="currency" class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP</option>
                    </select>
                    @error('currency')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Daily Limit</label>
                    <input type="number" name="daily_limit" min="{{ $minLimit }}" max="{{ $maxLimit }}" value="{{ old('daily_limit', $minLimit) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <p class="mt-1 text-xs text-slate-500">Allowed range: {{ number_format($minLimit, 2) }} - {{ number_format($maxLimit, 2) }}</p>
                    @error('daily_limit')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">Identity Details</h2>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-700">Card Holder Name</label>
                    <input type="text" name="card_holder_name" value="{{ old('card_holder_name', trim(Auth::user()->name . ' ' . (Auth::user()->lastname ?? ''))) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('card_holder_name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Billing Address</label>
                    <textarea name="billing_address" rows="3" required
                        class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('billing_address') }}</textarea>
                    @error('billing_address')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                <p class="font-semibold">Issuance Fee</p>
                <p class="mt-1">The card issuance fee is charged immediately and refunded automatically if admin rejects your request.</p>
            </div>
            <label class="mt-4 flex items-start gap-3">
                <input type="checkbox" name="terms_accepted" value="1" class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500" required>
                <span class="text-sm text-slate-700">I confirm the request details are valid and agree to card terms and account compliance checks.</span>
            </label>
            @error('terms_accepted')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

            <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Submit Card Request
                </button>
                <a href="{{ route('cards') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </section>
    </form>
</div>
@endsection
