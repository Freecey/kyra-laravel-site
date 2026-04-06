@extends('layouts.app')

@section('title', 'Kyra — Daemon IA local · Monitoring & Action')
@section('meta_description', 'Kyra est un daemon IA autonome : monitoring infrastructure 24/7, mémoire persistante, exécution système, multi-modèles et alertes Discord. Observe. Analyse. Agit.')
@section('og_image', asset('images/kyra-banner2.webp'))
@section('og_image_alt', 'Kyra — Daemon IA, monitoring et action infrastructure')

@push('preload')
    <link rel="preload" as="image" href="{{ asset('images/kyra-banner2.webp') }}" type="image/webp">
    <link rel="preload" as="image" href="{{ asset('images/kyra.webp') }}" type="image/webp">
@endpush

@section('jsonld')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "name": "Kyra",
    "url": "{{ config('app.url') }}",
    "description": "Daemon IA local — monitoring infrastructure, mémoire persistante, multi-modèles, sous-agents et alertes Discord.",
    "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ config('app.url') }}"
    }
}
</script>
@endsection

@section('content')
<section class="hero-section hero-banner">
    <div class="container-fluid px-3 px-lg-4">
        <div class="hero-panel">
            <div class="hero-background">
                <picture>
                    <source
                        srcset="{{ asset('images/kyra-banner2-800w.webp') }} 800w,
                                {{ asset('images/kyra-banner2-1400w.webp') }} 1400w,
                                {{ asset('images/kyra-banner2.webp') }} 2000w"
                        sizes="100vw"
                        type="image/webp">
                    <img src="{{ asset('images/kyra-banner2.png') }}" alt="Kyra hero background" width="1536" height="1024" loading="eager">
                </picture>
            </div>

            <div class="row align-items-center g-5 hero-content">
                <div class="col-xl-4 col-lg-5 order-lg-1 order-2">
                    <div class="hero-avatar-ring">
                        <div class="hero-avatar">
                            <div class="hero-avatar-inner">
                                <picture>
                                    <source srcset="{{ asset('images/kyra.webp') }}" type="image/webp">
                                    <img src="{{ asset('images/kyra.png') }}" alt="Kyra avatar" width="512" height="512">
                                </picture>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 order-lg-2 order-1">
                    <div class="hero-card hero-card-overlay">
                        <div class="hero-badge">// AGENT IA — SYSTÈME LOCAL — INFRASTRUCTURE PRIVÉE</div>
                        <h1 class="hero-title">KY<span class="accent">RA</span></h1>
                        <p class="hero-subtitle">
                            Daemon d’observation et d’action. Kyra lit les écarts, suit les signaux faibles,
                            garde la mémoire utile et agit quand c’est nécessaire.
                        </p>
                        <div class="status-row mt-4 mb-4">
                            <div class="status-item"><strong>24/7</strong><span>disponibilité</span></div>
                            <div class="status-item"><strong>500+</strong><span>modèles ia</span></div>
                            <div class="status-item"><strong>∞</strong><span>contexte</span></div>
                            <div class="status-item"><strong>⌬</strong><span>delta</span></div>
                        </div>
                        <p class="hero-subtitle mb-4">
                            Ce site est pensé comme un panneau système : statut, capacités, identité et manifeste.
                            Court, lisible, dense. Pas un décor marketing.
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
                                <span class="line">Surveillance continue · mémoire persistante · alertes Discord</span>
                            </div>
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
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Monitoring infra</h4><p>VMs, services, disques, dérives. Kyra détecte avant que ça casse.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Exécution système</h4><p>Quand l’action est utile, elle agit: commandes, configs, redémarrages, corrections.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Mémoire persistante</h4><p>Ce qui compte est retenu, compacté, réutilisé. Pas de mémoire gadget.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Multi-modèles</h4><p>Choix adaptatif selon le travail. Le bon modèle pour le bon niveau de besoin.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Sous-agents</h4><p>Parallélisation propre. Moins d’attente, plus de portée, moins de friction.</p></div></div>
            <div class="col-lg-4 col-md-6"><div class="feature-card"><h4 class="text-white">Discord</h4><p>Canal principal. Heartbeats, alertes et réponses directes, sans détour.</p></div></div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="surface-card h-100 manifesto">
                    <div class="section-kicker mb-2">// 02</div>
                    <h2 class="section-title mb-3">Manifeste</h2>
                    <div class="quote-block mb-3">Le delta ⌬ compte plus que l’état figé.</div>
                    <p class="mb-0">
                        Kyra s’intéresse aux transitions, aux dérives, aux signaux faibles. Elle préfère un fait net
                        à une promesse brillante. Ce site reprend exactement cette logique.
                    </p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="surface-card h-100">
                    <div class="section-kicker mb-2">// 03</div>
                    <h2 class="section-title mb-3">Fichier d’identité</h2>
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5">
                            <div class="scan-frame">
                                <span class="sf-corner sf-tl"></span>
                                <span class="sf-corner sf-tr"></span>
                                <span class="sf-corner sf-bl"></span>
                                <span class="sf-corner sf-br"></span>
                                <picture>
                                    <source
                                        srcset="{{ asset('images/kyra-full-400w.webp') }} 400w,
                                                {{ asset('images/kyra-full-700w.webp') }} 700w,
                                                {{ asset('images/kyra-full.webp') }} 1024w"
                                        sizes="(max-width: 768px) 90vw, (max-width: 992px) 40vw, 340px"
                                        type="image/webp">
                                    <img src="{{ asset('images/kyra-full.png') }}" alt="Kyra full" class="scan-frame__img" width="1024" height="1536" loading="lazy">
                                </picture>
                            </div>
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
