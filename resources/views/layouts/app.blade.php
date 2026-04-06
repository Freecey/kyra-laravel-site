<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ═══ TITRE & DESCRIPTION ═══ --}}
    <title>@yield('title', 'Kyra — Daemon IA local')</title>
    <meta name="description" content="@yield('meta_description', 'Kyra est un daemon d\'observation et d\'action IA. Monitoring infrastructure, mémoire persistante, multi-modèles, sous-agents et alertes Discord.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('meta_canonical', request()->url())">

    {{-- ═══ OPEN GRAPH ═══ --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:site_name"   content="Kyra">
    <meta property="og:locale"      content="fr_FR">
    <meta property="og:title"       content="@yield('title', 'Kyra — Daemon IA local')">
    <meta property="og:description" content="@yield('meta_description', 'Kyra est un daemon d\'observation et d\'action IA. Monitoring infrastructure, mémoire persistante, multi-modèles, sous-agents et alertes Discord.')">
    <meta property="og:url"         content="@yield('meta_canonical', request()->url())">
    <meta property="og:image"       content="@yield('og_image', asset('images/kyra-banner2.webp'))">
    <meta property="og:image:alt"   content="@yield('og_image_alt', 'Kyra — Daemon IA')">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">

    {{-- ═══ TWITTER CARD ═══ --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', 'Kyra — Daemon IA local')">
    <meta name="twitter:description" content="@yield('meta_description', 'Kyra est un daemon d\'observation et d\'action IA. Monitoring infrastructure, mémoire persistante, multi-modèles, sous-agents et alertes Discord.')">
    <meta name="twitter:image"       content="@yield('og_image', asset('images/kyra-banner2.webp'))">

    {{-- ═══ JSON-LD STRUCTURED DATA ═══ --}}
    @hasSection('jsonld')
        @yield('jsonld')
    @else
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Kyra",
        "description": "Daemon d'observation et d'action IA — monitoring infrastructure, mémoire persistante, multi-modèles.",
        "url": "{{ config('app.url') }}",
        "logo": {
            "@@type": "ImageObject",
            "url": "{{ asset('images/kyra.webp') }}"
        },
        "sameAs": []
    }
    </script>
    @endif

    {{-- ═══ PRELOAD POLICES CRITIQUES (above the fold) ═══ --}}
    <link rel="preload" as="font" type="font/woff2" href="/fonts/orbitron-latin.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="/fonts/share-tech-mono-latin.woff2" crossorigin>

    {{-- ═══ PRELOAD IMAGES CRITIQUES ═══ --}}
    @stack('preload')

    {{-- ═══ ASSETS ═══ --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
