@extends('admin.layout')

@section('topbar-title', 'Dashboard')

@section('content')
<div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(130px,1fr));">
  <div class="stat-card">
    <div class="stat-value">{{ $totalMessages }}</div>
    <div class="stat-label">Messages total</div>
  </div>
  <div class="stat-card">
    <div class="stat-value {{ $unreadMessages > 0 ? 'danger' : '' }}">{{ $unreadMessages }}</div>
    <div class="stat-label">Non lus</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--cyan);">{{ $totalUsers }}</div>
    <div class="stat-label">Utilisateurs</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ $viewsToday }}</div>
    <div class="stat-label">Vues aujourd'hui</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ $viewsWeek }}</div>
    <div class="stat-label">Vues 7 jours</div>
  </div>
  <div class="stat-card">
    <div class="stat-value" style="color:var(--success);">{{ $viewsMonth }}</div>
    <div class="stat-label">Vues 30 jours</div>
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

<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <h2>◎ Derniers inscrits</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-muted">Tous les utilisateurs →</a>
  </div>
  <div class="table-wrap">
    @if($recentUsers->isEmpty())
      <div class="card-body" style="color: var(--text-muted); font-size: 13px;">Aucun utilisateur.</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Inscrit le</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentUsers as $u)
          <tr>
            <td>{{ $u->name }}</td>
            <td style="color: var(--text-muted);">{{ $u->email }}</td>
            <td>
              @if($u->isAdmin())
                <span class="pill" style="background:rgba(0,200,200,.12); color:var(--cyan);">admin</span>
              @else
                <span class="pill pill-read">member</span>
              @endif
            </td>
            <td style="color: var(--text-muted); font-size: 12px;">{{ $u->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
@endsection
