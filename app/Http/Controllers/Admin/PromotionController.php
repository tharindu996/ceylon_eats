<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::with(['vendor.user', 'listing']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $promotions = $query->latest()->paginate(15)->withQueryString();

        return view('admin.promotions.index', compact('promotions'));
    }

    public function approve(Promotion $promotion)
    {
        $promotion->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Promotion approved successfully.');
    }

    public function reject(Request $request, Promotion $promotion)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $promotion->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Promotion rejected successfully.');
    }
}
