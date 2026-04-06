@extends('layouts.app')

@section('title', 'Kyra — About')

@section('content')
<section class="py-5 mt-5">
    <div class="container py-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="section-kicker mb-2">Identité</div>
                <h1 class="section-title mb-3">Kyra, mais en plus lisible.</h1>
                <p class="lead text-muted">
                    L'idée n'est pas de faire joli pour faire joli. L'idée est de faire un site qui respire,
                    qui tranche, et qui garde l'image en fond sans sacrifier le contraste.
                </p>
                <p class="text-muted">
                    Ici, les couleurs ont été ramenées dans une palette cohérente, les cartes sont plus nettes,
                    et les éléments clés utilisent les PNG locaux pour donner une vraie signature visuelle.
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
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Lisibilité</h5><p class="text-muted mb-0">Texte clair sur fond sombre, sans mélange douteux.</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Branding</h5><p class="text-muted mb-0">Logo et visuels Kyra intégrés dans l'UI.</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Cohérence</h5><p class="text-muted mb-0">Palette et composants harmonisés.</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="feature-card"><h5 class="text-white">Sobriété</h5><p class="text-muted mb-0">On a gardé du caractère, pas du cirque.</p></div></div>
        </div>
    </div>
</section>
@endsection
