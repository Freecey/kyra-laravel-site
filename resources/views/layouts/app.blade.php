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

    {{-- ═══ PRELOAD IMAGES CRITIQUES ═══ --}}
    @stack('preload')

    {{-- ═══ FONTS & ASSETS ═══ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600&display=swap" rel="stylesheet">
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
