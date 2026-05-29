@extends('layouts.dash2')
@section('title', $title)

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <x-danger-alert />
    <x-success-alert />

    <div>
        <h1 class="text-2xl font-bold text-gray-950">Manage Beneficiaries</h1>
        <div class="mt-1 flex items-center text-sm text-gray-500">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <i data-lucide="chevron-right" class="mx-2 h-4 w-4"></i>
            <span class="font-medium text-gray-700">Beneficiaries</span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[380px_minmax(0,1fr)]">
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-base font-bold text-gray-950">Add Beneficiary</h2>
            <form action="{{ route('beneficiaries.store') }}" method="post" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Type</label>
                    <select name="type" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        @foreach(['bank' => 'Bank', 'mobile' => 'Mobile', 'bill' => 'Bill', 'electricity' => 'Electricity', 'cable-streaming' => 'Cable & Streaming', 'ach' => 'ACH', 'other' => 'Other'] as $value => $label)
                            <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Nickname</label>
                    <input type="text" name="nickname" value="{{ old('nickname') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Provider / Bank</label>
                    <input type="text" name="provider" value="{{ old('provider') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Account / Customer Number</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="block w-full rounded-lg border border-gray-200 px-3 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-gray-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-gray-800">
                    <i data-lucide="user-plus" class="mr-2 h-5 w-5"></i>
                    Save beneficiary
                </button>
            </form>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 p-5">
                <h2 class="text-base font-bold text-gray-950">Saved Beneficiaries</h2>
                <p class="mt-1 text-sm text-gray-500">Only you can access beneficiaries saved to your account.</p>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($beneficiaries as $beneficiary)
                    <div class="flex items-center gap-4 p-5">
                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary-50 text-primary-700">
                            <i data-lucide="user-round-check" class="h-5 w-5"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-gray-950">{{ $beneficiary->name }}</p>
                            <p class="mt-1 truncate text-xs text-gray-500">{{ ucfirst($beneficiary->type) }} - {{ $beneficiary->provider ?: 'No provider' }} - {{ $beneficiary->account_number ?: $beneficiary->phone }}</p>
                        </div>
                        <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-50">
                                Remove
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                            <i data-lucide="users" class="h-6 w-6"></i>
                        </div>
                        <p class="mt-3 text-sm font-bold text-gray-950">No beneficiaries yet</p>
                        <p class="mt-1 text-sm text-gray-500">Add your frequent recipients and bill accounts here.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
