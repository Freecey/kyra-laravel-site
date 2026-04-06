<footer class="footer py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <picture>
                <source srcset="{{ asset('images/kyra.webp') }}" type="image/webp">
                <img src="{{ asset('images/kyra.png') }}" alt="" width="40" height="40"
                    class="rounded-0" style="border: 1px solid rgba(0,200,255,0.2);">
            </picture>
            <div>
                <div style="letter-spacing:.28em; font-family: 'Orbitron', ui-monospace, monospace; font-weight:900; font-size:.95rem;">
                    KY<span style="color: var(--kyra-cyan);">RA</span>
                </div>
                <div class="text-muted small" style="letter-spacing:.12em;">Observe · Analyse · Agit</div>
            </div>
        </div>
        <div class="text-muted small">&copy; {{ date('Y') }} Kyra — version publique.</div>
    </div>
</footer>
