@extends('admin.layouts.master')

@section('title', 'Edit Package — Fokuskesini')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-dark font-weight-bold text-uppercase" style="letter-spacing: 2px;">Edit Package</h1>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-dark" style="border-radius: 0;">Back to List</a>
    </div>

    <div class="card border-0 shadow-none" style="border-radius: 0; border: 1px solid #eeeeee !important;">
        <div class="card-body p-5">
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Package Name</label>
                            <input type="text" name="name" class="form-control" style="border-radius: 0; border: 1px solid #000;" value="{{ old('name', $package->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Category</label>
                            <select name="category" class="form-control" style="border-radius: 0; border: 1px solid #000;" required>
                                <option value="WEDDING" {{ old('category', $package->category) == 'WEDDING' ? 'selected' : '' }}>WEDDING</option>
                                <option value="GRADUATION" {{ old('category', $package->category) == 'GRADUATION' ? 'selected' : '' }}>GRADUATION</option>
                                <option value="ENGAGEMENT" {{ old('category', $package->category) == 'ENGAGEMENT' ? 'selected' : '' }}>ENGAGEMENT</option>
                                <option value="MATERNITY" {{ old('category', $package->category) == 'MATERNITY' ? 'selected' : '' }}>MATERNITY</option>
                            </select>
                            @error('category')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Price (IDR)</label>
                            <input type="number" name="price" class="form-control" style="border-radius: 0; border: 1px solid #000;" value="{{ old('price', $package->price) }}" required>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PERBAIKAN: Tambahkan field Description -->
                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Description</label>
                            <textarea name="description" class="form-control" style="border-radius: 0; border: 1px solid #000; min-height: 100px;" required>{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Duration (Hours)</label>
                            <input type="number" name="duration_hours" class="form-control" style="border-radius: 0; border: 1px solid #000;" value="{{ old('duration_hours', $package->duration_hours) }}" required>
                            @error('duration_hours')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PERBAIKAN: Tambahkan field Features -->
                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Features (One per line)</label>
                            <textarea name="features" class="form-control" style="border-radius: 0; border: 1px solid #000; min-height: 100px;">{{ old('features', is_array($package->features) ? implode("\n", $package->features) : $package->features) }}</textarea>
                            @error('features')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter each feature on a new line</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Cover Image (Keep empty if no change)</label>
                            <input type="file" name="cover_image" class="form-control-file mb-2">
                            @error('cover_image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @if($package->cover_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $package->cover_image) }}" style="height: 100px; border: 1px solid #ddd;">
                                    <p class="small text-muted mt-1">Current image</p>
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-4 mt-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="activeSwitch" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label small text-uppercase font-weight-bold" for="activeSwitch">Active Status</label>
                            </div>
                            @error('is_active')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" style="border-radius: 0; background: #000; letter-spacing: 2px;">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection