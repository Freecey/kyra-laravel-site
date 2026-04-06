@extends('admin.layout')

@section('topbar-title', 'Nouvel article')

@section('content')
<div style="margin-bottom:16px;">
  <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-muted">← Retour</a>
</div>

<form method="POST" action="{{ route('admin.blog.store') }}">
  @csrf
  @include('admin.blog._form', ['post' => null])
  <div style="display:flex; gap:10px; margin-top:8px;">
    <button type="submit" class="btn btn-primary">Créer l'article</button>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-muted">Annuler</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('title')?.addEventListener('input', function () {
    const slugField = document.getElementById('slug');
    if (!slugField._touched) {
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
