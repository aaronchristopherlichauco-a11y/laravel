@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon teal"><i class="bi bi-calendar3"></i></div>
            <div>
                <div class="stat-value">{{ $totalSchedules }}</div>
                <div class="stat-label">My Schedules</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-person-plus-fill"></i></div>
            <div>
                <div class="stat-value">{{ $newUsersThisWeek }}</div>
                <div class="stat-label">New Users This Week</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-book-fill"></i></div>
            <div>
                <div class="stat-value">{{ $subjectDist->count() }}</div>
                <div class="stat-label">Unique Subjects</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">

    <!-- Schedules per Day - Bar Chart -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-bar-chart-fill me-2" style="color:var(--primary)"></i>Schedules per Day of Week</span>
            </div>
            <div class="card-body" style="padding:20px;">
                <canvas id="dayChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Subjects Distribution - Doughnut -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart-fill me-2" style="color:var(--primary)"></i>Subjects Distribution
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="padding:20px;">
                @if($subjectDist->count() > 0)
                    <canvas id="subjectChart" height="200"></canvas>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-calendar-x" style="font-size:2.5rem;opacity:.3;"></i>
                        <p class="mt-2 mb-0" style="font-size:.875rem;">No schedules yet. Add some!</p>
                        <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary mt-3">
                            <i class="bi bi-plus-circle me-1"></i>Add Schedule
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Semester breakdown + Recent Schedules -->
<div class="row g-3">

    <!-- By Semester - Line/Area -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up-arrow me-2" style="color:var(--primary)"></i>Schedules by Semester
            </div>
            <div class="card-body" style="padding:20px;">
                @if(!empty($bySemester))
                    <canvas id="semesterChart" height="200"></canvas>
                @else
                    <div class="text-center text-muted py-4">
                        <p style="font-size:.875rem;">No data yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Schedules -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Recent Schedules</span>
                <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentSchedules->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Room</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSchedules as $s)
                            <tr>
                                <td>
                                    <span class="me-2" style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{$s->color}};"></span>
                                    <strong>{{ $s->subject_name }}</strong>
                                    <div class="text-muted" style="font-size:.75rem;">{{ $s->subject_code }}</div>
                                </td>
                                <td><span class="badge-day" style="background:{{ $s->color }}22;color:{{ $s->color }};border:1px solid {{ $s->color }}44;">{{ $s->day }}</span></td>
                                <td style="font-size:.8rem;">{{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</td>
                                <td><span class="text-muted" style="font-size:.8rem;">{{ $s->room }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-calendar-plus" style="font-size:2.5rem;opacity:.25;"></i>
                        <p class="mt-2 mb-0" style="font-size:.875rem;">No schedules found.</p>
                        <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary mt-3">
                            <i class="bi bi-plus-circle me-1"></i>Add First Schedule
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const GREEN_PALETTE = ['#1a6b3c','#28a164','#4caf78','#74c69d','#95d5b2','#b7e4c7','#d8f3dc'];
const CHART_DEFAULTS = {
    font: { family: "'Plus Jakarta Sans', sans-serif" },
    color: '#6b7c74',
};
Chart.defaults.font = CHART_DEFAULTS.font;
Chart.defaults.color = CHART_DEFAULTS.color;

// Bar chart - per day
new Chart(document.getElementById('dayChart'), {
    type: 'bar',
    data: {
        labels: @json($dayLabels),
        datasets: [{
            label: 'Schedules',
            data: @json($dayCounts),
            backgroundColor: GREEN_PALETTE,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.parsed.y} schedule${ctx.parsed.y !== 1 ? 's' : ''}`
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 },
                grid: { color: 'rgba(0,0,0,.05)' }
            },
            x: { grid: { display: false } }
        }
    }
});

// Doughnut - subjects
@if($subjectDist->count() > 0)
new Chart(document.getElementById('subjectChart'), {
    type: 'doughnut',
    data: {
        labels: @json($subjectDist->pluck('subject_name')),
        datasets: [{
            data: @json($subjectDist->pluck('count')),
            backgroundColor: GREEN_PALETTE,
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        cutout: '68%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { boxWidth: 12, padding: 12, font: { size: 11 } }
            }
        }
    }
});
@endif

// Bar - semester
@if(!empty($bySemester))
new Chart(document.getElementById('semesterChart'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($bySemester)),
        datasets: [{
            label: 'Schedules',
            data: @json(array_values($bySemester)),
            backgroundColor: ['#1a6b3c', '#28a164', '#74c69d'],
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,.05)' } },
            x: { grid: { display: false } }
        }
    }
});
@endif
</script>
@endpush
