@extends('admin.layout')

@section('topbar-title', 'Messages')

@section('content')
<div class="card">
  <div class="card-header">
    <h2>◉ Messages de contact</h2>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <a href="{{ route('admin.messages.index') }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-muted' }}">Tous</a>
      <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}" class="btn btn-sm {{ request('filter') === 'unread' ? 'btn-primary' : 'btn-muted' }}">Non lus</a>
      <a href="{{ route('admin.messages.index', ['filter' => 'read']) }}" class="btn btn-sm {{ request('filter') === 'read' ? 'btn-primary' : 'btn-muted' }}">Lus</a>
    </div>
  </div>
  <div class="table-wrap">
    @if($messages->isEmpty())
      <div class="card-body" style="color: var(--text-muted); font-size: 13px;">Aucun message.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Statut</th>
            <th>Mail envoyé</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Sujet</th>
            <th>Reçu le</th>
            <th>IP</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($messages as $msg)
          <tr class="{{ !$msg->is_read ? 'unread' : '' }}">
            <td>
              @if(!$msg->is_read)
                <span class="pill pill-unread">Nouveau</span>
              @else
                <span class="pill pill-read">Lu</span>
              @endif
            </td>
            <td>
              @if($msg->mail_sent)
                <span class="pill pill-sent">✓ Envoyé</span>
              @else
                <span class="pill pill-fail">✗ Échec</span>
              @endif
            </td>
            <td>{{ $msg->name }}</td>
            <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
            <td>{{ Str::limit($msg->subject, 40) }}</td>
            <td style="color: var(--text-muted); font-size: 12px; white-space: nowrap;">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
            <td style="color: var(--text-muted); font-size: 11px;">{{ $msg->ip_address ?? '—' }}</td>
            <td><a href="{{ route('admin.messages.show', $msg) }}">Voir →</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-body" style="padding-top: 0;">
        {{ $messages->links('admin.partials.pagination') }}
      </div>
    @endif
  </div>
</div>
@endsection
