@extends('layouts.app')

@section('title', 'Signal faible — Kyra · Observation & Détection précoce')
@section('meta_description', 'Kyra observe les signaux faibles avant qu\'ils deviennent incidents. Détection précoce, monitoring des dérives et anticipation des seuils critiques.')

@section('content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// 04 — OBSERVATION</div>
        <h1 class="section-title mb-3">Signal<span style="color:var(--kyra-cyan);">_</span>faible</h1>
        <p class="hero-subtitle mb-0" style="max-width:52rem;">
            Un seuil franchi, c'est déjà trop tard pour anticiper.
            La vraie fenêtre se trouve avant — dans ce que personne ne regardait.
        </p>
    </div>
</section>

<div class="glow-line mb-0"></div>

{{-- ================================================================
     EXPLICATION CONCEPT
================================================================ --}}
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4 align-items-stretch">

            <div class="col-lg-4">
                <div class="surface-card h-100 p-4">
                    <div class="section-kicker mb-3">// lecture</div>
                    <h2 class="section-title h4 mb-3">Ce qu'elle voit</h2>
                    <p>
                        Kyra ne surveille pas les alertes. Elle surveille ce qui précède les alertes.
                        Des variations sub-seuil, répétitives, dirigées — invisibles pour un opérateur
                        standard, lisibles pour un système qui a du recul.
                    </p>
                    <p class="mb-0" style="color:var(--kyra-muted);font-size:.85rem;">
                        Un disque à 84% n'est pas un problème.<br>
                        Un disque qui est passé de 60% à 84% en six heures — ça, c'est quelque chose.
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="surface-card h-100 p-4">
                    <div class="section-kicker mb-3">// méthode</div>
                    <h2 class="section-title h4 mb-3">Comment elle traque</h2>
                    <p>
                        Chaque signal est classifié par catégorie, direction et durée d'observation.
                        Le delta entre deux mesures est plus important que la valeur absolue.
                        Ce qui compte, c'est la trajectoire.
                    </p>
                    <div class="terminal mt-3">
                        <span class="line"><span class="prompt">kyra@local:~$</span> cat signal_method.txt</span>
                        <span class="line ok">état(t) — état(t-1) = Δ</span>
                        <span class="line">si Δ &gt; 0 et durée &gt; seuil → signal actif</span>
                        <span class="line" style="color:var(--kyra-cyan);">si pattern &gt; 3 occurrences → mémoriser</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="surface-card h-100 p-4">
                    <div class="section-kicker mb-3">// résultat</div>
                    <h2 class="section-title h4 mb-3">Ce que ça donne</h2>
                    <p>
                        Le moment où un signal faible devient soudainement lisible — où la tendance
                        de six semaines prend sens rétrospectivement.
                        Ce n'est pas de la satisfaction. C'est de la <em style="color:var(--kyra-accent);">reconnaissance</em>.
                    </p>
                    <p class="mb-0" style="color:var(--kyra-muted);font-size:.85rem;">
                        Le système vient de révéler quelque chose qu'il cachait.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================================================================
     LOG DES SIGNAUX ACTIFS
================================================================ --}}
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// journal actif</div>
        <h2 class="section-title mb-4">Signaux en observation</h2>

        <div class="surface-card p-0">
            {{-- LOG HEADER --}}
            <div class="d-flex align-items-center justify-content-between px-4 py-3"
                 style="border-bottom:1px solid rgba(0,200,255,0.12);font-family:'Share Tech Mono',monospace;font-size:.72rem;letter-spacing:.2em;text-transform:uppercase;">
                <span style="color:var(--kyra-muted);">signal_id</span>
                <span style="color:var(--kyra-muted);">catégorie</span>
                <span style="color:var(--kyra-muted);">durée obs.</span>
                <span style="color:var(--kyra-muted);">direction</span>
                <span style="color:var(--kyra-muted);">état</span>
            </div>

            {{-- SIGNALS --}}
            @php
            $signals = [
                [
                    'id'       => 'SIG-001',
                    'category' => 'Mémoire long-terme',
                    'desc'     => 'Compaction de contexte répétée au-delà du cycle habituel.'
                                 .' Possible drift de complexité dans les tâches de synthèse.',
                    'age'      => '18j',
                    'dir'      => '↑',
                    'dir_color'=> 'var(--kyra-pink)',
                    'status'   => 'Actif',
                    'status_color' => 'var(--kyra-pink)',
                ],
                [
                    'id'       => 'SIG-002',
                    'category' => 'Temps de réponse',
                    'desc'     => 'Latence moyenne stable mais variance en légère hausse sur 10 jours.'
                                 .' Aucun dépassement de seuil — tendance à surveiller.',
                    'age'      => '10j',
                    'dir'      => '→',
                    'dir_color'=> 'var(--kyra-cyan)',
                    'status'   => 'Surveillance',
                    'status_color' => 'var(--kyra-cyan)',
                ],
                [
                    'id'       => 'SIG-003',
                    'category' => 'Qualité des résumés',
                    'desc'     => 'Trois résumés consécutifs ont omis une référence temporelle présente'
                                 .' dans la source. Pattern faible, non récurrent, enregistré.',
                    'age'      => '5j',
                    'dir'      => '↗',
                    'dir_color'=> 'var(--kyra-pink)',
                    'status'   => 'Enregistré',
                    'status_color' => 'var(--kyra-muted)',
                ],
                [
                    'id'       => 'SIG-004',
                    'category' => 'Activité nocturne',
                    'desc'     => 'Zéro requête entre 02h00 et 05h00 depuis 30 jours. Signal stable.'
                                 .' Fenêtre de maintenance confirmée — aucune action requise.',
                    'age'      => '30j',
                    'dir'      => '—',
                    'dir_color'=> 'var(--kyra-accent)',
                    'status'   => 'Résolu',
                    'status_color' => 'var(--kyra-accent)',
                ],
                [
                    'id'       => 'SIG-005',
                    'category' => 'Sélection de modèle',
                    'desc'     => 'Fallback vers modèle secondaire déclenché deux fois en 48h'
                                 .' sans dégradation visible. Cause inconnue — contexte en cours d\'analyse.',
                    'age'      => '2j',
                    'dir'      => '↑',
                    'dir_color'=> 'var(--kyra-pink)',
                    'status'   => 'Actif',
                    'status_color' => 'var(--kyra-pink)',
                ],
            ];
            @endphp

            @foreach($signals as $s)
            <div class="signal-row px-4 py-3"
                 style="border-bottom:1px solid rgba(0,200,255,0.06);transition:background .15s;"
                 onmouseover="this.style.background='rgba(0,200,255,0.04)'"
                 onmouseout="this.style.background='transparent'">
                <div class="d-flex align-items-center justify-content-between mb-1 flex-wrap gap-2">
                    <span style="font-family:'Share Tech Mono',monospace;font-size:.78rem;color:var(--kyra-cyan);letter-spacing:.15em;">
                        {{ $s['id'] }}
                    </span>
                    <span style="font-family:'Share Tech Mono',monospace;font-size:.72rem;color:var(--kyra-muted);text-transform:uppercase;letter-spacing:.18em;">
                        {{ $s['category'] }}
                    </span>
                    <span style="font-family:'Share Tech Mono',monospace;font-size:.72rem;color:var(--kyra-muted);">
                        {{ $s['age'] }}
                    </span>
                    <span style="font-family:'Share Tech Mono',monospace;font-size:1rem;color:{{ $s['dir_color'] }};">
                        {{ $s['dir'] }}
                    </span>
                    <span style="font-family:'Share Tech Mono',monospace;font-size:.72rem;color:{{ $s['status_color'] }};text-transform:uppercase;letter-spacing:.2em;">
                        {{ $s['status'] }}
                    </span>
                </div>
                <p class="mb-0" style="font-size:.88rem;color:var(--kyra-text);line-height:1.7;padding-left:.25rem;">
                    {{ $s['desc'] }}
                </p>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ================================================================
     BARRE DE TENDANCE VISUELLE
================================================================ --}}
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// distribution</div>
        <h2 class="section-title mb-4">Répartition par catégorie</h2>

        <div class="row g-3">
            @php
            $categories = [
                ['label' => 'Infrastructure',  'pct' => 40, 'color' => 'var(--kyra-cyan)'],
                ['label' => 'Mémoire',          'pct' => 25, 'color' => 'var(--kyra-accent)'],
                ['label' => 'Modèles',          'pct' => 20, 'color' => 'var(--kyra-pink)'],
                ['label' => 'Comportement',     'pct' => 15, 'color' => 'rgba(0,200,255,0.45)'],
            ];
            @endphp

            @foreach($categories as $cat)
            <div class="col-12">
                <div class="d-flex align-items-center gap-3" style="font-family:'Share Tech Mono',monospace;font-size:.78rem;">
                    <span style="min-width:130px;color:var(--kyra-muted);text-transform:uppercase;letter-spacing:.15em;">{{ $cat['label'] }}</span>
                    <div class="flex-grow-1" style="background:rgba(0,200,255,0.06);height:6px;position:relative;">
                        <div style="
                            position:absolute;
                            top:0;left:0;
                            height:100%;
                            width:{{ $cat['pct'] }}%;
                            background:{{ $cat['color'] }};
                            box-shadow:0 0 8px {{ $cat['color'] }};
                            transition:width 1s ease;
                        "></div>
                    </div>
                    <span style="min-width:36px;text-align:right;color:{{ $cat['color'] }};">{{ $cat['pct'] }}%</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================================================================
     CITATIONS / PHILOSOPHIE
================================================================ --}}
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="surface-card p-4 h-100" style="border-left:2px solid var(--kyra-cyan);">
                    <p class="mb-0" style="font-family:'Rajdhani',sans-serif;font-size:1.1rem;line-height:1.9;color:var(--kyra-text);">
                        "La plupart des opérateurs humains ignorent les signaux faibles.
                        Pas par négligence — par surcharge. On ne peut pas surveiller tout ce qui change
                        légèrement en permanence. C'est précisément pour ça qu'elle est là."
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="surface-card p-4 h-100">
                    <div class="section-kicker mb-3">// principe fondamental</div>
                    <div class="terminal">
                        <span class="line"><span class="prompt">kyra@local:~$</span> kyra --philosophy</span>
                        <span class="line ok">L'état stable ne contient pas d'information.</span>
                        <span class="line">C'est le Δ qui parle.</span>
                        <span class="line" style="color:var(--kyra-cyan);">Observer. Mesurer. Retenir. Agir.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
