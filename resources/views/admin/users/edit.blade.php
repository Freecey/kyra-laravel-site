@extends('admin.layout')
@section('topbar-title', 'Éditer utilisateur')

@section('content')
<div class="card" style="max-width:560px;">
  <div class="card-header">
    <h2>Éditer — {{ $user->name }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-muted btn-sm">← Retour</a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
               value="{{ old('name', $user->name) }}" required>
        @error('name')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email', $user->email) }}" required>
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Rôle</label>
        <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}"
                @if($user->id === Auth::id()) disabled @endif>
          <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>member</option>
          <option value="admin"  {{ old('role', $user->role) === 'admin'  ? 'selected' : '' }}>admin</option>
        </select>
        @if($user->id === Auth::id())
          <input type="hidden" name="role" value="{{ $user->role }}">
          <div class="form-hint">Vous ne pouvez pas changer votre propre rôle.</div>
        @endif
        @error('role')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div style="border-top:1px solid var(--border); margin:24px 0 20px; padding-top:20px;">
        <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
          Nouveau mot de passe <span style="opacity:.5;">(laisser vide pour ne pas modifier)</span>
        </div>

        <div class="form-group">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                 autocomplete="new-password">
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Confirmer</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>
      </div>

      <div style="display:flex; gap:12px;">
        <button type="submit" class="btn btn-primary">✓ Enregistrer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-muted">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
