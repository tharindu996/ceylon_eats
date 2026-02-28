@extends('layouts.admin')

@section('title', 'Moderate Listing - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Moderate Listing: {{ $listing->title }}</h2>
        <div>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-light">Back to List</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Listing Details</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Title:</strong> {{ $listing->title }}</p>
                    <p class="mb-2"><strong>Category:</strong> {{ $listing->category->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Price:</strong> LKR {{ number_format($listing->price, 2) }}</p>
                    <p class="mb-2"><strong>Description:</strong></p>
                    <div class="p-3 bg-light rounded shadow-sm border">
                        {!! nl2br(e($listing->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Vendor Information</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Business Name:</strong> <a href="{{ route('admin.vendors.show', $listing->vendor->id) }}">{{ $listing->vendor->business_name ?? 'N/A' }}</a></p>
                    <p class="mb-2"><strong>Vendor Name:</strong> {{ $listing->vendor->user->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Contact:</strong> {{ $listing->vendor->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Moderation Status</h4>
                </div>
                <div class="card-body text-center">
                    <h5 class="mb-3">
                        @php
                            $badgeClass = match($listing->status) {
                                'pending' => 'bg-warning',
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                'suspended' => 'bg-secondary',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        Current Status: <span class="badge {{ $badgeClass }}">{{ ucfirst($listing->status) }}</span>
                    </h5>
                    
                    @if($listing->status == 'rejected' || $listing->status == 'suspended')
                        <div class="alert alert-danger text-start mt-3">
                            <strong>Reason:</strong> {{ $listing->rejection_reason }}
                        </div>
                    @endif

                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success w-100 mb-2 {{ $listing->status == 'approved' ? 'disabled' : '' }}">
                                <i class="material-icons md-check_circle"></i> Approve Listing
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger w-100 {{ $listing->status == 'rejected' ? 'disabled' : '' }}" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="material-icons md-cancel"></i> Reject / Suspend Listing
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.listings.reject', $listing->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="rejectModalLabel">Reject Listing</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="policy">Policy Violation (Optional)</label>
                            <select class="form-select" id="policy" onchange="document.getElementById('rejection_reason').value = this.options[this.selectedIndex].text + ' - \n'">
                                <option value="">Select a Policy</option>
                                @foreach($policies as $policy)
                                    <option value="{{ $policy->id }}">{{ $policy->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="rejection_reason">Reason Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="4" required placeholder="Explain why this listing is being rejected or suspended.">{{ old('rejection_reason') }}</textarea>
                            <small class="text-muted">This message may be sent to the vendor.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
