<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-5">
                    <h1 class="title1 d-inline text-{{ $text }}">View Deposit Screenshot</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('mdeposits') }}"> <i class="fa fa-arrow-left"></i>
                                back</a>
                        </div>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />
                @php
                    $proof = $deposit->proof ?? '';
                    $proofExists = !empty($proof) && \Illuminate\Support\Facades\Storage::disk('public')->exists($proof);
                    $proofExt = strtolower(pathinfo($proof, PATHINFO_EXTENSION));
                @endphp
                <div class="mb-5 row">
                    <div class="col-lg-8 offset-lg-2 card p-4  shadow">
                        @if (!$proofExists)
                            <div class="alert alert-info mb-0">
                                No uploaded proof file is available for this deposit.
                            </div>
                        @elseif($proofExt === 'pdf')
                            <iframe src="{{ asset('storage/' . $proof) }}" class="w-100" style="height: 700px;"></iframe>
                            <a href="{{ asset('storage/' . $proof) }}" target="_blank" rel="noopener"
                                class="btn btn-primary btn-sm mt-3">
                                Open PDF in new tab
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $proof) }}" alt="Proof of Payment"
                                class="img-fluid" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
