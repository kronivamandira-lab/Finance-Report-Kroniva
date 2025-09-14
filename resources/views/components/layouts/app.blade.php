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
            background: linear-gradient(135deg, var(--blue-dark), #002a5c);
            color: white;
            position: fixed;
            height: 100vh;
            left: -280px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
        }
        
        .sidebar.open {
            left: 0;
            animation: slideInSidebar 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes slideInSidebar {
            from {
                left: -280px;
                opacity: 0.8;
            }
            to {
                left: 0;
                opacity: 1;
            }
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
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
            margin: 0.25rem 0.75rem;
            border-radius: 12px;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .nav-item:hover::before {
            left: 100%;
        }
        
        .nav-item:hover, .nav-item.active {
            background: linear-gradient(135deg, rgba(255,130,28,0.2), rgba(255,130,28,0.1));
            color: white;
            border-left-color: var(--orange);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(255,130,28,0.2);
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
            background: linear-gradient(135deg, var(--orange), #e6741a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(255,130,28,0.3);
            position: relative;
            overflow: hidden;
        }
        
        .user-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg) translateX(-100%);
            transition: transform 0.6s ease;
        }
        
        .user-avatar:hover::before {
            transform: rotate(45deg) translateX(100%);
        }
        
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255,130,28,0.4);
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
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,249,250,0.95));
            backdrop-filter: blur(20px);
            padding: 1rem 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .menu-toggle {
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(248,249,250,0.9));
            border: 1px solid rgba(255,255,255,0.3);
            font-size: 1.25rem;
            cursor: pointer;
            color: var(--blue-dark);
            padding: 0.75rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .menu-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            background: linear-gradient(135deg, var(--orange), #e6741a);
            color: white;
        }
        
        .menu-toggle:active {
            transform: scale(0.95);
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
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,249,250,0.95));
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-around;
            padding: 0.5rem;
            z-index: 1000;
            box-shadow: 0 -8px 32px rgba(0,0,0,0.1);
            border-radius: 20px 20px 0 0;
            margin: 0 0.5rem;
            animation: slideUpNav 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes slideUpNav {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #6c757d;
            font-size: 0.7rem;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0.75rem 0.5rem;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            min-width: 60px;
        }
        
        .bottom-nav-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle, rgba(255,130,28,0.2), rgba(255,130,28,0.1));
            border-radius: 50%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translate(-50%, -50%);
        }
        
        .bottom-nav-item.active::before {
            width: 100%;
            height: 100%;
            border-radius: 16px;
        }
        
        .bottom-nav-item.active {
            color: var(--orange);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 25px rgba(255,130,28,0.3);
        }
        
        .bottom-nav-item.active i {
            animation: bounceIcon 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .bottom-nav-item:active {
            transform: translateY(-2px) scale(0.95);
        }
        
        @keyframes bounceIcon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
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
                padding: 0.75rem;
                border-radius: 0 0 20px 20px;
                margin: 0 0.5rem;
            }
            
            .top-navbar h1 {
                font-size: 1.1rem !important;
            }
            
            .sidebar {
                width: 85vw;
                left: -85vw;
                border-radius: 0 20px 20px 0;
                margin-top: 0.5rem;
                height: calc(100vh - 1rem);
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .sidebar-header {
                padding: 1.5rem 1rem;
                background: rgba(255,255,255,0.1);
                border-radius: 0 20px 0 0;
                margin-bottom: 1rem;
            }
            
            .sidebar-brand {
                font-size: 1.2rem;
                font-weight: 700;
            }
            
            .nav-item {
                padding: 1rem;
                font-size: 0.95rem;
                margin: 0.25rem 1rem;
                border-radius: 15px;
            }
            
            .nav-item i {
                width: 20px;
                margin-right: 0.75rem;
                font-size: 1rem;
            }
            
            .bottom-nav {
                padding: 0.5rem;
                margin: 0 0.5rem;
                border-radius: 20px 20px 0 0;
            }
            
            .bottom-nav-item {
                font-size: 0.7rem;
                padding: 0.75rem 0.5rem;
            }
            
            .bottom-nav-item i {
                font-size: 1.1rem;
                margin-bottom: 0.25rem;
            }
            
            .user-info {
                flex-direction: row;
                text-align: left;
                gap: 0.75rem;
                background: rgba(255,255,255,0.1);
                padding: 1rem;
                border-radius: 15px;
                margin-bottom: 1rem;
            }
            
            .user-avatar {
                width: 45px;
                height: 45px;
            }
            
            .sidebar-footer {
                padding: 1rem;
            }
            
            .btn-logout {
                border-radius: 15px;
                padding: 0.75rem;
                font-weight: 600;
                background: linear-gradient(135deg, var(--orange), #e6741a);
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
            background: rgba(0,0,0,0.6);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(4px);
        }
        
        .overlay.show {
            opacity: 1;
            visibility: visible;
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
            const menuToggle = document.querySelector('.menu-toggle');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
            
            // Enhanced menu toggle animation
            menuToggle.style.transform = 'scale(0.8) rotate(180deg)';
            setTimeout(() => {
                menuToggle.style.transform = 'scale(1) rotate(0deg)';
            }, 200);
            
            // Stagger animation for nav items when opening
            if (sidebar.classList.contains('open')) {
                const navItems = sidebar.querySelectorAll('.nav-item');
                navItems.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateX(0)';
                        item.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    }, index * 50);
                });
            }
        }
        
        // Enhanced mobile interactions
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item, .bottom-nav-item');
            
            navItems.forEach(item => {
                // Touch feedback
                item.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.95)';
                });
                
                item.addEventListener('touchend', function() {
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 100);
                });
                
                // Click animation
                item.addEventListener('click', function(e) {
                    if (this.href && this.href !== window.location.href) {
                        // Ripple effect
                        const ripple = document.createElement('div');
                        ripple.style.position = 'absolute';
                        ripple.style.borderRadius = '50%';
                        ripple.style.background = 'rgba(255,130,28,0.3)';
                        ripple.style.transform = 'scale(0)';
                        ripple.style.animation = 'ripple 0.6s linear';
                        ripple.style.left = '50%';
                        ripple.style.top = '50%';
                        ripple.style.width = '20px';
                        ripple.style.height = '20px';
                        ripple.style.marginLeft = '-10px';
                        ripple.style.marginTop = '-10px';
                        
                        this.appendChild(ripple);
                        
                        setTimeout(() => {
                            ripple.remove();
                        }, 600);
                    }
                });
            });
            
            // Bottom nav entrance animation
            const bottomNav = document.querySelector('.bottom-nav');
            if (bottomNav && window.innerWidth <= 1024) {
                const items = bottomNav.querySelectorAll('.bottom-nav-item');
                items.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                        item.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                    }, 100 + (index * 50));
                });
            }
        });
        
        // Add ripple animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Smooth scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.main-content > *');
            animateElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = `all 0.6s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s`;
                observer.observe(el);
            });
        });
    </script>
</body>
</html>