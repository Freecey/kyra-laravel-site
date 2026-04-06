@extends('admin.layout')
@section('topbar-title', 'Statistiques')

@section('content')

{{-- ── STAT CARDS ──────────────────────────────────────────────────── --}}
<div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(140px,1fr));">
  <div class="stat-card">
    <div class="stat-value">{{ number_format($totalToday) }}</div>
    <div class="stat-label">Aujourd'hui</div>
  </div>
  <div class="stat-card">
    <div class="stat-value">{{ number_format($totalWeek) }}</div>
    <div class="stat-label">7 derniers jours</div>
  </div>
  <div class="stat-card">
    <div class="stat-value">{{ number_format($totalMonth) }}</div>
    <div class="stat-label">30 derniers jours</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ number_format($uniqueMonth) }}</div>
    <div class="stat-label">Visiteurs uniques / 30j</div>
  </div>
</div>

<div class="row" style="display:grid; grid-template-columns:2fr 1fr; gap:24px; margin-bottom:0;">

  {{-- ── BAR CHART 14 JOURS ─────────────────────────────────────────── --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header"><h2>Vues / jour — 14 derniers jours</h2></div>
    <div class="card-body">
      <div style="display:flex; align-items:flex-end; gap:5px; height:90px; padding-top:8px;">
        @foreach($daily as $day)
          @php $pct = $dailyMax > 0 ? round(($day['count'] / $dailyMax) * 100) : 0; @endphp
          <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:4px; height:100%;">
            <div style="flex:1; width:100%; display:flex; align-items:flex-end;">
              <div style="width:100%; height:{{ max($pct, 2) }}%; background:var(--cyan); opacity:{{ $day['count'] > 0 ? '.75' : '.15' }}; border-radius:2px 2px 0 0; transition:opacity .2s;"
                   title="{{ $day['label'] }} : {{ $day['count'] }} vue(s)"></div>
            </div>
          </div>
        @endforeach
      </div>
      {{-- Labels dates --}}
      <div style="display:flex; gap:5px; margin-top:6px;">
        @foreach($daily as $i => $day)
          <div style="flex:1; text-align:center; font-size:9px; color:var(--text-muted); white-space:nowrap; overflow:hidden;">
            {{ $i % 2 === 0 ? $day['label'] : '' }}
          </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ── RÉPARTITION RÔLES ──────────────────────────────────────────── --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header"><h2>Répartition / 30j</h2></div>
    <div class="card-body">
      @foreach(['guest' => ['label' => 'Visiteurs', 'color' => 'var(--cyan)'], 'member' => ['label' => 'Membres', 'color' => 'var(--success)'], 'admin' => ['label' => 'Admin', 'color' => 'var(--warning)']] as $role => $meta)
        @php
          $count = $byRole[$role] ?? 0;
          $pct   = round(($count / $roleTotal) * 100);
        @endphp
        <div style="margin-bottom:16px;">
          <div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:5px;">
            <span style="color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">{{ $meta['label'] }}</span>
            <span style="color:{{ $meta['color'] }};">{{ number_format($count) }} <span style="color:var(--text-muted);">({{ $pct }}%)</span></span>
          </div>
          <div style="height:6px; background:var(--border); border-radius:3px; overflow:hidden;">
            <div style="height:100%; width:{{ $pct }}%; background:{{ $meta['color'] }}; border-radius:3px; transition:width .3s;"></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

</div>

{{-- ── TOP PAGES ───────────────────────────────────────────────────── --}}
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>Top pages — 30 derniers jours</h2>
    <span style="font-size:11px; color:var(--text-muted);">{{ $topPages->count() }} pages</span>
  </div>
  @if($topPages->isEmpty())
    <div class="card-body" style="color:var(--text-muted); font-size:13px;">Aucune donnée.</div>
  @else
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Page</th>
          <th style="text-align:right;">Vues</th>
          <th style="width:35%; min-width:120px;"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($topPages as $i => $page)
          @php $pct = round(($page->total / $topMax) * 100); @endphp
          <tr>
            <td style="color:var(--text-muted); font-size:11px; width:32px;">{{ $i + 1 }}</td>
            <td>
              <a href="{{ $page->path }}" target="_blank" style="font-family:'Share Tech Mono',monospace; font-size:12px;">
                {{ $page->path }}
              </a>
            </td>
            <td style="text-align:right; color:var(--cyan); font-family:'Orbitron',monospace; font-size:13px; font-weight:700; white-space:nowrap;">
              {{ number_format($page->total) }}
            </td>
            <td>
              <div style="height:4px; background:var(--border); border-radius:2px; overflow:hidden;">
                <div style="height:100%; width:{{ $pct }}%; background:var(--cyan); opacity:.6; border-radius:2px;"></div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

{{-- Note RGPD --}}
<div style="font-size:11px; color:var(--text-muted); margin-top:12px; letter-spacing:.05em;">
  ◈ Analytique local — aucun cookie, aucun service externe. IPs stockées sous forme de hash SHA-256.
</div>

@endsection
