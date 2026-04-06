@extends('layouts.app')

@section('title', $post->title . ' — Kyra Blog')
@section('meta_description', $post->meta_description ?? $post->excerpt ?? '')
@section('og_type', 'article')
@section('og_image', $post->getFeaturedImageUrl() ?? asset('images/kyra-banner2.webp'))
@section('og_image_alt', $post->featuredMedia?->alt ?? $post->title)
@section('meta_canonical', route('blog.show', $post->slug))

@section('jsonld')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Article",
    "headline": "{{ addslashes($post->title) }}",
    "description": "{{ addslashes($post->meta_description ?? $post->excerpt ?? '') }}",
    "datePublished": "{{ $post->published_at->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    @if($post->getFeaturedImageUrl())
    "image": "{{ $post->getFeaturedImageUrl() }}",
    @endif
    "author": {
        "@@type": "Person",
        "name": "{{ $post->author?->name ?? 'Kyra' }}"
    },
    "publisher": {
        "@@type": "Organization",
        "name": "Kyra",
        "url": "{{ config('app.url') }}"
    },
    "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ route('blog.show', $post->slug) }}"
    }
}
</script>
@endsection

@section('content')
<article class="py-5">
    <div class="container-fluid px-3 px-lg-4">

        {{-- Featured image --}}
        @if($post->getFeaturedImageUrl())
            <div class="blog-post__hero mb-5">
                <img src="{{ $post->getFeaturedImageUrl() }}"
                     alt="{{ $post->featuredMedia->alt ?? $post->title }}"
                     class="blog-post__hero-img"
                     style="object-position: center {{ match($post->featured_image_position ?? 'center') { 'top' => 'top', 'top-center' => '25%', 'center' => 'center', 'center-bottom' => '75%', 'bottom' => 'bottom' } }};"
                     loading="eager">
            </div>
        @endif

        {{-- Fil d'Ariane --}}
        <nav aria-label="breadcrumb" class="breadcrumb-kyra mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 48) }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="section-kicker mb-2">
                    {{ $post->published_at->translatedFormat('d M Y') }}
                </div>
                <h1 class="section-title mb-4">{{ $post->title }}</h1>

                @if($post->excerpt)
                    <p class="blog-post__excerpt mb-5">{{ $post->excerpt }}</p>
                @endif

                {{-- Content --}}
                <div class="blog-post__content">
                    {!! $post->renderContent() !!}
                </div>

                {{-- Prev / Next --}}
                <nav class="blog-post__nav mt-5 pt-4" aria-label="Navigation articles">
                    <div class="d-flex justify-content-between gap-3 flex-wrap">
                        <div>
                            @if($prev)
                                <a href="{{ route('blog.show', $prev->slug) }}" class="blog-nav-link blog-nav-link--prev">
                                    ← {{ $prev->title }}
                                </a>
                            @endif
                        </div>
                        <div>
                            @if($next)
                                <a href="{{ route('blog.show', $next->slug) }}" class="blog-nav-link blog-nav-link--next">
                                    {{ $next->title }} →
                                </a>
                            @endif
                        </div>
                    </div>
                </nav>

            </div>
        </div>

    </div>
</article>
@endsection

@push('scripts')
<style>
.blog-post__hero { border-radius: 8px; overflow: hidden; max-height: 480px; }
.blog-post__hero-img { width: 100%; height: 100%; object-fit: cover; display: block; max-height: 480px; }
.blog-post__excerpt { font-size: 1.15rem; color: var(--kyra-cyan-soft, #5be7ff); font-style: italic; opacity: .85; }
.blog-post__content { line-height: 1.85; font-size: 1.05rem; color: var(--kyra-text, #c8e8f0); }
.blog-post__content h2,
.blog-post__content h3,
.blog-post__content h4 { color: #fff; margin-top: 2rem; margin-bottom: 1rem; }
.blog-post__content p { margin-bottom: 1.25rem; color: var(--kyra-text, #c8e8f0); }
.blog-post__content a { color: var(--cyan, #00c8ff); }
.blog-post__content img.blog-media { max-width: 100%; border-radius: 6px; margin: 1.5rem 0; display: block; }
.blog-post__content pre,
.blog-post__content code { background: #0d1f2d; border-radius: 4px; padding: .2em .45em; font-size: .9em; }
.blog-post__content blockquote { border-left: 3px solid var(--cyan, #00c8ff); padding-left: 1rem; color: #8aa; font-style: italic; }
.blog-post__nav { border-top: 1px solid var(--border, #1e3a4a); }
.blog-nav-link { color: var(--cyan, #00c8ff); text-decoration: none; font-size: .9rem; }
.blog-nav-link:hover { text-decoration: underline; }
</style>
@endpush
