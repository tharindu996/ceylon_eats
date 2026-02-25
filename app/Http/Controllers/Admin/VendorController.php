<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vendor::with('user');

        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active');
        }

        if ($request->has('verification') && $request->verification != 'all') {
            $query->where('verification_status', $request->verification);
        }

        if ($request->has('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('business_name', 'like', '%' . $request->search . '%');
        }

        $vendors = $query->paginate(20);

        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Typically handled by user registration or promotions
        return redirect()->route('admin.vendors.index')->with('error', 'Use User Management to create a new vendor.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        $vendor->load('user');
        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_address' => 'nullable|string',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'commission_cap' => 'nullable|numeric|min:0',
            'verification_status' => 'required|in:pending,verified,rejected',
        ]);

        $vendor->update($request->only([
            'business_name',
            'business_address',
            'commission_rate',
            'commission_cap',
            'verification_status',
        ]));

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        // Usually we don't delete vendors, just deactivate them
        return back()->with('error', 'Vendors cannot be deleted. Deactivate them instead.');
    }

    /**
     * Toggle vendor verification status.
     */
    public function toggleVerification(Vendor $vendor)
    {
        $nextStatus = match($vendor->verification_status) {
            'pending' => 'verified',
            'verified' => 'rejected',
            'rejected' => 'verified',
        };

        $vendor->update(['verification_status' => $nextStatus]);

        return back()->with('success', 'Vendor verification status updated to ' . $nextStatus . '.');
    }

    /**
     * Toggle vendor active status.
     */
    public function toggleStatus(Vendor $vendor)
    {
        $vendor->update(['is_active' => !$vendor->is_active]);

        return back()->with('success', 'Vendor active status updated.');
    }
}
