@extends('admin.layout')

@section('title', 'Boîte à outils')
@section('topbar-title', 'Boîte à outils')

@section('content')

{{-- ── Test d'envoi d'email ─────────────────────────────────────────── --}}
<div class="card">
  <div class="card-header">
    <h2>&#x2709; Test d'envoi d'email</h2>
  </div>
  <div class="card-body">

    {{-- Config mail active --}}
    <div style="margin-bottom:20px; padding:12px 16px; background:var(--bg-card-alt, rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; font-size:12px; font-family:'Share Tech Mono', monospace; color:var(--text-muted); line-height:1.8;">
      <div><span style="color:var(--cyan)">driver</span> &nbsp; {{ $mailConfig['driver'] }}</div>
      <div><span style="color:var(--cyan)">host  </span> &nbsp; {{ $mailConfig['host'] ?? '—' }}</div>
      <div><span style="color:var(--cyan)">port  </span> &nbsp; {{ $mailConfig['port'] ?? '—' }}</div>
      <div><span style="color:var(--cyan)">from  </span> &nbsp; {{ $mailConfig['from'] ?? '—' }}</div>
    </div>

    @if(session('success'))
      <div class="alert alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger" style="margin-bottom:16px;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.toolbox.send-email') }}">
      @csrf
      <div class="form-group" style="display:flex; gap:12px; align-items:flex-end;">
        <div style="flex:1;">
          <label class="form-label" for="to">Destinataire</label>
          <input type="email" id="to" name="to"
                 class="form-control {{ $errors->has('to') ? 'is-invalid' : '' }}"
                 value="{{ old('to', Auth::user()->email) }}"
                 placeholder="adresse@exemple.com"
                 required>
          @error('to')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
      </div>
    </form>

  </div>
</div>

{{-- ── Commandes Artisan ───────────────────────────────────────────── --}}
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>&#x25B6; Commandes Artisan</h2>
  </div>
  <div class="card-body">

    {{-- Résultat de la dernière commande --}}
    @if(session('artisan_result'))
      @php $result = session('artisan_result'); @endphp
      <div style="margin-bottom:20px; padding:12px 16px; background:rgba(0,0,0,.3); border:1px solid {{ $result['status'] === 0 ? 'rgba(0,200,255,.4)' : 'rgba(255,68,102,.4)' }}; border-radius:4px;">
        <div style="font-family:'Share Tech Mono',monospace; font-size:11px; color:var(--text-muted); margin-bottom:8px;">
          <span style="color:{{ $result['status'] === 0 ? 'var(--cyan)' : 'var(--danger,#ff4466)' }}">
            {{ $result['status'] === 0 ? '✓' : '✗' }}
          </span>
          &nbsp; php artisan {{ $result['command'] }}
        </div>
        <pre style="margin:0; font-family:'Share Tech Mono',monospace; font-size:12px; color:var(--text); white-space:pre-wrap; word-break:break-all; line-height:1.6;">{{ $result['output'] }}</pre>
      </div>
    @endif

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:8px;">
      @foreach($commands as $cmd => $label)
        <form method="POST" action="{{ route('admin.toolbox.artisan') }}">
          @csrf
          <input type="hidden" name="command" value="{{ $cmd }}">
          <button type="submit" class="btn btn-secondary"
                  style="width:100%; text-align:left; display:flex; flex-direction:column; gap:2px; padding:10px 14px;">
            <span style="font-family:'Share Tech Mono',monospace; font-size:11px; color:var(--cyan);">php artisan {{ $cmd }}</span>
            <span style="font-size:11px; color:var(--text-muted);">{{ $label }}</span>
          </button>
        </form>
      @endforeach
    </div>

  </div>
</div>

{{-- ── Test des pages d'erreur ─────────────────────────────────────── --}}
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>&#x26A0; Test des pages d'erreur</h2>
  </div>
  <div class="card-body">
    <p style="font-size:13px; color:var(--text-muted); margin-bottom:20px;">
      Ouvre la page d'erreur correspondante dans un nouvel onglet.
    </p>
    <div style="display:flex; gap:12px; flex-wrap:wrap;">
      <a href="{{ route('admin.toolbox.error', 404) }}" target="_blank" class="btn btn-secondary">
        404 — Signal perdu
      </a>
      <a href="{{ route('admin.toolbox.error', 500) }}" target="_blank" class="btn btn-secondary" style="border-color:var(--danger, #ff4466); color:var(--danger, #ff4466);">
        500 — Défaillance système
      </a>
      <a href="{{ route('admin.toolbox.error', 503) }}" target="_blank" class="btn btn-secondary" style="border-color:#ffbb00; color:#ffbb00;">
        503 — Système hors ligne
      </a>
    </div>
  </div>
</div>

{{-- ── État du système ────────────────────────────────────────────── --}}
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>&#x2699; État du système</h2>
  </div>
  <div class="card-body">

    @php
      $s   = $systemStatus;
      $ok  = '<span style="color:var(--success); font-weight:700;">OK</span>';
      $err = '<span style="color:var(--danger,#ff4466); font-weight:700;">KO</span>';
      $warn = '<span style="color:var(--warning,#ffbb00); font-weight:700;">WARN</span>';

      function sysBytes(int|float|null $bytes): string {
          if ($bytes === null) return '—';
          foreach (['B','KB','MB','GB'] as $u) {
              if ($bytes < 1024) return round($bytes, 1) . ' ' . $u;
              $bytes /= 1024;
          }
          return round($bytes, 1) . ' TB';
      }
    @endphp

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px;">

      {{-- Runtime --}}
      <div style="background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; padding:14px 16px;">
        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Runtime</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; font-family:'Share Tech Mono',monospace;">
          <tr>
            <td style="color:var(--text-muted); padding:3px 0; width:50%;">PHP</td>
            <td style="color:var(--cyan);">{{ $s['php_version'] }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Laravel</td>
            <td style="color:var(--cyan);">{{ $s['laravel_version'] }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">APP_ENV</td>
            <td style="color:{{ $s['app_env'] === 'production' ? 'var(--success)' : 'var(--warning,#ffbb00)' }};">
              {{ $s['app_env'] }}
            </td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">APP_DEBUG</td>
            <td>
              @if($s['app_debug'])
                {!! $warn !!} <span style="font-size:11px; color:var(--text-muted);">activé</span>
              @else
                {!! $ok !!} <span style="font-size:11px; color:var(--text-muted);">désactivé</span>
              @endif
            </td>
          </tr>
        </table>
      </div>

      {{-- Base de données --}}
      <div style="background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; padding:14px 16px;">
        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Base de données</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; font-family:'Share Tech Mono',monospace;">
          <tr>
            <td style="color:var(--text-muted); padding:3px 0; width:50%;">Driver</td>
            <td style="color:var(--cyan);">{{ $s['db_driver'] }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Connexion</td>
            <td>{!! $s['db_ok'] ? $ok : $err !!}</td>
          </tr>
          @if($s['db_size'] !== null)
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Taille</td>
            <td style="color:var(--cyan);">{{ sysBytes($s['db_size']) }}</td>
          </tr>
          @endif
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Cache driver</td>
            <td style="color:var(--cyan);">{{ $s['cache_driver'] }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Queue driver</td>
            <td style="color:var(--cyan);">{{ $s['queue_driver'] }}</td>
          </tr>
        </table>
      </div>

      {{-- Stockage & Logs --}}
      <div style="background:var(--bg-card-alt,rgba(0,200,255,.04)); border:1px solid var(--border); border-radius:4px; padding:14px 16px;">
        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:10px;">Stockage & Logs</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; font-family:'Share Tech Mono',monospace;">
          <tr>
            <td style="color:var(--text-muted); padding:3px 0; width:50%;">Storage</td>
            <td>{!! $s['storage_writable'] ? $ok . ' <span style="font-size:11px;color:var(--text-muted);">writable</span>' : $err . ' <span style="font-size:11px;color:var(--text-muted);">non-writable</span>' !!}</td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Taille log</td>
            <td style="color:{{ $s['log_size'] > 10 * 1024 * 1024 ? 'var(--warning,#ffbb00)' : 'var(--cyan)' }};">
              {{ sysBytes($s['log_size']) }}
            </td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Disque libre</td>
            <td style="color:{{ $s['disk_used_pct'] > 90 ? 'var(--danger,#ff4466)' : ($s['disk_used_pct'] > 75 ? 'var(--warning,#ffbb00)' : 'var(--success)') }};">
              {{ sysBytes($s['disk_free']) }}
            </td>
          </tr>
          <tr>
            <td style="color:var(--text-muted); padding:3px 0;">Utilisation</td>
            <td>
              <div style="display:flex; align-items:center; gap:8px;">
                <div style="flex:1; height:5px; background:var(--border); border-radius:3px; overflow:hidden;">
                  <div style="height:100%; width:{{ $s['disk_used_pct'] }}%; background:{{ $s['disk_used_pct'] > 90 ? 'var(--danger,#ff4466)' : ($s['disk_used_pct'] > 75 ? 'var(--warning,#ffbb00)' : 'var(--success)') }}; border-radius:3px;"></div>
                </div>
                <span style="font-size:11px; color:var(--text-muted); white-space:nowrap;">{{ $s['disk_used_pct'] }}%</span>
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
