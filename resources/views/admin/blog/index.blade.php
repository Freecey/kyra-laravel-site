@extends('admin.layout')

@section('topbar-title', 'Blog')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
  <div></div>
  <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">+ Nouvel article</a>
</div>

<div class="card">
  <div class="card-header">
    <h2>◈ Articles</h2>
    <span style="font-size:11px; color:var(--text-muted);">{{ $posts->total() }} article(s)</span>
  </div>
  <div class="card-body" style="padding:0;">
    @if($posts->isEmpty())
      <div style="padding:40px; text-align:center; color:var(--text-muted);">Aucun article. <a href="{{ route('admin.blog.create') }}">Créer le premier →</a></div>
    @else
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Titre</th>
              <th>Statut</th>
              <th>Publié le</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($posts as $post)
              <tr>
                <td style="color:var(--text-muted); font-size:11px;">{{ $post->id }}</td>
                <td>
                  <a href="{{ route('admin.blog.edit', $post) }}">{{ $post->title }}</a>
                  @if($post->isPublished())
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" title="Voir sur le site"
                       style="margin-left:6px; font-size:11px; color:var(--text-muted);">↗</a>
                  @endif
                </td>
                <td>
                  @if($post->isPublished())
                    <span class="pill pill-sent">Publié</span>
                  @else
                    <span class="pill pill-read">Brouillon</span>
                  @endif
                </td>
                <td style="font-size:12px; color:var(--text-muted);">
                  {{ $post->published_at?->format('d/m/Y') ?? '—' }}
                </td>
                <td>
                  <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-muted">Éditer</a>

                    @if($post->isPublished())
                      <form method="POST" action="{{ route('admin.blog.unpublish', $post) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-muted">Dépublier</button>
                      </form>
                    @else
                      <form method="POST" action="{{ route('admin.blog.publish', $post) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-primary">Publier</button>
                      </form>
                    @endif

                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}"
                          onsubmit="return confirm('Supprimer « {{ addslashes($post->title) }} » ?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $posts->links() }}
    @endif
  </div>
</div>
@endsection
