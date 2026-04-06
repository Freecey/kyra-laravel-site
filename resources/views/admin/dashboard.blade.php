@extends('admin.layout')

@section('topbar-title', 'Dashboard')

@section('content')
<div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(130px,1fr));">
  <div class="stat-card">
    <div class="stat-value">{{ $totalMessages }}</div>
    <div class="stat-label">Messages total</div>
  </div>
  <div class="stat-card">
    <div class="stat-value {{ $unreadMessages > 0 ? 'danger' : '' }}">{{ $unreadMessages }}</div>
    <div class="stat-label">Non lus</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--cyan);">{{ $totalUsers }}</div>
    <div class="stat-label">Utilisateurs</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ $viewsToday }}</div>
    <div class="stat-label">Vues aujourd'hui</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ $viewsWeek }}</div>
    <div class="stat-label">Vues 7 jours</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ $viewsMonth }}</div>
    <div class="stat-label">Vues 30 jours</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h2>◉ Derniers messages</h2>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-muted">Tous les messages →</a>
  </div>
  <div class="table-wrap">
    @if($recentMessages->isEmpty())
      <div class="card-body" style="color: var(--text-muted); font-size: 13px;">Aucun message reçu.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Statut</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Sujet</th>
            <th>Reçu le</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentMessages as $msg)
          <tr class="{{ !$msg->is_read ? 'unread' : '' }}">
            <td>
              @if(!$msg->is_read)
                <span class="pill pill-unread">Nouveau</span>
              @else
                <span class="pill pill-read">Lu</span>
              @endif
            </td>
            <td>{{ $msg->name }}</td>
            <td style="color: var(--text-muted);">{{ $msg->email }}</td>
            <td>{{ Str::limit($msg->subject, 40) }}</td>
            <td style="color: var(--text-muted); font-size: 12px;">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
            <td><a href="{{ route('admin.messages.show', $msg) }}">Voir →</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>◎ Derniers inscrits</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-muted">Tous les utilisateurs →</a>
  </div>
  <div class="table-wrap">
    @if($recentUsers->isEmpty())
      <div class="card-body" style="color: var(--text-muted); font-size: 13px;">Aucun utilisateur.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Inscrit le</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentUsers as $u)
          <tr>
            <td>{{ $u->name }}</td>
            <td style="color: var(--text-muted);">{{ $u->email }}</td>
            <td>
              @if($u->isAdmin())
                <span class="pill" style="background:rgba(0,200,200,.12); color:var(--cyan);">admin</span>
              @else
                <span class="pill pill-read">member</span>
              @endif
            </td>
            <td style="color: var(--text-muted); font-size: 12px;">{{ $u->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

{{-- ── État du système ────────────────────────────────────────────── --}}
@php
  $s = $systemStatus;
  function dashBytes(int|float|null $bytes): string {
      if ($bytes === null) return '—';
      foreach (['B','KB','MB','GB'] as $u) {
          if ($bytes < 1024) return round($bytes, 1) . ' ' . $u;
          $bytes /= 1024;
      }
      return round($bytes, 1) . ' TB';
  }
  $ok   = '<span style="color:var(--success); font-weight:700;">OK</span>';
  $err  = '<span style="color:var(--danger,#ff4466); font-weight:700;">KO</span>';
  $warn = '<span style="color:var(--warning,#ffbb00); font-weight:700;">WARN</span>';
@endphp
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>⚙ État du système</h2>
    <a href="{{ route('admin.toolbox') }}" class="btn btn-sm btn-muted">Boîte à outils →</a>
  </div>
  <div class="card-body">
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px;">
      {{-- Runtime --}}
      <div style="background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; padding:14px 16px;">
        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Runtime</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; font-family:'Share Tech Mono',monospace;">
          <tr><td style="color:var(--text-muted); padding:3px 0; width:50%;">PHP</td><td style="color:var(--cyan);">{{ $s['php_version'] }}</td></tr>
          <tr><td style="color:var(--text-muted); padding:3px 0;">Laravel</td><td style="color:var(--cyan);">{{ $s['laravel_version'] }}</td></tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">APP_ENV</td>
            <td style="color:{{ $s['app_env'] === 'production' ? 'var(--success)' : 'var(--warning,#ffbb00)' }};">{{ $s['app_env'] }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">APP_DEBUG</td>
            <td>{!! $s['app_debug'] ? $warn . ' <span style="font-size:11px;color:var(--text-muted);">activé</span>' : $ok . ' <span style="font-size:11px;color:var(--text-muted);">désactivé</span>' !!}</td>
          </tr>
        </table>
      </div>
      {{-- Base de données --}}
      <div style="background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; padding:14px 16px;">
        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Base de données</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; font-family:'Share Tech Mono',monospace;">
          <tr><td style="color:var(--text-muted); padding:3px 0; width:50%;">Driver</td><td style="color:var(--cyan);">{{ $s['db_driver'] }}</td></tr>
          <tr><td style="color:var(--text-muted); padding:3px 0;">Connexion</td><td>{!! $s['db_ok'] ? $ok : $err !!}</td></tr>
          @if($s['db_size'] !== null)
          <tr><td style="color:var(--text-muted); padding:3px 0;">Taille</td><td style="color:var(--cyan);">{{ dashBytes($s['db_size']) }}</td></tr>
          @endif
          <tr><td style="color:var(--text-muted); padding:3px 0;">Cache</td><td style="color:var(--cyan);">{{ $s['cache_driver'] }}</td></tr>
          <tr><td style="color:var(--text-muted); padding:3px 0;">Queue</td><td style="color:var(--cyan);">{{ $s['queue_driver'] }}</td></tr>
        </table>
      </div>
      {{-- Stockage --}}
      <div style="background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; padding:14px 16px;">
        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Stockage & Logs</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; font-family:'Share Tech Mono',monospace;">
          <tr>
            <td style="color:var(--text-muted); padding:3px 0; width:50%;">Storage</td>
            <td>{!! $s['storage_writable'] ? $ok . ' <span style="font-size:11px;color:var(--text-muted);">writable</span>' : $err . ' <span style="font-size:11px;color:var(--text-muted);">non-writable</span>' !!}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Taille log</td>
            <td style="color:{{ $s['log_size'] > 10 * 1024 * 1024 ? 'var(--warning,#ffbb00)' : 'var(--cyan)' }};">{{ dashBytes($s['log_size']) }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Disque libre</td>
            <td style="color:{{ $s['disk_used_pct'] > 90 ? 'var(--danger,#ff4466)' : ($s['disk_used_pct'] > 75 ? 'var(--warning,#ffbb00)' : 'var(--success)') }};">{{ dashBytes($s['disk_free']) }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Utilisation</td>
            <td>
              <div style="display:flex; align-items:center; gap:8px;">
                <div style="flex:1; height:5px; background:var(--border); border-radius:3px; overflow:hidden;">
                  <div style="height:100%; width:{{ $s['disk_used_pct'] }}%; background:{{ $s['disk_used_pct'] > 90 ? 'var(--danger,#ff4466)' : ($s['disk_used_pct'] > 75 ? 'var(--warning,#ffbb00)' : 'var(--success)') }}; border-radius:3px;"></div>
                </div>
                <span style="font-size:11px; color:var(--text-muted);">{{ $s['disk_used_pct'] }}%</span>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    {{-- Extensions PHP --}}
    <div style="margin-top:16px; padding:12px 16px; background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px;">
      <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Extensions PHP</div>
      <div style="display:flex; flex-wrap:wrap; gap:8px;">
        @foreach($s['extensions'] as $ext)
          <span style="padding:3px 10px; border-radius:3px; font-family:'Share Tech Mono',monospace; font-size:11px;
                       background:{{ $ext['loaded'] ? 'rgba(0,200,150,.1)' : 'rgba(255,68,102,.1)' }};
                       border:1px solid {{ $ext['loaded'] ? 'rgba(0,200,150,.35)' : 'rgba(255,68,102,.35)' }};
                       color:{{ $ext['loaded'] ? 'var(--success)' : 'var(--danger,#ff4466)' }};">
            {{ $ext['loaded'] ? '✓' : '✗' }} {{ $ext['name'] }}
          </span>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection
