@extends('admin.layouts.master')

@section('title', 'Edit Package - Fokuskesini')

@section('content')
<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Package: {{ $package->name }}
        </h1>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Package Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Package Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $package->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Price (IDR) *</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $package->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration_hours">Duration (hours) *</label>
                            <input type="number" class="form-control @error('duration_hours') is-invalid @enderror" 
                                   id="duration_hours" name="duration_hours" 
                                   value="{{ old('duration_hours', $package->duration_hours) }}" required>
                            @error('duration_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ $package->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description', $package->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-group">
                    <label for="features">Features (One per line)</label>
                    <textarea class="form-control @error('features') is-invalid @enderror" 
                              id="features" name="features" rows="5">{{ old('features', $package->features ? implode("\n", $package->features) : '') }}</textarea>
                    @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    @if($package->cover_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $package->cover_image) }}" 
                             alt="Current cover" style="max-height: 150px;" class="rounded border">
                        <p class="small text-muted mt-1">Current image</p>
                    </div>
                    @endif
                    <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                    <small class="form-text text-muted">Leave empty to keep current image</small>
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-dark-classy">
                        <i class="fas fa-save"></i> Update Package
                    </button>
                </div>
                
            </form>
        </div>
    </div>
    
</div>
@endsection