@extends('layouts.app')

@section('title', 'Kyra — Home')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-card">
                    <div class="hero-badge mb-3">⌬ Système IA · Interface privée</div>
                    <h1 class="hero-title">Un site <span class="accent">sharp</span>, sombre, propre.</h1>
                    <p class="hero-subtitle mb-4">
                        Base Laravel + Bootstrap, personnalisée pour Kyra avec un contraste net, une identité forte,
                        et des visuels internes pour éviter le look générique Bootstrap qui fatigue les yeux.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('about') }}" class="btn btn-primary btn-lg">Découvrir</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Contacter</a>
                    </div>
                    <div class="row g-3 mt-4">
                        <div class="col-4">
                            <div class="hero-stat"><strong>24/7</strong><span>actif</span></div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat"><strong>∞</strong><span>contexte</span></div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat"><strong>500+</strong><span>modèles</span></div>
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

<section class="py-5">
    <div class="container">
        <div class="section-kicker mb-2">Capacités</div>
        <h2 class="section-title mb-4">Ce qu'on garde, ce qu'on améliore</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <h4 class="text-white">Précision</h4>
                    <p class="text-muted mb-0">Des actions claires, des réponses lisibles, pas du texte gris sur du gris.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h4 class="text-white">Vitesse</h4>
                    <p class="text-muted mb-0">Interface légère, lecture rapide, hiérarchie visuelle plus propre.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h4 class="text-white">Identité</h4>
                    <p class="text-muted mb-0">Un vrai branding Kyra au lieu d'un Bootstrap sorti du carton.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
