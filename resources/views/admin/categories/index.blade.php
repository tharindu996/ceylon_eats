@extends('layouts.admin')

@section('title', 'Categories - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Categories</h2>
        <div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create new</a>
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
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Listings Count</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td><b>{{ $category->name }}</b></td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge rounded-pill alert-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill alert-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $category->listings()->count() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-brand rounded font-sm mt-15">Edit</a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded font-sm mt-15">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-area mt-15 mb-50">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
