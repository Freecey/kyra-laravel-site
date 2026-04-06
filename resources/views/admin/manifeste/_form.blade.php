{{-- Shared form fields for create & edit --}}

<div class="card" style="margin-bottom:20px;">
  <div class="card-header"><h2>◈ Contenu</h2></div>
  <div class="card-body">

    <div class="form-group">
      <label class="form-label" for="quote">Citation / phrase clé *</label>
      <input type="text" id="quote" name="quote"
             class="form-control @error('quote') is-invalid @enderror"
             value="{{ old('quote', $manifeste?->quote) }}"
             placeholder="Le delta ⌬ compte plus que l'état figé."
             required autofocus>
      @error('quote')<div class="form-error">{{ $message }}</div>@enderror
      <p class="form-hint">Affiché dans le bloc en évidence (quote-block).</p>
    </div>

    <div class="form-group">
      <label class="form-label" for="body">Corps du texte</label>
      <textarea id="body" name="body" rows="4"
                class="form-control @error('body') is-invalid @enderror"
                placeholder="Développement optionnel de la citation…">{{ old('body', $manifeste?->body) }}</textarea>
      @error('body')<div class="form-error">{{ $message }}</div>@enderror
    </div>

  </div>
</div>

<div class="card" style="margin-bottom:20px;">
  <div class="card-header"><h2>◈ Affichage & épinglage</h2></div>
  <div class="card-body">

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label class="form-label" for="sort_order">Ordre d'affichage</label>
        <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
               class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $manifeste?->sort_order ?? 0) }}">
        @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
        <p class="form-hint">Plus petit = affiché en premier (après épinglés).</p>
      </div>
      <div class="form-group" style="display:flex; align-items:center; gap:10px; padding-top:28px;">
        <input type="hidden" name="is_pinned" value="0">
        <input type="checkbox" id="is_pinned" name="is_pinned" value="1"
               {{ old('is_pinned', $manifeste?->is_pinned) ? 'checked' : '' }}
               style="width:16px; height:16px; accent-color:var(--cyan);">
        <label for="is_pinned" class="form-label" style="margin:0; cursor:pointer;">
          Épinglé <span style="font-size:11px; color:var(--text-muted);">(toujours affiché en tête sur la home)</span>
        </label>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:8px;">
      <div class="form-group">
        <label class="form-label" for="starts_at">Début d'affichage</label>
        <input type="datetime-local" id="starts_at" name="starts_at"
               class="form-control @error('starts_at') is-invalid @enderror"
               value="{{ old('starts_at', $manifeste?->starts_at?->format('Y-m-d\TH:i')) }}">
        @error('starts_at')<div class="form-error">{{ $message }}</div>@enderror
        <p class="form-hint">Laisser vide = pas de limite.</p>
      </div>
      <div class="form-group">
        <label class="form-label" for="ends_at">Fin d'affichage</label>
        <input type="datetime-local" id="ends_at" name="ends_at"
               class="form-control @error('ends_at') is-invalid @enderror"
               value="{{ old('ends_at', $manifeste?->ends_at?->format('Y-m-d\TH:i')) }}">
        @error('ends_at')<div class="form-error">{{ $message }}</div>@enderror
        <p class="form-hint">Laisser vide = pas de limite.</p>
      </div>
    </div>

  </div>
</div>
