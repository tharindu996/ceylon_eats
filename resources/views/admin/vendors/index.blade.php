@extends('layouts.admin')

@section('title', 'Vendor Management - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Vendor Management</h2>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create
                new</a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <form action="{{ route('admin.vendors.index') }}" method="GET" class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" name="search" placeholder="Search by name, business or email"
                        class="form-control" value="{{ request('search') }}" />
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="verification" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ request('verification') == 'all' ? 'selected' : '' }}>All Verification
                        </option>
                        <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified
                        </option>
                        <option value="rejected" {{ request('verification') == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                </div>
            </form>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Seller / Business</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Verification</th>
                            <th>Registered</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                            <tr>
                                <td width="30%">
                                    <a href="{{ route('admin.vendors.show', $vendor) }}" class="itemside">
                                        <div class="left">
                                            <img src="{{ asset('admin_assets/imgs/people/avatar-2.png') }}"
                                                class="img-sm img-avatar" alt="Userpic" />
                                        </div>
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title">{{ $vendor->user->name }}</h6>
                                            <small class="text-muted">{{ $vendor->business_name }}</small>
                                        </div>
                                    </a>
                                </td>
                                <td>{{ $vendor->user->email }}</td>
                                <td>
                                    @if ($vendor->is_active)
                                        <span class="badge rounded-pill alert-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill alert-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($vendor->verification_status == 'verified')
                                        <span class="badge rounded-pill alert-success">Verified</span>
                                    @elseif($vendor->verification_status == 'pending')
                                        <span class="badge rounded-pill alert-warning">Pending</span>
                                    @else
                                        <span class="badge rounded-pill alert-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $vendor->created_at->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.vendors.show', $vendor) }}"
                                        class="btn btn-sm btn-brand rounded font-sm mt-15">View details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No vendors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- table-responsive.// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        {{ $vendors->links() }}
    </div>
@endsection
