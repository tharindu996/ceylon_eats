<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Listing;
use App\Models\Policy;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['vendor.user', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $listings = $query->latest()->paginate(15)->withQueryString();
        $categories = \App\Models\Category::where('is_active', true)->get();

        return view('admin.listings.index', compact('listings', 'categories'));
    }

    public function show(Listing $listing)
    {
        $listing->load(['vendor.user', 'category']);
        $policies = Policy::where('is_active', true)->get();
        return view('admin.listings.show', compact('listing', 'policies'));
    }

    public function approve(Listing $listing)
    {
        $listing->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Listing approved successfully.');
    }

    public function reject(Request $request, Listing $listing)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $listing->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Listing rejected successfully.');
    }
}
