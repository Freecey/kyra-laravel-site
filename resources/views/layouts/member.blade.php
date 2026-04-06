<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Espace membre') — Kyra</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <picture>
                    <source srcset="{{ asset('images/kyra.webp') }}" type="image/webp">
                    <img src="{{ asset('images/kyra.png') }}" alt="" width="512" height="512">
                </picture>
                <span>KY<span class="navbar-brand-accent">RA</span></span>
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto gap-lg-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.profile.*') ? 'active' : '' }}"
                           href="{{ route('member.profile.edit') }}">Mon profil</a>
                    </li>
                    {{-- Future sections ici --}}
                </ul>
                <div class="d-none d-lg-flex align-items-center gap-3 ms-lg-auto">
                    <span style="color:var(--kyra-muted); font-size:.75rem; letter-spacing:.15em;">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('member.logout') }}" class="m-0">
                        @csrf
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--kyra-muted);font-size:.75rem;letter-spacing:.15em;font-family:inherit;">
                            DÉCONNEXION
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @stack('scripts')
</body>
</html>
