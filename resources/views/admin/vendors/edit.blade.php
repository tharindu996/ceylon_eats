@extends('layouts.admin')

@section('title', 'Edit Vendor - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Edit Vendor: {{ $vendor->user->name }}</h2>
        <div>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-danger">Cancel</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Vendor Business Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="business_name" class="form-label">Business Name</label>
                            <input type="text" name="business_name" id="business_name"
                                value="{{ old('business_name', $vendor->business_name) }}"
                                class="form-control @error('business_name') is-invalid @enderror" required />
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="business_address" class="form-label">Business Address</label>
                            <textarea name="business_address" id="business_address" rows="3"
                                class="form-control @error('business_address') is-invalid @enderror">{{ old('business_address', $vendor->business_address) }}</textarea>
                            @error('business_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="commission_rate" id="commission_rate"
                                        value="{{ old('commission_rate', $vendor->commission_rate) }}"
                                        class="form-control @error('commission_rate') is-invalid @enderror" required />
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('commission_rate')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="verification_status" class="form-label">Verification Status</label>
                                <select name="verification_status" id="verification_status"
                                    class="form-select @error('verification_status') is-invalid @enderror" required>
                                    <option value="pending"
                                        {{ old('verification_status', $vendor->verification_status) == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="verified"
                                        {{ old('verification_status', $vendor->verification_status) == 'verified' ? 'selected' : '' }}>
                                        Verified</option>
                                    <option value="rejected"
                                        {{ old('verification_status', $vendor->verification_status) == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                                @error('verification_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Vendor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Seller Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $vendor->user->name }}</p>
                    <p><strong>Email:</strong> {{ $vendor->user->email }}</p>
                    <p><strong>Mobile:</strong> {{ $vendor->user->mobile ?: 'N/A' }}</p>
                    <p><strong>Joined:</strong> {{ $vendor->created_at->format('M d, Y') }}</p>
                    <hr>
                    <a href="{{ route('admin.users.edit', $vendor->user_id) }}" class="btn btn-light btn-sm">Edit User
                        Account</a>
                </div>
            </div>
        </div>
    </div>
@endsection
