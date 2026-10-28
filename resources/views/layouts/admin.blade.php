<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị Góc Nhỏ')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin">
@include('partials.flash')
<a class="visually-hidden-focusable" href="#main">Bỏ qua điều hướng</a>
<div class="admin-shell">
    <aside class="admin-side">
        @include('partials.admin-sidebar')
    </aside>
    <div class="admin-main">
        <header class="admin-top">
            @include('partials.admin-topbar')
        </header>
        <main id="main" class="admin-content">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>