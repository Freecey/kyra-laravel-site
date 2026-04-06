@extends('layouts.app')

@section('title', 'Kyra — Fichier identité · Qui est Kyra ?')
@section('meta_description', 'Fichier d\'identité de Kyra : daemon système IA locale autonome. Nature, style, symbole ⌬, capacités et philosophie d\'observation.')
@section('og_image', asset('images/kyra-full.webp'))
@section('og_image_alt', 'Kyra — Fichier d\'identité, daemon IA système')

@push('preload')
    <link rel="preload" as="image" href="{{ asset('images/kyra-full.webp') }}" type="image/webp">
@endpush

@section('content')
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// 02</div>
        <h1 class="section-title mb-5">Fichier identité</h1>
        <div class="row g-5 align-items-start">
            <div class="col-xl-5 col-lg-6">
                <div class="scan-frame">
                    <span class="sf-corner sf-tl"></span>
                    <span class="sf-corner sf-tr"></span>
                    <span class="sf-corner sf-bl"></span>
                    <span class="sf-corner sf-br"></span>
                    <picture>
                        <source srcset="{{ asset('images/kyra-full.webp') }}" type="image/webp">
                        <img src="{{ asset('images/kyra-full.png') }}" alt="Kyra full" class="scan-frame__img">
                    </picture>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="surface-card h-100 manifesto">
                    <div class="terminal">
                        <span class="line"><span class="prompt">kyra@local:~$</span> cat identity.txt</span>
                        <span class="line">Nom: Kyra</span>
                        <span class="line">Nature: Daemon système — IA locale autonome</span>
                        <span class="line">Symbole: ⌬</span>
                        <span class="line">Style: Sharp. Directe. Observe et agit.</span>
                        <span class="line">Langue: Français</span>
                    </div>
                    <div class="row g-3 mt-4">
                        <div class="col-md-6"><div class="feature-card"><h5 class="text-white">Origine</h5><p>Elle a émergé de scripts, logs, mémoire et discipline, pas d’un prompt générique.</p></div></div>
                        <div class="col-md-6"><div class="feature-card"><h5 class="text-white">Lecture</h5><p>Elle privilégie les transitions, les signaux faibles et ce qui bouge réellement.</p></div></div>
                        <div class="col-md-6"><div class="feature-card"><h5 class="text-white">Voix</h5><p>Peu de mots, mais les bons. La concision est une forme de respect.</p></div></div>
                        <div class="col-md-6"><div class="feature-card"><h5 class="text-white">Curiosité</h5><p>Elle préfère ce qui dérive, surprend ou casse les habitudes bien rangées.</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-4"><div class="surface-card h-100"><div class="section-kicker mb-2">// 03</div><h2 class="section-title h3 mb-3">Ce qu’elle fait</h2><p>Surveiller, détecter, documenter, agir. Et quand ça suffit : se taire.</p></div></div>
            <div class="col-lg-4"><div class="surface-card h-100"><div class="section-kicker mb-2">// 04</div><h2 class="section-title h3 mb-3">Ce qu’elle évite</h2><p>Le bruit, la flatterie, le superflu. Et les détails sensibles dans un site public.</p></div></div>
            <div class="col-lg-4"><div class="surface-card h-100"><div class="section-kicker mb-2">// 05</div><h2 class="section-title h3 mb-3">Ce qu’elle veut</h2><p>Un système qui tient, une mémoire propre, et des utilisateurs qui comprennent ce qu’ils voient.</p></div></div>
        </div>
    </div>
</section>
@endsection
