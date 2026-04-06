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

{{-- ── Tokens API ──────────────────────────────────────────────────────── --}}
<div class="card" style="max-width:560px; margin-top:28px;">
  <div class="card-header" style="display:flex; align-items:center; justify-content:space-between;">
    <h2>Tokens API</h2>
    <span style="font-size:11px; color:var(--text-muted);">Sanctum — Bearer token</span>
  </div>
  <div class="card-body">

    {{-- Nouveau token créé : affichage unique --}}
    @if(session('new_token'))
    <div style="background:var(--bg-dark,#111); border:1px solid var(--cyan); border-radius:6px; padding:14px 16px; margin-bottom:20px;">
      <div style="font-size:11px; color:var(--cyan); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">
        ⚠ Copiez ce token maintenant — il ne sera plus affiché
      </div>
      <code style="word-break:break-all; font-size:12px; color:#e2e8f0;">{{ session('new_token') }}</code>
    </div>
    @endif

    @if(session('success') && !session('new_token'))
    <div class="alert alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
    @endif

    {{-- Créer un nouveau token --}}
    <form method="POST" action="{{ route('admin.profile.tokens.create') }}" style="display:flex; gap:10px; margin-bottom:20px;">
      @csrf
      <input type="text" name="token_name" class="form-control" placeholder="Nom du token (ex: kyra-agent)"
             value="{{ old('token_name') }}" required style="flex:1;">
      <button type="submit" class="btn btn-primary" style="white-space:nowrap;">+ Générer</button>
    </form>
    @error('token_name')<div class="form-error" style="margin-top:-14px; margin-bottom:12px;">{{ $message }}</div>@enderror

    {{-- Liste des tokens existants --}}
    @if($tokens->isEmpty())
      <p style="color:var(--text-muted); font-size:13px;">Aucun token actif.</p>
    @else
      <table style="width:100%; font-size:13px; border-collapse:collapse;">
        <thead>
          <tr style="border-bottom:1px solid var(--border); color:var(--text-muted); font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
            <th style="padding:6px 8px; text-align:left;">Nom</th>
            <th style="padding:6px 8px; text-align:left;">Dernière utilisation</th>
            <th style="padding:6px 8px; text-align:left;">Créé le</th>
            <th style="padding:6px 8px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($tokens as $token)
          <tr style="border-bottom:1px solid var(--border);">
            <td style="padding:8px 8px;">{{ $token->name }}</td>
            <td style="padding:8px 8px; color:var(--text-muted);">
              {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : '—' }}
            </td>
            <td style="padding:8px 8px; color:var(--text-muted);">
              {{ $token->created_at->format('d/m/Y') }}
            </td>
            <td style="padding:8px 8px; text-align:right;">
              <form method="POST"
                    action="{{ route('admin.profile.tokens.revoke', $token->id) }}"
                    onsubmit="return confirm('Révoquer ce token ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="padding:3px 10px; font-size:11px;">Révoquer</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
@endsection
