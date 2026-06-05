@extends('layouts.app')
@section('title', 'Edit Schedule')
@section('page-title', 'Edit Schedule')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}" style="color:var(--primary);">Schedules</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="page-header">
            <h1><i class="bi bi-calendar-event-fill me-2" style="color:var(--primary);"></i>Edit Schedule</h1>
        </div>

        <div class="card">
            <div class="card-header">Editing — {{ $schedule->subject_name }}</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('schedules.update', $schedule) }}" novalidate>
                    @csrf @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" name="subject_name" class="form-control @error('subject_name') is-invalid @enderror"
                                value="{{ old('subject_name', $schedule->subject_name) }}" required>
                            @error('subject_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Subject Code <span class="text-danger">*</span></label>
                            <input type="text" name="subject_code" class="form-control @error('subject_code') is-invalid @enderror"
                                value="{{ old('subject_code', $schedule->subject_code) }}" required>
                            @error('subject_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Instructor <span class="text-danger">*</span></label>
                            <input type="text" name="instructor" class="form-control @error('instructor') is-invalid @enderror"
                                value="{{ old('instructor', $schedule->instructor) }}" required>
                            @error('instructor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Room <span class="text-danger">*</span></label>
                            <input type="text" name="room" class="form-control @error('room') is-invalid @enderror"
                                value="{{ old('room', $schedule->room) }}" required>
                            @error('room')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Day <span class="text-danger">*</span></label>
                            <select name="day" class="form-select @error('day') is-invalid @enderror" required>
                                @foreach($days as $d)
                                    <option value="{{ $d }}" {{ old('day', $schedule->day) === $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                            @error('day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required>
                            @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required>
                            @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem }}" {{ old('semester', $schedule->semester) === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                @endforeach
                            </select>
                            @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">School Year <span class="text-danger">*</span></label>
                            <input type="text" name="school_year" class="form-control @error('school_year') is-invalid @enderror"
                                value="{{ old('school_year', $schedule->school_year) }}" required>
                            @error('school_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Color picker -->
                    <div class="mb-4">
                        <label class="form-label">Label Color</label>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            @foreach($colors as $c)
                            <span class="color-swatch {{ (old('color', $schedule->color)) === $c ? 'selected' : '' }}"
                                  style="background:{{ $c }};"
                                  onclick="selectColor(this, '{{ $c }}')"></span>
                            @endforeach
                        </div>
                        <input type="hidden" name="color" id="colorInput" value="{{ old('color', $schedule->color) }}">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle-fill me-2"></i>Update Schedule
                        </button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectColor(el, color) {
    document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('colorInput').value = color;
}
</script>
@endpush
