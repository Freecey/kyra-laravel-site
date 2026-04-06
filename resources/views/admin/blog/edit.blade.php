@extends('admin.layout')

@section('topbar-title', 'Éditer — ' . $post->title)

@section('content')
<div style="margin-bottom:16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
  <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-muted">← Retour</a>
  <div style="display:flex; gap:8px; flex-wrap:wrap;">
    @if($post->isPublished())
      <form method="POST" action="{{ route('admin.blog.unpublish', $post) }}">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-muted">Dépublier</button>
      </form>
      <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-muted">↗ Voir</a>
    @else
      <form method="POST" action="{{ route('admin.blog.publish', $post) }}">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-primary">Publier</button>
      </form>
    @endif
    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}"
          onsubmit="return confirm('Supprimer cet article définitivement ?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
    </form>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

  {{-- Left: Form --}}
  <div>
    <form method="POST" action="{{ route('admin.blog.update', $post) }}">
      @csrf @method('PUT')
      @include('admin.blog._form', ['post' => $post])
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
  </div>

  {{-- Right: Media panel --}}
  <div>
    <div class="card">
      <div class="card-header">
        <h2>◈ Médias</h2>
        <span style="font-size:11px; color:var(--text-muted);">{{ $post->media->count() }} fichier(s)</span>
      </div>
      <div class="card-body">

        {{-- Upload form --}}
        <form method="POST" action="{{ route('admin.blog.media.store', $post) }}" enctype="multipart/form-data" style="margin-bottom:20px;">
          @csrf
          <div class="form-group">
            <label class="form-label" for="file">Ajouter un fichier</label>
            <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror"
                   accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml">
            @error('file')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label" for="media_alt">Texte alt</label>
            <input type="text" id="media_alt" name="alt" class="form-control" placeholder="Description de l'image">
          </div>
          <button type="submit" class="btn btn-sm btn-primary">Uploader</button>
        </form>

        {{-- Media list --}}
        @if($post->media->isNotEmpty())
          <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach($post->media as $media)
              <div style="background:var(--bg-panel); border:1px solid var(--border); border-radius:4px; padding:12px;
                          {{ $post->featured_media_id === $media->id ? 'border-color:var(--cyan);' : '' }}">

                @if($media->isImage())
                  <img src="{{ $media->getUrl() }}" alt="{{ $media->alt ?? $media->filename }}"
                       style="width:100%; max-height:120px; object-fit:cover; border-radius:3px; margin-bottom:8px; display:block;">
                @endif

                <div style="font-size:11px; color:var(--text-muted); margin-bottom:6px; word-break:break-all;">
                  {{ $media->filename }}
                  @if($post->featured_media_id === $media->id)
                    <span class="pill pill-sent" style="margin-left:4px;">Vedette</span>
                  @endif
                </div>
                <div style="font-size:10px; color:var(--text-muted); margin-bottom:8px;">
                  ID: <code style="color:var(--cyan);">{{ $media->id }}</code>
                  · {{ number_format($media->size / 1024, 1) }} Ko
                  · Tag: <code style="color:var(--cyan);">[media:{{ $media->id }}]</code>
                </div>

                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                  @if($post->featured_media_id !== $media->id)
                    <form method="POST" action="{{ route('admin.blog.media.featured', [$post, $media]) }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn btn-sm btn-muted">★ Vedette</button>
                    </form>
                  @endif
                  <form method="POST" action="{{ route('admin.blog.media.destroy', [$post, $media]) }}"
                        onsubmit="return confirm('Supprimer ce média ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">✕</button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p style="font-size:12px; color:var(--text-muted);">Aucun média pour cet article.</p>
        @endif

      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('title')?.addEventListener('input', function () {
    const slugField = document.getElementById('slug');
    if (!slugField._touched && !{{ $post->slug ? 'true' : 'false' }}) {
        slugField.value = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
});
document.getElementById('slug')?.addEventListener('input', function () {
    this._touched = true;
});
</script>
@endpush
