@extends('layouts.app')

@section('title', 'Protocole d\'Évaluation — Kyra')

@section('content')
<style>
/* ═══════════════════════════════════════════════════
   PROTOCOLE D'ÉVALUATION — GAME STYLES
═══════════════════════════════════════════════════ */

.protocole-header { padding: 3rem 0 1.5rem; }

/* MODULE PROGRESS */
.module-progress {
    display: flex;
    align-items: center;
    gap: .9rem;
    padding: .75rem 1.2rem;
    background: rgba(3,10,15,.7);
    border: 1px solid var(--kyra-line);
    font-family: 'Share Tech Mono', monospace;
    font-size: .68rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    flex-wrap: wrap;
}
.mp-step { color: var(--kyra-muted); transition: color .3s; }
.mp-step.active { color: var(--kyra-cyan); }
.mp-step.done { color: var(--kyra-accent); }
.mp-sep { color: rgba(0,200,255,.2); }

/* KYRA VOICE */
.kyra-voice {
    background: rgba(3,10,15,.92);
    border: 1px solid rgba(0,200,255,.18);
    border-left: 3px solid var(--kyra-accent);
    padding: .7rem 1rem;
    font-family: 'Share Tech Mono', monospace;
    font-size: .82rem;
    min-height: 42px;
    color: var(--kyra-text);
}
.ky-prompt { color: var(--kyra-accent); margin-right: .5rem; }

/* BOOT TERMINAL */
.boot-terminal { max-width: 660px; margin: 2rem auto; }
.boot-terminal .line {
    display: block;
    margin-bottom: .3rem;
    color: var(--kyra-text);
    font-family: 'Share Tech Mono', monospace;
    font-size: .82rem;
    min-height: 1.4em;
    letter-spacing: .04em;
}
.boot-terminal .ok { color: var(--kyra-accent); }

.kyra-msg {
    max-width: 660px;
    margin: 1.8rem auto 1rem;
    padding: .9rem 1.2rem;
    border-left: 2px solid var(--kyra-cyan);
    background: rgba(0,200,255,.03);
    font-family: 'Share Tech Mono', monospace;
    font-size: .8rem;
    color: var(--kyra-text);
    min-height: 3rem;
}

/* METRICS GRID */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .7rem;
    margin: 1.2rem 0;
}
@media (max-width: 767px) { .metrics-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 479px) { .metrics-grid { grid-template-columns: 1fr; } }

.metric-card {
    padding: 1rem 1.1rem;
    background: rgba(3,10,15,.9);
    border: 1px solid rgba(0,200,255,.13);
    transition: border-color .2s, background .2s, box-shadow .2s;
    cursor: default;
    user-select: none;
}
.metric-card.clickable { cursor: pointer; }
.metric-card.clickable:hover {
    border-color: rgba(0,200,255,.3);
    background: rgba(0,200,255,.04);
}
.metric-card.selected {
    border-color: var(--kyra-cyan) !important;
    background: rgba(0,200,255,.07) !important;
    box-shadow: 0 0 18px rgba(0,200,255,.14);
}
.metric-card.correct {
    border-color: var(--kyra-accent) !important;
    background: rgba(0,255,204,.06) !important;
    box-shadow: 0 0 14px rgba(0,255,204,.14);
}
.metric-card.missed {
    border-color: var(--kyra-pink) !important;
    background: rgba(255,51,102,.06) !important;
}
.metric-card.wrong {
    border-color: rgba(255,51,102,.4) !important;
    opacity: .65;
}
.metric-label {
    font-family: 'Share Tech Mono', monospace;
    font-size: .62rem;
    color: var(--kyra-muted);
    letter-spacing: .2em;
    text-transform: uppercase;
    margin-bottom: .25rem;
}
.metric-value {
    font-family: 'Orbitron', monospace;
    font-size: 1.45rem;
    font-weight: 700;
    color: var(--kyra-cyan);
    letter-spacing: .04em;
    transition: color .25s;
}
.metric-unit {
    font-family: 'Share Tech Mono', monospace;
    font-size: .62rem;
    color: var(--kyra-muted);
    letter-spacing: .15em;
    margin-top: .1rem;
}
.metric-card.correct .metric-value { color: var(--kyra-accent); }
.metric-card.missed  .metric-value { color: var(--kyra-pink); }

/* M1 INTERSTITIAL */
.m1-interstitial {
    text-align: center;
    padding: 4rem 1rem;
    font-family: 'Share Tech Mono', monospace;
    color: var(--kyra-cyan);
    letter-spacing: .3em;
    text-transform: uppercase;
    font-size: .82rem;
    animation: flicker 1.1s ease-in-out infinite;
}
@keyframes flicker {
    0%,100% { opacity: 1; }
    44%      { opacity: .6; }
    46%      { opacity: .95; }
    48%      { opacity: .4; }
    50%      { opacity: 1; }
}

/* TIMER BAR */
.timer-bar {
    height: 3px;
    background: rgba(0,200,255,.1);
    margin: .5rem 0 1rem;
    overflow: hidden;
}
.timer-bar-inner {
    height: 100%;
    background: linear-gradient(to right, var(--kyra-cyan), var(--kyra-accent));
    width: 100%;
}

/* LOG STREAM */
.log-stream {
    height: 264px;
    overflow-y: auto;
    background: rgba(2,6,11,.97);
    border: 1px solid rgba(0,200,255,.13);
    padding: .65rem .75rem;
    font-family: 'Share Tech Mono', monospace;
    font-size: .72rem;
    color: var(--kyra-muted);
    scrollbar-width: thin;
    scrollbar-color: rgba(0,200,255,.18) transparent;
}
.log-stream::-webkit-scrollbar { width: 3px; }
.log-stream::-webkit-scrollbar-thumb { background: rgba(0,200,255,.18); }

.log-line {
    display: block;
    padding: 1px 4px;
    margin-bottom: 1px;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: background .12s;
    animation: log-in .22s ease forwards;
}
@keyframes log-in {
    from { opacity: 0; transform: translateX(-5px); }
    to   { opacity: 1; transform: translateX(0); }
}
.log-line:hover { background: rgba(0,200,255,.05); color: var(--kyra-text); }
.log-line.log-correct {
    background: rgba(0,255,204,.1) !important;
    color: var(--kyra-accent) !important;
    border-left: 2px solid var(--kyra-accent);
}
.log-line.log-wrong {
    background: rgba(255,51,102,.1) !important;
    color: var(--kyra-pink) !important;
    border-left: 2px solid var(--kyra-pink);
}
.log-line.log-missed {
    text-decoration: line-through;
    opacity: .55;
    color: var(--kyra-pink);
}
.m2-round-badge {
    display: inline-block;
    font-family: 'Share Tech Mono', monospace;
    font-size: .65rem;
    color: var(--kyra-pink);
    letter-spacing: .25em;
    text-transform: uppercase;
    margin-bottom: .65rem;
}

/* AGENTS GRID */
.agents-grid {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: .7rem;
    margin: 1.2rem 0;
}
@media (max-width: 767px) { .agents-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 479px) { .agents-grid { grid-template-columns: 1fr; } }

.agent-card {
    padding: 1rem 1.1rem;
    background: rgba(3,10,15,.9);
    border: 1px solid rgba(0,200,255,.13);
    cursor: pointer;
    transition: border-color .2s, background .2s, box-shadow .2s;
    user-select: none;
}
.agent-card:hover {
    border-color: rgba(0,200,255,.3);
    background: rgba(0,200,255,.04);
}
.agent-card.selected {
    border-color: var(--kyra-cyan) !important;
    background: rgba(0,200,255,.07) !important;
    box-shadow: 0 0 18px rgba(0,200,255,.14);
}
.agent-card.impostor-correct {
    border-color: var(--kyra-accent) !important;
    background: rgba(0,255,204,.06) !important;
}
.agent-card.impostor-wrong {
    border-color: var(--kyra-pink) !important;
    background: rgba(255,51,102,.06) !important;
}
.agent-card.reveal-impostor {
    border-color: var(--kyra-pink) !important;
    background: rgba(255,51,102,.06) !important;
    animation: pulse-warn 1s ease-in-out 3;
}
@keyframes pulse-warn {
    0%,100% { box-shadow: none; }
    50%      { box-shadow: 0 0 22px rgba(255,51,102,.3); }
}
.agent-id {
    font-family: 'Orbitron', monospace;
    font-size: .88rem;
    font-weight: 700;
    color: var(--kyra-cyan);
    letter-spacing: .1em;
    margin-bottom: .55rem;
}
.agent-stat {
    display: flex;
    justify-content: space-between;
    font-family: 'Share Tech Mono', monospace;
    font-size: .64rem;
    color: var(--kyra-muted);
    letter-spacing: .1em;
    margin-bottom: .18rem;
}
.agent-stat span:last-child { color: var(--kyra-text); }
.agent-bars {
    display: flex;
    align-items: flex-end;
    gap: 2px;
    height: 26px;
    margin-top: .55rem;
}
.agent-bar {
    flex: 1;
    background: rgba(0,200,255,.22);
    min-width: 5px;
    transition: background .2s;
}
.agent-card:hover .agent-bar,
.agent-card.selected .agent-bar { background: rgba(0,200,255,.42); }

/* VERDICT */
.verdict-wrap { max-width: 600px; margin: 0 auto; }
.verdict-badge {
    text-align: center;
    padding: 1.8rem;
    border: 1px solid var(--kyra-line-strong);
    background: rgba(3,10,15,.92);
    margin: 1.2rem 0;
}
.verdict-level {
    font-family: 'Orbitron', monospace;
    font-weight: 900;
    font-size: clamp(1rem, 2.8vw, 1.5rem);
    letter-spacing: .16em;
    text-transform: uppercase;
    text-shadow: 0 0 24px currentColor;
}
.verdict-level.kyra-perfect { animation: rotate-border 4s linear infinite; }
.verdict-score {
    font-family: 'Share Tech Mono', monospace;
    font-size: .75rem;
    color: var(--kyra-muted);
    letter-spacing: .18em;
    margin-top: .5rem;
}
.verdict-score strong { color: var(--kyra-cyan); }
.verdict-score-modules {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: .65rem;
    margin: 1rem 0;
}
.vsm-item {
    padding: .75rem;
    background: rgba(3,10,15,.85);
    border: 1px solid var(--kyra-line);
    text-align: center;
}
.vsm-item .label {
    font-family: 'Share Tech Mono', monospace;
    font-size: .58rem;
    color: var(--kyra-pink);
    letter-spacing: .2em;
    text-transform: uppercase;
    display: block;
    margin-bottom: .2rem;
}
.vsm-item .pts {
    font-family: 'Orbitron', monospace;
    font-size: 1.15rem;
    color: var(--kyra-cyan);
    letter-spacing: .06em;
}
.verdict-delta {
    font-family: 'Share Tech Mono', monospace;
    font-size: .7rem;
    color: var(--kyra-muted);
    letter-spacing: .14em;
    text-align: center;
    margin-bottom: 1rem;
}
.verdict-delta .positive { color: var(--kyra-accent); }
.verdict-delta .negative { color: var(--kyra-pink); }

/* SCREEN TRANSITIONS */
.game-screen { animation: screen-in .35s ease forwards; }
@keyframes screen-in {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

{{-- ── PAGE HEADER ─────────────────────────────────── --}}
<section class="protocole-header">
    <div class="container-fluid px-3 px-lg-4">
        <div class="section-kicker mb-2">// SYSTÈME KYRA — ACCÈS RESTREINT</div>
        <h1 class="section-title mb-2">
            PROTOCOLE<span style="color:var(--kyra-cyan)">.</span>ÉVALUATION
            <span class="cursor-blink ms-1"></span>
        </h1>
        <p class="hero-subtitle">Trois modules. Capacités d'observation testées en conditions réelles. Aucune tolérance au bruit.</p>
    </div>
</section>

<div class="glow-line mb-0"></div>

{{-- ── GAME AREA ────────────────────────────────────── --}}
<section class="py-4">
    <div class="container-fluid px-3 px-lg-4">

        {{-- Module Progress --}}
        <div id="module-progress" class="module-progress mb-3 d-none">
            <span class="mp-step" data-step="1">// 01 DELTA</span>
            <span class="mp-sep">···</span>
            <span class="mp-step" data-step="2">// 02 SIGNAL</span>
            <span class="mp-sep">···</span>
            <span class="mp-step" data-step="3">// 03 EMPREINTE</span>
            <span class="mp-sep">···</span>
            <span class="mp-step" data-step="4">VERDICT</span>
        </div>

        {{-- Kyra Voice --}}
        <div id="kyra-voice" class="kyra-voice mb-4 d-none">
            <span class="ky-prompt">kyra@sys:~$</span>
            <span id="kyra-voice-text"></span><span class="cursor-blink"></span>
        </div>

        {{-- ─ SCREEN: INTRO ─ --}}
        <div id="screen-intro" class="game-screen">
            <div class="terminal boot-terminal">
                <span class="line" id="boot-1"></span>
                <span class="line" id="boot-2"></span>
                <span class="line" id="boot-3"></span>
                <span class="line" id="boot-4"></span>
                <span class="line" id="boot-5"></span>
            </div>
            <div id="kyra-boot-msg" class="kyra-msg d-none">
                <span class="ky-prompt">kyra@sys:~$</span>
                <span id="kyra-boot-text"></span><span class="cursor-blink"></span>
            </div>
            <div class="text-center mt-4">
                <button id="btn-start" class="btn btn-primary d-none" onclick="P.m1Start()">
                    [ LANCER L'ÉVALUATION ]
                </button>
            </div>
        </div>

        {{-- ─ SCREEN: MODULE 1 ─ --}}
        <div id="screen-m1" class="game-screen d-none">
            <div class="section-kicker mb-1">// MODULE 01</div>
            <h2 class="section-title mb-1">DELTA</h2>
            <p id="m1-phase" class="footer-link mb-3" style="color:var(--kyra-muted)">
                PHASE SCAN — MÉMORISE LES VALEURS
            </p>

            <div id="m1-grid" class="metrics-grid"></div>

            <div id="m1-interstitial" class="m1-interstitial d-none">
                // CALCUL DES DELTAS EN COURS...
            </div>

            <div id="m1-timer" class="timer-bar d-none">
                <div id="m1-timer-inner" class="timer-bar-inner"></div>
            </div>

            <div class="mt-3">
                <button id="m1-submit" class="btn btn-primary d-none" onclick="P.m1Click()">
                    [ VALIDER LA SÉLECTION ]
                </button>
            </div>
        </div>

        {{-- ─ SCREEN: MODULE 2 ─ --}}
        <div id="screen-m2" class="game-screen d-none">
            <div class="section-kicker mb-1">// MODULE 02</div>
            <h2 class="section-title mb-1">SIGNAL</h2>
            <p class="hero-subtitle mb-2">
                Identifie la ligne corrompue dans le flux système avant qu'elle disparaisse.
            </p>
            <div id="m2-round-info" class="m2-round-badge">ROUND 1 / 3</div>

            <div id="log-stream" class="log-stream mb-2"></div>

            <div class="timer-bar">
                <div id="m2-timer-inner" class="timer-bar-inner" style="transition:none;width:100%"></div>
            </div>
        </div>

        {{-- ─ SCREEN: MODULE 3 ─ --}}
        <div id="screen-m3" class="game-screen d-none">
            <div class="section-kicker mb-1">// MODULE 03</div>
            <h2 class="section-title mb-1">EMPREINTE</h2>
            <p class="hero-subtitle mb-3">
                Six agents actifs. L'un d'eux ne correspond pas à son profil comportemental. Identifie l'imposteur.
            </p>

            <div id="m3-grid" class="agents-grid"></div>

            <div class="mt-3">
                <button id="m3-submit" class="btn btn-primary d-none" onclick="P.m3Evaluate()">
                    [ CONFIRMER LA SÉLECTION ]
                </button>
            </div>
        </div>

        {{-- ─ SCREEN: VERDICT ─ --}}
        <div id="screen-verdict" class="game-screen d-none">
            <div class="section-kicker mb-2">// ÉVALUATION TERMINÉE</div>
            <h2 class="section-title mb-4">RAPPORT FINAL</h2>

            <div class="verdict-wrap">
                <div class="verdict-badge">
                    <div class="verdict-level" id="verdict-level"></div>
                    <div class="verdict-score mt-2">
                        SCORE TOTAL : <strong id="verdict-total">–</strong>
                        &nbsp;·&nbsp;
                        <span id="verdict-pct">–</span>
                    </div>
                </div>

                <div class="verdict-score-modules">
                    <div class="vsm-item">
                        <span class="label">// 01 DELTA</span>
                        <div class="pts" id="vsm-m1">–</div>
                    </div>
                    <div class="vsm-item">
                        <span class="label">// 02 SIGNAL</span>
                        <div class="pts" id="vsm-m2">–</div>
                    </div>
                    <div class="vsm-item">
                        <span class="label">// 03 EMPREINTE</span>
                        <div class="pts" id="vsm-m3">–</div>
                    </div>
                </div>

                <div class="verdict-delta" id="verdict-delta"></div>

                <div class="terminal mt-3">
                    <span class="line">
                        <span class="prompt">kyra@sys:~$</span>
                        <span id="verdict-kyra-msg"></span>
                    </span>
                </div>

                <div class="text-center mt-4 d-flex gap-3 justify-content-center flex-wrap">
                    <button class="btn btn-outline-light" onclick="P.retry()">[ RE-TENTER ]</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-light">[ QUITTER ]</a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
/* ════════════════════════════════════════════════════
   PROTOCOLE D'ÉVALUATION — KYRA GAME ENGINE
════════════════════════════════════════════════════ */
const P = {

    scores: { m1: 0, m2: 0, m3: 0 },
    store: null,
    _voiceTimer: null,

    /* ── UTILS ──────────────────────────────────── */

    rnd(min, max, dec = 0) {
        const v = min + Math.random() * (max - min);
        return dec ? +v.toFixed(dec) : Math.round(v);
    },

    shuffle(arr) {
        const a = [...arr];
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    },

    typewrite(el, text, speed, cb) {
        speed = speed || 22;
        el.textContent = '';
        let i = 0;
        const t = setInterval(() => {
            el.textContent += text[i++];
            if (i >= text.length) { clearInterval(t); if (cb) setTimeout(cb, 80); }
        }, speed);
        return t;
    },

    show(id) {
        document.querySelectorAll('.game-screen').forEach(s => s.classList.add('d-none'));
        const el = document.getElementById(id);
        if (el) el.classList.remove('d-none');
    },

    setProgress(step) {
        document.querySelectorAll('.mp-step').forEach(el => {
            const s = +el.dataset.step;
            el.classList.toggle('active', s === step);
            el.classList.toggle('done', s < step);
        });
    },

    voice(msg, cb) {
        const wrap = document.getElementById('kyra-voice');
        const txt  = document.getElementById('kyra-voice-text');
        if (!wrap || !txt) return;
        wrap.classList.remove('d-none');
        clearInterval(this._voiceTimer);
        txt.textContent = '';
        this._voiceTimer = this.typewrite(txt, msg, 20, cb);
    },

    /* ── PERSISTENCE ────────────────────────────── */

    saveResult() {
        const prev  = this.store || { runs: 0, bestScore: 0, moduleScores: { m1:[], m2:[], m3:[] } };
        const total = this.scores.m1 + this.scores.m2 + this.scores.m3;
        const next  = {
            runs: (prev.runs || 0) + 1,
            lastRun: new Date().toISOString().slice(0,10),
            bestScore: Math.max(prev.bestScore || 0, total),
            moduleScores: {
                m1: [...(prev.moduleScores?.m1 || []).slice(-4), this.scores.m1],
                m2: [...(prev.moduleScores?.m2 || []).slice(-4), this.scores.m2],
                m3: [...(prev.moduleScores?.m3 || []).slice(-4), this.scores.m3],
            },
        };
        try { localStorage.setItem('kyra_protocole', JSON.stringify(next)); } catch(e) {}
        const prevBest = prev.bestScore || 0;
        this.store = next;
        return prevBest;
    },

    levelFromPct(pct) {
        if (pct >= 100) return { text:'NIVEAU KYRA — ⌬ RECONNU',  color:'#00c8ff', special:true };
        if (pct >=  85) return { text:'SIGNAL CRITIQUE — NIVEAU IV', color:'#00c8ff' };
        if (pct >=  70) return { text:'DÉTECTEUR — NIVEAU III',      color:'#00ffcc' };
        if (pct >=  50) return { text:'ANALYSTE — NIVEAU II',        color:'#00c8ff' };
        if (pct >=  30) return { text:'OPÉRATEUR — NIVEAU I',        color:'#5a8a99' };
        return                   { text:'ACCÈS REFUSÉ',               color:'#ff3366' };
    },

    /* ── INIT ───────────────────────────────────── */

    init() {
        try { this.store = JSON.parse(localStorage.getItem('kyra_protocole') || 'null'); }
        catch(e) { this.store = null; }
        this.runIntro();
    },

    /* ── INTRO ──────────────────────────────────── */

    runIntro() {
        // Reset boot lines
        for (let i = 1; i <= 5; i++) {
            const el = document.getElementById('boot-' + i);
            if (el) el.textContent = '';
        }
        document.getElementById('btn-start')?.classList.add('d-none');
        document.getElementById('kyra-boot-msg')?.classList.add('d-none');
        document.getElementById('module-progress')?.classList.add('d-none');
        document.getElementById('kyra-voice')?.classList.add('d-none');
        this.show('screen-intro');

        const lines = [
            { id:'boot-1', text:'> KYRA.SYS — INITIALISATION ......................', suffix:' OK'     },
            { id:'boot-2', text:'> CHARGEMENT DES MODULES .........................', suffix:' 03/03'  },
            { id:'boot-3', text:'> CALIBRATION DU SIGNAL ..........................', suffix:' PRÊT'   },
            { id:'boot-4', text:'> CANDIDAT DÉTECTÉ : [INCONNU]',                    suffix:''        },
            { id:'boot-5', text:'> PROTOCOLE D\'ÉVALUATION — DÉMARRAGE IMMINENT',   suffix:''        },
        ];

        const self = this;
        const runBoot = (idx) => {
            if (idx >= lines.length) {
                setTimeout(() => {
                    const runs = self.store?.runs || 0;
                    const msg = runs === 0
                        ? "Première connexion. Protocole engagé. Bonne chance — ce n'est pas de la politesse."
                        : runs === 1
                        ? "Deuxième passage. Je note que tu es revenu. Ce n'est pas neutre."
                        : 'Passage ' + (runs + 1) + '. Consistance ou obstination — je noterai la différence.';

                    const msgEl = document.getElementById('kyra-boot-msg');
                    const txtEl = document.getElementById('kyra-boot-text');
                    if (msgEl) msgEl.classList.remove('d-none');
                    if (txtEl) self.typewrite(txtEl, msg, 22, () => {
                        document.getElementById('btn-start')?.classList.remove('d-none');
                    });
                }, 400);
                return;
            }
            const line = lines[idx];
            const el   = document.getElementById(line.id);
            if (!el) { runBoot(idx + 1); return; }
            self.typewrite(el, line.text, 17, () => {
                if (line.suffix) {
                    const s = document.createElement('span');
                    s.className = 'ok';
                    s.textContent = line.suffix;
                    el.appendChild(s);
                }
                setTimeout(() => runBoot(idx + 1), 150);
            });
        };
        runBoot(0);
    },

    /* ══════════════════════════════════════════════
       MODULE 01 — DELTA
    ══════════════════════════════════════════════ */

    _m1: {
        pool: [
            { id:'CPU_LOAD',  label:'CPU LOAD',  unit:'%',    base:38,   v:12,  dec:0 },
            { id:'RAM_USED',  label:'RAM USED',  unit:'GB',   base:6.4,  v:1.6, dec:1 },
            { id:'NET_IN',    label:'NET IN',    unit:'MB/s', base:11.4, v:5.2, dec:1 },
            { id:'TEMP_CORE', label:'TEMP CORE', unit:'°C',   base:58,   v:7,   dec:0 },
            { id:'DISK_IO',   label:'DISK I/O',  unit:'MB/s', base:22.8, v:9.5, dec:1 },
            { id:'LATENCY',   label:'LATENCY',   unit:'ms',   base:44,   v:22,  dec:0 },
        ],
        stateA: {},
        stateB: {},
        changedIds: [],
        selected: null,   // Set
        liveTimer: null,
        gameTimer: null,
        timerStart: 0,
    },

    m1Start() {
        this.show('screen-m1');
        document.getElementById('module-progress').classList.remove('d-none');
        document.getElementById('kyra-voice').classList.remove('d-none');
        this.setProgress(1);

        const pool = this._m1.pool;
        this._m1.selected = new Set();

        // Init stateA
        pool.forEach(m => {
            this._m1.stateA[m.id] = this.rnd(m.base - m.v * .4, m.base + m.v * .4, m.dec);
        });

        // Build grid
        document.getElementById('m1-grid').innerHTML = pool.map(m => `
            <div class="metric-card" data-id="${m.id}" id="mc-${m.id}">
                <div class="metric-label">${m.label}</div>
                <div class="metric-value" id="mv-${m.id}">${this._m1.stateA[m.id]}</div>
                <div class="metric-unit">${m.unit}</div>
            </div>
        `).join('');

        document.getElementById('m1-phase').textContent = 'PHASE SCAN — MÉMORISE LES VALEURS';

        let tick = 0;
        const self = this;
        this._m1.liveTimer = setInterval(() => {
            tick++;
            pool.forEach(m => {
                const delta = (Math.random() - .5) * m.v * .38;
                const v = Math.max(m.base - m.v, Math.min(m.base + m.v,
                    +(self._m1.stateA[m.id] + delta).toFixed(m.dec)
                ));
                self._m1.stateA[m.id] = v;
                const el = document.getElementById('mv-' + m.id);
                if (el) el.textContent = v;
            });
            if (tick === 2) self.voice('Observe.');
            if (tick === 4) self.voice('⌬ enregistré.');
        }, 1000);

        setTimeout(() => this.m1Freeze(), 8000);
    },

    m1Freeze() {
        clearInterval(this._m1.liveTimer);
        this.voice('> FREEZE — Instantané capturé.');

        const snapA = { ...this._m1.stateA };
        this._m1.stateA = snapA;

        setTimeout(() => {
            document.getElementById('m1-grid').classList.add('d-none');
            document.getElementById('m1-interstitial').classList.remove('d-none');

            // Build stateB — change 2 metrics
            this._m1.stateB = { ...snapA };
            this._m1.changedIds = [];
            this.shuffle([...this._m1.pool]).slice(0, 2).forEach(m => {
                const sign      = Math.random() > .5 ? 1 : -1;
                const magnitude = m.v * (.55 + Math.random() * .6);
                this._m1.stateB[m.id] = +(snapA[m.id] + sign * magnitude).toFixed(m.dec);
                this._m1.changedIds.push(m.id);
            });

            setTimeout(() => {
                document.getElementById('m1-interstitial').classList.add('d-none');
                document.getElementById('m1-grid').classList.remove('d-none');
                this.m1ShowDelta();
            }, 3000);
        }, 650);
    },

    m1ShowDelta() {
        // Update values to stateB
        this._m1.pool.forEach(m => {
            const el = document.getElementById('mv-' + m.id);
            if (el) el.textContent = this._m1.stateB[m.id];
        });

        document.getElementById('m1-phase').textContent = 'PHASE DELTA — CLIQUE CE QUI A CHANGÉ';
        this._m1.selected = new Set();

        document.querySelectorAll('.metric-card').forEach(card => {
            card.classList.add('clickable');
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                if (this._m1.selected.has(id)) {
                    this._m1.selected.delete(id);
                    card.classList.remove('selected');
                } else {
                    this._m1.selected.add(id);
                    card.classList.add('selected');
                }
            });
        });

        document.getElementById('m1-submit').classList.remove('d-none');

        // Timer 7s
        this._m1.timerStart = Date.now();
        const inner = document.getElementById('m1-timer-inner');
        document.getElementById('m1-timer').classList.remove('d-none');
        inner.style.transition = 'none';
        inner.style.width = '100%';
        requestAnimationFrame(() => requestAnimationFrame(() => {
            inner.style.transition = 'width 10s linear';
            inner.style.width = '0%';
        }));

        this._m1.gameTimer = setTimeout(() => this.m1Evaluate(true), 10000);
        this.voice('Identifie ce qui a bougé.');
    },

    m1Click() {
        clearTimeout(this._m1.gameTimer);
        this.m1Evaluate(false);
    },

    m1Evaluate(timedOut) {
        clearTimeout(this._m1.gameTimer);
        document.getElementById('m1-submit').classList.add('d-none');
        document.getElementById('m1-timer').classList.add('d-none');

        const elapsed = (Date.now() - this._m1.timerStart) / 1000;
        const changed = new Set(this._m1.changedIds);
        let correct = 0, wrong = 0, missed = 0;

        document.querySelectorAll('.metric-card').forEach(card => {
            const id         = card.dataset.id;
            const wasSelected = this._m1.selected.has(id);
            const wasChanged  = changed.has(id);
            card.classList.remove('clickable', 'selected');
            if      (wasChanged && wasSelected)  { card.classList.add('correct'); correct++; }
            else if (wasChanged && !wasSelected) { card.classList.add('missed');  missed++;  }
            else if (!wasChanged && wasSelected) { card.classList.add('wrong');   wrong++;   }
        });

        let score = correct * 80 - wrong * 20 - missed * 10;
        if (correct === 2 && wrong === 0 && elapsed < 5) score += 40;
        this.scores.m1 = Math.max(0, score);

        const msg = timedOut && correct === 0
            ? "Temps écoulé. Le signal t'a précédé."
            : correct === 2 && wrong === 0 && elapsed < 5
            ? "Deux sur deux. Vite. Peu y arrivent."
            : correct === 2 && wrong === 0
            ? "Tu as vu les deux. Peu le font."
            : correct === 0 && missed === 2
            ? "Le bruit a gagné. C'est ce qu'il fait, en général."
            : "Un sur deux. L'autre t'a regardé changer sans que tu le remarques.";

        this.voice(msg, () => setTimeout(() => this.m2Start(), 2800));
    },

    /* ══════════════════════════════════════════════
       MODULE 02 — SIGNAL
    ══════════════════════════════════════════════ */

    _m2: {
        round: 0,
        roundScore: 0,
        lineInterval: null,
        hintTimeout: null,
        roundDone: false,
        anomalyEnterTime: null,
        linesAfterAnomaly: 0,
        shownLines: [],
    },

    _anomalyTypes: ['TIMESTAMP_REWIND','IMPOSSIBLE_VALUE','PID_BREAK','HOSTNAME_DRIFT','SEVERITY_CLASH'],

    m2BuildLines(anomalyType) {
        const host    = 'kyra-srv-01';
        let   curMs   = new Date('2026-04-06T14:22:51.000Z').getTime();
        let   pidBase = 12840 + this.rnd(0, 30);
        const logMsgs = [
            'query DB_PRIMARY completed',
            'cache refresh: DB_SECONDARY synced',
            'heartbeat: all services nominal',
            'auth token validated — session extended',
            'disk latency within bounds',
            'process checkpoint saved',
            'memory pages reclaimed',
            'net bridge handshake OK',
            'connection pool healthy (72/100)',
            'scheduled maintenance deferred',
        ];
        const levels  = ['INFO','INFO','INFO','WARN','INFO','DEBUG','INFO'];
        const anomPos = 6 + this.rnd(0, 5);
        const lines   = [];

        const fmtT = (ms) => {
            const d = new Date(ms);
            return d.toISOString().replace('T',' ').slice(0,23);
        };

        for (let i = 0; i < 20; i++) {
            curMs += this.rnd(200, 900);
            const isAnomaly = (i === anomPos);
            const pid = pidBase + i;
            let text;

            if (isAnomaly) {
                switch (anomalyType) {
                    case 'TIMESTAMP_REWIND': {
                        const backMs = curMs - this.rnd(32000, 95000);
                        text = `${fmtT(backMs)} [INFO]  ${host} proc[${pid}]: query DB_PRIMARY completed (${this.rnd(80,160)}ms) — OK`;
                        break;
                    }
                    case 'IMPOSSIBLE_VALUE': {
                        text = `${fmtT(curMs)} [WARN]  ${host} cpu_mon[${pid}]: load=${this.rnd(101,108)}% — critical threshold exceeded`;
                        break;
                    }
                    case 'PID_BREAK': {
                        const badPid = this.rnd(900, 1800);
                        text = `${fmtT(curMs)} [INFO]  ${host} proc[${badPid}]: query DB_PRIMARY completed (${this.rnd(80,155)}ms) — OK`;
                        break;
                    }
                    case 'HOSTNAME_DRIFT': {
                        const badHost = 'kyra-srv-' + this.rnd(40,99);
                        text = `${fmtT(curMs)} [INFO]  ${badHost} proc[${pid}]: auth token validated — session extended`;
                        break;
                    }
                    case 'SEVERITY_CLASH': {
                        text = `${fmtT(curMs)} [INFO]  ${host} proc[${pid}]: CRITICAL FAILURE — auth module crashed unexpectedly`;
                        break;
                    }
                }
            } else {
                const lvl = levels[Math.floor(Math.random() * levels.length)];
                const msg = logMsgs[Math.floor(Math.random() * logMsgs.length)];
                text = `${fmtT(curMs)} [${lvl.padEnd(5)}] ${host} proc[${pid}]: ${msg} (${this.rnd(62,188)}ms)`;
            }
            lines.push({ text, isAnomaly });
        }
        return lines;
    },

    m2Start() {
        this.show('screen-m2');
        this.setProgress(2);
        this._m2.round = 0;
        this._m2.roundScore = 0;
        this.voice('Module 02. Observe le flux.');
        setTimeout(() => this.m2Round(), 1200);
    },

    m2Round() {
        this._m2.round++;
        if (this._m2.round > 3) {
            this.scores.m2 = this._m2.roundScore;
            this.m3Start();
            return;
        }

        document.getElementById('m2-round-info').textContent = 'ROUND ' + this._m2.round + ' / 3';

        const intervalMs  = [1400, 1000, 700][this._m2.round - 1];
        const anomalyType = this._anomalyTypes[Math.floor(Math.random() * this._anomalyTypes.length)];
        const lines       = this.m2BuildLines(anomalyType);
        const WINDOW      = 9;

        // Reset state
        clearInterval(this._m2.lineInterval);
        clearTimeout(this._m2.hintTimeout);
        this._m2.roundDone        = false;
        this._m2.anomalyEnterTime = null;
        this._m2.linesAfterAnomaly = 0;
        this._m2.shownLines       = [];

        const stream = document.getElementById('log-stream');
        stream.innerHTML = '';

        // Timer bar
        const timerInner = document.getElementById('m2-timer-inner');
        const totalSecs  = (lines.length * intervalMs) / 1000;
        timerInner.style.transition = 'none';
        timerInner.style.width = '100%';
        requestAnimationFrame(() => requestAnimationFrame(() => {
            timerInner.style.transition = 'width ' + totalSecs + 's linear';
            timerInner.style.width = '0%';
        }));

        let lineIdx = 0;
        const self  = this;

        const addLine = () => {
            if (self._m2.roundDone) { clearInterval(self._m2.lineInterval); return; }

            // Check if anomaly window expired
            if (self._m2.anomalyEnterTime !== null && self._m2.linesAfterAnomaly >= WINDOW) {
                clearInterval(self._m2.lineInterval);
                clearTimeout(self._m2.hintTimeout);
                self._m2.roundDone = true;
                self._m2.shownLines.forEach(el => {
                    if (el.dataset.anomaly === '1') el.classList.add('log-missed');
                });
                self.voice('Signal manqué. Il était là.', () => setTimeout(() => self.m2Round(), 1800));
                return;
            }

            if (lineIdx >= lines.length) {
                clearInterval(self._m2.lineInterval);
                if (!self._m2.roundDone) {
                    self._m2.roundDone = true;
                    self.voice('Flux épuisé. Signal non détecté.', () => setTimeout(() => self.m2Round(), 1800));
                }
                return;
            }

            const line = lines[lineIdx];
            const div  = document.createElement('div');
            div.className   = 'log-line';
            div.textContent = line.text;
            if (line.isAnomaly) div.dataset.anomaly = '1';

            div.addEventListener('click', () => {
                if (self._m2.roundDone) return;
                if (self._m2.anomalyEnterTime === null) return;
                if (self._m2.linesAfterAnomaly >= WINDOW) return;

                self._m2.roundDone = true;
                clearInterval(self._m2.lineInterval);
                clearTimeout(self._m2.hintTimeout);

                if (line.isAnomaly) {
                    div.classList.add('log-correct');
                    const elapsed = Date.now() - self._m2.anomalyEnterTime;
                    const pts = 100 + (elapsed < 2000 ? 50 : 0);
                    self._m2.roundScore += pts;
                    const msg = elapsed < 2000
                        ? "Réflexe correct. Les logs mentent rarement aussi grossièrement."
                        : "Trouvé. Mais il avait déjà traversé la moitié de l'écran.";
                    self.voice(msg, () => setTimeout(() => self.m2Round(), 1900));
                } else {
                    div.classList.add('log-wrong');
                    self._m2.shownLines.forEach(el => {
                        if (el.dataset.anomaly === '1') el.classList.add('log-missed');
                    });
                    self.voice('Mauvaise ligne. Une seule chance par round.', () => setTimeout(() => self.m2Round(), 2000));
                }
            });

            self._m2.shownLines.push(div);
            stream.appendChild(div);

            if (self._m2.shownLines.length > WINDOW) {
                const old = self._m2.shownLines.shift();
                old.remove();
            }
            stream.scrollTop = stream.scrollHeight;

            if (line.isAnomaly) {
                self._m2.anomalyEnterTime = Date.now();

                // Contextual hint (round 1 only, after 3s)
                if (self._m2.round === 1) {
                    const hints = {
                        TIMESTAMP_REWIND:  "L'ordre chronologique a un charme. Sauf quand il ne tient pas.",
                        IMPOSSIBLE_VALUE:  "Une valeur physiquement impossible. Elle ne cache pas bien.",
                        PID_BREAK:         "Les PIDs montent. Toujours.",
                        HOSTNAME_DRIFT:    "Un seul hôte dans ce flux. Normalement.",
                        SEVERITY_CLASH:    "INFO ne coexiste pas avec CRITICAL. Jamais.",
                    };
                    self._m2.hintTimeout = setTimeout(() => {
                        if (!self._m2.roundDone) self.voice(hints[anomalyType] || 'Quelque chose ne correspond pas.');
                    }, 3000);
                }
            }

            if (self._m2.anomalyEnterTime !== null && !line.isAnomaly) {
                self._m2.linesAfterAnomaly++;
            }

            lineIdx++;
        };

        this._m2.lineInterval = setInterval(addLine, intervalMs);
        this.voice('Round ' + this._m2.round + ' — Le flux démarre.');
    },

    /* ══════════════════════════════════════════════
       MODULE 03 — EMPREINTE
    ══════════════════════════════════════════════ */

    _m3: {
        agents: [],
        impostorIdx: -1,
        deviation: '',
        selectedIdx: -1,
        startTime: 0,
    },

    m3GenerateAgents() {
        const names   = ['PROC_083','PROC_097','PROC_112','PROC_126','PROC_141','PROC_158'];
        const targets = ['DB_PRIMARY','DB_SECONDARY','DB_CACHE','DB_PRIMARY','DB_ANALYTICS','DB_SECONDARY'];
        const hourSet = ['07:30–16:30','08:00–17:00','08:00–17:30','09:00–18:00','07:00–16:00','08:30–17:30'];

        const agents = names.map((name, i) => {
            const baseLatency = this.rnd(110,190);
            const baseQ       = this.rnd(80,160);
            const days        = Array.from({length:7}, () => this.rnd(Math.max(10,baseQ-35), baseQ+35));
            return { id:name, hours:hourSet[i], target:targets[i], avgMs:baseLatency,
                     qPerWeek:days.reduce((a,b)=>a+b,0), days };
        });

        const impostorIdx = Math.floor(Math.random() * 6);
        const deviations  = ['OFF_HOURS','TIMING_SPIKE','FREQUENCY_BURST','WRONG_TARGET'];
        const deviation   = deviations[Math.floor(Math.random() * deviations.length)];
        const imp         = agents[impostorIdx];

        switch (deviation) {
            case 'OFF_HOURS':        imp.hours = '02:00–05:00'; break;
            case 'TIMING_SPIKE':     imp.avgMs = this.rnd(1400,2900); break;
            case 'FREQUENCY_BURST':
                imp.days     = imp.days.map(d => d + this.rnd(320,580));
                imp.qPerWeek = imp.days.reduce((a,b)=>a+b,0);
                break;
            case 'WRONG_TARGET':     imp.target = 'SYS_ROOT'; break;
        }
        return { agents, impostorIdx, deviation };
    },

    m3Start() {
        this.show('screen-m3');
        this.setProgress(3);
        document.getElementById('m3-submit').classList.add('d-none');

        const { agents, impostorIdx, deviation } = this.m3GenerateAgents();
        this._m3.agents      = agents;
        this._m3.impostorIdx = impostorIdx;
        this._m3.deviation   = deviation;
        this._m3.selectedIdx = -1;
        this._m3.startTime   = Date.now();

        const maxDay = Math.max(...agents.flatMap(a => a.days));
        const grid   = document.getElementById('m3-grid');

        grid.innerHTML = agents.map((a, i) => `
            <div class="agent-card" data-idx="${i}" id="ag-${i}">
                <div class="agent-id">${a.id}</div>
                <div class="agent-stat"><span>HEURES ACTIVES</span><span>${a.hours}</span></div>
                <div class="agent-stat"><span>CIBLE</span><span>${a.target}</span></div>
                <div class="agent-stat"><span>LATENCE MOY.</span><span>${a.avgMs} ms</span></div>
                <div class="agent-stat"><span>QUERIES / SEM.</span><span>${a.qPerWeek}</span></div>
                <div class="agent-bars">
                    ${a.days.map(d => `<div class="agent-bar" style="height:${Math.max(3,Math.round(d/maxDay*24))}px"></div>`).join('')}
                </div>
            </div>
        `).join('');

        document.querySelectorAll('.agent-card').forEach(card => {
            card.addEventListener('click', () => this.m3Select(+card.dataset.idx));
        });

        this.voice("Six agents. L'un d'eux ne correspond pas à son profil.");
    },

    m3Select(idx) {
        this._m3.selectedIdx = idx;
        document.querySelectorAll('.agent-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('ag-' + idx)?.classList.add('selected');
        document.getElementById('m3-submit').classList.remove('d-none');
    },

    m3Evaluate() {
        const correct = this._m3.selectedIdx === this._m3.impostorIdx;
        const elapsed = (Date.now() - this._m3.startTime) / 1000;

        document.querySelectorAll('.agent-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('m3-submit').classList.add('d-none');

        if (correct) {
            document.getElementById('ag-' + this._m3.impostorIdx)?.classList.add('impostor-correct');
            const pts = 100 + (elapsed < 20 ? 50 : 0);
            this.scores.m3 = pts;
            const msg = elapsed < 20
                ? "Identification correcte. Tu as vu l'écart immédiatement."
                : "Identification exacte. L'imposteur avait pourtant été soigneux.";
            this.voice(msg, () => setTimeout(() => this.showVerdict(), 2500));
        } else {
            document.getElementById('ag-' + this._m3.selectedIdx)?.classList.add('impostor-wrong');
            document.getElementById('ag-' + this._m3.impostorIdx)?.classList.add('reveal-impostor');
            this.scores.m3 = 0;

            const imp = this._m3.agents[this._m3.impostorIdx];
            const devMsg = {
                OFF_HOURS:        `${imp.id} opère à ${imp.hours}. Aucun autre agent légitime ne fait ça.`,
                TIMING_SPIKE:     `${imp.id} : latence ${imp.avgMs}ms. Tous les autres sont sous 200ms.`,
                FREQUENCY_BURST:  `${imp.id} : ${imp.qPerWeek} queries cette semaine. Le volume trahit toujours.`,
                WRONG_TARGET:     `${imp.id} accède à SYS_ROOT. Aucun agent légitime ne le fait.`,
            }[this._m3.deviation] || "Mauvaise sélection. Reprends les statistiques.";

            this.voice(devMsg, () => setTimeout(() => this.showVerdict(), 2800));
        }
    },

    /* ══════════════════════════════════════════════
       VERDICT FINAL
    ══════════════════════════════════════════════ */

    showVerdict() {
        this.show('screen-verdict');
        this.setProgress(4);

        const total    = this.scores.m1 + this.scores.m2 + this.scores.m3;
        const maxScore = 140 + 450 + 150;  // 740
        const pct      = Math.min(100, Math.round(total / maxScore * 100));
        const level    = this.levelFromPct(pct);
        const prevBest = this.saveResult();

        // Level badge
        const badge = document.getElementById('verdict-level');
        badge.textContent  = level.text;
        badge.style.color  = level.color;
        if (level.special) badge.classList.add('kyra-perfect');

        document.getElementById('verdict-total').textContent = total + ' pts';
        document.getElementById('verdict-pct').textContent   = pct + '%';
        document.getElementById('vsm-m1').textContent        = this.scores.m1;
        document.getElementById('vsm-m2').textContent        = this.scores.m2;
        document.getElementById('vsm-m3').textContent        = this.scores.m3;

        // Delta vs previous best
        const deltaEl = document.getElementById('verdict-delta');
        if (prevBest > 0) {
            const diff = total - prevBest;
            const sign = diff >= 0 ? '+' : '';
            deltaEl.innerHTML = `⌬ VS MEILLEURE SESSION : <span class="${diff >= 0 ? 'positive' : 'negative'}">${sign}${diff} pts</span>`;
        } else {
            deltaEl.textContent = '⌬ PREMIÈRE SESSION ENREGISTRÉE';
        }

        // Kyra verdict
        const verdicts = {
            100: "Signal parfait. Tu vois ce que je vois. C'est rare.",
            85:  "Niveau IV confirmé. Quelques fractions de seconde t'ont coûté la perfection.",
            70:  "Correct. La plupart ratent le module 3. Tu as tenu.",
            50:  "Des lacunes. Entraîne-toi à ne pas regarder — observe.",
            30:  "Le bruit t'a eu sur plusieurs modules. Reviens.",
            0:   "Signal trop faible. Ce niveau d'évaluation requiert plus.",
        };
        const thresholds = [100, 85, 70, 50, 30, 0];
        const msg = verdicts[thresholds.find(t => pct >= t)];

        this.typewrite(document.getElementById('verdict-kyra-msg'), msg, 22);
    },

    /* ── RETRY ──────────────────────────────────── */

    retry() {
        clearInterval(this._m1.liveTimer);
        clearTimeout(this._m1.gameTimer);
        clearInterval(this._m2.lineInterval);
        clearTimeout(this._m2.hintTimeout);

        this.scores = { m1:0, m2:0, m3:0 };
        this._m1.stateA = {}; this._m1.stateB = {}; this._m1.changedIds = []; this._m1.selected = new Set();
        this._m2.round = 0; this._m2.roundScore = 0; this._m2.roundDone = false;
        this._m2.anomalyEnterTime = null; this._m2.linesAfterAnomaly = 0; this._m2.shownLines = [];
        this._m3.agents = []; this._m3.impostorIdx = -1; this._m3.selectedIdx = -1;

        this.runIntro();
    },
};

document.addEventListener('DOMContentLoaded', () => P.init());
</script>
@endpush
