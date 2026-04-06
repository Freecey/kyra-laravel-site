@extends('admin.layout')

@section('topbar-title', 'Manifestes')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
  <div></div>
  <a href="{{ route('admin.manifeste.create') }}" class="btn btn-primary">+ Nouveau manifeste</a>
</div>

<div class="card">
  <div class="card-header">
    <h2>◈ Manifestes</h2>
    <span style="font-size:11px; color:var(--text-muted);">{{ $manifestes->count() }} entrée(s) — home : max 6 actifs</span>
  </div>
  <div class="card-body" style="padding:0;">
    @if($manifestes->isEmpty())
      <div style="padding:40px; text-align:center; color:var(--text-muted);">
        Aucun manifeste. <a href="{{ route('admin.manifeste.create') }}">Créer le premier →</a>
      </div>
    @else
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Citation</th>
              <th>Épinglé</th>
              <th>Ordre</th>
              <th>Actif du</th>
              <th>Actif au</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($manifestes as $m)
              @php
                $now = now();
                $active = ($m->starts_at === null || $m->starts_at <= $now)
                       && ($m->ends_at   === null || $m->ends_at   >= $now);
              @endphp
              <tr>
                <td style="color:var(--text-muted); font-size:11px;">{{ $m->id }}</td>
                <td>
                  <a href="{{ route('admin.manifeste.edit', $m) }}">{{ Str::limit($m->quote, 70) }}</a>
                </td>
                <td style="text-align:center;">
                  @if($m->is_pinned)
                    <span title="Épinglé" style="color:var(--cyan);">📌</span>
                  @else
                    <span style="color:var(--text-muted);">—</span>
                  @endif
                </td>
                <td style="font-size:12px; color:var(--text-muted); text-align:center;">{{ $m->sort_order }}</td>
                <td style="font-size:11px; color:var(--text-muted);">{{ $m->starts_at?->format('d/m/Y H:i') ?? '—' }}</td>
                <td style="font-size:11px; color:var(--text-muted);">{{ $m->ends_at?->format('d/m/Y H:i') ?? '—' }}</td>
                <td>
                  @if($active)
                    <span class="pill pill-sent">Actif</span>
                  @else
                    <span class="pill pill-read">Inactif</span>
                  @endif
                </td>
                <td>
                  <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <a href="{{ route('admin.manifeste.edit', $m) }}" class="btn btn-sm btn-muted">Éditer</a>

                    @if($m->is_pinned)
                      <form method="POST" action="{{ route('admin.manifeste.unpin', $m) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-muted">Désépingler</button>
                      </form>
                    @else
                      <form method="POST" action="{{ route('admin.manifeste.pin', $m) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-primary">Épingler</button>
                      </form>
                    @endif

                    <form method="POST" action="{{ route('admin.manifeste.destroy', $m) }}"
                          onsubmit="return confirm('Supprimer ce manifeste ?')">
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
    @endif
  </div>
</div>
@endsection
