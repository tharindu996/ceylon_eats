@extends('layouts.admin')

@section('title', 'Promotions Moderation - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Promotions Moderation</h2>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <header class="card-header">
            <form action="{{ route('admin.promotions.index') }}" method="GET" class="row gx-3">
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </form>
        </header>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Promotion Title</th>
                            <th>Listing</th>
                            <th>Vendor</th>
                            <th>Discount</th>
                            <th>Valid Dates</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promotion)
                            <tr>
                                <td><b>{{ $promotion->title }}</b></td>
                                <td><a href="{{ route('admin.listings.show', $promotion->listing_id) }}" target="_blank">{{ $promotion->listing->title ?? 'N/A' }}</a></td>
                                <td>{{ $promotion->vendor->business_name ?? 'N/A' }}</td>
                                <td><span class="badge bg-primary">{{ $promotion->discount_percentage }}% OFF</span></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($promotion->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($promotion->end_date)->format('d M Y') }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($promotion->status) {
                                            'pending' => 'badge rounded-pill alert-warning',
                                            'approved' => 'badge rounded-pill alert-success',
                                            'rejected' => 'badge rounded-pill alert-danger',
                                            default => 'badge rounded-pill alert-light'
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ ucfirst($promotion->status) }}</span>
                                    @if($promotion->status == 'rejected')
                                        <br><small class="text-danger" title="{{ $promotion->rejection_reason }}">Hover for reason</small>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($promotion->status != 'approved')
                                        <form action="{{ route('admin.promotions.approve', $promotion->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-success rounded font-sm mt-15" title="Approve">Approve</button>
                                        </form>
                                    @endif
                                    
                                    @if($promotion->status != 'rejected')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded font-sm mt-15" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $promotion->id }}">
                                            Reject
                                        </button>

                                        <!-- Reject Modal for this Promotion -->
                                        <div class="modal fade" id="rejectModal{{ $promotion->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $promotion->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <form action="{{ route('admin.promotions.reject', $promotion->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="rejectModalLabel{{ $promotion->id }}">Reject Promotion: {{ $promotion->title }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="rejection_reason_{{ $promotion->id }}">Reason Details <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" name="rejection_reason" id="rejection_reason_{{ $promotion->id }}" rows="3" required placeholder="Explain why this promotion is being rejected."></textarea>
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
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No promotions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-area mt-15 mb-50">
                {{ $promotions->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
