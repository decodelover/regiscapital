<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $bg = 'dark';
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 text-{{ $text }}">KYC Verification Management</h1>
                    <p class="text-muted">Review and manage user KYC applications</p>
                </div>
                <x-danger-alert />
                <x-success-alert />
                
                <div class="mb-5 row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-alt mr-2"></i>KYC Applications List
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @if($kycs->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="text-{{ $text }}">User Name</th>
                                                    <th class="text-{{ $text }}">Email</th>
                                                    <th class="text-{{ $text }}">Document Type</th>
                                                    <th class="text-{{ $text }}">Status</th>
                                                    <th class="text-{{ $text }}">Submitted Date</th>
                                                    <th class="text-{{ $text }} text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kycs as $list)
                                                    <tr class="align-middle">
                                                        <td class="text-{{ $text }}">
                                                            <strong>{{ $list->user->name ?? 'N/A' }}</strong>
                                                        </td>
                                                        <td class="text-{{ $text }}">
                                                            {{ $list->user->email ?? 'N/A' }}
                                                        </td>
                                                        <td class="text-{{ $text }}">
                                                            <span class="badge badge-info">{{ $list->document_type ?? 'N/A' }}</span>
                                                        </td>
                                                        <td>
                                                            @if ($list->status == 'Verified')
                                                                <span class="badge badge-success">
                                                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                                                </span>
                                                            @elseif ($list->status == 'Under review')
                                                                <span class="badge badge-warning">
                                                                    <i class="fas fa-hourglass-half mr-1"></i>Under Review
                                                                </span>
                                                            @elseif ($list->status == 'Rejected')
                                                                <span class="badge badge-danger">
                                                                    <i class="fas fa-times-circle mr-1"></i>Rejected
                                                                </span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ $list->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-{{ $text }}">
                                                            <small>{{ $list->created_at->format('M d, Y') ?? 'N/A' }}</small>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('viewkyc', $list->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-eye mr-1"></i>Review
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">No KYC applications to review</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
