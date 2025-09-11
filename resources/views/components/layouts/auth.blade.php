<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Auth' }} - Pelaporan Keuangan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">₹</div>
            <h1 class="auth-title">{{ $title ?? 'Pelaporan Keuangan' }}</h1>
            <p class="auth-subtitle">{{ $subtitle ?? 'Kelola keuangan dengan mudah' }}</p>
        </div>
        
        <div class="auth-form">
            {{ $slot }}
        </div>
    </div>
</body>
</html>