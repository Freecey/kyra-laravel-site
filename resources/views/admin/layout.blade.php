<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title', 'Admin') — KYRA Control Panel</title>
<link rel="icon" href="/favicon.ico" sizes="any">
<style>
  :root {
    --cyan: #00c8ff;
    --cyan-dim: #00c8ff33;
    --cyan-mid: #00c8ff66;
    --bg: #050d12;
    --bg-panel: #0a1a24;
    --bg-card: #0d1f2d;
    --bg-hover: #102535;
    --border: #1e3a4a;
    --text: #c8d8e0;
    --text-muted: #4a6a7a;
    --danger: #ff4466;
    --success: #00ff88;
    --warning: #ffbb00;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Rajdhani', 'Share Tech Mono', monospace;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
  }

  /* SIDEBAR */
  .sidebar {
    width: 240px;
    min-height: 100vh;
    background: var(--bg-panel);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
  }
  .sidebar-logo {
    padding: 24px 20px 20px;
    border-bottom: 1px solid var(--border);
  }
  .sidebar-logo .logo-title {
    font-family: 'Orbitron', monospace;
    color: var(--cyan);
    font-size: 20px;
    letter-spacing: 4px;
    font-weight: 700;
  }
  .sidebar-logo .logo-sub {
    font-size: 10px;
    color: var(--text-muted);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 4px;
  }
  .sidebar-nav {
    flex: 1;
    padding: 16px 0;
  }
  .nav-section {
    padding: 8px 20px 4px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--text-muted);
  }
  .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    color: var(--text);
    text-decoration: none;
    font-size: 13px;
    letter-spacing: 1px;
    border-left: 2px solid transparent;
    transition: all 0.15s;
  }
  .nav-link:hover {
    background: var(--bg-hover);
    border-left-color: var(--cyan-mid);
    color: var(--cyan);
  }
  .nav-link.active {
    background: var(--bg-hover);
    border-left-color: var(--cyan);
    color: var(--cyan);
  }
  .nav-link .icon { width: 16px; text-align: center; opacity: 0.7; }
  .nav-link.active .icon { opacity: 1; }
  .badge {
    margin-left: auto;
    background: var(--danger);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 10px;
    min-width: 18px;
    text-align: center;
    line-height: 16px;
  }
  .sidebar-footer {
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    font-size: 12px;
    color: var(--text-muted);
  }
  .sidebar-footer a {
    color: var(--text-muted);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.15s;
  }
  .sidebar-footer a:hover { color: var(--danger); }

  /* MAIN CONTENT */
  .main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    overflow: hidden;
  }
  .topbar {
    background: var(--bg-panel);
    border-bottom: 1px solid var(--border);
    padding: 12px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
  }
  .topbar-title {
    font-family: 'Orbitron', monospace;
    font-size: 13px;
    letter-spacing: 3px;
    color: var(--cyan);
    text-transform: uppercase;
  }
  .topbar-user {
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .topbar-user span { color: var(--text); }
  .content {
    flex: 1;
    padding: 28px;
    overflow-y: auto;
  }

  /* CARDS & PANELS */
  .card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 4px;
    margin-bottom: 24px;
  }
  .card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .card-header h2 {
    font-family: 'Orbitron', monospace;
    font-size: 11px;
    letter-spacing: 2px;
    color: var(--cyan);
    text-transform: uppercase;
    font-weight: 600;
  }
  .card-body { padding: 20px; }

  /* STATS */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }
  .stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 20px;
    text-align: center;
  }
  .stat-card .stat-value {
    font-family: 'Orbitron', monospace;
    font-size: 32px;
    color: var(--cyan);
    font-weight: 700;
    line-height: 1;
  }
  .stat-card .stat-value.danger { color: var(--danger); }
  .stat-card .stat-label {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 8px;
  }

  /* TABLE */
  .table-wrap { overflow-x: auto; }
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }
  thead th {
    padding: 10px 16px;
    text-align: left;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
  }
  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background 0.1s;
  }
  tbody tr:hover { background: var(--bg-hover); }
  tbody tr.unread { border-left: 2px solid var(--cyan); }
  tbody td {
    padding: 12px 16px;
    vertical-align: middle;
  }
  td a { color: var(--cyan); text-decoration: none; }
  td a:hover { text-decoration: underline; }

  /* BUTTONS */
  .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: 1px solid;
    border-radius: 3px;
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
    font-family: inherit;
    background: transparent;
  }
  .btn-primary { border-color: var(--cyan); color: var(--cyan); }
  .btn-primary:hover { background: var(--cyan); color: var(--bg); }
  .btn-danger { border-color: var(--danger); color: var(--danger); }
  .btn-danger:hover { background: var(--danger); color: #fff; }
  .btn-muted { border-color: var(--border); color: var(--text-muted); }
  .btn-muted:hover { border-color: var(--text-muted); color: var(--text); }
  .btn-sm { padding: 5px 10px; font-size: 11px; }

  /* ALERTS */
  .alert {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
    font-size: 13px;
    border-left: 3px solid;
  }
  .alert-success { background: #00ff8811; border-color: var(--success); color: var(--success); }
  .alert-danger  { background: #ff446611; border-color: var(--danger); color: var(--danger); }

  /* FORMS */
  .form-group { margin-bottom: 20px; }
  .form-label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    margin-bottom: 6px;
  }
  .form-control {
    width: 100%;
    background: var(--bg-panel);
    border: 1px solid var(--border);
    border-radius: 3px;
    padding: 10px 14px;
    color: var(--text);
    font-family: inherit;
    font-size: 14px;
    transition: border-color 0.15s;
    outline: none;
  }
  .form-control:focus { border-color: var(--cyan); box-shadow: 0 0 0 2px var(--cyan-dim); }
  .form-control.is-invalid { border-color: var(--danger); }
  .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }
  .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

  .form-check { display: flex; align-items: center; gap: 10px; }
  .form-check input[type="checkbox"] {
    width: 16px; height: 16px;
    accent-color: var(--cyan);
    cursor: pointer;
  }
  .form-check label { font-size: 13px; color: var(--text); cursor: pointer; }

  /* DETAIL VIEW */
  .detail-field { margin-bottom: 20px; }
  .detail-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    margin-bottom: 6px;
  }
  .detail-value {
    background: var(--bg-panel);
    border: 1px solid var(--border);
    border-radius: 3px;
    padding: 10px 14px;
    font-size: 14px;
    color: var(--text);
    white-space: pre-wrap;
    line-height: 1.6;
  }

  /* PAGINATION */
  .pagination { display: flex; gap: 4px; justify-content: center; padding: 16px 0 0; flex-wrap: wrap; }
  .pagination a, .pagination span {
    display: inline-block;
    padding: 6px 12px;
    border: 1px solid var(--border);
    border-radius: 3px;
    font-size: 12px;
    color: var(--text-muted);
    text-decoration: none;
    transition: all 0.15s;
  }
  .pagination a:hover { border-color: var(--cyan); color: var(--cyan); }
  .pagination .active span { border-color: var(--cyan); color: var(--cyan); background: var(--cyan-dim); }
  .pagination .disabled span { opacity: 0.3; cursor: default; }

  /* PILL STATUS */
  .pill {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 600;
  }
  .pill-unread { background: #00c8ff22; color: var(--cyan); border: 1px solid var(--cyan-mid); }
  .pill-read   { background: #1e3a4a44; color: var(--text-muted); border: 1px solid var(--border); }
  .pill-sent   { background: #00ff8822; color: var(--success); border: 1px solid #00ff8855; }
  .pill-fail   { background: #ff446622; color: var(--danger); border: 1px solid #ff446655; }

  /* SCAN LINE EFFECT */
  body::after {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,200,255,0.01) 2px, rgba(0,200,255,0.01) 4px);
    pointer-events: none;
    z-index: 9999;
  }

  @media (max-width: 768px) {
    body { flex-direction: column; }
    .sidebar {
      width: 100%;
      height: auto;
      min-height: unset;
      position: static;
      flex-direction: row;
      overflow-x: auto;
    }
    .sidebar-logo { display: none; }
    .sidebar-nav { display: flex; padding: 0; }
    .nav-section { display: none; }
    .nav-link { padding: 12px 16px; border-left: none; border-bottom: 2px solid transparent; flex-direction: column; gap: 3px; font-size: 11px; }
    .nav-link.active { border-bottom-color: var(--cyan); }
    .sidebar-footer { display: none; }
  }
</style>
@stack('styles')
</head>
<body>
<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-title">KYRA</div>
    <div class="logo-sub">Control Panel</div>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Navigation</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="icon">◈</span> Dashboard
    </a>
    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
      <span class="icon">◉</span> Messages
      @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
      @if($unread > 0)
        <span class="badge">{{ $unread }}</span>
      @endif
    </a>
    <div class="nav-section">Administration</div>
    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
      <span class="icon">⚙</span> Paramètres
    </a>
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <span class="icon">◎</span> Utilisateurs
    </a>
    <div class="nav-section">Compte</div>
    <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
      <span class="icon">▷</span> Mon profil
    </a>
    <a href="{{ route('home') }}" class="nav-link" target="_blank">
      <span class="icon">↗</span> Voir le site
    </a>
  </nav>
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" style="background:none;border:none;cursor:pointer;width:100%;padding:0;">
        <a href="#" onclick="this.closest('form').submit(); return false;" style="color:var(--text-muted); display:flex; align-items:center; gap:8px;">
          <span>⏻</span> {{ Auth::user()->name }}
        </a>
      </button>
    </form>
  </div>
</aside>

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div class="topbar-title">@yield('topbar-title', 'Dashboard')</div>
    <div class="topbar-user">
      <span>{{ Auth::user()->email }}</span>
    </div>
  </div>
  <div class="content">
    @if(session('success'))
      <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">✗ {{ session('error') }}</div>
    @endif
    @yield('content')
  </div>
</div>
</body>
</html>
