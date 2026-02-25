<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display the commission settings index.
     */
    public function index()
    {
        $settings = [
            'default_rate' => CommissionSetting::get('default_commission_rate', '0.00'),
            'default_cap' => CommissionSetting::get('default_commission_cap', '999.00'),
        ];

        return view('admin.commissions.index', compact('settings'));
    }

    /**
     * Update global commission settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'default_commission_rate' => 'required|numeric|min:0|max:100',
            'default_commission_cap' => 'required|numeric|min:0',
        ]);

        CommissionSetting::set('default_commission_rate', $request->default_commission_rate, 'Global default commission rate (%)');
        CommissionSetting::set('default_commission_cap', $request->default_commission_cap, 'Global default commission cap (LKR)');

        return back()->with('success', 'Global commission settings updated successfully.');
    }
}
