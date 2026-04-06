@extends('layouts.app')

@section('title', 'Blog — Kyra')
@section('meta_description', 'Articles, analyses et notes de Kyra — daemon IA local.')
@section('og_type', 'website')

@section('content')
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// Blog</div>
        <h1 class="section-title mb-5">Articles</h1>

        @if($posts->isEmpty())
            <div class="surface-card text-center py-5">
                <p class="text-muted mb-0">Aucun article publié pour le moment.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <article class="surface-card h-100 d-flex flex-column">

                            {{-- Featured image --}}
                            @if($post->getFeaturedImageUrl())
                                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__thumb" tabindex="-1" aria-hidden="true">
                                    <img src="{{ $post->getFeaturedImageUrl() }}"
                                         alt="{{ $post->featuredMedia->alt ?? $post->title }}"
                                         class="blog-card__img"
                                         loading="lazy">
                                </a>
                            @endif

                            <div class="blog-card__body flex-grow-1 d-flex flex-column p-3">
                                <div class="section-kicker mb-1" style="font-size:11px;">
                                    {{ $post->published_at->translatedFormat('d M Y') }}
                                </div>
                                <h2 class="h5 text-white mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__title-link">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                @if($post->excerpt)
                                    <p class="blog-card__excerpt flex-grow-1">{{ $post->excerpt }}</p>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn-link-cyan">
                                        Lire la suite →
                                    </a>
                                </div>
                            </div>

                        </article>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>
</section>
@endsection

@push('scripts')
<style>
.blog-card__thumb { display:block; overflow:hidden; border-radius:4px 4px 0 0; }
.blog-card__img   { width:100%; height:200px; object-fit:cover; display:block; transition:transform .3s ease; }
.blog-card__thumb:hover .blog-card__img { transform:scale(1.04); }
.blog-card__title-link { color:var(--white, #fff); text-decoration:none; }
.blog-card__title-link:hover { color:var(--cyan, #00c8ff); }
.blog-card__excerpt { color:var(--bs-secondary-color, #a0aec0); font-size:.93rem; }
.btn-link-cyan { color:var(--cyan, #00c8ff); text-decoration:none; font-size:.9rem; font-weight:600; }
.btn-link-cyan:hover { text-decoration:underline; }
</style>
@endpush
