@extends('layouts.app')
@section('title', 'Users Management')
@section('page-title', 'Users Management')
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1><i class="bi bi-people-fill me-2" style="color:var(--primary);"></i>Users Management</h1>
        <p class="text-muted mb-0" style="font-size:.85rem;">Manage all registered users in the system.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-2"></i>Add User
    </a>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ $search }}">
            </div>
            <button class="btn btn-primary px-4" type="submit">Search</button>
            @if($search)
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">Clear</a>
            @endif
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>All Users <span class="badge" style="background:var(--accent-soft);color:var(--primary);font-weight:600;">{{ $users->total() }}</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted" style="font-size:.8rem;">{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="sidebar-user-avatar" style="width:34px;height:34px;font-size:.75rem;background:var(--primary);flex-shrink:0;">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" alt="">
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-600" style="font-weight:600;">{{ $user->name }}</div>
                                    @if($user->id === Auth::id())
                                        <span class="badge" style="background:var(--accent-soft);color:var(--primary);font-size:.68rem;">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><a href="mailto:{{ $user->email }}" class="text-decoration-none" style="color:var(--primary);">{{ $user->email }}</a></td>
                        <td><span style="font-size:.82rem;color:#6b7280;">{{ $user->created_at->format('M d, Y') }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            @if($user->id !== Auth::id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" onsubmit="return confirmDelete('{{ $user->name }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people" style="font-size:2.5rem;opacity:.25;display:block;margin-bottom:8px;"></i>
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center" style="border-top:1px solid var(--gray-200);">
        <small class="text-muted">Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</small>
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name) {
    return confirm(`Are you sure you want to delete user "${name}"? This action cannot be undone.`);
}
</script>
@endpush
