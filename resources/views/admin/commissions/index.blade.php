@extends('layouts.admin')

@section('title', 'Commission Management - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Commission Management</h2>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Global Commission rules</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.commissions.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="default_commission_rate" class="form-label">Default Commission Rate (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="default_commission_rate"
                                    id="default_commission_rate" value="{{ $settings['default_rate'] }}"
                                    class="form-control" required />
                                <span class="input-group-text">%</span>
                            </div>
                            <div class="form-text">Applied to all vendors unless specifically overridden.</div>
                        </div>

                        <div class="mb-4">
                            <label for="default_commission_cap" class="form-label">Default Commission Cap (LKR)</label>
                            <div class="input-group">
                                <span class="input-group-text">LKR</span>
                                <input type="number" step="0.01" name="default_commission_cap"
                                    id="default_commission_cap" value="{{ $settings['default_cap'] }}" class="form-control"
                                    required />
                            </div>
                            <div class="form-text">The maximum commission amount per order (e.g., LKR 999.00).</div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Global Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Commission Audit Policy</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="material-icons md-info"></i> All changes to commission rates and caps are automatically
                        logged in the audit system for transparency.
                    </div>
                    <p>Current policy highlights:</p>
                    <ul>
                        <li>Global rates apply to all new vendors automatically.</li>
                        <li>Individual vendor overrides take precedence over global settings.</li>
                        <li>The cap prevents excessive commission on high-value orders.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
