@extends('layouts.admin')

@section('title', 'Booking Details - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Booking Details #{{ $booking->id }}</h2>
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-light">Back to List</a>
        </div>
    </div>

    <div class="row">
        <!-- Customer Details -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Customer Information</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong> {{ $booking->customer->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $booking->customer->email ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Mobile:</strong> {{ $booking->customer->mobile ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Vendor Details -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Vendor Information</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Business Name:</strong> <a href="{{ route('admin.vendors.show', $booking->vendor->id) }}">{{ $booking->vendor->business_name ?? 'N/A' }}</a></p>
                    <p class="mb-2"><strong>Vendor Name:</strong> {{ $booking->vendor->user->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Contact:</strong> {{ $booking->vendor->user->email ?? 'N/A' }} | {{ $booking->vendor->user->mobile ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Booking Date/Status -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Booking Status</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                    <p class="mb-2"><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</p>
                    <p class="mb-2">
                        <strong>Booking Status:</strong> 
                        <span class="badge bg-{{ $booking->status == 'completed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </p>
                    <p class="mb-2">
                        <strong>Payment Status:</strong> 
                        <span class="badge bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'failed' ? 'danger' : 'warning') }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Financial Breakdown -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Financial Breakdown</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount (LKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end">{{ number_format($booking->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Platform Commission</td>
                                    <td class="text-end text-danger">- {{ number_format($booking->commission_amount, 2) }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td>Vendor Payout Amount</td>
                                    <td class="text-end text-success">{{ number_format($booking->vendor_payout_amount, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold fs-5 bg-light">
                                    <td>Total Customer Paid</td>
                                    <td class="text-end">LKR {{ number_format($booking->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
