{{-- Shared form fields for create & edit --}}

<div class="card" style="margin-bottom:20px;">
  <div class="card-header"><h2>◈ Contenu</h2></div>
  <div class="card-body">

    <div class="form-group">
      <label class="form-label" for="title">Titre *</label>
      <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
             value="{{ old('title', $post?->title) }}" required autofocus>
      @error('title')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="slug">Slug (URL) *</label>
      <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
             value="{{ old('slug', $post?->slug) }}" required>
      @error('slug')<div class="form-error">{{ $message }}</div>@enderror
      @if($post)
        <p class="form-hint">URL : <code style="color:var(--cyan);">{{ config('app.url') }}/blog/{{ $post->slug }}</code></p>
      @endif
    </div>

    <div class="form-group">
      <label class="form-label" for="excerpt">Résumé <span style="font-size:10px;">(affiché dans la liste)</span></label>
      <textarea id="excerpt" name="excerpt" rows="3"
                class="form-control @error('excerpt') is-invalid @enderror"
                placeholder="Court résumé visible en aperçu…">{{ old('excerpt', $post?->excerpt) }}</textarea>
      @error('excerpt')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="content">Contenu *</label>
      <p class="form-hint" style="margin-bottom:6px;">
        Supports HTML. Pour insérer un média associé : <code style="color:var(--cyan);">[media:ID]</code>
      </p>
      <textarea id="content" name="content" rows="20"
                class="form-control @error('content') is-invalid @enderror"
                style="font-family: 'Share Tech Mono', monospace; font-size:13px;">{{ old('content', $post?->content) }}</textarea>
      @error('content')<div class="form-error">{{ $message }}</div>@enderror
    </div>

  </div>
</div>

<div class="card" style="margin-bottom:20px;">
  <div class="card-header"><h2>◈ Publication & SEO</h2></div>
  <div class="card-body">

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label class="form-label" for="status">Statut</label>
        <select id="status" name="status" class="form-control">
          <option value="draft"     {{ old('status', $post?->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Brouillon</option>
          <option value="published" {{ old('status', $post?->status) === 'published' ? 'selected' : '' }}>Publié</option>
        </select>
      </div>

      @if($post?->published_at)
        <div class="form-group">
          <label class="form-label">Publié le</label>
          <div class="detail-value" style="font-size:13px;">{{ $post->published_at->format('d/m/Y H:i') }}</div>
        </div>
      @endif
    </div>

    <div class="form-group">
      <label class="form-label" for="meta_description">Meta description <span style="font-size:10px;">(max 255 car.)</span></label>
      <input type="text" id="meta_description" name="meta_description" maxlength="255"
             class="form-control @error('meta_description') is-invalid @enderror"
             value="{{ old('meta_description', $post?->meta_description) }}"
             placeholder="Description pour les moteurs de recherche…">
      @error('meta_description')<div class="form-error">{{ $message }}</div>@enderror
    </div>

  </div>
</div>
