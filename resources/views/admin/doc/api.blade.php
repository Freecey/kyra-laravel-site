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
  <strong>URL de base :</strong> <code>{{ url('/api/v1') }}</code><br>
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
      "featured_image_url": "https://...",
      "featured_image_position": "center",
      "meta_description": "...",
      "created_at": "2026-04-06T10:00:00Z",
      "updated_at": "2026-04-06T11:00:00Z"
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
    "featured_image_url": "https://...",
    "featured_image_position": "center",
    "meta_description": "...",
    "created_at": "2026-04-06T10:00:00Z",
    "updated_at": "2026-04-06T11:00:00Z",
    "media": [ { "id": 3, "filename": "photo.webp", "url": "https://...", "mime_type": "image/webp", "size": 42000, "alt": "...", "tag": "[media:3]" } ],
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
        <tr><td class="param-name">featured_image_position</td><td class="param-type">string</td><td><span class="param-optional">optionnel</span></td><td><code>top</code> · <code>top-center</code> · <code>center</code> · <code>center-bottom</code> · <code>bottom</code> (défaut : <code>center</code>)</td></tr>
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
        <tr><td class="param-name">featured_image_position</td><td class="param-type">string</td><td><code>top</code> · <code>top-center</code> · <code>center</code> · <code>center-bottom</code> · <code>bottom</code></td></tr>
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
<pre class="code-block">{ "data": { "id": 5, "filename": "photo.webp", "url": "https://...", "mime_type": "image/webp", "size": 42000, "alt": "...", "tag": "[media:5]" }, "message": "Média ajouté." }</pre>
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

{{-- ── Shortcode [media:ID] ─────────────────────────────────────────── --}}
<div class="doc-section">
  <h3>⬡ Intégrer des médias dans le contenu</h3>

  <div class="info-box">
    Une fois un média uploadé sur un article, son <strong>tag</strong> (ex. <code>[media:5]</code>) peut être inséré directement dans le champ <code>content</code> (Markdown). Il sera automatiquement remplacé par une balise <code>&lt;img&gt;</code> au rendu.
  </div>

  <div class="endpoint">
    <div class="endpoint-header" style="cursor:default;">
      <span class="method" style="background:rgba(255,255,255,0.06);color:var(--text-muted);border-color:var(--border);min-width:auto;padding:3px 10px;">TAG</span>
      <span class="endpoint-path">[media:{id}]</span>
      <span class="endpoint-desc">Syntaxe de base — insère l'image (pleine largeur par défaut)</span>
    </div>
  </div>

  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method" style="background:rgba(255,255,255,0.06);color:var(--text-muted);border-color:var(--border);min-width:auto;padding:3px 10px;">OPTIONS</span>
      <span class="endpoint-path">[media:{id} maxw=N maxh=N align=start|center|end]</span>
      <span class="endpoint-desc">Options combinables</span>
    </div>
    <div class="endpoint-body">
      <h4>Paramètres disponibles</h4>
      <table class="param-table">
        <tr><th>Option</th><th>Type</th><th>Description</th></tr>
        <tr><td class="param-name">maxw</td><td class="param-type">integer (px)</td><td>Largeur maximale de l'image (<code>max-width</code>)</td></tr>
        <tr><td class="param-name">maxh</td><td class="param-type">integer (px)</td><td>Hauteur maximale de l'image (<code>max-height</code>)</td></tr>
        <tr><td class="param-name">align</td><td class="param-type">start · center · end</td><td>Alignement horizontal via auto-margin. <code>center</code> = centré, <code>end</code> = droite, <code>start</code> = gauche (défaut)</td></tr>
      </table>
      <h4>Exemples</h4>
<pre class="code-block"># Image simple
[media:5]

# Image centrée, max 400 px de large
[media:5 maxw=400 align=center]

# Image à droite, max 200 px de haut
[media:5 maxh=200 align=end]

# Toutes les options ensemble
[media:5 maxw=600 maxh=400 align=center]</pre>
      <h4>Workflow recommandé (agent IA)</h4>
      <ol style="font-size:12px;color:var(--text-muted);padding-left:18px;line-height:1.8;margin:0;">
        <li>Créer l'article : <code>POST /posts</code> → récupérer <code>data.id</code></li>
        <li>Uploader les médias : <code>POST /posts/{id}/media</code> → récupérer <code>data.tag</code> de chaque média</li>
        <li>Mettre à jour le contenu avec les tags : <code>PUT /posts/{id}</code> en insérant <code>data.tag</code> aux bons endroits dans le Markdown</li>
        <li>Publier : <code>PATCH /posts/{id}/publish</code></li>
      </ol>
    </div>
  </div>
</div>

{{-- ── Manifestes ───────────────────────────────────────────────────────── --}}
<div class="doc-section">
  <h3>⌬ Manifestes</h3>

  <div class="info-box">
    Endpoint <strong>public</strong> — aucune authentification requise. Retourne uniquement les manifestes actifs (dates respectées).
    La gestion (création, édition, suppression, épinglage) se fait via l'interface admin.
  </div>

  {{-- GET /manifestes --}}
  <div class="endpoint">
    <div class="endpoint-header">
      <span class="method method-get">GET</span>
      <span class="endpoint-path">/api/v1/manifestes</span>
      <span class="endpoint-desc">Lister les manifestes actifs</span>
    </div>
    <div class="endpoint-body">
      <div class="info-box" style="margin-bottom:12px;">Route publique — pas de token requis.</div>
      <h4>Réponse 200</h4>
<pre class="code-block">{
  "data": [
    {
      "id": 1,
      "quote": "Le delta ⌬ compte plus que l'état figé.",
      "body": "Kyra s'intéresse aux transitions, aux dérives, aux signaux faibles.",
      "is_pinned": true,
      "sort_order": 0,
      "starts_at": null,
      "ends_at": null
    }
  ]
}</pre>
      <h4>Tri</h4>
      <p style="font-size:12px;color:var(--text-muted);margin:0;">Les résultats sont triés par : épinglés en premier, puis <code>sort_order</code> ASC, puis <code>id</code> DESC.</p>
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

{{-- ── Prompt agent IA ──────────────────────────────────────────────────── --}}
<div class="doc-section">
  <h3>◎ Prompt pour agent IA</h3>

  <div class="info-box" style="margin-bottom:16px;">
    Colle ce texte dans le system prompt ou le context de ton agent IA pour lui donner accès à l'API directement, ou pour qu'il génère ses propres <em>tools</em>.
  </div>

  <div style="position:relative;">
    <button id="copy-prompt-btn" onclick="copyPrompt()" style="position:absolute;top:10px;right:10px;background:rgba(0,200,255,0.1);border:1px solid var(--cyan);color:var(--cyan);padding:4px 12px;border-radius:3px;font-size:11px;letter-spacing:1px;cursor:pointer;text-transform:uppercase;font-family:inherit;">
      Copier
    </button>
    <pre class="code-block" id="agent-prompt" style="white-space:pre-wrap;padding-right:90px;">## Kyra Blog API

You have access to the Kyra blog REST API. Always send:
  Authorization: Bearer {TOKEN}
  Accept: application/json
  Content-Type: application/json  (for POST/PUT)

Base URL: {{ url('/api/v1') }}

---

### List articles
GET /posts
Query params (all optional):
  status    = "draft" | "published"
  per_page  = integer (default 15)
  page      = integer
Response 200: { data: [...posts], meta: { pagination: { total, per_page, current_page, last_page } } }
  post fields: { id, title, slug, excerpt, status, published_at, featured_image_url, featured_image_position, meta_description, created_at, updated_at }

### Get one article
GET /posts/{id}
Response 200: { data: { id, title, slug, excerpt, content, rendered_content, meta_description, status, published_at, featured_image_url, featured_image_position, created_at, updated_at, media[], author } }
  media item fields: { id, filename, url, mime_type, size, alt, tag }

### Create article
POST /posts
Body (JSON):
  title            string  REQUIRED
  content          string  REQUIRED  (Markdown)
  status           string  REQUIRED  "draft" | "published"
  slug             string  optional  (auto-generated from title if omitted)
  excerpt          string  optional  (max 1000 chars)
  meta_description        string  optional  (max 255 chars)
  featured_image_position  string  optional  "top" | "top-center" | "center" | "center-bottom" | "bottom" (default: "center")
Response 201: { data: {...post}, message: "Article créé." }

### Update article
PUT /posts/{id}
Body (JSON): same fields as create (including featured_image_position), all optional (partial update)
Response 200: { data: {...post}, message: "Article mis à jour." }

### Publish article
PATCH /posts/{id}/publish
No body required.
Response 200: { data: {...post}, message: "Article publié." }

### Unpublish article
PATCH /posts/{id}/unpublish
No body required.
Response 200: { data: {...post}, message: "Article dépublié." }

### Delete article
DELETE /posts/{id}
Deletes article and all associated media files.
Response 200: { message: "Article supprimé." }

### Upload media to an article
POST /posts/{id}/media
Multipart form-data:
  file  file    REQUIRED  Image (jpg, jpeg, png, webp, gif, svg, max 10 MB)
  alt   string  optional  Alt text (max 255 chars)
Response 201: { data: { id, filename, url, mime_type, size, alt, tag }, message: "Média ajouté." }

### Set featured image
PATCH /posts/{id}/media/{mediaId}/featured
No body required. Media must belong to the article.
Response 200: { message: "Image vedette définie." }

### Delete media
DELETE /posts/{id}/media/{mediaId}
Deletes file from storage and DB record.
Response 200: { message: "Média supprimé." }

---

### Manifestes — public (no auth)
GET /manifestes
Returns only active manifestes (start/end dates respected).
Response 200: { data: [ { id, quote, body, is_pinned, sort_order, starts_at, ends_at, created_at, updated_at } ] }
Sorting: pinned first → sort_order ASC → id DESC.

### Manifestes — admin (auth required)

GET /manifestes/all
Query params (optional): active=1|0 (filter by active/inactive; omit to get all)
Response 200: { data: [...manifestes] }

GET /manifestes/{id}
Response 200: { data: {...manifeste} }

POST /manifestes
Body (JSON):
  quote       string   REQUIRED  Main quote (max 500)
  body        string   optional  Body text (max 2000)
  is_pinned   boolean  optional  Pin to top (default false)
  sort_order  integer  optional  Ascending order key (default 0)
  starts_at   datetime optional  Visibility start (ISO 8601)
  ends_at     datetime optional  Visibility end ≥ starts_at
Response 201: { data: {...manifeste}, message: "Manifeste créé." }

PUT /manifestes/{id}
Body (JSON): same fields as create, all optional (partial update)
Response 200: { data: {...manifeste}, message: "Manifeste mis à jour." }

PATCH /manifestes/{id}/pin
No body. Sets is_pinned to true.
Response 200: { data: {...manifeste}, message: "Manifeste épinglé." }

PATCH /manifestes/{id}/unpin
No body. Sets is_pinned to false.
Response 200: { data: {...manifeste}, message: "Manifeste déépinglé." }

DELETE /manifestes/{id}
Response 200: { message: "Manifeste supprimé." }

---

### Embedding media in article content — [media:ID] shortcodes
After uploading a media, its `tag` field (e.g. `[media:5]`) can be placed anywhere in the `content`
Markdown. It is replaced by an <img> tag at render time (visible in `rendered_content`).

Syntax:
  [media:{id}]                              — basic, full width
  [media:{id} maxw=N]                       — max-width in px
  [media:{id} maxh=N]                       — max-height in px
  [media:{id} align=start|center|end]       — horizontal alignment
  [media:{id} maxw=400 maxh=300 align=center]  — all options combined

Recommended workflow:
  1. POST /posts                → get article id
  2. POST /posts/{id}/media     → get tag for each image (e.g. "[media:5]")
  3. PUT  /posts/{id}           → update content with tags embedded in Markdown
  4. PATCH /posts/{id}/publish

---

### Error codes
401  Missing or invalid token
403  Forbidden (resource does not belong to this context)
404  Resource not found
422  Validation error — check field constraints above
500  Internal server error</pre>
  </div>
</div>

@push('scripts')
<script>
function copyPrompt() {
  var text = document.getElementById('agent-prompt').innerText;
  navigator.clipboard.writeText(text).then(function() {
    var btn = document.getElementById('copy-prompt-btn');
    btn.textContent = 'Copié !';
    btn.style.color = 'var(--success, #00c896)';
    btn.style.borderColor = 'var(--success, #00c896)';
    setTimeout(function() {
      btn.textContent = 'Copier';
      btn.style.color = 'var(--cyan)';
      btn.style.borderColor = 'var(--cyan)';
    }, 2000);
  });
}
</script>
@endpush

@endsection
