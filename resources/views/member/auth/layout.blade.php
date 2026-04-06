<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Connexion') — Kyra</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem;">
        <div style="width:100%; max-width:420px;">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" style="text-decoration:none;">
                    <div style="font-family:'Orbitron',ui-monospace,monospace; font-weight:900; font-size:1.4rem; letter-spacing:.3em; color:#fff; text-shadow:0 0 18px rgba(0,200,255,.5);">
                        KY<span style="color:var(--kyra-cyan);">RA</span>
                    </div>
                </a>
                <div style="font-family:'Share Tech Mono',ui-monospace,monospace; font-size:.75rem; letter-spacing:.25em; color:var(--kyra-muted); margin-top:.5rem; text-transform:uppercase;">
                    Espace membre
                </div>
            </div>

            <div class="surface-card p-4">
                <h1 style="font-family:'Orbitron',ui-monospace,monospace; font-size:1rem; letter-spacing:.15em; color:var(--kyra-cyan); margin-bottom:1.5rem; text-transform:uppercase;">
                    @yield('title', 'Connexion')
                </h1>

                @if(session('error'))
                    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                @endif

                @if(session('info'))
                    <div class="alert mb-3" style="background:#0d1f2d; border:1px solid #00c8ff55; color:#e2e8f0; border-radius:6px; padding:12px 16px; font-size:13px;">{{ session('info') }}</div>
                @endif

                @if(session('success'))
                    <div class="alert mb-3" style="background:#052010; border:1px solid #16a34a55; color:#bbf7d0; border-radius:6px; padding:12px 16px; font-size:13px;">{{ session('success') }}</div>
                @endif

                @yield('form')
            </div>

            <div class="text-center mt-3" style="font-size:.8rem; color:var(--kyra-muted);">
                @yield('footer-link')
            </div>
        </div>
    </main>
</body>
</html>
