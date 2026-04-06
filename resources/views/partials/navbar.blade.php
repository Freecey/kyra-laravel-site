<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-3 px-lg-4">
        <a class="navbar-brand" href="{{ route('home') }}">
            <picture>
                <source srcset="{{ asset('images/kyra.webp') }}" type="image/webp">
                <img src="{{ asset('images/kyra.png') }}" alt="Kyra" width="512" height="512">
            </picture>
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
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('protocole') ? 'active' : '' }}" href="{{ route('protocole') }}">Protocole</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Statut</a></li>
            </ul>
            <div class="d-none d-lg-flex align-items-center gap-2 ms-lg-auto">
                @auth
                    @if(Auth::user()->isMember())
                        <a href="{{ route('member.profile.edit') }}" class="footer-link" style="color:var(--kyra-accent); letter-spacing:.1em; font-size:.75rem;">
                            ▷ Mon espace
                        </a>
                        <span style="color:var(--kyra-muted); opacity:.4;">|</span>
                        <form method="POST" action="{{ route('member.logout') }}" class="m-0">
                            @csrf
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--kyra-muted);font-size:.75rem;letter-spacing:.15em;font-family:inherit;padding:0;">
                                DÉCONNEXION
                            </button>
                        </form>
                    @else
                        <span class="status-dot"></span>
                        <a href="{{ route('admin.dashboard') }}" class="footer-link" style="color:var(--kyra-accent); letter-spacing:.1em; font-size:.75rem;">
                            ONLINE · v2026.4 · <span style="color:var(--kyra-cyan);">ADMIN</span>
                        </a>
                    @endif
                @else
                    <span class="status-dot"></span>
                    <a href="{{ route('member.login') }}" class="footer-link" style="color:var(--kyra-accent); letter-spacing:.1em; font-size:.75rem;">
                        ONLINE · v2026.4
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
