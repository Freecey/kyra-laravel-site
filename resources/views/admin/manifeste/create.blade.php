@extends('admin.layout')

@section('topbar-title', 'Manifestes — Nouveau')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
  <a href="{{ route('admin.manifeste.index') }}" class="btn btn-muted">← Retour</a>
</div>

<form method="POST" action="{{ route('admin.manifeste.store') }}">
  @csrf

  @include('admin.manifeste._form')

  <div style="display:flex; gap:10px;">
    <button type="submit" class="btn btn-primary">Créer</button>
    <a href="{{ route('admin.manifeste.index') }}" class="btn btn-muted">Annuler</a>
  </div>
</form>
@endsection
