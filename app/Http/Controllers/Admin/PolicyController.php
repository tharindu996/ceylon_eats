<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Policy;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = Policy::latest()->paginate(15);
        return view('admin.policies.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.policies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Policy::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.policies.index')->with('success', 'Policy created successfully.');
    }

    public function edit(Policy $policy)
    {
        return view('admin.policies.edit', compact('policy'));
    }

    public function update(Request $request, Policy $policy)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $policy->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.policies.index')->with('success', 'Policy updated successfully.');
    }

    public function destroy(Policy $policy)
    {
        $policy->delete();
        return redirect()->route('admin.policies.index')->with('success', 'Policy deleted successfully.');
    }
}
