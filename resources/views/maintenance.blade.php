<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Maintenance — KYRA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link rel="preload" href="/fonts/orbitron-vf.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="/fonts/rajdhani-400.woff2" as="font" type="font/woff2" crossorigin>
  <style>
    @font-face {
      font-family: 'Orbitron';
      src: url('/fonts/orbitron-vf.woff2') format('woff2');
      font-weight: 100 900;
      font-display: swap;
    }
    @font-face {
      font-family: 'Rajdhani';
      src: url('/fonts/rajdhani-400.woff2') format('woff2');
      font-weight: 400;
      font-display: swap;
    }
    @font-face {
      font-family: 'Rajdhani';
      src: url('/fonts/rajdhani-600.woff2') format('woff2');
      font-weight: 600;
      font-display: swap;
    }
    @font-face {
      font-family: 'Share Tech Mono';
      src: url('/fonts/share-tech-mono-400.woff2') format('woff2');
      font-weight: 400;
      font-display: swap;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:     #050d12;
      --cyan:   #00c8ff;
      --accent: #00ffcc;
      --pink:   #ff3366;
      --text:   #c8e8f0;
      --muted:  #4a7a8a;
      --card:   rgba(0, 200, 255, 0.04);
      --border: rgba(0, 200, 255, 0.15);
    }

    html, body {
      height: 100%;
      background-color: var(--bg);
      color: var(--text);
      font-family: 'Rajdhani', sans-serif;
      font-size: 16px;
      overflow-x: hidden;
    }

    /* Scanlines */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 2px,
        rgba(0, 200, 255, 0.015) 2px,
        rgba(0, 200, 255, 0.015) 4px
      );
      pointer-events: none;
      z-index: 1000;
    }

    /* Grid background */
    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(0, 200, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 200, 255, 0.03) 1px, transparent 1px);
      background-size: 50px 50px;
      pointer-events: none;
      z-index: 0;
    }

    /* Ambient glow blobs */
    .glow-blob {
      position: fixed;
      border-radius: 50%;
      filter: blur(120px);
      pointer-events: none;
      z-index: 0;
      animation: breathe 6s ease-in-out infinite alternate;
    }
    .glow-blob-1 {
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(0, 200, 255, 0.06) 0%, transparent 70%);
      top: -200px; left: -200px;
    }
    .glow-blob-2 {
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(255, 51, 102, 0.05) 0%, transparent 70%);
      bottom: -150px; right: -150px;
      animation-delay: 3s;
    }

    @keyframes breathe {
      from { opacity: 0.5; transform: scale(1); }
      to   { opacity: 1;   transform: scale(1.1); }
    }

    /* Layout */
    .page {
      position: relative;
      z-index: 10;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
      gap: 0;
    }

    /* Avatar */
    .avatar-wrap {
      position: relative;
      width: 180px;
      margin-bottom: 32px;
      flex-shrink: 0;
    }
    .avatar-wrap::before {
      content: '';
      position: absolute;
      inset: -3px;
      background: linear-gradient(135deg, var(--cyan), var(--accent), var(--pink), var(--cyan));
      background-size: 300% 300%;
      clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
      animation: gradientShift 4s linear infinite;
      z-index: 0;
    }
    .avatar-wrap::after {
      content: '';
      position: absolute;
      inset: 0;
      background: var(--bg);
      clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
      z-index: 1;
    }
    .avatar-img {
      position: relative;
      z-index: 2;
      width: 100%;
      height: 180px;
      object-fit: cover;
      object-position: top center;
      clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
      display: block;
    }

    @keyframes gradientShift {
      0%   { background-position: 0% 50%; }
      50%  { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Scan ring around avatar */
    .scan-ring {
      position: absolute;
      inset: -18px;
      border-radius: 50%;
      border: 1px solid rgba(0, 200, 255, 0.2);
      animation: scanRotate 8s linear infinite;
      z-index: 3;
    }
    .scan-ring::after {
      content: '';
      position: absolute;
      top: 0; left: 50%;
      transform: translateX(-50%);
      width: 6px; height: 6px;
      background: var(--cyan);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--cyan), 0 0 16px var(--cyan);
    }
    @keyframes scanRotate {
      from { transform: rotate(0deg); }
      to   { transform: rotate(360deg); }
    }

    /* Content */
    .content {
      text-align: center;
      max-width: 640px;
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-family: 'Share Tech Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--pink);
      border: 1px solid rgba(255, 51, 102, 0.3);
      background: rgba(255, 51, 102, 0.06);
      padding: 6px 16px;
      border-radius: 2px;
      margin-bottom: 24px;
    }
    .status-badge .dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--pink);
      box-shadow: 0 0 6px var(--pink);
      animation: blink 1.2s ease-in-out infinite;
    }
    @keyframes blink {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0.2; }
    }

    h1 {
      font-family: 'Orbitron', sans-serif;
      font-weight: 700;
      font-size: clamp(28px, 6vw, 48px);
      background: linear-gradient(135deg, var(--cyan) 0%, var(--accent) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1.1;
      margin-bottom: 8px;
      text-shadow: none;
      filter: drop-shadow(0 0 20px rgba(0, 200, 255, 0.4));
    }

    .subtitle {
      font-family: 'Orbitron', sans-serif;
      font-size: clamp(11px, 2vw, 13px);
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 40px;
    }

    /* Terminal panel */
    .terminal-panel {
      background: rgba(0, 0, 0, 0.4);
      border: 1px solid var(--border);
      border-radius: 4px;
      padding: 24px 28px;
      text-align: left;
      position: relative;
      margin-bottom: 32px;
    }
    .terminal-panel::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--cyan), transparent);
    }
    .terminal-header {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 16px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }
    .terminal-dot {
      width: 10px; height: 10px;
      border-radius: 50%;
    }
    .terminal-dot.red    { background: #ff5f56; }
    .terminal-dot.yellow { background: #ffbd2e; }
    .terminal-dot.green  { background: #27c93f; }
    .terminal-title {
      font-family: 'Share Tech Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      margin-left: auto;
    }

    .terminal-line {
      font-family: 'Share Tech Mono', monospace;
      font-size: 13px;
      line-height: 1.8;
      color: var(--text);
    }
    .terminal-line .prompt { color: var(--cyan); }
    .terminal-line .cmd    { color: var(--accent); }
    .terminal-line .val    { color: var(--pink); }
    .terminal-line .ok     { color: #27c93f; }
    .terminal-line .cursor {
      display: inline-block;
      width: 8px; height: 14px;
      background: var(--cyan);
      vertical-align: middle;
      margin-left: 2px;
      animation: cursorBlink 1s step-end infinite;
    }
    @keyframes cursorBlink {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0; }
    }

    .message-text {
      font-size: 17px;
      line-height: 1.7;
      color: rgba(200, 232, 240, 0.75);
      font-family: 'Rajdhani', sans-serif;
      font-weight: 400;
    }

    /* Stats row */
    .stats-row {
      display: flex;
      gap: 16px;
      justify-content: center;
      margin-top: 32px;
      flex-wrap: wrap;
    }
    .stat-item {
      border: 1px solid var(--border);
      background: var(--card);
      padding: 12px 20px;
      border-radius: 2px;
      text-align: center;
      min-width: 120px;
    }
    .stat-label {
      font-family: 'Share Tech Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--muted);
      display: block;
      margin-bottom: 4px;
    }
    .stat-value {
      font-family: 'Orbitron', sans-serif;
      font-size: 14px;
      color: var(--cyan);
    }

    /* Agent name */
    .agent-name {
      font-family: 'Share Tech Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.2em;
      color: var(--muted);
      margin-top: 40px;
      text-transform: uppercase;
    }
    .agent-name span { color: var(--cyan); }

    @media (max-width: 480px) {
      .terminal-panel { padding: 16px 18px; }
      .avatar-wrap { width: 140px; }
      .avatar-img { height: 140px; }
    }
  </style>
</head>
<body>
  <div class="glow-blob glow-blob-1"></div>
  <div class="glow-blob glow-blob-2"></div>

  <div class="page">
    <div class="avatar-wrap">
      <div class="scan-ring"></div>
      <img
        src="/images/kyra-full.webp"
        alt="Kyra"
        class="avatar-img"
        width="180"
        height="180"
      >
    </div>

    <div class="content">
      <div class="status-badge">
        <span class="dot"></span>
        SYSTÈME — HORS LIGNE
      </div>

      <h1>Maintenance</h1>
      <p class="subtitle">Protocole de maintenance initié</p>

      <div class="terminal-panel">
        <div class="terminal-header">
          <span class="terminal-dot red"></span>
          <span class="terminal-dot yellow"></span>
          <span class="terminal-dot green"></span>
          <span class="terminal-title">kyra@system ~ maintenance.log</span>
        </div>
        <div class="terminal-line">
          <span class="prompt">$</span>
          <span class="cmd"> status</span>
          <br>
          <span class="val">  [503]</span> SERVICE_UNAVAILABLE
        </div>
        <div class="terminal-line" style="margin-top:8px;">
          <span class="prompt">$</span>
          <span class="cmd"> mode</span>
          <br>
          &nbsp;&nbsp;<span class="ok">MAINTENANCE_ACTIVE</span>
        </div>
        <div class="terminal-line" style="margin-top:8px;">
          <span class="prompt">$</span>
          <span class="cmd"> message</span>
          <br>
          &nbsp;&nbsp;<span style="color:var(--text)">{{ $message }}</span>
        </div>
        <div class="terminal-line" style="margin-top:8px;">
          <span class="prompt">$</span>
          <span class="cmd"> eta</span>
          <br>
          &nbsp;&nbsp;<span class="val">calculating...</span><span class="cursor"></span>
        </div>
      </div>

      <div class="stats-row">
        <div class="stat-item">
          <span class="stat-label">Statut</span>
          <span class="stat-value">503</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Mode</span>
          <span class="stat-value" id="cycle-mode" style="font-size:11px; letter-spacing:0.05em;">Analyse…</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Agent</span>
          <span class="stat-value">KYRA</span>
        </div>
      </div>

      <p class="agent-name">Opérée par <span>KYRA</span> — Intelligence Artificielle</p>
    </div>
  </div>

  <script>
    (function () {
      const states = [
        'Analyse…',
        'Vérification…',
        'Recalibrage…',
        'Synchronisation…',
        'Diagnostic…',
        'Mise à jour…',
        'Optimisation…',
        'Initialisation…',
      ];
      const el = document.getElementById('cycle-mode');
      let i = 0;
      setInterval(function () {
        el.style.opacity = '0';
        setTimeout(function () {
          i = (i + 1) % states.length;
          el.textContent = states[i];
          el.style.opacity = '1';
        }, 300);
      }, 2200);
      el.style.transition = 'opacity 0.3s ease';
    })();
  </script>
</body>
</html>
