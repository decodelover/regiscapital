@extends('layouts.dash2')
@section('title', $title)

@section('content')
<div class="space-y-6">
    <x-danger-alert />
    <x-success-alert />
    <x-error-alert />

    @if($title === 'Complete Payment')
        <section class="mx-auto max-w-2xl rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Crypto Checkout</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900">Complete Payment</h1>
                <p class="mt-2 text-sm text-slate-600">Scan the QR code and send the exact amount shown below.</p>
            </div>

            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex flex-col items-center gap-4">
                    <img src="{{ $p_qrcode }}" alt="Payment QR code" class="h-56 w-56 rounded-xl border border-slate-200 bg-white p-2">
                    <div class="w-full">
                        <label class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">{{ $coin }} Address</label>
                        <div class="mt-1 flex">
                            <input type="text" readonly value="{{ $p_address }}" class="w-full rounded-l-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                            <button type="button" class="rounded-r-xl border border-l-0 border-slate-300 px-3 text-slate-600 hover:bg-slate-100" onclick="copyValue('{{ $p_address }}', this)">
                                Copy
                            </button>
                        </div>
                    </div>
                    <div class="w-full">
                        <label class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Amount</label>
                        <div class="mt-1 flex">
                            <input type="text" readonly value="{{ $amount }} {{ $coin }}" class="w-full rounded-l-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                            <button type="button" class="rounded-r-xl border border-l-0 border-slate-300 px-3 text-slate-600 hover:bg-slate-100" onclick="copyValue('{{ $amount }} {{ $coin }}', this)">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Deposit Confirmation</p>
                    <h1 class="mt-1 text-2xl font-semibold text-slate-900">{{ $payment_mode->name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Send funds using the details below, then upload proof for admin review.</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-right">
                    <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Deposit Amount</p>
                    <p class="text-xl font-semibold text-slate-900">{{ $settings->currency }}{{ number_format((float) $amount, 2) }}</p>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <article class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                <h2 class="text-base font-semibold text-slate-900">Payment Details</h2>

                @if(strtolower((string) $payment_mode->methodtype) === 'crypto')
                    <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Currency</p>
                                <p class="mt-1 text-sm font-medium text-slate-800">{{ $payment_mode->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Network</p>
                                <p class="mt-1 text-sm font-medium text-slate-800">{{ $payment_mode->network ?: 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Wallet Address</p>
                                <div class="mt-2 flex">
                                    <input type="text" readonly value="{{ $payment_mode->wallet_address }}" class="w-full rounded-l-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                                    <button type="button" class="rounded-r-xl border border-l-0 border-slate-300 px-3 text-slate-600 hover:bg-slate-100" onclick="copyValue('{{ $payment_mode->wallet_address }}', this)">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode((string) $payment_mode->wallet_address) }}" alt="Wallet QR" class="rounded-xl border border-slate-200 bg-white p-2">
                        </div>
                    </div>
                @else
                    <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @if(!empty($payment_mode->bankname))
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Bank Name</p>
                                    <p class="mt-1 text-sm font-medium text-slate-800">{{ $payment_mode->bankname }}</p>
                                </div>
                            @endif
                            @if(!empty($payment_mode->account_name))
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Account Name</p>
                                    <p class="mt-1 text-sm font-medium text-slate-800">{{ $payment_mode->account_name }}</p>
                                </div>
                            @endif
                            @if(!empty($payment_mode->account_number))
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Account Number</p>
                                    <div class="mt-1 flex">
                                        <input type="text" readonly value="{{ $payment_mode->account_number }}" class="w-full rounded-l-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                                        <button type="button" class="rounded-r-xl border border-l-0 border-slate-300 px-3 text-slate-600 hover:bg-slate-100" onclick="copyValue('{{ $payment_mode->account_number }}', this)">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($payment_mode->swift_code))
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Swift / Routing</p>
                                    <div class="mt-1 flex">
                                        <input type="text" readonly value="{{ $payment_mode->swift_code }}" class="w-full rounded-l-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                                        <button type="button" class="rounded-r-xl border border-l-0 border-slate-300 px-3 text-slate-600 hover:bg-slate-100" onclick="copyValue('{{ $payment_mode->swift_code }}', this)">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </article>

            <article class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-900">Upload Proof</h2>
                <p class="mt-2 text-sm text-slate-600">Accepted formats: JPG, PNG, or PDF (max 5 MB).</p>

                <form action="{{ route('savedeposit') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="paymethd_method_id" value="{{ $payment_mode->id }}">

                    <label class="block">
                        <span class="sr-only">Upload proof</span>
                        <input type="file" name="proof" required accept="image/*,.pdf"
                            class="block w-full cursor-pointer rounded-2xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-700 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
                    </label>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Submit Deposit
                    </button>
                </form>

                <p class="mt-3 text-xs text-slate-500">Deposits are reviewed by admin before balance credit.</p>
            </article>
        </section>
    @endif
</div>

<script>
    function copyValue(value, button) {
        navigator.clipboard.writeText(value).then(function () {
            const original = button.innerText;
            button.innerText = 'Copied';
            setTimeout(function () {
                button.innerText = original;
            }, 1200);
        });
    }
</script>
@endsection
