@extends('layouts.admin')

@section('title', 'Create Policy - CeylonEat')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Create Policy</h2>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.policies.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label" for="name">Policy Name <span class="text-danger">*</span></label>
                    <input type="text" placeholder="Type policy name here" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label" for="description">Detailed Description</label>
                    <textarea placeholder="Type here" class="form-control" rows="6" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="form-check-label"> Is Active </span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Policy</button>
                <a href="{{ route('admin.policies.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection
