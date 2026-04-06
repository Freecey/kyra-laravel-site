@extends('member.auth.layout')
@section('title', 'Créer un compte')

@section('form')
@if($disabled ?? false)
  <div style="padding:20px; background:#0d1f2d; border:1px solid #1e3a4a; border-radius:6px; color:#e2e8f0; font-size:14px; line-height:1.6; text-align:center;">
    {{ $disabledMessage }}
  </div>
@else
<form method="POST" action="{{ route('member.register.post') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" id="name" name="name"
               class="form-control form-control-lg @error('name') is-invalid @enderror"
               value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email"
               class="form-control form-control-lg @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" id="password" name="password"
               class="form-control form-control-lg @error('password') is-invalid @enderror"
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control form-control-lg" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Créer mon compte</button>
</form>
@endif
@endsection

@section('footer-link')
    Déjà un compte ?
    <a href="{{ route('member.login') }}" style="color:var(--kyra-cyan);">Se connecter</a>
@endsection
