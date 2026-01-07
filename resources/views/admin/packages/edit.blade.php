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
                            <input type="text" name="name" class="form-control" style="border-radius: 0; border: 1px solid #000;" value="{{ $package->name }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Category</label>
                            <select name="category" class="form-control" style="border-radius: 0; border: 1px solid #000;" required>
                                <option value="WEDDING" {{ $package->category == 'WEDDING' ? 'selected' : '' }}>WEDDING</option>
                                <option value="GRADUATION" {{ $package->category == 'GRADUATION' ? 'selected' : '' }}>GRADUATION</option>
                                <option value="ENGAGEMENT" {{ $package->category == 'ENGAGEMENT' ? 'selected' : '' }}>ENGAGEMENT</option>
                                <option value="MATERNITY" {{ $package->category == 'MATERNITY' ? 'selected' : '' }}>MATERNITY</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Price (IDR)</label>
                            <input type="number" name="price" class="form-control" style="border-radius: 0; border: 1px solid #000;" value="{{ $package->price }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Duration (Hours)</label>
                            <input type="number" name="duration_hours" class="form-control" style="border-radius: 0; border: 1px solid #000;" value="{{ $package->duration_hours }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Cover Image (Keep empty if no change)</label>
                            <input type="file" name="cover_image" class="form-control-file mb-2">
                            @if($package->cover_image)
                                <img src="{{ asset('storage/' . $package->cover_image) }}" style="height: 100px; border: 1px solid #ddd;">
                            @endif
                        </div>

                        <div class="form-group mb-4 mt-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="activeSwitch" {{ $package->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label small text-uppercase font-weight-bold" for="activeSwitch">Active Status</label>
                            </div>
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