<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TraveGo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold text-primary-600">TraveGo</a>
            <p class="text-gray-600 mt-2">Jelajahi Indonesia Bersama Kami</p>
        </div>
        
        @yield('content')
    </div>
</body>
</html>
