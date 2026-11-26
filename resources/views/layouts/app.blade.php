<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | SIMSARPRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar-wrap { --bs-offcanvas-width: 280px; }
        @media (min-width: 992px) {
            .sidebar-wrap { flex: 0 0 280px; width: 280px; }
            .sidebar-inner { position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        }
        .sidebar .nav-link { color: rgba(255, 255, 255, .85); border-radius: .5rem; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255, 255, 255, .15); }
        .sidebar .nav-link.active { color: var(--bs-primary); background: #fff; font-weight: 500; }
        .sidebar-heading { color: rgba(255, 255, 255, .6); letter-spacing: .05em; }
        .badge { font-size: .9rem; }
    </style>
    @stack('styles')
</head>
<body class="bg-light">

<div class="d-flex">
    @include('layouts.partials.sidebar')

    <div class="flex-grow-1 min-vh-100 d-flex flex-column" style="min-width: 0;">
        @include('layouts.partials.topbar')

        <main class="flex-grow-1 p-3 p-md-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="text-center text-muted py-3">
            SIMSARPRAS &copy; {{ date('Y') }}
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>