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
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Système</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Identité</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('signal') ? 'active' : '' }}" href="{{ route('signal') }}">Signal</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('protocole') ? 'active' : '' }}" href="{{ route('protocole') }}">Protocole</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Statut</a></li>
            </ul>
            <div class="d-none d-lg-flex align-items-center gap-2 ms-lg-auto">
                <span class="status-dot"></span>
                <span class="footer-link" style="color: var(--kyra-accent);">ONLINE · v2026.4</span>
            </div>
        </div>
    </div>
</nav>
