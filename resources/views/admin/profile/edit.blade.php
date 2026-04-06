@extends('admin.layout')
@section('topbar-title', 'Mon profil')

@section('content')
<div class="card" style="max-width:560px;">
  <div class="card-header"><h2>Informations du compte</h2></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.profile.update') }}">
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

      <div style="border-top:1px solid var(--border); margin:24px 0 20px; padding-top:20px;">
        <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
          Changer le mot de passe <span style="opacity:.5;">(laisser vide pour ne pas modifier)</span>
        </div>

        <div class="form-group">
          <label class="form-label">Nouveau mot de passe</label>
          <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                 autocomplete="new-password">
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Confirmer le mot de passe</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>
      </div>

      <div style="display:flex; gap:12px;">
        <button type="submit" class="btn btn-primary">✓ Enregistrer</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-muted">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
