@extends('layouts.admin')

@section('title', 'Edit Category - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Edit Category</h2>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" placeholder="Type category name here" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label" for="description">Description</label>
                    <textarea placeholder="Type here" class="form-control" rows="4" id="description" name="description">{{ old('description', $category->description) }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <span class="form-check-label"> Is Active </span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection
