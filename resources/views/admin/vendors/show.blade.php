@extends('layouts.admin')

@section('title', 'Vendor Details - ' . $vendor->business_name)

@section('content')
    <div class="content-header">
        <a href="{{ route('admin.vendors.index') }}"><i class="material-icons md-arrow_back"></i> Go back </a>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-brand-2" style="height: 150px"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl col-lg flex-grow-0" style="flex-basis: 230px">
                    <div class="img-thumbnail shadow w-100 bg-white position-relative text-center"
                        style="height: 190px; width: 200px; margin-top: -120px">
                        <img src="{{ asset('admin_assets/imgs/people/avatar-2.png') }}" class="center-xy img-fluid"
                            alt="Logo Brand" />
                    </div>
                </div>
                <!--  col.// -->
                <div class="col-xl col-lg">
                    <h3>{{ $vendor->business_name }}</h3>
                    <p>{{ $vendor->business_address }}</p>
                </div>
                <!--  col.// -->
                <div class="col-xl-4 text-md-end">
                    <form action="{{ route('admin.vendors.toggle-status', $vendor) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ $vendor->is_active ? 'btn-danger' : 'btn-success' }}">
                            {{ $vendor->is_active ? 'Suspend Vendor' : 'Activate Vendor' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.vendors.toggle-verification', $vendor) }}" method="POST"
                        class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            @if ($vendor->verification_status == 'pending')
                                Verify Now
                            @elseif($vendor->verification_status == 'verified')
                                Reject Verification
                            @else
                                Re-verify
                            @endif
                        </button>
                    </form>
                </div>
                <!--  col.// -->
            </div>
            <!-- card-body.// -->
            <hr class="my-4" />
            <div class="row g-4">
                <div class="col-md-12 col-lg-4 col-xl-3">
                    <article class="box">
                        <p class="mb-0 text-muted">Commission Rate:</p>
                        <h5 class="text-brand">{{ $vendor->commission_rate }}%</h5>
                        <p class="mb-0 text-muted">Status:</p>
                        <h5 class="{{ $vendor->is_active ? 'text-success' : 'text-danger' }}">
                            {{ $vendor->is_active ? 'Active' : 'Suspended' }}
                        </h5>
                        <p class="mb-0 text-muted">Verification:</p>
                        <h5
                            class="{{ $vendor->verification_status == 'verified' ? 'text-success' : ($vendor->verification_status == 'pending' ? 'text-warning' : 'text-danger') }}">
                            {{ ucfirst($vendor->verification_status) }}
                        </h5>
                    </article>
                </div>
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <h6>Account Information</h6>
                    <p>
                        Manager: {{ $vendor->user->name }} <br />
                        Email: {{ $vendor->user->email }} <br />
                        Mobile: {{ $vendor->user->mobile ?? 'N/A' }}
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-5">
                    <h6>Business Address</h6>
                    <p>
                        {{ $vendor->business_address ?: 'No address provided.' }}
                    </p>
                </div>
                <!--  col.// -->
            </div>
            <!--  row.// -->
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Quick Edit</h5>
            <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="business_name" class="form-label">Business Name</label>
                        <input type="text" class="form-control" id="business_name" name="business_name"
                            value="{{ $vendor->business_name }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                        <input type="number" step="0.01" class="form-control" id="commission_rate"
                            name="commission_rate" value="{{ $vendor->commission_rate }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="commission_cap" class="form-label">Commission Cap (LKR)</label>
                        <input type="number" step="0.01" class="form-control" id="commission_cap" name="commission_cap"
                            value="{{ $vendor->commission_cap }}" placeholder="Default">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="verification_status" class="form-label">Manual Verification Status Override</label>
                        <select class="form-select" id="verification_status" name="verification_status">
                            <option value="pending" {{ $vendor->verification_status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="verified" {{ $vendor->verification_status == 'verified' ? 'selected' : '' }}>
                                Verified</option>
                            <option value="rejected" {{ $vendor->verification_status == 'rejected' ? 'selected' : '' }}>
                                Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="business_address" class="form-label">Address</label>
                        <textarea class="form-control" id="business_address" name="business_address" rows="3">{{ $vendor->business_address }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Vendor Info</button>
            </form>
        </div>
    </div>
@endsection
