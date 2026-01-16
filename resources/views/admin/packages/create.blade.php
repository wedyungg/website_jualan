@extends('admin.layouts.master')

@section('title', 'Create New Package - Fokuskesini')

@section('content')
<div class="container-fluid">
    
    <!-- 🎯 Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Create New Package
        </h1>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
    
    <!-- 📝 Create Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Package Details
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        
                        <!-- Package Name -->
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Package Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="e.g., Premium Wedding Package" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                         <div class="form-group mb-4">
    <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Kategori Paket</label>
    <select name="category" class="form-control" style="border-radius: 0; border: 1px solid #000;" required>
        <option value="" selected disabled>— Pilih Kategori —</option>
        <option value="WEDDING">WEDDING</option>
        <option value="GRADUATION">GRADUATION</option>
        <option value="ENGAGEMENT">ENGAGEMENT</option>
        <option value="MATERNITY">MATERNITY</option>
        <option value="FAMILY">FAMILY</option>
    </select>
    @error('category')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
                        
                        <!-- Price -->
                        <div class="form-group">
                            <label for="price" class="font-weight-bold">Price (IDR) *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" 
                                       min="0" step="50000" placeholder="7500000" required>
                            </div>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Duration -->
                        <div class="form-group">
                            <label for="duration_hours" class="font-weight-bold">Duration (hours) *</label>
                            <input type="number" class="form-control @error('duration_hours') is-invalid @enderror" 
                                   id="duration_hours" name="duration_hours" value="{{ old('duration_hours', 2) }}" 
                                   min="1" max="24" required>
                            @error('duration_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" 
                                       id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active">
                                    Active (visible to customers)
                                </label>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        
                        <!-- Cover Image -->
                        <div class="form-group">
                            <label for="cover_image" class="font-weight-bold">Cover Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('cover_image') is-invalid @enderror" 
                                       id="cover_image" name="cover_image" accept="image/*">
                                <label class="custom-file-label" for="cover_image">Choose image...</label>
                                @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Recommended: 800x600px, max 2MB
                            </small>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                        
                        <!-- Features -->
                        <div class="form-group">
                            <label for="features" class="font-weight-bold">Features (One per line)</label>
                            <textarea class="form-control @error('features') is-invalid @enderror" 
                                      id="features" name="features" rows="5" 
                                      placeholder="2 Fotografer Profesional&#10;500 Foto Hasil Edit&#10;Album Fisik Premium">{{ old('features') }}</textarea>
                            @error('features')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Each line will become a bullet point feature
                            </small>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Description (Full Width) -->
                <div class="form-group">
                    <label for="description" class="font-weight-bold">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" 
                              placeholder="Describe this package in detail..." required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="form-group text-right mt-4">
                    <button type="reset" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-dark-classy">
                        <i class="fas fa-save"></i> Create Package
                    </button>
                </div>
                
            </form>
        </div>
    </div>
    
</div>
@endsection

@section('scripts')
<script>
    // Preview image before upload
    document.getElementById('cover_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="border rounded p-2">
                        <img src="${e.target.result}" 
                             class="img-fluid rounded" 
                             style="max-height: 200px;">
                        <p class="small mt-1 mb-0">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                    </div>
                `;
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
    
    // Update file input label
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose image...';
        e.target.nextElementSibling.textContent = fileName;
    });
</script>
@endsection