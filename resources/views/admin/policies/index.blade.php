@extends('layouts.admin')

@section('title', 'Policies - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Policies</h2>
        <div>
            <a href="{{ route('admin.policies.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create new</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Policy Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($policies as $policy)
                            <tr>
                                <td>{{ $policy->id }}</td>
                                <td><b>{{ $policy->name }}</b></td>
                                <div style="max-height: 50px; overflow: hidden; text-overflow: ellipsis;">
                                    <td>{{ Str::limit($policy->description, 50) }}</td>
                                </div>
                                <td>
                                    @if($policy->is_active)
                                        <span class="badge rounded-pill alert-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill alert-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.policies.edit', $policy->id) }}" class="btn btn-sm btn-brand rounded font-sm mt-15">Edit</a>
                                    
                                    <form action="{{ route('admin.policies.destroy', $policy->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this policy?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded font-sm mt-15">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No policies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-area mt-15 mb-50">
                {{ $policies->links() }}
            </div>
        </div>
    </div>
@endsection
