@extends('admin.layout')
@section('topbar-title', 'Nouvel utilisateur')

@section('content')
<div class="card" style="max-width:560px;">
  <div class="card-header">
    <h2>Créer un utilisateur</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-muted btn-sm">← Retour</a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf

      <div class="form-group">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
               value="{{ old('name') }}" required>
        @error('name')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email') }}" required>
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Rôle</label>
        <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}">
          <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>member</option>
          <option value="admin"  {{ old('role') === 'admin'  ? 'selected' : '' }}>admin</option>
        </select>
        @error('role')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
               autocomplete="new-password" required>
        @error('password')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <div style="display:flex; gap:12px;">
        <button type="submit" class="btn btn-primary">✓ Créer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-muted">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
