<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Dashboard' }} - Pelaporan Keuangan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --orange: #ff821c;
            --blue-dark: #003e7f;
            --yellow: #ffde59;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            padding-bottom: 80px;
            overflow-x: hidden;
        }
        
        .app-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Desktop */
        .sidebar {
            width: 280px;
            background: var(--blue-dark);
            color: white;
            position: fixed;
            height: 100vh;
            left: -280px;
            transition: left 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            display: block;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(255,130,28,0.1);
            color: white;
            border-left-color: var(--orange);
        }
        
        .nav-item i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .btn-logout {
            background: var(--orange);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: #e6741a;
        }
        
        /* Main Content */
        .main-wrapper {
            flex: 1;
            transition: margin-left 0.3s ease;
            min-width: 0;
            overflow-x: hidden;
        }
        
        .top-navbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: var(--blue-dark);
        }
        
        .main-content {
            padding: 2rem 1.5rem;
        }
        
        /* Bottom Navigation Mobile */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-around;
            padding: 0.75rem 0;
            z-index: 1000;
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #6c757d;
            font-size: 0.75rem;
            transition: color 0.3s ease;
        }
        
        .bottom-nav-item.active {
            color: var(--orange);
        }
        
        .bottom-nav-item i {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }
        
        /* Extra Small Mobile */
        @media (max-width: 360px) {
            .main-content {
                padding: 0.5rem 0.25rem;
            }
            
            .top-navbar {
                padding: 0.5rem;
            }
            
            .top-navbar h1 {
                font-size: 0.9rem !important;
            }
            
            .sidebar {
                width: 100vw;
                left: -100vw;
            }
            
            .nav-item {
                padding: 0.75rem 0.75rem;
                font-size: 0.85rem;
            }
            
            .nav-item i {
                width: 16px;
                margin-right: 0.4rem;
                font-size: 0.8rem;
            }
            
            .bottom-nav {
                padding: 0.3rem 0;
            }
            
            .bottom-nav-item {
                font-size: 0.6rem;
                padding: 0.2rem;
            }
            
            .bottom-nav-item i {
                font-size: 0.8rem;
                margin-bottom: 0.1rem;
            }
        }
        
        /* Mobile First Responsive */
        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem 0.5rem;
            }
            
            .top-navbar {
                padding: 0.75rem 0.75rem;
            }
            
            .top-navbar h1 {
                font-size: 1.1rem !important;
            }
            
            .sidebar {
                width: 100vw;
                left: -100vw;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .sidebar-header {
                padding: 1rem;
            }
            
            .sidebar-brand {
                font-size: 1.1rem;
            }
            
            .nav-item {
                padding: 1rem 1rem;
                font-size: 0.95rem;
            }
            
            .nav-item i {
                width: 18px;
                margin-right: 0.5rem;
                font-size: 0.9rem;
            }
            
            .bottom-nav {
                padding: 0.4rem 0;
                background: white;
                border-top: 1px solid #e9ecef;
            }
            
            .bottom-nav-item {
                font-size: 0.65rem;
                padding: 0.25rem;
            }
            
            .bottom-nav-item i {
                font-size: 0.9rem;
                margin-bottom: 0.15rem;
            }
            
            .user-info {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
            }
            
            .sidebar-footer {
                padding: 1rem;
            }
        }
        
        /* Tablet */
        @media (min-width: 481px) and (max-width: 768px) {
            .main-content {
                padding: 1.5rem 1rem;
            }
            
            .sidebar.open {
                left: 0;
            }
        }
        
        /* Small Desktop */
        @media (min-width: 769px) and (max-width: 1023px) {
            .main-content {
                padding: 2rem 1.5rem;
            }
            
            .sidebar.open {
                left: 0;
            }
        }
        
        /* Desktop */
        @media (min-width: 1024px) {
            .sidebar {
                left: 0;
            }
            
            .main-wrapper {
                margin-left: 280px;
            }
            
            .bottom-nav {
                display: none;
            }
            
            .menu-toggle {
                display: none;
            }
            
            body {
                padding-bottom: 0;
            }
            
            .main-content {
                padding: 2rem;
            }
        }
        
        /* Large Desktop */
        @media (min-width: 1440px) {
            .main-content {
                padding: 2rem 3rem;
                max-width: 1400px;
                margin: 0 auto;
            }
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        
        .overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <span>₹</span> Pelaporan Keuangan
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('pemasukan') }}" class="nav-item {{ request()->routeIs('pemasukan') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up"></i> Pemasukan
                </a>
                <a href="{{ route('pengeluaran') }}" class="nav-item {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
                    <i class="fas fa-arrow-down"></i> Pengeluaran
                </a>
                <a href="{{ route('laporan') }}" class="nav-item {{ request()->routeIs('laporan') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Laporan
                </a>
                <a href="{{ route('kategori.index') }}" class="nav-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Kategori
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-weight: 500;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.8rem; opacity: 0.7;">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </aside>
        
        <!-- Overlay -->
        <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
        
        <!-- Main Content -->
        <div class="main-wrapper">
            <header class="top-navbar">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    ☰
                </button>
                <h1 style="color: var(--blue-dark); font-weight: 600;">{{ $title ?? 'Dashboard' }}</h1>
                <div></div>
            </header>
            
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
    </div>
    
    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('pemasukan') }}" class="bottom-nav-item {{ request()->routeIs('pemasukan') ? 'active' : '' }}">
            <i class="fas fa-arrow-up"></i>
            <span>Pemasukan</span>
        </a>
        <a href="{{ route('pengeluaran') }}" class="bottom-nav-item {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
            <i class="fas fa-arrow-down"></i>
            <span>Pengeluaran</span>
        </a>
        <a href="{{ route('laporan') }}" class="bottom-nav-item {{ request()->routeIs('laporan') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Laporan</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="bottom-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Profil</span>
        </a>
    </nav>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
    </script>
</body>
</html>