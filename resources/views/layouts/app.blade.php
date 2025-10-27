<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Course Builder')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body class="light-theme">
    <!-- Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header mx-auto">
                <div class="logo"> 
                    <span class="logo-text">CourseBuilder</span>
                </div>
                <button class="sidebar-close" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item  {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                        <a href="{{ route('courses.index') }}" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">All Courses</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('courses.create') ? 'active' : '' }}">
                        <a href="{{ route('courses.create') }}" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span class="nav-text">Create Course</span>
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span class="nav-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </nav> 
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="top-bar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb">
                        <span>Dashboard</span>
                    </div>
                </div>
                
                <div class="top-bar-right">
                    <div class="top-bar-actions"> 
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <div class="user-avatar-sm">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="user-name-sm">John Doe</span>
                                <i class="fas fa-chevron-down"></i>
                            </button> 
                        </div>
                    </div>
                </div>
            </header>
           
            <!-- Page Content -->
            <main class="page-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>