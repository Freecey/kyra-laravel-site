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
      <div class="detail-value" style="min-height: 120px;">{{ $message->message }}</div>
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

<div style="text-align: center;">
  <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="btn btn-primary">
    ✉ Répondre par email
  </a>
</div>
@endsection
