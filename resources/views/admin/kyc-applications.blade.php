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
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <p>
                    <a href="{{ route('kyc') }}">
                        <i class="p-2 rounded-lg fa fa-arrow-circle-left fa-2x bg-light"></i>
                    </a>
                </p>

                <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="title1 text-{{ $text }}">{{ $kyc->user->name }} KYC Application Review</h1>
                        @if ($kyc->status == 'Verified')
                            <span class="badge badge-success badge-lg" style="font-size: 14px;">
                                <i class="fas fa-check-circle mr-2"></i>Verified on {{ $kyc->updated_at->format('M d, Y') }}
                            </span>
                        @elseif ($kyc->status == 'Under review')
                            <span class="badge badge-warning badge-lg" style="font-size: 14px;">
                                <i class="fas fa-hourglass-half mr-2"></i>Under Review
                            </span>
                        @elseif ($kyc->status == 'Rejected')
                            <span class="badge badge-danger badge-lg" style="font-size: 14px;">
                                <i class="fas fa-times-circle mr-2"></i>Rejected
                            </span>
                        @else
                            <span class="badge badge-secondary badge-lg" style="font-size: 14px;">{{ $kyc->status }}</span>
                        @endif
                    </div>
                    @if ($kyc->status != 'Verified')
                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#action">
                            <i class="fas fa-check-double mr-2"></i>Take Action
                        </button>
                    @endif
                </div>
                <div id="action" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h3 class="mb-0 text-white">
                                    <i class="fas fa-stamp mr-2"></i>KYC Decision
                                </h3>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-h6="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('processkyc') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="action" class="font-weight-bold">Decision</label>
                                        <select name="action" id="action" class="form-control form-control-lg" required>
                                            <option value="">-- Select Decision --</option>
                                            <option value="Accept">✓ Accept and Verify User</option>
                                            <option value="Reject">✗ Reject and Request Resubmission</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject" class="font-weight-bold">Email Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control" 
                                            placeholder="e.g., Your KYC Verification Status" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="font-weight-bold">Message to User</label>
                                        <textarea name="message" id="message" class="form-control" rows="6" required>This is to inform you that following the documents you submitted, your account has been verified. You can now enjoy all our services without restrictions. Thank you for your patience!</textarea>
                                        <small class="form-text text-muted">This message will be sent to the user's email address</small>
                                    </div>
                                    <input type="hidden" name="kyc_id" value="{{ $kyc->id }}">
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                                            <i class="fas fa-paper-plane mr-2"></i>Submit Decision & Notify User
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /view KYC ID Modal -->
                <x-danger-alert />
                <x-success-alert />
                
                <div class="row">
                    <!-- Documents Section -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-id-card mr-2"></i>{{ $kyc->document_type ?? 'Identity Document' }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 text-center mb-3">
                                        <div class="position-relative" style="border: 2px solid #e3e6f0; padding: 10px; border-radius: 5px;">
                                            @if($kyc->frontimg)
                                                <img src="{{ asset('storage/' . $kyc->frontimg) }}" alt="Front of Document" 
                                                    class="img-fluid" style="max-height: 300px; object-fit: contain;">
                                                <small class="d-block mt-2 text-muted"><strong>Front View</strong></small>
                                            @else
                                                <div class="text-muted py-5">
                                                    <i class="fas fa-image fa-3x mb-3 d-block opacity-50"></i>
                                                    <small>No front image</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center mb-3">
                                        <div class="position-relative" style="border: 2px solid #e3e6f0; padding: 10px; border-radius: 5px;">
                                            @if($kyc->backimg)
                                                <img src="{{ asset('storage/' . $kyc->backimg) }}" alt="Back of Document" 
                                                    class="img-fluid" style="max-height: 300px; object-fit: contain;">
                                                <small class="d-block mt-2 text-muted"><strong>Back View</strong></small>
                                            @else
                                                <div class="text-muted py-5">
                                                    <i class="fas fa-image fa-3x mb-3 d-block opacity-50"></i>
                                                    <small>No back image</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Summary -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user-circle mr-2"></i>Quick Summary
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Username</small>
                                        <strong class="text-{{ $text }}">{{ $kyc->user->name ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Email</small>
                                        <strong class="text-{{ $text }}">{{ $kyc->user->email ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Phone</small>
                                        <strong class="text-{{ $text }}">{{ $kyc->user->phone ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Document Type</small>
                                        <strong class="text-{{ $text }}">{{ $kyc->document_type ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Account Type</small>
                                        <strong class="text-{{ $text }}">{{ $kyc->accounttype ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Submitted Date</small>
                                        <strong class="text-{{ $text }}">{{ $kyc->created_at->format('M d, Y H:i') ?? 'N/A' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5 row">
                    <div class="col-md-12">
                        <div class="card p-md-4 p-2 shadow">
                            <div class="card-body">
                                <h5 class="mb-4 font-weight-bold">
                                    <i class="fas fa-file-alt mr-2 text-primary"></i>Complete Application Details
                                </h5>
                                <div class="row">
                                    <div class="mb-3 col-md-12 border-bottom pb-3">
                                        <h6 class="text-primary font-weight-bold">
                                            <i class="fas fa-address-card mr-2"></i>PERSONAL INFORMATION
                                        </h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">First Name</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->user->name ?? 'N/A'}}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Middle Name</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->user->middlename ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Last Name</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->user->lastname ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Email Address</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->user->email ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Phone Number</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->user->phone ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Date of Birth</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->user->dob ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Gender</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->gender ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">SSN / Government ID</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->statenumber ?? 'N/A' }}</h6>
                                    </div>

                                    <div class="my-3 border-bottom col-md-12 pb-3">
                                        <h6 class="text-primary font-weight-bold">
                                            <i class="fas fa-briefcase mr-2"></i>EMPLOYMENT INFORMATION
                                        </h6>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Account Type</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->accounttype ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Income Range</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->income ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Employer</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->employer ?? 'N/A' }}</h6>
                                    </div>

                                    <div class="my-3 border-bottom col-md-12 pb-3">
                                        <h6 class="text-primary font-weight-bold">
                                            <i class="fas fa-map-marker-alt mr-2"></i>ADDRESS INFORMATION
                                        </h6>
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <small class="text-muted d-block">Address Line</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->address ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">City</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->city ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">State/Province</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->state ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Zip Code</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->zipcode ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Country</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->country ?? 'N/A' }}</h6>
                                    </div>

                                    <div class="my-3 border-bottom col-md-12 pb-3">
                                        <h6 class="text-primary font-weight-bold">
                                            <i class="fas fa-users mr-2"></i>EMERGENCY CONTACT INFORMATION
                                        </h6>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Emergency Contact Name</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->kinname ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <small class="text-muted d-block">Relationship</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->relationship ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <small class="text-muted d-block">Emergency Contact Address</small>
                                        <h6 class="text-{{ $text }}">{{ $kyc->kinaddress ?? 'N/A' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
