@extends('admin.layouts.master')

@section('title', 'Manage Packages — Fokuskesini')

@section('content')
<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-dark font-weight-bold text-uppercase" style="letter-spacing: 2px;">
            <i class="fas fa-box-open mr-2"></i> Manage Packages
        </h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-dark" style="border-radius: 0; background: #000; padding: 10px 20px;">
            <i class="fas fa-plus mr-2"></i> Add New Package
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-dark border-0 shadow-sm fade show" role="alert" style="border-radius: 0; background: #000; color: #fff;">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close text-white" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif
    
    <div class="card border-0 shadow-none" style="border-radius: 0; border: 1px solid #eeeeee !important;">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 font-weight-bold text-dark text-uppercase small" style="letter-spacing: 1px;">
                <i class="fas fa-list mr-2"></i> All Photography Packages
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0" style="color: #000;">
                    <thead class="bg-light">
                        <tr class="text-uppercase small font-weight-bold" style="letter-spacing: 1px;">
                            <th class="border-0 pl-4">ID</th>
                            <th class="border-0">Cover</th>
                            <th class="border-0">Package Name</th>
                            <th class="border-0 text-center">Category</th>
                            <th class="border-0 text-center">Price</th>
                            <th class="border-0 text-center">Status</th>
                            <th class="border-0 pr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                        <tr>
                            <td class="align-middle pl-4 text-muted small">#{{ $package->id }}</td>
                            <td class="align-middle">
    @if($package->cover_image)
        <?php
        // Hapus 'packages/' dari awal string jika ada
        $imagePath = $package->cover_image;
        if (strpos($imagePath, 'packages/') === 0) {
            $imagePath = substr($imagePath, 9); // Hapus 'packages/'
        }
        ?>
        
        <!-- DEBUG: Tampilkan info -->
        <small class="text-muted d-block">{{ $imagePath }}</small>
        
        <!-- Akses langsung ke public/packages/ -->
        <img src="{{ asset('packages/' . $imagePath) }}" 
             alt="{{ $package->name }}" 
             style="width: 70px; height: 50px; object-fit: cover; border: 1px solid #00f;">
    @else
        <div style="width: 70px; height: 50px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 1px solid #eee;">
            <i class="fas fa-camera text-muted small"></i>
        </div>
    @endif
</td>
                            <td class="align-middle pr-4 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $package->name }} permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-dark ml-1" style="border-radius: 0; background: #000;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-box-open fa-2x text-muted mb-3 d-block"></i>
                                <span class="text-muted small text-uppercase" style="letter-spacing: 2px;">No packages found.</span>
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
<script src="{{ asset('sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[0, "desc"]],
            "language": {
                "search": "SEARCH:",
                "lengthMenu": "_MENU_ entries per page"
            }
        });

        setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 4000);
    });
</script>


@endsection