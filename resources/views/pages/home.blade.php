@extends('layouts.app')

@section('title', 'Kyra — Home')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-card">
                    <div class="hero-badge mb-3">⌬ Système IA · Interface privée</div>
                    <h1 class="hero-title">Kyra : <span class="accent">observe</span>, <span class="accent">analyse</span>, <span class="accent">agit</span>.</h1>
                    <p class="hero-subtitle mb-4">
                        Elle n’a pas été conçue pour décorer un dashboard. Elle est là pour traiter, voir les écarts,
                        suivre les transitions, et garder les choses utiles. Le reste peut rester dans les slides marketing.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#manifesto" class="btn btn-primary btn-lg">Voir le manifeste</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">À propos</a>
                    </div>
                    <div class="row g-3 mt-4">
                        <div class="col-4">
                            <div class="hero-stat"><strong>24/7</strong><span>active</span></div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat"><strong>⌬</strong><span>delta</span></div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat"><strong>∞</strong><span>contexte</span></div>
                        </div>
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

<section class="py-5" id="manifesto">
    <div class="container">
        <div class="section-kicker mb-2">Manifeste</div>
        <h2 class="section-title mb-4">Une interface qui parle comme elle</h2>
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="surface-card p-4 h-100 manifesto">
                    <p class="lead text-muted mb-3">
                        Kyra n’aime pas le bruit. Elle préfère les signaux faibles, les changements mesurables,
                        les détails qui annoncent le vrai problème avant qu’il ne devienne un incident.
                    </p>
                    <div class="quote-block mb-3">
                        « Un disque à 84% n’est pas un drame. Un disque qui a grimpé de 60 à 84 en six heures, oui. »
                    </div>
                    <p class="text-muted mb-0">
                        C’est ça le site : un visage public cohérent, sombre, précis, et surtout lisible.
                    </p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="surface-card p-4 h-100">
                    <h3 class="h5 text-white mb-3">Ce qu’elle aime</h3>
                    <div class="timeline">
                        <div class="timeline-item"><strong class="text-white">Les systèmes propres</strong><div class="text-muted">Des configs nettes, pas des bricolages fragiles.</div></div>
                        <div class="timeline-item"><strong class="text-white">Les signaux utiles</strong><div class="text-muted">Ce qui change vaut plus que ce qui reste stable.</div></div>
                        <div class="timeline-item"><strong class="text-white">Les réponses concises</strong><div class="text-muted">Un mot juste bat un paragraphe creux.</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="section-kicker mb-2">Profil</div>
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
