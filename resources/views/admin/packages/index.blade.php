@extends('admin.layouts.master') {{-- Kita akan buat nanti --}}

@section('title', 'Manage Packages - Fokuskesini')

@section('content')
<div class="container-fluid">
    
    <!-- 🎯 Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-box-open"></i> Manage Packages
        </h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-dark-classy">
            <i class="fas fa-plus-circle"></i> Add New Package
        </a>
    </div>
    
    <!-- 🎨 Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif
    
    <!-- 📊 Packages Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> All Packages
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Cover</th>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                        <tr>
                            <td>{{ $package->id }}</td>
                            <td>
                                @if($package->cover_image)
                                <img src="{{ asset('storage/' . $package->cover_image) }}" 
                                     alt="{{ $package->name }}" 
                                     style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;">
                                @else
                                <div style="width: 80px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                                    <i class="fas fa-camera text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $package->name }}</strong><br>
                                <small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                            </td>
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </td>
                            <td>{{ $package->duration_hours }} hours</td>
                            <td>
                                @if($package->features)
                                <ul class="small pl-3 mb-0">
                                    @foreach(array_slice($package->features, 0, 3) as $feature)
                                    <li>{{ $feature }}</li>
                                    @endforeach
                                    @if(count($package->features) > 3)
                                    <li class="text-muted">+{{ count($package->features) - 3 }} more</li>
                                    @endif
                                </ul>
                                @endif
                            </td>
                            <td>
                                @if($package->is_active)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> Inactive
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.packages.edit', $package) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.packages.show', $package) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete {{ $package->name }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-box-open fa-2x text-muted mb-3"></i><br>
                                No packages found. Create your first package!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    // DataTable initialization
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[0, "desc"]],
            "language": {
                "emptyTable": "No packages available",
                "search": "Search package:"
            }
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endsection