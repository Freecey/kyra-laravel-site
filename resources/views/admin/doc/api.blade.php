@extends('admin.layout')

@section('topbar-title', 'Documentation — API')

@push('styles')
<style>
  .doc-section { margin-bottom: 40px; }
  .doc-section h3 {
    font-family: 'Orbitron', monospace;
    font-size: 10px;
    letter-spacing: 2px;
    color: var(--text-muted);
    text-transform: uppercase;
    margin: 0 0 16px 0;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border);
  }
  .endpoint {
    border: 1px solid var(--border);
    border-radius: 4px;
    margin-bottom: 12px;
    overflow: hidden;
  }
  .endpoint-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: var(--bg-card);
    cursor: pointer;
    user-select: none;
  }
  .endpoint-header:hover { background: var(--bg-hover); }
  .method {
    font-family: 'Orbitron', monospace;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 3px 8px;
    border-radius: 3px;
    min-width: 60px;
    text-align: center;
  }
  .method-get    { background: rgba(0,200,150,0.15); color: #00c896; border: 1px solid #00c896; }
  .method-post   { background: rgba(100,160,255,0.15); color: #64a0ff; border: 1px solid #64a0ff; }
  .method-put    { background: rgba(255,180,0,0.15); color: #ffb400; border: 1px solid #ffb400; }
  .method-patch  { background: rgba(200,130,255,0.15); color: #c882ff; border: 1px solid #c882ff; }
  .method-delete { background: rgba(255,80,80,0.15); color: var(--danger); border: 1px solid var(--danger); }
  .endpoint-path {
    font-family: 'Courier New', monospace;
    font-size: 13px;
    color: var(--text);
    flex: 1;
  }
  .endpoint-desc {
    font-size: 12px;
    color: var(--text-muted);
  }
  .endpoint-body {
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    display: none;
  }
  .endpoint-body.open { display: block; }
  .endpoint-body h4 {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    margin: 0 0 8px 0;
  }
  .endpoint-body h4:not(:first-child) { margin-top: 16px; }
  .param-table { width: 100%; font-size: 12px; margin-bottom: 4px; }
  .param-table th {
    text-align: left;
    padding: 6px 10px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    font-weight: 400;
  }
  .param-table td {
    padding: 7px 10px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    vertical-align: top;
  }
  .param-name { font-family: 'Courier New', monospace; color: var(--cyan); }
  .param-type { color: var(--text-muted); font-size: 11px; }
  .param-required {
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 3px;
    background: rgba(255,80,80,0.15);
    color: var(--danger);
    border: 1px solid var(--danger);
  }
  .param-optional {
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 3px;
    background: rgba(255,255,255,0.05);
    color: var(--text-muted);
  }
  pre.code-block {
    background: rgba(0,0,0,0.4);
    border: 1px solid var(--border);
    border-radius: 3px;
    padding: 12px 14px;
    font-size: 12px;
    font-family: 'Courier New', monospace;
    color: var(--text);
    overflow-x: auto;
    margin: 0;
    line-height: 1.6;
  }
  .info-box {
    background: rgba(0,200,255,0.07);
    border: 1px solid rgba(0,200,255,0.25);
    border-radius: 4px;
    padding: 12px 16px;
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 16px;
  }
  .info-box strong { color: var(--cyan); }
</style>
@endpush

@push('scripts')
<script>
  document.querySelectorAll('.endpoint-header').forEach(function(h) {
    h.addEventListener('click', function() {
      var body = this.nextElementSibling;
      body.classList.toggle('open');
    });
  });
</script>
@endpush

@section('content')

<div class="info-box">
  <strong>URL de base :</strong> <code>{{ config('app.url') }}/api/v1</code><br>
  <strong>Authentification :</strong> Bearer token (Sanctum) — <code>Authorization: Bearer {token}</code><br>
  <strong>Format :</strong> JSON — <code>Accept: application/json</code>
</div>

{{-- ── Articles ─────────────────────────────────────────────────────────── --}}
<div class="doc-section">
  <h3>✦ Articles</h3>

  {{-- GET /posts --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-get">GET</span>
      <span class="endpoint-path">/api/v1/posts</span>
      <span class="endpoint-desc">Lister les articles</span>
    </div>
    <div class="endpoint-body">
      <h4>Paramètres de requête</h4>
      <table class="param-table">
        <tr><th>Paramètre</th><th>Type</th><th>Requis</th><th>Description</th></tr>
        <tr><td class="param-name">status</td><td class="param-type">string</td><td><span class="param-optional">optionnel</span></td><td><code>draft</code> ou <code>published</code> — filtre par statut</td></tr>
        <tr><td class="param-name">per_page</td><td class="param-type">integer</td><td><span class="param-optional">optionnel</span></td><td>Nombre d'articles par page (défaut : 15)</td></tr>
        <tr><td class="param-name">page</td><td class="param-type">integer</td><td><span class="param-optional">optionnel</span></td><td>Numéro de page</td></tr>
      </table>
      <h4>Réponse 200</h4>
<pre class="code-block">{
  "data": [
    {
      "id": 1,
      "title": "Mon article",
      "slug": "mon-article",
      "excerpt": "...",
      "status": "published",
      "published_at": "2026-04-06T12:00:00Z",
      "featured_media": { "id": 3, "url": "https://...", "alt": "..." }
    }
  ],
  "meta": {
    "pagination": {
      "total": 42,
      "per_page": 15,
      "current_page": 1,
      "last_page": 3
    }
  }
}</pre>
    </div>
  </div>

  {{-- GET /posts/{id} --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-get">GET</span>
      <span class="endpoint-path">/api/v1/posts/{id}</span>
      <span class="endpoint-desc">Voir un article</span>
    </div>
    <div class="endpoint-body">
      <h4>Réponse 200</h4>
<pre class="code-block">{
  "data": {
    "id": 1,
    "title": "Mon article",
    "slug": "mon-article",
    "excerpt": "...",
    "content": "Contenu brut (Markdown)",
    "rendered_content": "&lt;p&gt;Contenu HTML rendu&lt;/p&gt;",
    "meta_description": "...",
    "status": "published",
    "published_at": "2026-04-06T12:00:00Z",
    "featured_media": { "id": 3, "url": "https://...", "alt": "..." },
    "media": [ { "id": 3, "url": "https://...", "alt": "...", "is_featured": true } ],
    "author": { "id": 1, "name": "Admin" }
  }
}</pre>
    </div>
  </div>

  {{-- POST /posts --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-post">POST</span>
      <span class="endpoint-path">/api/v1/posts</span>
      <span class="endpoint-desc">Créer un article</span>
    </div>
    <div class="endpoint-body">
      <h4>Corps de la requête (JSON)</h4>
      <table class="param-table">
        <tr><th>Champ</th><th>Type</th><th>Requis</th><th>Description</th></tr>
        <tr><td class="param-name">title</td><td class="param-type">string</td><td><span class="param-required">requis</span></td><td>Titre de l'article (max 255)</td></tr>
        <tr><td class="param-name">content</td><td class="param-type">string</td><td><span class="param-required">requis</span></td><td>Contenu (Markdown)</td></tr>
        <tr><td class="param-name">status</td><td class="param-type">string</td><td><span class="param-required">requis</span></td><td><code>draft</code> ou <code>published</code></td></tr>
        <tr><td class="param-name">slug</td><td class="param-type">string</td><td><span class="param-optional">optionnel</span></td><td>Auto-généré depuis le titre si absent</td></tr>
        <tr><td class="param-name">excerpt</td><td class="param-type">string</td><td><span class="param-optional">optionnel</span></td><td>Résumé (max 1000)</td></tr>
        <tr><td class="param-name">meta_description</td><td class="param-type">string</td><td><span class="param-optional">optionnel</span></td><td>Description SEO (max 255)</td></tr>
      </table>
      <h4>Réponse 201</h4>
<pre class="code-block">{ "data": { ...article... }, "message": "Article créé." }</pre>
    </div>
  </div>

  {{-- PUT /posts/{id} --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-put">PUT</span>
      <span class="endpoint-path">/api/v1/posts/{id}</span>
      <span class="endpoint-desc">Modifier un article</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0 0 12px;">Tous les champs sont optionnels (mise à jour partielle acceptée).</p>
      <table class="param-table">
        <tr><th>Champ</th><th>Type</th><th>Description</th></tr>
        <tr><td class="param-name">title</td><td class="param-type">string</td><td>Titre (max 255)</td></tr>
        <tr><td class="param-name">content</td><td class="param-type">string</td><td>Contenu (Markdown)</td></tr>
        <tr><td class="param-name">status</td><td class="param-type">string</td><td><code>draft</code> ou <code>published</code></td></tr>
        <tr><td class="param-name">slug</td><td class="param-type">string</td><td>Slug unique</td></tr>
        <tr><td class="param-name">excerpt</td><td class="param-type">string</td><td>Résumé (max 1000)</td></tr>
        <tr><td class="param-name">meta_description</td><td class="param-type">string</td><td>Description SEO (max 255)</td></tr>
      </table>
      <h4>Réponse 200</h4>
<pre class="code-block">{ "data": { ...article... }, "message": "Article mis à jour." }</pre>
    </div>
  </div>

  {{-- PATCH publish --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-patch">PATCH</span>
      <span class="endpoint-path">/api/v1/posts/{id}/publish</span>
      <span class="endpoint-desc">Publier un article</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0;">Aucun corps requis. Le <code>published_at</code> est défini au moment de la publication si absent.</p>
      <h4>Réponse 200</h4>
<pre class="code-block">{ "data": { ...article... }, "message": "Article publié." }</pre>
    </div>
  </div>

  {{-- PATCH unpublish --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-patch">PATCH</span>
      <span class="endpoint-path">/api/v1/posts/{id}/unpublish</span>
      <span class="endpoint-desc">Dépublier un article</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0;">Aucun corps requis.</p>
      <h4>Réponse 200</h4>
<pre class="code-block">{ "data": { ...article... }, "message": "Article dépublié." }</pre>
    </div>
  </div>

  {{-- DELETE /posts/{id} --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-delete">DELETE</span>
      <span class="endpoint-path">/api/v1/posts/{id}</span>
      <span class="endpoint-desc">Supprimer un article</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0;">Supprime l'article et tous ses médias associés (fichiers inclus).</p>
      <h4>Réponse 200</h4>
<pre class="code-block">{ "message": "Article supprimé." }</pre>
    </div>
  </div>
</div>

{{-- ── Médias ───────────────────────────────────────────────────────────── --}}
<div class="doc-section">
  <h3>◈ Médias</h3>

  {{-- POST /posts/{id}/media --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-post">POST</span>
      <span class="endpoint-path">/api/v1/posts/{id}/media</span>
      <span class="endpoint-desc">Uploader un média</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0 0 12px;">Requête <code>multipart/form-data</code>.</p>
      <table class="param-table">
        <tr><th>Champ</th><th>Type</th><th>Requis</th><th>Description</th></tr>
        <tr><td class="param-name">file</td><td class="param-type">file</td><td><span class="param-required">requis</span></td><td>Image — jpg, jpeg, png, webp, gif, svg (max 10 Mo)</td></tr>
        <tr><td class="param-name">alt</td><td class="param-type">string</td><td><span class="param-optional">optionnel</span></td><td>Texte alternatif (max 255)</td></tr>
      </table>
      <h4>Réponse 201</h4>
<pre class="code-block">{ "data": { "id": 5, "url": "https://...", "filename": "image.jpg", "alt": "...", "is_featured": false }, "message": "Média ajouté." }</pre>
    </div>
  </div>

  {{-- PATCH featured --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-patch">PATCH</span>
      <span class="endpoint-path">/api/v1/posts/{id}/media/{mediaId}/featured</span>
      <span class="endpoint-desc">Définir comme image vedette</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0;">Aucun corps requis. Le média doit appartenir à l'article.</p>
      <h4>Réponse 200</h4>
<pre class="code-block">{ "message": "Image vedette définie." }</pre>
    </div>
  </div>

  {{-- DELETE media --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-delete">DELETE</span>
      <span class="endpoint-path">/api/v1/posts/{id}/media/{mediaId}</span>
      <span class="endpoint-desc">Supprimer un média</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:12px;color:var(--text-muted);margin:0;">Supprime le fichier et l'enregistrement en base.</p>
      <h4>Réponse 200</h4>
<pre class="code-block">{ "message": "Média supprimé." }</pre>
    </div>
  </div>
</div>

{{-- ── Erreurs communes ────────────────────────────────────────────────── --}}
<div class="doc-section">
  <h3>▤ Erreurs communes</h3>
  <div class="card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Code HTTP</th><th>Signification</th></tr>
        </thead>
        <tbody>
          <tr><td>401</td><td>Token manquant ou invalide</td></tr>
          <tr><td>403</td><td>Accès refusé (ressource hors périmètre)</td></tr>
          <tr><td>404</td><td>Ressource introuvable</td></tr>
          <tr><td>422</td><td>Erreur de validation — champs manquants ou invalides</td></tr>
          <tr><td>500</td><td>Erreur serveur interne</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
