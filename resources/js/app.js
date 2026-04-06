import 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.navbar');
    const currentPath = window.location.pathname;

    document.querySelectorAll('.navbar .nav-link').forEach(link => {
        try {
            const href = new URL(link.href).pathname;
            if (href === currentPath) link.classList.add('active');
        } catch (_) {}
    });

    window.addEventListener('scroll', () => {
        if (!navbar) return;
        navbar.style.boxShadow = window.scrollY > 20
            ? '0 16px 40px rgba(0,0,0,0.22)'
            : 'none';
    }, { passive: true });

    document.querySelectorAll('.feature-card, .hero-card, .card').forEach(card => {
        card.style.transition = 'transform .25s ease, box-shadow .25s ease, border-color .25s ease';
    });
});
