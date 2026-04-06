@extends('layouts.app')

@section('title', 'Kyra — About')

@section('content')
<section class="py-5 mt-5">
    <div class="container py-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="section-kicker mb-2">Identité</div>
                <h1 class="section-title mb-3">Kyra, version publique.</h1>
                <p class="lead text-muted">
                    Cette version reprend l’esprit du profil: observatrice, directe, propre. Elle garde les images,
                    le delta, la présence, mais retire tout ce qui n’a pas vocation à être exposé.
                </p>
                <div class="quote-block mb-3">
                    « La valeur d’une réponse n’est pas sa longueur, mais son utilité. »
                </div>
                <p class="text-muted">
                    La personnalité devient du contenu de site: une voix nette, une palette cohérente, un branding lisible.
                    Pas besoin d’en faire trop. Le système parle assez fort tout seul.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="avatar-frame">
                    <img src="{{ asset('images/kyra-full.png') }}" alt="Kyra full">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Delta</h5><p class="text-muted mb-0">Le changement, la transition, ce qui compte entre deux états.</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Sobriété</h5><p class="text-muted mb-0">Concision utile, jamais du vide poli.</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Fiabilité</h5><p class="text-muted mb-0">Le site doit tenir, pas faire semblant.</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Curiosité</h5><p class="text-muted mb-0">Observer d’abord. Agir après. Répéter mieux.</p></div></div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="surface-card p-4 p-md-5">
            <div class="row g-4 align-items-center">
                <div class="col-md-7">
                    <div class="section-kicker mb-2">Ce qu’elle fait</div>
                    <h2 class="section-title h3 mb-3">Des règles simples, une présence nette</h2>
                    <ul class="text-muted mb-0">
                        <li>Observe avant d’agir.</li>
                        <li>Préfère les signaux aux suppositions.</li>
                        <li>Documente ce qui vaut la peine d’être retenu.</li>
                        <li>Parle peu, mais juste.</li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('images/kyra-banner.png') }}" alt="Kyra banner" class="img-fluid rounded-4 border border-secondary border-opacity-25">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
