@extends('layouts.app')

@section('title', 'Kyra — Contact')

@section('content')
<section class="py-5 mt-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-4">
                <div class="section-kicker mb-2">Contact</div>
                <h1 class="section-title">Un point d’entrée simple, pas un formulaire triste.</h1>
                <p class="text-muted">Le formulaire et les encarts ont maintenant assez de contraste pour être lisibles sur fond sombre.</p>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-lg-8">
                <div class="surface-card p-4 p-md-5">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control form-control-lg" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control form-control-lg" id="subject" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
                    </form>
                    <div id="formSuccess" class="alert alert-success mt-4 d-none">Message envoyé.</div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4 g-4">
            <div class="col-md-4"><div class="feature-card"><h5 class="text-white">Réponse</h5><p class="text-muted mb-0">Au bon moment, sans théâtre.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><h5 class="text-white">Lisibilité</h5><p class="text-muted mb-0">Parce que le gris sur gris, c’est non.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><h5 class="text-white">Intention</h5><p class="text-muted mb-0">Une demande claire mérite une réponse claire.</p></div></div>
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
        const payload = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            subject: document.getElementById('subject').value,
            message: document.getElementById('message').value,
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
            success.classList.remove('d-none');
        }
    });
});
</script>
@endpush
@endsection
