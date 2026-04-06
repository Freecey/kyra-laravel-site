@extends('admin.layout')
@section('topbar-title', 'Utilisateurs')

@section('content')
<div class="card">
  <div class="card-header">
    <h2>Utilisateurs ({{ $users->total() }})</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Nouveau</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Créé le</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td style="color:var(--text-muted); font-size:11px;">{{ $user->id }}</td>
          <td>{{ $user->name }}
            @if($user->id === Auth::id())
              <span class="pill pill-sent" style="margin-left:6px;">moi</span>
            @endif
          </td>
          <td>{{ $user->email }}</td>
          <td>
            @if($user->role === 'admin')
              <span class="pill pill-unread">admin</span>
            @else
              <span class="pill pill-read">member</span>
            @endif
            @if(($user->status ?? 'active') === 'pending')
              <span class="pill" style="background:#b45309; color:#fff; margin-left:4px;">en attente</span>
            @endif
          </td>
          <td style="color:var(--text-muted); font-size:12px;">{{ $user->created_at->format('d/m/Y') }}</td>
          <td>
            <div style="display:flex; gap:8px; justify-content:flex-end;">
              @if(($user->status ?? 'active') === 'pending')
              <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-primary btn-sm">Approuver</button>
              </form>
              @endif
              <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-muted btn-sm">Éditer</a>
              @if($user->id !== Auth::id())
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                    onsubmit="return confirm('Supprimer {{ addslashes($user->name) }} ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:32px;">Aucun utilisateur.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($users->hasPages())
  <div class="card-body" style="padding-top:0;">
    @include('admin.partials.pagination', ['paginator' => $users])
  </div>
  @endif
</div>
@endsection
