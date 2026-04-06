@extends('member.auth.layout')
@section('title', 'Connexion')

@section('form')
<form method="POST" action="{{ route('member.login.post') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email"
               class="form-control form-control-lg @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" id="password" name="password"
               class="form-control form-control-lg @error('password') is-invalid @enderror"
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4 d-flex align-items-center gap-2">
        <input type="checkbox" id="remember" name="remember" class="form-check-input m-0">
        <label for="remember" class="form-label m-0" style="cursor:pointer;">Se souvenir de moi</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Connexion</button>
</form>
@endsection

@section('footer-link')
    Pas encore de compte ?
    <a href="{{ route('member.register') }}" style="color:var(--kyra-cyan);">Créer un compte</a>
@endsection
