@extends('layouts.admin')

@section('title', 'Listings Moderation - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Listings Moderation</h2>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <header class="card-header">
            <form action="{{ route('admin.listings.index') }}" method="GET" class="row gx-3">
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </header>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Listing</th>
                            <th>Vendor</th>
                            <th>Category</th>
                            <th>Price (LKR)</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $listing)
                            <tr>
                                <td><b>{{ $listing->title }}</b></td>
                                <td>{{ $listing->vendor->business_name ?? 'N/A' }}</td>
                                <td>{{ $listing->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($listing->price, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match($listing->status) {
                                            'pending' => 'badge rounded-pill alert-warning',
                                            'approved' => 'badge rounded-pill alert-success',
                                            'rejected' => 'badge rounded-pill alert-danger',
                                            'suspended' => 'badge rounded-pill alert-secondary',
                                            default => 'badge rounded-pill alert-light'
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ ucfirst($listing->status) }}</span>
                                </td>
                                <td>{{ $listing->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.listings.show', $listing->id) }}" class="btn btn-sm btn-brand rounded font-sm mt-15">Moderate</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No listings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-area mt-15 mb-50">
                {{ $listings->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
