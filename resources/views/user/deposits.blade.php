@extends('layouts.dash2')
@section('title', $title)

@section('content')
<div x-data="{ methodId: '', amount: '' }" class="space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Account Funding</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">Deposit Funds</h1>
                <p class="mt-2 text-sm text-slate-600">Available deposit channels are bank transfer and crypto (Bitcoin, Ethereum, USDT).</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-xs font-medium uppercase tracking-[0.14em] text-slate-500">Total Deposited</p>
                <p class="mt-1 text-xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format($deposited, 2) }}</p>
            </div>
        </div>
    </section>

    <form action="{{ route('newdeposit') }}" method="POST" class="space-y-6">
        @csrf

        <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">1. Select Method</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                @forelse($dmethods as $method)
                    @php
                        $methodType = strtolower((string) $method->methodtype);
                        $name = strtolower((string) $method->name);
                        $isBank = $methodType === 'currency';
                        $isBtc = \Illuminate\Support\Str::contains($name, ['bitcoin', 'btc']);
                        $isEth = \Illuminate\Support\Str::contains($name, ['ethereum', 'eth']);
                        $isUsdt = \Illuminate\Support\Str::contains($name, ['usdt', 'tether']);
                    @endphp
                    <label class="cursor-pointer rounded-2xl border p-4 transition"
                        :class="methodId === '{{ $method->id }}' ? 'border-blue-500 bg-blue-50 shadow-sm' : 'border-slate-200 hover:border-slate-300'">
                        <input type="radio" class="hidden" name="payment_method_id" value="{{ $method->id }}" x-model="methodId" required>
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl
                                    @if($isBank) bg-blue-100 text-blue-600 @elseif($isBtc) bg-amber-100 text-amber-700 @elseif($isEth) bg-indigo-100 text-indigo-700 @elseif($isUsdt) bg-emerald-100 text-emerald-700 @else bg-slate-100 text-slate-700 @endif">
                                    @if($isBank)
                                        <i data-lucide="building-2" class="h-5 w-5"></i>
                                    @elseif($isBtc)
                                        <i data-lucide="bitcoin" class="h-5 w-5"></i>
                                    @elseif($isEth)
                                        <i data-lucide="coins" class="h-5 w-5"></i>
                                    @elseif($isUsdt)
                                        <i data-lucide="wallet" class="h-5 w-5"></i>
                                    @else
                                        <i data-lucide="landmark" class="h-5 w-5"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $method->name }}</p>
                                    <p class="text-xs text-slate-500">
                                        Min {{ $settings->currency }}{{ number_format((float) $method->minimum, 2) }}
                                        @if(!empty($method->maximum))
                                            | Max {{ $settings->currency }}{{ number_format((float) $method->maximum, 2) }}
                                        @endif
                                    </p>
                                    @if($methodType === 'crypto' && !empty($method->network))
                                        <p class="mt-1 text-xs font-medium text-slate-600">Network: {{ $method->network }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="mt-1 inline-flex h-5 w-5 items-center justify-center rounded-full border text-[10px]"
                                :class="methodId === '{{ $method->id }}' ? 'border-blue-500 bg-blue-500 text-white' : 'border-slate-300 text-transparent'">
                                <i data-lucide="check" class="h-3 w-3"></i>
                            </span>
                        </div>
                    </label>
                @empty
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        No approved deposit methods are enabled. Contact admin.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">2. Enter Amount</h2>
            <div class="mt-4 max-w-xl">
                <label for="amount" class="text-sm font-medium text-slate-700">Amount</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-500">{{ $settings->currency }}</span>
                    <input id="amount" name="amount" type="number" min="1" step="0.01" required x-model="amount"
                        class="w-full rounded-2xl border border-slate-300 py-4 pl-12 pr-4 text-lg font-semibold text-slate-900 outline-none ring-blue-500 transition focus:border-blue-500 focus:ring-2"
                        placeholder="0.00">
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" @click="amount = '100'" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">100</button>
                    <button type="button" @click="amount = '500'" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">500</button>
                    <button type="button" @click="amount = '1000'" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">1000</button>
                    <button type="button" @click="amount = '5000'" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">5000</button>
                </div>
            </div>
            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="!methodId || !amount">
                    Continue
                </button>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Back to dashboard
                </a>
            </div>
        </section>
    </form>

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-900">Recent Deposits</h2>
            <span class="text-xs text-slate-500">{{ $deposits->count() }} records</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[620px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-xs uppercase tracking-[0.12em] text-slate-500">
                        <th class="pb-3">Reference</th>
                        <th class="pb-3">Method</th>
                        <th class="pb-3">Amount</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Date</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    @forelse($deposits->take(8) as $deposit)
                        <tr class="border-b border-slate-100 last:border-0">
                            <td class="py-3 font-medium">{{ $deposit->txn_id ?? ('DEP-' . $deposit->id) }}</td>
                            <td class="py-3">{{ $deposit->payment_mode }}</td>
                            <td class="py-3">{{ $settings->currency }}{{ number_format($deposit->amount, 2) }}</td>
                            <td class="py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $deposit->status === 'Processed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $deposit->status }}
                                </span>
                            </td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-sm text-slate-500">No deposits found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
