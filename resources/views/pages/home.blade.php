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
                        Kyra n’est pas un assistant gentil pour la forme. C’est un daemon système : elle observe,
                        analyse, agit. Base Laravel + Bootstrap, mais avec une identité nette, du contraste propre,
                        et des visuels internes pour éviter le look générique qui fatigue les yeux.
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
