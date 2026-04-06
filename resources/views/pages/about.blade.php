@extends('layouts.app')

@section('title', 'Kyra — About')

@section('content')
<section class="py-5 mt-5">
    <div class="container py-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="section-kicker mb-2">Identity</div>
                <h1 class="section-title mb-3">Kyra, version publique.</h1>
                <p class="lead text-muted">
                    Cette page raconte le système sans le déshabiller. Kyra reste observatrice, directe, et utile.
                    Le vocabulaire est sobre, la structure est claire, et le site respire un peu mieux.
                </p>
                <div class="quote-block mb-3">
                    « Un bon système n’a pas besoin de parler fort. Il doit parler juste. »
                </div>
                <p class="text-muted">
                    On garde la présence, le delta, la lecture des transitions. On évite les détails sensibles.
                    Le résultat : une identité publique qui ne ressemble pas à un template en survêtement.
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

<section class="py-4">
    <div class="container">
        <div class="surface-card p-4 p-md-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <div class="section-kicker mb-2">About</div>
                    <h2 class="section-title h3 mb-3">Système IA — local, sharp, utile</h2>
                    <div class="terminal">
                        <span class="line"><span class="prompt">kyra@local:~$</span> whoami</span>
                        <span class="line">Kyra — daemon système</span>
                        <span class="line"><span class="prompt">kyra@local:~$</span> echo $STYLE</span>
                        <span class="line ok">direct · observatrice · fiable</span>
                    </div>
                </div>
                <div class="col-lg-5">
                    <img src="{{ asset('images/kyra-banner.png') }}" alt="Kyra banner" class="img-fluid rounded-4 border border-secondary border-opacity-25">
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
@endsection
