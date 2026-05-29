@extends('layouts.dash2')
@section('title', $title)

@section('content')
@php
    $user = Auth::user();
    $currency = $settings->currency;
    $fullName = trim($user->name . ' ' . ($user->lastname ?? ''));
    $accountNumber = (string) ($user->usernumber ?? '');
    $maskedAccount = strlen($accountNumber) > 4 ? '**** ' . substr($accountNumber, -4) : $accountNumber;
    $kycLabel = $kycStatus ?: 'Pending';
    $kycKey = strtolower((string) $kycLabel);
    $accountState = strtolower((string) ($user->status ?? 'active'));
    $activeCards = $cards->where('status', 'active')->count();
    $pendingCards = $cards->where('status', 'pending')->count();

    $pillStyles = [
        'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'verified' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'under review' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'rejected' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'blocked' => 'bg-rose-50 text-rose-700 ring-rose-200',
    ];

    $activity = collect();

    foreach ($deposits as $deposit) {
        $activity->push([
            'label' => $deposit->payment_mode ?? 'Account deposit',
            'kind' => 'Deposit',
            'amount' => $deposit->amount,
            'status' => $deposit->status,
            'date' => $deposit->created_at,
            'ref' => $deposit->txn_id ?? ('DEP-' . $deposit->id),
            'inflow' => true,
        ]);
    }

    foreach ($withdrawals as $withdrawal) {
        $activity->push([
            'label' => $withdrawal->payment_mode ?? 'Account withdrawal',
            'kind' => 'Withdrawal',
            'amount' => $withdrawal->amount,
            'status' => $withdrawal->status,
            'date' => $withdrawal->created_at,
            'ref' => $withdrawal->txn_id ?? ('WDL-' . $withdrawal->id),
            'inflow' => false,
        ]);
    }

    $activity = $activity->sortByDesc('date')->take(5)->values();
@endphp

<div x-data="modernBankDashboard()" x-init="init()" class="mx-auto max-w-7xl space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <section class="space-y-2">
        <div class="flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-primary-600">
                    <span x-text="greeting"></span>, {{ $user->name }}
                </p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-950 sm:text-3xl">
                    Dashboard
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    A clear view of your balance, quick banking actions, and recent account activity.
                </p>
            </div>

        </div>

        <div class="grid grid-cols-1 gap-3 lg:-mt-2 lg:grid-cols-12">
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-5 xl:col-span-5">
                <div class="relative min-h-[200px] overflow-hidden rounded-2xl bg-[#27495a] p-5 text-white sm:min-h-[260px] lg:h-full">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_35%_30%,rgba(255,255,255,0.22),transparent_18%),radial-gradient(circle_at_53%_42%,rgba(255,255,255,0.14),transparent_10%),radial-gradient(circle_at_74%_8%,rgba(255,255,255,0.10),transparent_22%)]"></div>
                    <div class="absolute -right-7 top-0 text-[9rem] font-black leading-none text-white/10 sm:text-[12rem]">R</div>
                    <div class="absolute -right-2 top-16 text-[7rem] font-black leading-none text-white/10 sm:text-[10rem]">B</div>

                    <div class="relative flex h-full flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold text-white/85">Available Balance</p>
                                    <p class="mt-1 break-words text-3xl font-black tracking-tight sm:text-4xl xl:text-5xl" x-cloak>
                                        <span x-show="showBalance" x-transition>{{ $currency }}{{ number_format($user->account_bal, 2) }}</span>
                                        <span x-show="!showBalance" x-transition>••••••••</span>
                                    </p>
                                </div>
                                <button
                                    type="button"
                                    @click="toggleBalance()"
                                    class="flex h-11 w-11 flex-none items-center justify-center rounded-full bg-white/10 text-white ring-1 ring-white/15 transition hover:bg-white/20 sm:h-12 sm:w-12"
                                    :aria-label="showBalance ? 'Hide balance' : 'Show balance'"
                                    title="Show or hide balance"
                                >
                                    <i x-show="showBalance" data-lucide="eye" class="h-5 w-5"></i>
                                    <i x-show="!showBalance" data-lucide="eye-off" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="relative mt-8">
                            <div class="flex items-end justify-between gap-4">
                                <div>
                                    <p class="max-w-[170px] truncate text-sm font-semibold text-white/90">{{ $fullName }}</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <p class="text-base font-black tracking-wide">{{ $accountNumber }}</p>
                                        <button
                                            type="button"
                                            @click="copyAccountNumber(@js($accountNumber))"
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/10 text-white/90 transition hover:bg-white/20"
                                            aria-label="Copy account number"
                                            title="Copy account number"
                                        >
                                            <i data-lucide="copy" class="h-4 w-4"></i>
                                        </button>
                                        <span x-show="balanceCopyText" x-transition class="text-xs font-bold text-cyan-200" x-text="balanceCopyText"></span>
                                    </div>
                                </div>

                                <span class="max-w-[150px] rounded-lg bg-white px-3 py-1.5 text-right text-[11px] font-black leading-tight text-[#27495a] shadow-sm sm:max-w-none sm:text-sm">
                                    {{ $settings->site_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-4 text-center shadow-sm lg:order-4 lg:col-span-12">
                <p class="text-sm font-bold text-gray-700">Available for transfer is {{ $currency }}{{ number_format($user->account_bal, 2) }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5 lg:order-5 lg:col-span-12">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-gray-800">Quick Actions</h2>
                        <p class="mt-1 text-xs text-gray-500">Choose what you want to do next.</p>
                    </div>
                    <i data-lucide="zap" class="h-5 w-5 text-primary-600"></i>
                </div>

                <div class="grid grid-cols-3 gap-3 lg:grid-cols-9">
                    <a href="{{ route('quick-actions.service', 'airtime-data') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-primary-300 hover:bg-primary-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-primary-50 text-primary-700 group-hover:bg-white">
                            <i data-lucide="phone-call" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Mobile Top-Up</span>
                    </a>

                    <a href="{{ route('localtransfer') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-cyan-300 hover:bg-cyan-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-cyan-50 text-cyan-700 group-hover:bg-white">
                            <i data-lucide="send" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Make Transfer</span>
                    </a>

                    <a href="{{ route('quick-actions.service', 'bill-payments') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-emerald-300 hover:bg-emerald-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 group-hover:bg-white">
                            <i data-lucide="receipt" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Bill Payments</span>
                    </a>

                    <a href="{{ route('quick-actions.service', 'betting') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-violet-300 hover:bg-violet-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-violet-50 text-violet-700 group-hover:bg-white">
                            <i data-lucide="ticket" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Betting</span>
                    </a>

                    <a href="{{ route('quick-actions.service', 'ach-payment') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-50 text-slate-700 group-hover:bg-white">
                            <i data-lucide="building-2" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">ACH Payment</span>
                    </a>

                    <a href="{{ route('accounthistory') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-amber-300 hover:bg-amber-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-50 text-amber-700 group-hover:bg-white">
                            <i data-lucide="landmark" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Account Statement</span>
                    </a>

                    <a href="{{ route('beneficiaries.index') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-teal-300 hover:bg-teal-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-50 text-teal-700 group-hover:bg-white">
                            <i data-lucide="sparkles" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Manage Beneficiaries</span>
                    </a>

                    <a href="{{ route('quick-actions.service', 'electricity') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-rose-300 hover:bg-rose-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-50 text-rose-700 group-hover:bg-white">
                            <i data-lucide="zap" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Electricity</span>
                    </a>

                    <a href="{{ route('quick-actions.service', 'cable-streaming') }}" class="group flex min-h-[118px] flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-50 text-indigo-700 group-hover:bg-white">
                            <i data-lucide="tv" class="h-5 w-5"></i>
                        </span>
                        <span class="mt-3 block text-sm font-semibold leading-tight text-gray-700">Cable & Streaming</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:order-2 lg:col-span-3 lg:grid-cols-1 xl:col-span-3">
                <article class="rounded-lg border border-emerald-100 bg-emerald-50 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase text-emerald-700">Money in this month</p>
                        <i data-lucide="arrow-down-left" class="h-5 w-5 text-emerald-700"></i>
                    </div>
                    <p class="mt-4 text-2xl font-black text-emerald-950">{{ $currency }}{{ number_format($monthly_deposits, 2) }}</p>
                    <p class="mt-1 text-xs text-emerald-700">Processed inflow</p>
                </article>

                <article class="rounded-lg border border-rose-100 bg-rose-50 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase text-rose-700">Money out this month</p>
                        <i data-lucide="arrow-up-right" class="h-5 w-5 text-rose-700"></i>
                    </div>
                    <p class="mt-4 text-2xl font-black text-rose-950">{{ $currency }}{{ number_format($monthly_expenses, 2) }}</p>
                    <p class="mt-1 text-xs text-rose-700">Processed outflow</p>
                </article>
            </div>

            <article class="hidden rounded-lg border border-gray-200 bg-white p-5 shadow-sm lg:order-3 lg:col-span-4 lg:block xl:col-span-4">
                <div class="flex h-full min-h-[220px] flex-col justify-between rounded-lg bg-gray-950 p-5 text-white">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase text-gray-400">{{ $settings->site_name }}</p>
                            <p class="mt-2 text-sm text-gray-300">Primary checking</p>
                        </div>
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-cyan-400/15 text-cyan-200">
                            <i data-lucide="landmark" class="h-5 w-5"></i>
                        </span>
                    </div>

                    <div>
                        <p class="text-xl font-bold tracking-[0.18em]">{{ $maskedAccount }}</p>
                        <div class="mt-6 flex items-end justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs text-gray-400">Account holder</p>
                                <p class="mt-1 truncate text-sm font-bold">{{ $fullName }}</p>
                            </div>
                            <p class="text-right text-xs font-bold text-cyan-200" x-text="today"></p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Processed deposits</p>
                <i data-lucide="arrow-down-left" class="h-5 w-5 text-emerald-600"></i>
            </div>
            <p class="mt-4 text-2xl font-black text-gray-950">{{ $currency }}{{ number_format($total_deposited, 2) }}</p>
            <p class="mt-1 text-xs text-gray-500">Total approved funding</p>
        </article>

        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Pending deposits</p>
                <i data-lucide="clock-3" class="h-5 w-5 text-amber-600"></i>
            </div>
            <p class="mt-4 text-2xl font-black text-gray-950">{{ $currency }}{{ number_format($total_deposited_pending, 2) }}</p>
            <p class="mt-1 text-xs text-gray-500">Awaiting confirmation</p>
        </article>

        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Processed withdrawals</p>
                <i data-lucide="arrow-up-right" class="h-5 w-5 text-rose-600"></i>
            </div>
            <p class="mt-4 text-2xl font-black text-gray-950">{{ $currency }}{{ number_format($total_withdrawal, 2) }}</p>
            <p class="mt-1 text-xs text-gray-500">Completed payouts</p>
        </article>

        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-500">Card requests</p>
                <i data-lucide="badge-check" class="h-5 w-5 text-violet-600"></i>
            </div>
            <p class="mt-4 text-2xl font-black text-gray-950">{{ $cards->count() }}</p>
            <p class="mt-1 text-xs text-gray-500">{{ $pendingCards }} pending approval</p>
        </article>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-950">Recent activity</h2>
                    <p class="mt-1 text-sm text-gray-500">Latest deposits and withdrawals on this account.</p>
                </div>
                <a href="{{ route('accounthistory') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 px-3 py-2 text-sm font-bold text-gray-800 transition hover:bg-gray-50">
                    View history
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($activity as $item)
                    <div class="grid grid-cols-[44px_minmax(0,1fr)] gap-4 p-5 sm:grid-cols-[44px_minmax(0,1fr)_auto] sm:items-center">
                        <div class="flex h-11 w-11 items-center justify-center rounded-md {{ $item['inflow'] ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            <i data-lucide="{{ $item['inflow'] ? 'arrow-down-left' : 'arrow-up-right' }}" class="h-5 w-5"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="truncate text-sm font-bold text-gray-950">{{ $item['label'] }}</p>
                                <span class="rounded-md bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600">{{ $item['kind'] }}</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{{ $item['ref'] }} - {{ \Carbon\Carbon::parse($item['date'])->format('M d, Y') }}</p>
                        </div>

                        <div class="col-span-2 flex items-center justify-between sm:col-span-1 sm:block sm:text-right">
                            <p class="text-sm font-black {{ $item['inflow'] ? 'text-emerald-700' : 'text-gray-950' }}">
                                {{ $item['inflow'] ? '+' : '-' }}{{ $currency }}{{ number_format($item['amount'], 2) }}
                            </p>
                            <span class="mt-1 inline-flex rounded-md px-2 py-0.5 text-xs font-bold {{ strtolower((string) $item['status']) === 'processed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $item['status'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-md bg-gray-100 text-gray-500">
                            <i data-lucide="inbox" class="h-6 w-6"></i>
                        </div>
                        <p class="mt-3 text-sm font-bold text-gray-950">No recent activity</p>
                        <p class="mt-1 text-sm text-gray-500">Transactions will appear here when you start using your account.</p>
                    </div>
                @endforelse
            </div>
        </article>

        <aside class="space-y-4">
            <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-gray-950">Security status</h2>
                    <i data-lucide="{{ $kycStatusIcon }}" class="h-5 w-5 text-primary-600"></i>
                </div>
                <p class="mt-2 text-sm leading-6 text-gray-500">Complete verification to keep your profile current and reduce account restrictions.</p>
                <div class="mt-5">
                    <div class="mb-2 flex items-center justify-between text-xs font-bold text-gray-500">
                        <span>Verification</span>
                        <span>{{ $kycLabel }}</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full rounded-full {{ $kycKey === 'verified' ? 'w-full bg-emerald-500' : ($kycKey === 'under review' ? 'w-2/3 bg-amber-500' : 'w-1/3 bg-gray-400') }}"></div>
                    </div>
                </div>
                <a href="{{ route('account.verify') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-md bg-gray-950 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-gray-800">
                    Manage verification
                </a>
            </article>

            <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-bold text-gray-950">Need assistance?</h2>
                <p class="mt-2 text-sm leading-6 text-gray-500">Get help with transfers, cards, deposits, or account review.</p>
                <a href="{{ route('support') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-md border border-gray-300 px-4 py-2.5 text-sm font-bold text-gray-800 transition hover:bg-gray-50">
                    Contact support
                </a>
            </article>
        </aside>
    </section>
</div>

<script>
    function modernBankDashboard() {
        return {
            greeting: '',
            today: '',
            showBalance: true,
            balanceCopyText: '',
            init() {
                const now = new Date();
                const hour = now.getHours();
                this.greeting = hour < 12 ? 'Good morning' : (hour < 18 ? 'Good afternoon' : 'Good evening');
                this.today = now.toLocaleDateString([], {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            },
            toggleBalance() {
                this.showBalance = !this.showBalance;
                if (window.lucide && typeof lucide.createIcons === 'function') {
                    this.$nextTick(() => lucide.createIcons());
                }
            },
            async copyAccountNumber(value) {
                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(value);
                    } else {
                        const input = document.createElement('input');
                        input.value = value;
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        input.remove();
                    }

                    this.balanceCopyText = 'Copied';
                    setTimeout(() => {
                        this.balanceCopyText = '';
                    }, 1600);
                } catch (error) {
                    console.error('Unable to copy account number', error);
                }
            }
        };
    }
</script>
@endsection
