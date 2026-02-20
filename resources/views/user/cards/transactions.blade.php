@extends('layouts.dash2')
@section('title', 'Card Transactions')

@section('content')
<div class="space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Card Ledger</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">Transactions</h1>
                <p class="mt-2 text-sm text-slate-600">Card ending in {{ $card->last_four ?: '----' }}</p>
            </div>
            <a href="{{ route('cards.view', $card) }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Back to card
            </a>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Total Spend</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ strtoupper($card->currency) }} {{ number_format((float) $totalSpending, 2) }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Transactions</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $transactions->total() }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Last Activity</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">
                @if($lastActivity)
                    {{ \Carbon\Carbon::parse($lastActivity->transaction_date ?: $lastActivity->created_at)->format('M d') }}
                @else
                    --
                @endif
            </p>
        </article>
    </section>

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-slate-900">Filter</h2>
        <form action="{{ route('cards.transactions', $card) }}" method="GET" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-5">
            <select name="type" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-700">
                <option value="">All types</option>
                <option value="purchase" {{ request('type') === 'purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="fee" {{ request('type') === 'fee' ? 'selected' : '' }}>Fee</option>
                <option value="topup" {{ request('type') === 'topup' ? 'selected' : '' }}>Top-up</option>
                <option value="deduction" {{ request('type') === 'deduction' ? 'selected' : '' }}>Deduction</option>
                <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>Refund</option>
            </select>
            <select name="status" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-700">
                <option value="">All status</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
            </select>
            <input type="date" name="date_start" value="{{ request('date_start') }}" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-700">
            <input type="date" name="date_end" value="{{ request('date_end') }}" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-700">
            <div class="flex gap-2">
                <button type="submit" class="w-full rounded-xl bg-slate-900 px-3 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Apply</button>
                <a href="{{ route('cards.transactions', $card) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
            </div>
        </form>
    </section>

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-slate-900">Transaction History</h2>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[820px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-xs uppercase tracking-[0.12em] text-slate-500">
                        <th class="pb-3">Date</th>
                        <th class="pb-3">Reference</th>
                        <th class="pb-3">Merchant</th>
                        <th class="pb-3">Type</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Amount</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    @forelse($transactions as $tx)
                        <tr class="border-b border-slate-100 last:border-0">
                            <td class="py-3">{{ \Carbon\Carbon::parse($tx->transaction_date ?: $tx->created_at)->format('M d, Y h:i A') }}</td>
                            <td class="py-3 font-medium">{{ $tx->transaction_reference }}</td>
                            <td class="py-3">{{ $tx->merchant_name ?: 'N/A' }}</td>
                            <td class="py-3">{{ ucfirst($tx->transaction_type) }}</td>
                            <td class="py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium
                                    @if($tx->status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif($tx->status === 'pending') bg-amber-100 text-amber-700
                                    @else bg-rose-100 text-rose-700 @endif">
                                    {{ ucfirst($tx->status) }}
                                </span>
                            </td>
                            <td class="py-3 font-medium">{{ strtoupper($tx->currency) }} {{ number_format((float) $tx->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-sm text-slate-500">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
    </section>
</div>
@endsection
