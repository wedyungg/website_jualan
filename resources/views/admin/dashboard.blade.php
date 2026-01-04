@extends('admin.layouts.master')

@section('title', 'Admin Dashboard - Fokuskesini')

@section('content')
<div class="container-fluid">
    
    <!-- 🏆 Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-crown"></i> Admin Dashboard
        </h1>
        <div class="badge badge-luxury p-2">
            <i class="fas fa-star"></i> SUPER ADMIN
        </div>
    </div>
    
    <!-- 🎯 Content Row -->
    <div class="row">
        
        <!-- 📦 Packages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Packages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Package::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.packages.index') }}" class="small text-primary mt-2 d-block">
                        View all packages →
                    </a>
                </div>
            </div>
        </div>
        
        <!-- 📅 Bookings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pending Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="#" class="small text-success mt-2 d-block">
                        Manage bookings →
                    </a>
                </div>
            </div>
        </div>
        
        <!-- 👥 Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Customers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'customer')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="#" class="small text-info mt-2 d-block">
                        View customers →
                    </a>
                </div>
            </div>
        </div>
        
        <!-- 💰 Revenue Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp 0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">This month</small>
                </div>
            </div>
        </div>
        
    </div>
    <!-- 🎯 End Content Row -->
    
    <!-- 📊 Quick Actions -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.packages.create') }}" class="btn btn-dark-classy btn-block">
                                <i class="fas fa-plus-circle"></i> Add Package
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-dark btn-block">
                                <i class="fas fa-calendar-plus"></i> View Bookings
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-dark btn-block">
                                <i class="fas fa-images"></i> Manage Portfolio
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-dark btn-block">
                                <i class="fas fa-user-cog"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection