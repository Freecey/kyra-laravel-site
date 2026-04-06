<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Erreur système · Kyra</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <style>
        @font-face {
            font-family: 'Orbitron';
            src: url('/fonts/orbitron-latin.woff2') format('woff2');
            font-weight: 900;
            font-display: swap;
        }
        @font-face {
            font-family: 'Share Tech Mono';
            src: url('/fonts/share-tech-mono-latin.woff2') format('woff2');
            font-weight: 400;
            font-display: swap;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #050d12;
            --cyan: #00c8ff;
            --accent: #00ffcc;
            --pink: #ff3366;
            --text: #c8e8f0;
            --muted: #5a8a99;
            --grid: rgba(0,200,255,0.04);
            --line: rgba(0,200,255,0.16);
        }
        html, body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: 'Share Tech Mono', ui-monospace, monospace;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,.13) 2px, rgba(0,0,0,.13) 4px);
            pointer-events: none; z-index: 10;
        }
        body::after {
            content: '';
            position: fixed; inset: 0;
            background-image: linear-gradient(var(--grid) 1px, transparent 1px), linear-gradient(90deg, var(--grid) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none; z-index: 0;
        }
        .wrap {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        .code {
            font-family: 'Orbitron', ui-monospace, monospace;
            font-size: clamp(5rem, 18vw, 9rem);
            font-weight: 900;
            color: var(--pink);
            text-shadow: 0 0 40px rgba(255,51,102,.4), 0 0 80px rgba(255,51,102,.15);
            letter-spacing: .05em;
            line-height: 1;
        }
        .kicker {
            font-size: .75rem;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--muted);
            margin: 1rem 0 .5rem;
        }
        .title {
            font-family: 'Orbitron', ui-monospace, monospace;
            font-size: clamp(1rem, 3vw, 1.6rem);
            font-weight: 900;
            color: var(--text);
            letter-spacing: .1em;
            margin-bottom: 1.5rem;
        }
        .terminal {
            background: rgba(0,0,0,.45);
            border: 1px solid rgba(255,51,102,.25);
            border-left: 3px solid var(--pink);
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: .85rem;
            line-height: 2;
            color: var(--muted);
            max-width: 480px;
            width: 100%;
            margin-bottom: 2.5rem;
        }
        .terminal .prompt { color: var(--cyan); }
        .terminal .val { color: var(--accent); }
        .terminal .err { color: var(--pink); }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .6rem 1.6rem;
            border: 1px solid var(--cyan);
            color: var(--cyan);
            text-decoration: none;
            font-family: 'Share Tech Mono', ui-monospace, monospace;
            font-size: .8rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            transition: background .2s, color .2s;
        }
        .btn-home:hover {
            background: var(--cyan);
            color: var(--bg);
        }
        .brand {
            position: fixed;
            top: 1.2rem;
            left: 1.5rem;
            font-family: 'Orbitron', ui-monospace, monospace;
            font-weight: 900;
            font-size: .95rem;
            letter-spacing: .3em;
            color: #fff;
            text-decoration: none;
            text-shadow: 0 0 18px rgba(0,200,255,.5);
            z-index: 20;
        }
        .brand span { color: var(--cyan); }
    </style>
</head>
<body>
    <a class="brand" href="/">KY<span>RA</span></a>
    <div class="wrap">
        <div class="code">500</div>
        <div class="kicker">// erreur interne</div>
        <div class="title">Défaillance système</div>
        <div class="terminal">
            <div><span class="err">CRITICAL</span> exception non gérée</div>
            <div><span class="prompt">$</span> status <span class="err">INTERNAL_ERROR</span></div>
            <div><span class="prompt">$</span> daemon <span class="val">KYRA</span> · en cours de récupération</div>
            <div><span class="prompt">$</span> action <span class="val">retenter dans quelques instants</span></div>
        </div>
        <a class="btn-home" href="/">↩ Retour au système</a>
    </div>
</body>
</html>
