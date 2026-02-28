@extends('layouts.admin')

@section('title', 'Bookings - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Bookings</h2>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by customer or vendor..." class="form-control" />
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" placeholder="From Date" onchange="this.form.submit()" />
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" placeholder="To Date" onchange="this.form.submit()" />
                </div>
                <div class="col-lg-1 col-md-2 col-6">
                    <button class="btn btn-primary w-100" type="submit">Filter</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light w-100 mt-1">Clear</a>
                </div>
            </form>
        </header>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Vendor</th>
                            <th>Date & Time</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>
                                    <b>{{ $booking->customer->name ?? 'N/A' }}</b>
                                </td>
                                <td>
                                    {{ $booking->vendor->business_name ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</small>
                                </td>
                                <td>LKR {{ number_format($booking->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($booking->status) {
                                            'pending' => 'badge rounded-pill alert-warning',
                                            'confirmed' => 'badge rounded-pill alert-info',
                                            'completed' => 'badge rounded-pill alert-success',
                                            'cancelled' => 'badge rounded-pill alert-danger',
                                            default => 'badge rounded-pill alert-secondary',
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                                </td>
                                <td>
                                    @php
                                        $paymentClass = match ($booking->payment_status) {
                                            'pending' => 'text-warning',
                                            'paid' => 'text-success',
                                            'failed' => 'text-danger',
                                            'refunded' => 'text-info',
                                            default => 'text-secondary',
                                        };
                                    @endphp
                                    <span class="{{ $paymentClass }} fw-bold">{{ ucfirst($booking->payment_status) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                        class="btn btn-sm btn-brand rounded font-sm mt-15">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-area mt-15 mb-50">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
