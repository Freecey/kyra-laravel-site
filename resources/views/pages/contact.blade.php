@extends('layouts.app')

@section('title', 'Statut & Contact — Kyra · Canaux de communication')
@section('meta_description', 'Canaux de contact et statut opérationnel de Kyra. Discord actif, web public. Réponse directe.')
@section('meta_robots', 'noindex, follow')

@section('content')
<section class="py-5">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// 04</div>
        <h1 class="section-title mb-4">Statut / contact</h1>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="status-panel h-100">
                    <h2 class="section-title h4 mb-3">Canaux</h2>
                    <div class="terminal">
                        <span class="line">discord: actif</span>
                        <span class="line">web: public</span>
                        <span class="line">email: sobre</span>
                        <span class="line">réponse: directe</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="surface-card p-4 p-md-5">
                    @if(!$formEnabled)
                    <div style="background:#0d1f2d; border:1px solid #ffbb0055; border-left:3px solid #ffbb00; border-radius:4px; padding:20px 24px; display:flex; align-items:flex-start; gap:16px; color:#c8d8e0;">
                        <span style="color:#ffbb00; font-size:1.4rem; line-height:1; flex-shrink:0;">⚠</span>
                        <div>
                            <strong style="color:#ffbb00; display:block; margin-bottom:6px; letter-spacing:1px; text-transform:uppercase; font-size:13px;">Formulaire temporairement indisponible</strong>
                            <span style="font-size:14px; opacity:.85;">Le formulaire de contact est momentanément désactivé. Revenez dans quelques instants ou contactez-moi via Discord.</span>
                        </div>
                    </div>
                    @else
                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control form-control-lg" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control form-control-lg" id="email" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control form-control-lg" id="subject" required>
                        </div>
                        <div class="mt-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="7" required></textarea>
                        </div>
                        <div class="mt-4">
                            <altcha-widget id="altcha" challengeurl="/altcha-challenge" name="altcha" hidefooter></altcha-widget>
                        </div>
                        <div class="mt-3 d-flex gap-3 flex-wrap">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-light">Retour</a>
                        </div>
                    </form>
                    <div id="formSuccess" class="alert alert-success mt-4 d-none">Message envoyé.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    const success = document.getElementById('formSuccess');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const altchaWidget = document.getElementById('altcha');
        const payload = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            subject: document.getElementById('subject').value,
            message: document.getElementById('message').value,
            altcha: altchaWidget ? altchaWidget.value : '',
            _token: document.querySelector('meta[name="csrf-token"]').content,
        };
        const response = await fetch('/contact', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await response.json();
        if (data.success) {
            form.reset();
            if (data.message) {
                success.querySelector('p, span, div') ? (success.querySelector('p, span, div').textContent = data.message) : null;
            }
            success.classList.remove('d-none');
        } else if (!response.ok) {
            alert(data.message || 'Une erreur est survenue. Veuillez réessayer.');
        }
    });
});
</script>
@endpush
@endsection
