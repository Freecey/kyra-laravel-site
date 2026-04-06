@extends('admin.layout')

@section('topbar-title', 'Dashboard')

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-value">{{ $totalMessages }}</div>
    <div class="stat-label">Messages total</div>
  </div>
  <div class="stat-card">
    <div class="stat-value {{ $unreadMessages > 0 ? 'danger' : '' }}">{{ $unreadMessages }}</div>
    <div class="stat-label">Non lus</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h2>◉ Derniers messages</h2>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-muted">Tous les messages →</a>
  </div>
  <div class="table-wrap">
    @if($recentMessages->isEmpty())
      <div class="card-body" style="color: var(--text-muted); font-size: 13px;">Aucun message reçu.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Statut</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Sujet</th>
            <th>Reçu le</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentMessages as $msg)
          <tr class="{{ !$msg->is_read ? 'unread' : '' }}">
            <td>
              @if(!$msg->is_read)
                <span class="pill pill-unread">Nouveau</span>
              @else
                <span class="pill pill-read">Lu</span>
              @endif
            </td>
            <td>{{ $msg->name }}</td>
            <td style="color: var(--text-muted);">{{ $msg->email }}</td>
            <td>{{ Str::limit($msg->subject, 40) }}</td>
            <td style="color: var(--text-muted); font-size: 12px;">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
            <td><a href="{{ route('admin.messages.show', $msg) }}">Voir →</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
@endsection
