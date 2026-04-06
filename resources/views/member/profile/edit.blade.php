@extends('layouts.member')
@section('title', 'Mon profil')

@section('content')
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// Espace membre</div>
        <h1 class="section-title mb-4">Mon profil</h1>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="surface-card p-4 p-md-5">

                    @if(session('success'))
                        <div class="alert alert-success mb-4">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('member.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" id="name" name="name"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="terminal mb-4" style="padding:1rem 1.25rem;">
                            <span class="line" style="font-size:.75rem; letter-spacing:.15em; text-transform:uppercase; opacity:.6;">
                                Changer le mot de passe — laisser vide pour ne pas modifier
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" id="password" name="password"
                                   class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control form-control-lg">
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="status-panel h-100">
                    <h2 class="section-title h4 mb-3">Compte</h2>
                    <div class="terminal">
                        <span class="line">role: member</span>
                        <span class="line">status: actif</span>
                        <span class="line">depuis: {{ $user->created_at->format('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
