@extends('admin.layout')

@section('topbar-title', 'Message #' . $message->id)

@section('content')
<div style="margin-bottom: 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
  <a href="{{ route('admin.messages.index') }}" class="btn btn-muted btn-sm">← Retour</a>
  <div style="display:flex; gap:8px; flex-wrap:wrap;">
    @if($message->is_read)
      <form method="POST" action="{{ route('admin.messages.unread', $message) }}">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-muted">Marquer non lu</button>
      </form>
    @else
      <form method="POST" action="{{ route('admin.messages.read', $message) }}">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-primary">Marquer lu</button>
      </form>
    @endif
    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
          onsubmit="return confirm('Supprimer ce message ?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
    </form>
  </div>
</div>

{{-- Flash messages --}}
@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
@endif
@if(session('warning'))
  <div class="alert alert-warning" style="margin-bottom:16px;">{{ session('warning') }}</div>
@endif

{{-- Original message --}}
<div class="card">
  <div class="card-header">
    <h2>◉ Message #{{ $message->id }}</h2>
    <div style="display:flex; gap:8px;">
      @if(!$message->is_read)
        <span class="pill pill-unread">Non lu</span>
      @else
        <span class="pill pill-read">Lu</span>
      @endif
      @if($message->mail_sent)
        <span class="pill pill-sent">Mail envoyé</span>
      @else
        <span class="pill pill-fail">Mail non envoyé</span>
      @endif
    </div>
  </div>
  <div class="card-body">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div class="detail-field">
        <div class="detail-label">Nom</div>
        <div class="detail-value">{{ $message->name }}</div>
      </div>
      <div class="detail-field">
        <div class="detail-label">Email</div>
        <div class="detail-value">
          <a href="mailto:{{ $message->email }}" style="color: var(--cyan);">{{ $message->email }}</a>
        </div>
      </div>
    </div>

    <div class="detail-field">
      <div class="detail-label">Sujet</div>
      <div class="detail-value">{{ $message->subject }}</div>
    </div>

    <div class="detail-field">
      <div class="detail-label">Message</div>
      <div class="detail-value" style="min-height: 120px; white-space: pre-wrap;">{{ $message->message }}</div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div class="detail-field">
        <div class="detail-label">Reçu le</div>
        <div class="detail-value">{{ $message->created_at->format('d/m/Y à H:i:s') }}</div>
      </div>
      <div class="detail-field">
        <div class="detail-label">IP</div>
        <div class="detail-value">{{ $message->ip_address ?? '—' }}</div>
      </div>
    </div>
  </div>
</div>

{{-- Reply history --}}
@if($message->replies->isNotEmpty())
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>◉ Réponses envoyées ({{ $message->replies->count() }})</h2>
  </div>
  <div class="card-body" style="padding:0;">
    @foreach($message->replies as $reply)
    <div style="padding:20px; @if(!$loop->last) border-bottom: 1px solid var(--border-color, #1e3a4a); @endif">
      <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap; margin-bottom:12px;">
        <div>
          <div class="detail-label" style="margin-bottom:2px;">Sujet</div>
          <div style="font-weight:600; color: var(--cyan);">{{ $reply->subject }}</div>
        </div>
        <div style="text-align:right; font-size:12px; color:#6b8fa3;">
          @if($reply->sent_at)
            ✓ Envoyé le {{ $reply->sent_at->format('d/m/Y à H:i') }}
          @else
            <span style="color:#f87171;">✗ Non envoyé</span>
          @endif<br>
          Créé le {{ $reply->created_at->format('d/m/Y à H:i') }}
        </div>
      </div>
      <div class="detail-value" style="white-space: pre-wrap; margin-bottom:12px;">{{ $reply->body }}</div>
      @if($reply->attachments->isNotEmpty())
        <div>
          <div class="detail-label" style="margin-bottom:6px;">Pièces jointes</div>
          <div style="display:flex; flex-wrap:wrap; gap:8px;">
            @foreach($reply->attachments as $att)
            <a href="{{ route('admin.messages.replies.attachment', [$reply, $att->id]) }}"
               class="btn btn-muted btn-sm"
               style="font-size:12px;">
              📎 {{ $att->original_name }}
              <span style="opacity:0.6; margin-left:4px;">({{ number_format($att->size / 1024, 1) }} Ko)</span>
            </a>
            @endforeach
          </div>
        </div>
      @endif
    </div>
    @endforeach
  </div>
</div>
@endif

{{-- Reply form --}}
<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>◉ Répondre à {{ $message->name }}</h2>
  </div>
  <div class="card-body">
    @if($errors->any())
      <div class="alert alert-danger" style="margin-bottom:16px;">
        <ul style="margin:0; padding-left:18px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST"
          action="{{ route('admin.messages.replies.store', $message) }}"
          enctype="multipart/form-data">
      @csrf

      <div class="form-group" style="margin-bottom:16px;">
        <label class="detail-label" for="reply-subject">Sujet</label>
        <input type="text"
               id="reply-subject"
               name="subject"
               class="form-control"
               value="{{ old('subject', 'Re: ' . $message->subject) }}"
               required
               style="width:100%; box-sizing:border-box;">
      </div>

      <div class="form-group" style="margin-bottom:16px;">
        <label class="detail-label" for="reply-body">Message</label>
        <textarea id="reply-body"
                  name="body"
                  rows="10"
                  class="form-control"
                  required
                  style="width:100%; box-sizing:border-box; resize:vertical;">{{ old('body') }}</textarea>
      </div>

      <div class="form-group" style="margin-bottom:20px;">
        <label class="detail-label" for="reply-attachments">Pièces jointes (optionnel, max 10 Mo chacune)</label>
        <input type="file"
               id="reply-attachments"
               name="attachments[]"
               multiple
               class="form-control"
               style="width:100%; box-sizing:border-box;">
      </div>

      <button type="submit" class="btn btn-primary">✉ Envoyer la réponse</button>
    </form>
  </div>
</div>
@endsection
