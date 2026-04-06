@extends('admin.layout')

@section('title', 'Journaux')
@section('topbar-title', 'Journaux système')

@push('styles')
<style>
  .log-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }
  .log-toolbar .spacer { flex: 1; }
  .log-size {
    font-size: 11px;
    font-family: 'Share Tech Mono', monospace;
    color: var(--text-muted);
  }

  .log-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .log-entry {
    border: 1px solid var(--border);
    border-radius: 3px;
    overflow: hidden;
    background: rgba(255,255,255,.02);
    transition: border-color .15s;
  }
  .log-entry:hover { border-color: rgba(0,200,255,.3); }
  .log-entry[open] { border-color: rgba(0,200,255,.4); background: rgba(0,200,255,.03); }

  .log-summary {
    display: grid;
    grid-template-columns: 140px 80px 1fr;
    gap: 8px;
    align-items: baseline;
    padding: 7px 12px;
    cursor: pointer;
    list-style: none;
    font-family: 'Share Tech Mono', monospace;
    font-size: 12px;
    user-select: none;
  }
  .log-summary::-webkit-details-marker { display: none; }
  .log-summary::marker { display: none; }

  .log-ts { color: var(--text-muted); white-space: nowrap; }
  .log-msg { color: var(--text); line-height: 1.4; word-break: break-all; }

  .log-badge {
    display: inline-block;
    padding: 1px 7px;
    border-radius: 2px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .06em;
    text-align: center;
  }
  .badge-DEBUG    { background: rgba(150,150,150,.15); color: #888; }
  .badge-INFO     { background: rgba(0,200,255,.15);   color: var(--cyan); }
  .badge-NOTICE   { background: rgba(0,200,255,.1);    color: #60d0e0; }
  .badge-WARNING  { background: rgba(255,187,0,.15);   color: #ffbb00; }
  .badge-ERROR    { background: rgba(255,68,102,.2);   color: var(--danger, #ff4466); }
  .badge-CRITICAL { background: rgba(255,68,102,.3);   color: #ff2244; }
  .badge-ALERT    { background: rgba(255,68,102,.35);  color: #ff0033; }
  .badge-EMERGENCY{ background: rgba(255,0,50,.4);     color: #ff0033; font-style: italic; }

  .log-detail {
    padding: 10px 12px 12px;
    border-top: 1px solid var(--border);
  }
  .log-detail pre {
    margin: 0;
    font-family: 'Share Tech Mono', monospace;
    font-size: 11px;
    color: var(--text-muted);
    white-space: pre-wrap;
    word-break: break-all;
    line-height: 1.6;
  }

  .log-empty {
    padding: 40px;
    text-align: center;
    font-family: 'Share Tech Mono', monospace;
    color: var(--text-muted);
    font-size: 13px;
  }
</style>
@endpush

@section('content')

{{-- Toolbar --}}
<div class="log-toolbar">

  {{-- Filtre par niveau --}}
  <form method="GET" action="{{ route('admin.logs') }}" style="display:flex; gap:8px; align-items:center;">
    <select name="level" class="form-control" style="width:auto; padding:6px 10px; font-size:12px;" onchange="this.form.submit()">
      <option value="">Tous les niveaux</option>
      @foreach($levels as $lvl)
        <option value="{{ $lvl }}" {{ $levelFilter === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
      @endforeach
    </select>
    @if($levelFilter)
      <a href="{{ route('admin.logs') }}" class="btn btn-secondary" style="padding:5px 10px; font-size:12px;">✕ Réinitialiser</a>
    @endif
  </form>

  <span class="spacer"></span>

  @if($fileSize > 0)
    <span class="log-size">
      {{ count($entries) }} entrée(s) affichée(s) · {{ number_format($fileSize / 1024, 1) }} Ko
    </span>

    <a href="{{ route('admin.logs.download') }}" class="btn btn-secondary" style="font-size:12px; padding:5px 12px;">
      ↓ Télécharger
    </a>

    <form method="POST" action="{{ route('admin.logs.clear') }}" onsubmit="return confirm('Effacer tout le journal ?')">
      @csrf
      <button type="submit" class="btn btn-secondary" style="font-size:12px; padding:5px 12px; border-color:var(--danger, #ff4466); color:var(--danger, #ff4466);">
        ⊘ Effacer
      </button>
    </form>
  @endif
</div>

{{-- Flash --}}
@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
@endif

{{-- Entries --}}
<div class="card">
  <div class="card-body" style="padding: 12px;">

    @if(empty($entries))
      <div class="log-empty">
        <div style="font-size:24px; margin-bottom:8px;">◎</div>
        Journal vide
      </div>
    @else
      <div class="log-list">
        @foreach($entries as $entry)
          @if($entry['has_detail'])
            <details class="log-entry">
              <summary class="log-summary">
                <span class="log-ts">{{ $entry['timestamp'] }}</span>
                <span class="log-badge badge-{{ $entry['level'] }}">{{ $entry['level'] }}</span>
                <span class="log-msg">{{ $entry['summary'] }}</span>
              </summary>
              <div class="log-detail">
                <pre>{{ $entry['detail'] }}</pre>
              </div>
            </details>
          @else
            <div class="log-entry">
              <div class="log-summary" style="cursor:default;">
                <span class="log-ts">{{ $entry['timestamp'] }}</span>
                <span class="log-badge badge-{{ $entry['level'] }}">{{ $entry['level'] }}</span>
                <span class="log-msg">{{ $entry['summary'] }}</span>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    @endif

  </div>
</div>

@endsection
