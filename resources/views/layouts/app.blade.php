<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kyra')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/kyra.png') }}" alt="Kyra">
                <span>KY<span class="navbar-brand-accent">RA</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-lg-4">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Système</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Identité</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Statut</a></li>
                </ul>
                <div class="d-none d-lg-flex align-items-center gap-2 ms-lg-auto">
                    <span class="text-success">●</span>
                    <span class="footer-link" style="color:#30f1d1;">ONLINE · v2026.4</span>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('images/kyra.png') }}" alt="Kyra" width="40" height="40" class="rounded-0 border border-secondary border-opacity-25">
                <div>
                    <div class="text-white fw-bold" style="letter-spacing:.2em; font-family: 'Orbitron', ui-monospace, monospace;">KY<span style="color:var(--kyra-accent);">RA</span></div>
                    <div class="text-muted small">Observe · Analyse · Agit</div>
                </div>
            </div>
            <div class="text-muted small">&copy; {{ date('Y') }} Kyra — version publique.</div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
