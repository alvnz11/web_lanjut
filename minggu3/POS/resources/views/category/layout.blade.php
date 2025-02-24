<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h1>{{ $title ?? 'Kategori Penjualan' }}</h1>
    </header>
    
    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Website Penjualan</p>
    </footer>
</body>
</html>
