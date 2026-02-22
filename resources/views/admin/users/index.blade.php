@extends('layouts.admin')

@section('title', 'User Management - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">User Management</h2>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create
                new</a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email..." class="form-control" />
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended
                        </option>
                        <option value="guest" {{ request('status') == 'guest' ? 'selected' : '' }}>Guest</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="all">All Roles</option>
                        <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="vendor-manager" {{ request('role') == 'vendor-manager' ? 'selected' : '' }}>Vendor
                            Manager</option>
                        <option value="finance-manager" {{ request('role') == 'finance-manager' ? 'selected' : '' }}>
                            Finance Manager</option>
                        <option value="support-executive" {{ request('role') == 'support-executive' ? 'selected' : '' }}>
                            Support Executive</option>
                    </select>
                </div>
            </form>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td width="30%">
                                    <a href="#" class="itemside">
                                        <div class="left">
                                            <img src="{{ asset('admin_assets/imgs/people/avatar-1.png') }}"
                                                class="img-sm img-avatar" alt="Userpic" />
                                        </div>
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: #{{ $user->id }}</small>
                                        </div>
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-light text-dark">{{ ucfirst(str_replace('-', ' ', $user->role)) }}</span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match ($user->status) {
                                            'active' => 'alert-success',
                                            'suspended' => 'alert-danger',
                                            'guest' => 'alert-warning',
                                            default => 'alert-secondary',
                                        };
                                    @endphp
                                    <span
                                        class="badge rounded-pill {{ $badgeClass }}">{{ ucfirst($user->status) }}</span>
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-brand rounded font-sm mt-15">Edit</a>
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @if ($user->status == 'active')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded font-sm mt-15">Suspend</button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-success rounded font-sm mt-15">Activate</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-area mt-15 mb-50">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
