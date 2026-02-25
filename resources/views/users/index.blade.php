@extends('layouts.admin_softui')

@section('title', 'Usuarios')

@section('content')
    <div class="ph">
        <div>
            <div class="ph-label">Administración</div>
            <div class="ph-title">Usuarios del Sistema</div>
            <div class="ph-sub">Gestiona roles, estados y permisos</div>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-solid">+ Nuevo Usuario</a>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="filter-neu" style="margin-top:6px">
        <span class="fn-label">Rol:</span>
        <select name="role" class="fn-input">
            <option value="Todos" {{ request('role') == 'Todos' ? 'selected' : '' }}>Todos</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
            <option value="viewer" {{ request('role') == 'viewer' ? 'selected' : '' }}>Solo vista</option>
        </select>
        <span class="fn-label">Estado:</span>
        <select name="status" class="fn-input">
            <option value="Todos" {{ request('status') == 'Todos' ? 'selected' : '' }}>Todos</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
        </select>
        <div class="fn-search" style="flex:1">
            <span class="fn-search-icon">🔍</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar usuario..." class="fn-input" style="box-shadow:none;padding:0;flex:1">
        </div>
        <button type="submit" class="btn btn-neu btn-sm">Filtrar</button>
    </form>

    <div class="users-grid" style="margin-top:12px">
        @forelse($users as $u)
            <div class="user-card">
                <div class="uc-avatar" style="background:var(--verde);color:var(--oro-bright)">{{ strtoupper(substr($u->name,0,1)) }}</div>
                <div class="uc-name">{{ $u->name }}</div>
                <div class="uc-email">{{ $u->email }}</div>
                <div class="uc-tags">
                    <span class="badge-neu" style="color:{{ $u->role==='admin' ? 'var(--verde)' : ($u->role==='editor' ? 'var(--blue)' : 'var(--text)') }};font-size:11px">{{ ucfirst($u->role) }}</span>
                    <span class="badge-neu" style="color:{{ $u->status==='active' ? 'var(--green)' : 'var(--red)' }};font-size:11px">{{ $u->status==='active'?'● Activo':'○ Inactivo' }}</span>
                </div>
                <div class="uc-stats">
                    <div class="uc-stat"><div class="uc-stat-val">—</div><div class="uc-stat-label">Encuestas</div></div>
                    <div class="uc-stat"><div class="uc-stat-val">—</div><div class="uc-stat-label">Acciones</div></div>
                </div>
                <div class="uc-actions">
                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-neu btn-sm" style="flex:1">✏ Editar</a>
                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-neu btn-sm btn-icon" style="color:var(--red)">🗑</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="badge-neu" style="color:var(--text-muted)">No se encontraron usuarios.</div>
        @endforelse
    </div>

    <div style="margin-top:12px">{{ $users->appends(request()->query())->links() }}</div>
@endsection
