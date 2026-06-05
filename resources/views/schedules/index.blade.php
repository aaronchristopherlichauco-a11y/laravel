@extends('layouts.app')
@section('title', 'Class Schedule')
@section('page-title', 'Class Schedule')
@section('breadcrumb')
    <li class="breadcrumb-item active">Schedules</li>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1><i class="bi bi-calendar3 me-2" style="color:var(--primary);"></i>Class Schedule</h1>
        <p class="text-muted mb-0" style="font-size:.85rem;">Your personal class schedule for the semester.</p>
    </div>
    <a href="{{ route('schedules.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle-fill me-2"></i>Add Schedule
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('schedules.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
            <div class="input-group" style="max-width:320px;">
                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search subject, code, instructor..." value="{{ $search }}">
            </div>
            <select name="day" class="form-select" style="width:auto;">
                <option value="">All Days</option>
                @foreach($days as $d)
                    <option value="{{ $d }}" {{ $filterDay === $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Filter</button>
            @if($search || $filterDay)
                <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>All Schedules <span class="badge" style="background:var(--accent-soft);color:var(--primary);font-weight:600;">{{ $schedules->total() }}</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Instructor</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Room</th>
                        <th>Semester</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $s)
                    <tr>
                        <td class="text-muted" style="font-size:.8rem;">{{ $schedules->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:{{ $s->color }};flex-shrink:0;"></span>
                                <div>
                                    <div class="fw-bold" style="font-size:.875rem;">{{ $s->subject_name }}</div>
                                    <div class="text-muted" style="font-size:.75rem;">{{ $s->subject_code }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.85rem;">{{ $s->instructor }}</td>
                        <td>
                            <span class="badge-day" style="background:{{ $s->color }}22;color:{{ $s->color }};border:1px solid {{ $s->color }}44;">
                                {{ $s->day }}
                            </span>
                        </td>
                        <td style="font-size:.8rem;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}<br>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</span>
                        </td>
                        <td style="font-size:.85rem;">{{ $s->room }}</td>
                        <td style="font-size:.8rem;color:#6b7280;">{{ $s->semester }}<br>{{ $s->school_year }}</td>
                        <td class="text-end">
                            <a href="{{ route('schedules.edit', $s) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form method="POST" action="{{ route('schedules.destroy', $s) }}" class="d-inline"
                                  onsubmit="return confirmDelete('{{ $s->subject_name }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x" style="font-size:2.5rem;opacity:.25;display:block;margin-bottom:8px;"></i>
                            No schedules found.
                            <br>
                            <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary mt-3">
                                <i class="bi bi-plus-circle me-1"></i>Add First Schedule
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($schedules->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $schedules->firstItem() }}–{{ $schedules->lastItem() }} of {{ $schedules->total() }}</small>
        {{ $schedules->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(name) {
    return confirm(`Delete schedule for "${name}"?`);
}
</script>
@endpush
