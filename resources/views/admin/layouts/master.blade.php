<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin - Fokuskesini')</title>
    
    <!-- 🎨 SB Admin 2 + Black Luxury Theme -->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    
    <style>
        /* 🖤 Black Luxury Customizations */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%) !important;
        }
        .sidebar-dark .sidebar-brand {
            color: #fff;
            font-weight: 800;
            font-size: 1.5rem;
        }
        .sidebar-dark .nav-item .nav-link {
            color: rgba(255,255,255,.8);
            transition: all 0.3s;
        }
        .sidebar-dark .nav-item .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.1);
            transform: translateX(5px);
        }
        .sidebar-dark .nav-item.active .nav-link {
            color: #fff;
            background: rgba(201, 169, 110, 0.2);
            border-left: 4px solid #c9a96e;
        }
        .btn-dark-classy {
            background: linear-gradient(45deg, #000000, #333333);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-dark-classy:hover {
            background: linear-gradient(45deg, #333333, #000000);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .badge-luxury {
            background: linear-gradient(45deg, #c9a96e, #d4b87a);
            color: #000;
            font-weight: bold;
        }
    </style>
    
    @stack('styles')
</head>
<body id="page-top">
    
    <!-- 🏰 Page Wrapper -->
    <div id="wrapper">
        
        <!-- 🎯 Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            
            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="sidebar-brand-text mx-3">FOKUSKESINI <sup class="badge-luxury">ADMIN</sup></div>
            </a>
            
            <hr class="sidebar-divider my-0">
            
            <!-- Nav Items -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <!-- Heading: Management -->
            <div class="sidebar-heading">Management</div>
            
            <li class="nav-item {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.packages.index') }}">
                    <i class="fas fa-fw fa-box-open"></i>
                    <span>Packages</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Bookings</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-images"></i>
                    <span>Portfolio</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <!-- Account -->
            <div class="sidebar-heading">Account</div>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.profile.edit') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; text-align: left; color: rgba(255,255,255,.8);">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
            
        </ul>
        <!-- 🎯 End Sidebar -->
        
        <!-- 🏆 Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            
            <!-- Main Content -->
            <div id="content">
                
                <!-- 🎖️ Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    
                    <!-- Sidebar Toggle -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <small class="text-muted d-block">{{ auth()->user()->nomer_wa }}</small>
                                </span>
                                <img class="img-profile rounded-circle" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=000&color=fff" 
                                     height="40">
                            </a>
                        </li>
                        
                    </ul>
                    
                </nav>
                <!-- 🎖️ End Topbar -->
                
                <!-- 🎮 Main Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- 🎮 End Main Content -->
                
            </div>
            <!-- End Main Content -->
            
            <!-- 🏁 Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Fokuskesini {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            
        </div>
        <!-- 🏆 End Content Wrapper -->
        
    </div>
    <!-- 🏰 End Page Wrapper -->
    
    <!-- 🔼 Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- ⚡ Core Scripts -->
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
    
    <!-- Page level plugins -->
    @stack('scripts')
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Active menu highlight
        $(document).ready(function() {
            const currentPath = window.location.pathname;
            $('.nav-item').removeClass('active');
            $('.nav-link').each(function() {
                if ($(this).attr('href') === currentPath || currentPath.startsWith($(this).attr('href'))) {
                    $(this).parent().addClass('active');
                }
            });
        });
    </script>
    
</body>
</html>