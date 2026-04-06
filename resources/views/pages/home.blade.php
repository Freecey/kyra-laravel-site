@extends('layouts.app')

@section('title', 'Kyra — Home')

@section('content')
<section class="hero-section">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-start g-5">
            <div class="col-xl-4 col-lg-5">
                <div class="avatar-frame">
                    <img src="{{ asset('images/kyra-banner2.png') }}" alt="Kyra banner">
                </div>
            </div>
            <div class="col-xl-8 col-lg-7">
                <div class="hero-card">
                    <div class="hero-badge">// AGENT IA — SYSTÈME LOCAL — INFRASTRUCTURE PRIVÉE</div>
                    <h1 class="hero-title">KYRA</h1>
                    <p class="hero-subtitle">
                        Daemon d'observation et d'action. Elle lit, analyse, exécute. Sharp. Directe. Pas de bruit inutile.
                    </p>
                    <div class="status-row mt-4 mb-4">
                        <div class="status-item"><strong>24/7</strong><span>disponibilité</span></div>
                        <div class="status-item"><strong>500+</strong><span>modèles ia</span></div>
                        <div class="status-item"><strong>∞</strong><span>contexte</span></div>
                        <div class="status-item"><strong>⌬</strong><span>delta</span></div>
                    </div>
                    <p class="hero-subtitle mb-4">
                        Kyra est un agent IA autonome. Elle surveille, détecte, documente et agit. Le site reprend sa logique:
                        structure nette, information hiérarchisée, accents cyan, fond sombre, et une esthétique de panneau système.
                    </p>
                    <div class="btn-group-like">
                        <a href="#status" class="btn btn-primary">Statut système</a>
                        <a href="#capabilities" class="btn btn-outline-light">Capacités</a>
                    </div>
                    <div class="status-panel mt-4" id="status">
                        <div class="section-kicker mb-2">Status</div>
                        <div class="terminal">
                            <span class="line"><span class="prompt">kyra@local:~$</span> systemctl status kyra</span>
                            <span class="line ok">● active (running)</span>
                            <span class="line">Surveillance continue · alertes Discord · mémoire persistante</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="capabilities">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// 01</div>
        <h2 class="section-title mb-4">Capacités</h2>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Monitoring infra</h4><p>Surveillance continue des VMs, services Docker, espace disque. Alertes si un seuil est dépassé.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Exécution système</h4><p>Accès shell sur VM dédiée. Commandes, configs, redémarrages. Elle agit quand ça compte.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Mémoire persistante</h4><p>Journaux, notes, continuité. Pas une mémoire magique : une mémoire tenue proprement.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Multi-modèles</h4><p>Fallbacks, choix adaptatif, outils selon le besoin. Le bon modèle pour le bon travail.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Sous-agents</h4><p>Quand il faut paralléliser, elle délègue. Moins d’attente, plus de portée.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Discord</h4><p>Canal principal. Heartbeats, alertes, réponses. Directe, pas de détour.</p></div></div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="surface-card h-100">
                    <div class="section-kicker mb-2">// 02</div>
                    <h2 class="section-title mb-3">Manifeste</h2>
                    <div class="quote-block mb-3">Le delta ⌬ compte plus que l’état figé.</div>
                    <p class="mb-0">
                        Kyra s’intéresse aux transitions, aux dérives, aux signaux faibles. Le site reprend ce réflexe:
                        il montre ce qui compte, supprime le superflu, et laisse respirer les blocs.
                    </p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="surface-card h-100">
                    <div class="section-kicker mb-2">// 03</div>
                    <h2 class="section-title mb-3">Fichier d’identité</h2>
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5">
                            <img src="{{ asset('images/kyra-full.png') }}" alt="Kyra full" class="img-fluid border border-secondary border-opacity-25">
                        </div>
                        <div class="col-md-7">
                            <div class="terminal">
                                <span class="line"><span class="prompt">kyra@local:~$</span> whoami</span>
                                <span class="line">Kyra — daemon système</span>
                                <span class="line"><span class="prompt">kyra@local:~$</span> echo $VIBE</span>
                                <span class="line ok">sharp · observatrice · fiable</span>
                                <span class="line"><span class="prompt">kyra@local:~$</span> echo $LANG</span>
                                <span class="line">français</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
