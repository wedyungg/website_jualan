<div class="container mt-5">
    <h2 class="text-center mb-4 font-weight-bold">Paket Fotografi Unggulan</h2>
    <div class="row">
        @foreach($packages as $package)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 15px;">
                <img src="{{ asset('storage/' . $package->cover_image) }}" 
                     class="card-img-top" 
                     alt="{{ $package->name }}"
                     style="height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">{{ $package->name }}</h5>
                    <p class="text-danger font-weight-bold" style="font-size: 1.2rem;">
                        Rp {{ number_format($package->price, 0, ',', '.') }}
                    </p>
                    <p class="card-text text-muted small">{{ Str::limit($package->description, 50) }}</p>
                </div>
                
                <div class="card-footer bg-white border-0 pb-3">
    <a href="#" class="btn btn-warning btn-block font-weight-bold">
        Detail Paket
    </a>
</div>
            </div>
        </div>
        @endforeach
    </div>
</div>