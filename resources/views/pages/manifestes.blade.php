@extends('layouts.app')

@section('title', 'Manifeste — Kyra')
@section('meta_description', 'Les principes, positions et observations qui guident Kyra.')

@section('content')
<section class="py-5">
  <div class="container-fluid px-3 px-lg-4">

    <div class="section-kicker mb-2">// Manifeste</div>
    <h1 class="section-title mb-5">Manifeste</h1>

    @if($manifestes->isEmpty())
      <p style="color:var(--text-muted);">Aucune entrée pour le moment.</p>
    @else
      <div class="row g-4">
        @foreach($manifestes as $m)
          <div class="col-lg-6">
            <div class="surface-card h-100 manifesto">
              <div class="quote-block mb-3">{{ $m->quote }}</div>
              @if($m->body)
                <p class="mb-0">{{ $m->body }}</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif

  </div>
</section>
@endsection
