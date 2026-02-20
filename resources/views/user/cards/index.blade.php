@extends('layouts.dash2')
@section('title', 'Cards')

@section('content')
<div class="space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Virtual Cards</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">Manage Your Cards</h1>
                <p class="mt-2 text-sm text-slate-600">Request cards, track approval status, and control card activity.</p>
            </div>
            <a href="{{ route('cards.apply') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                Request Card
            </a>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Active Cards</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $activeCards }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Pending Review</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $pendingCards }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Card Balance</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format($totalBalance, 2) }}</p>
        </article>
    </section>

    <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-900">Your Card Requests</h2>
            <span class="text-xs text-slate-500">{{ $cards->count() }} total</span>
        </div>

        @if($cards->count() > 0)
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @foreach($cards as $card)
                    @php
                        $statusClass = 'bg-slate-100 text-slate-700';
                        if ($card->status === 'active') {
                            $statusClass = 'bg-emerald-100 text-emerald-700';
                        } elseif ($card->status === 'pending') {
                            $statusClass = 'bg-amber-100 text-amber-700';
                        } elseif ($card->status === 'blocked' || $card->status === 'rejected') {
                            $statusClass = 'bg-rose-100 text-rose-700';
                        }
                    @endphp
                    <article class="overflow-hidden rounded-2xl border border-slate-200">
                        <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-4 text-white">
                            <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <p class="text-sm font-semibold">{{ $settings->site_name }}</p>
                                <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-[11px] font-medium">{{ strtoupper($card->currency) }}</span>
                            </div>
                            <p class="relative z-10 mt-7 font-mono text-lg tracking-[0.2em]">&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; {{ $card->last_four ?: '----' }}</p>
                            <div class="relative z-10 mt-5 flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.16em] text-slate-200">Card Holder</p>
                                    <p class="mt-1 text-sm font-medium">{{ $card->card_holder_name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] uppercase tracking-[0.16em] text-slate-200">Status</p>
                                    <p class="mt-1 text-sm font-medium">{{ ucfirst($card->status) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                {{ ucfirst($card->status) }}
                            </span>
                            <a href="{{ route('cards.view', $card) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                                View Details
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <p class="text-sm text-slate-600">No card requests yet.</p>
                <a href="{{ route('cards.apply') }}" class="mt-3 inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Request your first card
                </a>
            </div>
        @endif
    </section>
</div>
@endsection
