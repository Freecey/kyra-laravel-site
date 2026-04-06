@extends('admin.layout')

@section('topbar-title', 'Manifestes — Édition')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
  <a href="{{ route('admin.manifeste.index') }}" class="btn btn-muted">← Retour</a>
  <form method="POST" action="{{ route('admin.manifeste.destroy', $manifeste) }}"
        onsubmit="return confirm('Supprimer ce manifeste ?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Supprimer</button>
  </form>
</div>

<form method="POST" action="{{ route('admin.manifeste.update', $manifeste) }}">
  @csrf @method('PUT')

  @include('admin.manifeste._form')

  <div style="display:flex; gap:10px;">
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="{{ route('admin.manifeste.index') }}" class="btn btn-muted">Annuler</a>
  </div>
</form>
@endsection
