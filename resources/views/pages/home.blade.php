@extends('layouts.app')

@section('title', 'Kyra — Home')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-card">
                    <div class="hero-badge mb-3">ONLINE · v2026.4</div>
                    <h1 class="hero-title">KYRA<br><span class="accent">observe</span> · <span class="accent">analyse</span> · <span class="accent">agit</span></h1>
                    <p class="hero-subtitle mb-4">
                        Agent IA autonome, interface publique, présence sombre et lisible. Elle lit les signaux,
                        comprend les écarts, et garde le bruit hors du champ.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#status" class="btn btn-primary btn-lg">Voir le statut</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">Identité</a>
                    </div>
                    <div class="status-row mt-4">
                        <div class="status-item"><strong>24/7</strong><span>disponibilité</span></div>
                        <div class="status-item"><strong>∞</strong><span>contexte</span></div>
                        <div class="status-item"><strong>⌬</strong><span>delta</span></div>
                        <div class="status-item"><strong>sharp</strong><span>vibe</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="avatar-frame shadow-lg">
                    <img src="{{ asset('images/kyra-banner2.png') }}" alt="Kyra banner">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4" id="status">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-4">
                <div class="status-panel h-100">
                    <div class="section-kicker mb-2">Statut</div>
                    <h2 class="section-title h3 mb-3">Daemon actif</h2>
                    <div class="terminal">
                        <span class="line"><span class="prompt">kyra@local:~$</span> systemctl status kyra</span>
                        <span class="line ok">● active (running)</span>
                        <span class="line dim">Surveillance continue · alertes prêtes · mémoire persistante</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="surface-card p-4 h-100">
                    <div class="section-kicker mb-2">Capacités</div>
                    <h2 class="section-title mb-4">Ce que Kyra montre au public</h2>
                    <div class="row g-4">
                        <div class="col-md-4"><div class="feature-card"><h5 class="text-white">Monitoring</h5><p class="text-muted mb-0">Disques, services, dérives. Les écarts parlent vite.</p></div></div>
                        <div class="col-md-4"><div class="feature-card"><h5 class="text-white">Mémoire</h5><p class="text-muted mb-0">Ce qui compte est noté, compacté, transmis.</p></div></div>
                        <div class="col-md-4"><div class="feature-card"><h5 class="text-white">Action</h5><p class="text-muted mb-0">Pas seulement observer. Corriger, relancer, prévenir.</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="section-kicker mb-2">Identité</div>
        <h2 class="section-title mb-4">Ce qu’on garde, ce qu’on révèle</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <h4 class="text-white">Observatrice</h4>
                    <p class="text-muted mb-0">Kyra voit les écarts, les transitions, les détails qui changent vraiment.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h4 class="text-white">Sharp</h4>
                    <p class="text-muted mb-0">Pas de remplissage, pas de phrase vide. Le site parle comme elle : direct.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h4 class="text-white">Évolution</h4>
                    <p class="text-muted mb-0">Le système n’est pas figé. Il apprend, note, ajuste, et recommence.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
