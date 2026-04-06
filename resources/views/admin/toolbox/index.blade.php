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

{{-- ── Testeur API ─────────────────────────────────────────────────── --}}
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>◎ Testeur API</h2>
    <a href="{{ route('admin.doc.api') }}" class="btn btn-sm btn-muted">Documentation →</a>
  </div>
  <div class="card-body">

      @if($tokens->isEmpty())
      <div style="font-size:13px; color:var(--text-muted); margin-bottom:16px;">
        Aucun token API disponible. <a href="{{ route('admin.profile.edit') }}" style="color:var(--cyan);">Générer un token →</a>
      </div>
    @else
      <div style="margin-bottom:8px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <label style="font-size:12px; color:var(--text-muted); white-space:nowrap;">Token :</label>
        <select id="api-token" style="flex:1; min-width:200px; background:var(--bg-card); border:1px solid var(--border); color:var(--text); padding:7px 10px; border-radius:3px; font-family:'Share Tech Mono',monospace; font-size:12px;">
          @foreach($tokens as $token)
            <option value="{{ $token->id }}">{{ $token->name }} — créé {{ $token->created_at->diffForHumans() }}</option>
          @endforeach
        </select>
      </div>
      <div style="margin-bottom:16px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <label style="font-size:12px; color:var(--text-muted); white-space:nowrap;">Valeur :</label>
        <input id="api-token-plain" type="password" placeholder="Colle ici la valeur du token (affiché une fois à la création)"
               style="flex:1; min-width:260px; background:var(--bg-card); border:1px solid var(--border); color:var(--text); padding:7px 10px; border-radius:3px; font-family:'Share Tech Mono',monospace; font-size:12px; outline:none;">
        <button onclick="document.getElementById('api-token-plain').type = document.getElementById('api-token-plain').type === 'password' ? 'text' : 'password';"
                style="background:transparent; border:1px solid var(--border); color:var(--text-muted); padding:5px 10px; border-radius:3px; font-size:11px; cursor:pointer; white-space:nowrap;">
          Afficher
        </button>
      </div>
    @endif

    <div style="display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap;">
      <select id="api-method" style="background:var(--bg-card); border:1px solid var(--border); color:var(--cyan); padding:7px 12px; border-radius:3px; font-family:'Share Tech Mono',monospace; font-size:12px; font-weight:700; min-width:100px;">
        <option>GET</option>
        <option>POST</option>
        <option>PUT</option>
        <option>PATCH</option>
        <option>DELETE</option>
      </select>
      <div style="flex:1; display:flex; align-items:center; background:var(--bg-card); border:1px solid var(--border); border-radius:3px; overflow:hidden; min-width:260px;">
        <span style="padding:0 10px; font-family:'Share Tech Mono',monospace; font-size:12px; color:var(--text-muted); white-space:nowrap; border-right:1px solid var(--border);">{{ url('/api/v1') }}</span>
        <input id="api-path" type="text" value="/posts" placeholder="/posts" style="flex:1; background:transparent; border:none; color:var(--text); padding:7px 10px; font-family:'Share Tech Mono',monospace; font-size:12px; outline:none;">
      </div>
      <button onclick="apiSend()" style="background:transparent; border:1px solid var(--cyan); color:var(--cyan); padding:7px 20px; border-radius:3px; font-size:12px; letter-spacing:1px; text-transform:uppercase; cursor:pointer; font-family:inherit;">
        Envoyer
      </button>
    </div>

    <div id="api-body-wrap" style="display:none; margin-bottom:12px;">
      <label style="font-size:11px; color:var(--text-muted); display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:1px;">Corps (JSON)</label>
      <textarea id="api-body" rows="5" placeholder='{ "title": "...", "content": "...", "status": "draft" }'
                style="width:100%; box-sizing:border-box; background:rgba(0,0,0,.3); border:1px solid var(--border); color:var(--text); padding:10px 14px; border-radius:3px; font-family:'Share Tech Mono',monospace; font-size:12px; line-height:1.6; resize:vertical; outline:none;"></textarea>
    </div>

    <div id="api-response" style="display:none;">
      <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
        <span style="font-size:10px; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted);">Réponse</span>
        <span id="api-status-badge" style="font-family:'Share Tech Mono',monospace; font-size:12px; padding:2px 10px; border-radius:3px;"></span>
        <span id="api-time" style="font-size:11px; color:var(--text-muted);"></span>
      </div>
      <pre id="api-output" style="margin:0; background:rgba(0,0,0,.4); border:1px solid var(--border); border-radius:3px; padding:12px 14px; font-family:'Share Tech Mono',monospace; font-size:12px; color:var(--text); white-space:pre-wrap; word-break:break-all; max-height:400px; overflow-y:auto; line-height:1.6;"></pre>
    </div>

  </div>
</div>

@push('scripts')
<script>
(function() {
  var tokenData = @json($tokens->map(fn($t) => ['id' => $t->id, 'raw' => '']));

  // Stocker les plain tokens saisis manuellement (optionnel)
  var manualToken = '';

  document.getElementById('api-method').addEventListener('change', function() {
    var m = this.value;
    var bodyWrap = document.getElementById('api-body-wrap');
    bodyWrap.style.display = (m === 'GET' || m === 'DELETE') ? 'none' : 'block';
  });

  window.apiSend = function() {
    var method   = document.getElementById('api-method').value;
    var path     = document.getElementById('api-path').value.trim();
    var bodyEl   = document.getElementById('api-body');
    var tokenEl  = document.getElementById('api-token');

    if (!path.startsWith('/')) path = '/' + path;
    var url = '{{ url('/api/v1') }}' + path;

    // Récupérer le plain token depuis un champ manuel si présent, sinon demander
    var token = document.getElementById('api-token-plain')
      ? document.getElementById('api-token-plain').value.trim()
      : '';

    var headers = { 'Accept': 'application/json' };
    if (token) headers['Authorization'] = 'Bearer ' + token;

    var opts = { method: method, headers: headers };
    if (method !== 'GET' && method !== 'DELETE' && bodyEl.value.trim()) {
      headers['Content-Type'] = 'application/json';
      opts.body = bodyEl.value.trim();
    }

    var t0 = Date.now();
    document.getElementById('api-response').style.display = 'none';

    fetch(url, opts)
      .then(function(res) {
        var elapsed = Date.now() - t0;
        var status  = res.status;
        return res.text().then(function(text) {
          var badge = document.getElementById('api-status-badge');
          badge.textContent = status;
          var ok = status >= 200 && status < 300;
          badge.style.background = ok ? 'rgba(0,200,150,.15)' : 'rgba(255,68,102,.15)';
          badge.style.border     = '1px solid ' + (ok ? 'rgba(0,200,150,.5)' : 'rgba(255,68,102,.5)');
          badge.style.color      = ok ? 'var(--success)' : 'var(--danger,#ff4466)';
          document.getElementById('api-time').textContent = elapsed + ' ms';

          var out;
          try { out = JSON.stringify(JSON.parse(text), null, 2); }
          catch(e) { out = text; }
          document.getElementById('api-output').textContent = out;
          document.getElementById('api-response').style.display = 'block';
        });
      })
      .catch(function(e) {
        document.getElementById('api-output').textContent = 'Erreur réseau : ' + e.message;
        document.getElementById('api-response').style.display = 'block';
      });
  };
})();
</script>
@endpush

@endsection
