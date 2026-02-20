@extends('layouts.dash2')
@section('title', $title)

@section('content')
<div x-data="dashboardState()" x-init="init()">
    <x-danger-alert />
    <x-success-alert />

    <section class="relative overflow-hidden rounded-[28px] border border-white/40 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-6 text-white shadow-2xl shadow-slate-900/20 md:p-8">
        <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-cyan-300/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-20 h-56 w-56 rounded-full bg-blue-300/20 blur-3xl"></div>
        <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-100" x-text="greeting"></p>
                <h1 class="mt-2 text-2xl font-semibold md:text-3xl">Welcome back, {{ Auth::user()->name }}</h1>
                <p class="mt-2 text-sm text-slate-200">Manage your balances, transfers, and activity from one secure workspace.</p>
                <div class="mt-6 flex items-center gap-3">
                    <span class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-3 py-1 text-xs font-medium">
                        <span class="mr-2 h-2 w-2 rounded-full {{ Auth::user()->account_status === 'active' ? 'bg-emerald-300' : 'bg-rose-300' }}"></span>
                        {{ ucfirst((string) Auth::user()->account_status) }}
                    </span>
                    <span class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-3 py-1 text-xs font-medium">
                        KYC: {{ $kycStatus }}
                    </span>
                </div>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 text-right backdrop-blur-xl">
                <p class="text-xs font-medium uppercase tracking-[0.18em] text-slate-200">Available Balance</p>
                <p class="mt-2 text-3xl font-semibold">{{ $settings->currency }}{{ number_format(Auth::user()->account_bal, 2) }}</p>
                <p class="mt-2 text-xs text-slate-200"><span x-text="currentDate"></span> <span class="mx-1">|</span> <span x-text="currentTime"></span></p>
            </div>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
        <a href="{{ route('deposits') }}" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <i data-lucide="arrow-down-left" class="h-5 w-5"></i>
            </div>
            <p class="mt-3 text-sm font-semibold text-slate-900">Deposit</p>
            <p class="text-xs text-slate-500">Fund account</p>
        </a>
        <a href="{{ route('localtransfer') }}" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <i data-lucide="send" class="h-5 w-5"></i>
            </div>
            <p class="mt-3 text-sm font-semibold text-slate-900">Transfer</p>
            <p class="text-xs text-slate-500">Local or wire</p>
        </a>
        <a href="{{ route('cards') }}" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                <i data-lucide="credit-card" class="h-5 w-5"></i>
            </div>
            <p class="mt-3 text-sm font-semibold text-slate-900">Cards</p>
            <p class="text-xs text-slate-500">{{ $cards->where('status', 'active')->count() }} active</p>
        </a>
        <a href="{{ route('accounthistory') }}" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <i data-lucide="activity" class="h-5 w-5"></i>
            </div>
            <p class="mt-3 text-sm font-semibold text-slate-900">Activity</p>
            <p class="text-xs text-slate-500">Recent transactions</p>
        </a>
    </section>

    <section class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Processed Deposits</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format($total_deposited, 2) }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Pending Deposits</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format($total_deposited_pending, 2) }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Processed Withdrawals</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format($total_withdrawal, 2) }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Pending Withdrawals</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format($total_withdrawal_pending, 2) }}</p>
        </article>
    </section>

    <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Recent Deposits</h2>
                <a href="{{ route('deposits') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-left">
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
                        @forelse($deposits as $deposit)
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
                                <td colspan="5" class="py-6 text-center text-sm text-slate-500">No deposits yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <aside class="space-y-6">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-base font-semibold text-slate-900">Verification Status</h3>
                <p class="mt-2 text-sm text-slate-600">Current KYC state for account access and transfer limits.</p>
                <div class="mt-4 rounded-xl border px-3 py-2 text-sm font-medium
                    @if($kycStatus === 'Verified') border-emerald-200 bg-emerald-50 text-emerald-700
                    @elseif($kycStatus === 'Under review') border-amber-200 bg-amber-50 text-amber-700
                    @elseif($kycStatus === 'Rejected') border-rose-200 bg-rose-50 text-rose-700
                    @else border-slate-200 bg-slate-50 text-slate-700 @endif">
                    {{ $kycStatus }}
                </div>
                <a href="{{ route('account.verify') }}" class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                    Manage verification
                    <i data-lucide="arrow-right" class="ml-1 h-4 w-4"></i>
                </a>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-base font-semibold text-slate-900">Virtual Cards</h3>
                <p class="mt-2 text-sm text-slate-600">Submit requests and track admin approval.</p>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-xs text-slate-500">Total</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $cards->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-xs text-slate-500">Pending</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $cards->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
                <a href="{{ route('cards') }}" class="mt-4 inline-flex items-center rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
                    Open cards
                </a>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-base font-semibold text-slate-900">Need Help</h3>
                <p class="mt-2 text-sm text-slate-600">Support is available for account, transfer, and card issues.</p>
                <a href="{{ route('support') }}" class="mt-4 inline-flex items-center rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Contact support
                </a>
            </article>
        </aside>
    </section>
</div>

<script>
    function dashboardState() {
        return {
            currentDate: '',
            currentTime: '',
            greeting: '',
            init() {
                this.tick();
                setInterval(() => this.tick(), 1000);
            },
            tick() {
                const now = new Date();
                const h = now.getHours();
                this.greeting = h < 12 ? 'Good morning' : (h < 18 ? 'Good afternoon' : 'Good evening');
                this.currentTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                this.currentDate = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            }
        };
    }
</script>
@endsection
