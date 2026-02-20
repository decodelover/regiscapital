@extends('layouts.dash2')
@section('title', 'Card Details')

@section('content')
<div x-data="{ showSensitive: false }" class="space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Card Details</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $card->card_type)) }} {{ ucfirst($card->card_level) }}</h1>
                <p class="mt-2 text-sm text-slate-600">Reference: {{ $card->reference_id ?: ('CARD-' . $card->id) }}</p>
            </div>
            <a href="{{ route('cards') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Back to cards
            </a>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <article class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-6 text-white">
                <div class="absolute -right-14 -top-14 h-36 w-36 rounded-full bg-white/10 blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold">{{ $settings->site_name }}</p>
                        <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-[11px] font-medium">{{ strtoupper($card->currency) }}</span>
                    </div>
                    <p class="mt-8 font-mono text-xl tracking-[0.2em]">
                        <template x-if="showSensitive && '{{ $card->status }}' === 'active' && '{{ $card->card_number }}' !== ''">
                            <span>{{ trim(chunk_split((string) $card->card_number, 4, ' ')) }}</span>
                        </template>
                        <template x-if="!showSensitive || '{{ $card->status }}' !== 'active' || '{{ $card->card_number }}' === ''">
                            <span>&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; {{ $card->last_four ?: '----' }}</span>
                        </template>
                    </p>
                    <div class="mt-6 flex items-end justify-between">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.15em] text-slate-200">Card Holder</p>
                            <p class="mt-1 text-sm font-medium">{{ $card->card_holder_name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-[0.15em] text-slate-200">Valid Thru</p>
                            <p class="mt-1 text-sm font-medium">
                                @if($card->expiry_month && $card->expiry_year)
                                    {{ sprintf('%02d', (int) $card->expiry_month) }}/{{ substr((string) $card->expiry_year, -2) }}
                                @else
                                    --/--
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Status</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ ucfirst($card->status) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Balance</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $settings->currency }}{{ number_format((float) $card->balance, 2) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Daily Limit</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $settings->currency }}{{ number_format((float) ($card->daily_limit ?? 0), 2) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Monthly Limit</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $settings->currency }}{{ number_format((float) ($card->monthly_limit ?? 0), 2) }}</p>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                @if($card->status === 'active')
                    <form action="{{ route('cards.deactivate', $card) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 hover:bg-amber-100">
                            Deactivate
                        </button>
                    </form>
                @elseif($card->status === 'inactive')
                    <form action="{{ route('cards.activate', $card) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">
                            Activate
                        </button>
                    </form>
                @endif

                @if(in_array($card->status, ['active', 'inactive'], true))
                    <form action="{{ route('cards.block', $card) }}" method="POST" onsubmit="return confirm('Block this card?');">
                        @csrf
                        <button type="submit" class="rounded-xl border border-rose-300 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">
                            Block Card
                        </button>
                    </form>
                @endif

                @if($card->status === 'active')
                    <button type="button" @click="showSensitive = !showSensitive"
                        class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        <span x-text="showSensitive ? 'Hide Sensitive Details' : 'Show Sensitive Details'"></span>
                    </button>
                @endif

                <a href="{{ route('cards.transactions', $card) }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    View Transactions
                </a>
            </div>
        </article>

        <aside class="space-y-6">
            <article class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-slate-900">Application Timeline</h3>
                <div class="mt-4 space-y-3 text-sm text-slate-700">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Submitted</p>
                        <p class="mt-1 font-medium">{{ \Carbon\Carbon::parse($card->application_date ?: $card->created_at)->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Reviewed</p>
                        <p class="mt-1 font-medium">
                            @if($card->approval_date)
                                {{ \Carbon\Carbon::parse($card->approval_date)->format('M d, Y h:i A') }}
                            @else
                                Pending review
                            @endif
                        </p>
                    </div>
                    @if(!empty($card->rejection_reason))
                        <div class="rounded-xl border border-rose-200 bg-rose-50 p-3 text-rose-800">
                            <p class="text-xs uppercase tracking-[0.12em]">Rejection Reason</p>
                            <p class="mt-1 text-sm">{{ $card->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </article>

            <article class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-slate-900">Billing Address</h3>
                <p class="mt-3 whitespace-pre-line text-sm text-slate-700">{{ $card->billing_address ?: 'N/A' }}</p>
            </article>
        </aside>
    </section>

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-900">Latest Transactions</h2>
            <a href="{{ route('cards.transactions', $card) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[620px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-xs uppercase tracking-[0.12em] text-slate-500">
                        <th class="pb-3">Reference</th>
                        <th class="pb-3">Type</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Amount</th>
                        <th class="pb-3">Date</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    @forelse($transactions as $transaction)
                        <tr class="border-b border-slate-100 last:border-0">
                            <td class="py-3 font-medium">{{ $transaction->transaction_reference }}</td>
                            <td class="py-3">{{ ucfirst($transaction->transaction_type) }}</td>
                            <td class="py-3">{{ ucfirst($transaction->status) }}</td>
                            <td class="py-3">{{ strtoupper($transaction->currency) }} {{ number_format((float) $transaction->amount, 2) }}</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($transaction->transaction_date ?: $transaction->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-sm text-slate-500">No transactions for this card yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
