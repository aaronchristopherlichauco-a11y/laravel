@extends('layouts.app')
@section('title', 'Add Schedule')
@section('page-title', 'Add Schedule')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}" style="color:var(--primary);">Schedules</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="page-header">
            <h1><i class="bi bi-calendar-plus-fill me-2" style="color:var(--primary);"></i>Add Class Schedule</h1>
        </div>

        <div class="card">
            <div class="card-header">Schedule Details</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('schedules.store') }}" novalidate>
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" name="subject_name" class="form-control @error('subject_name') is-invalid @enderror"
                                value="{{ old('subject_name') }}" placeholder="e.g. Web Systems and Technologies" required>
                            @error('subject_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Subject Code <span class="text-danger">*</span></label>
                            <input type="text" name="subject_code" class="form-control @error('subject_code') is-invalid @enderror"
                                value="{{ old('subject_code') }}" placeholder="e.g. ITEC 106" required>
                            @error('subject_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Instructor <span class="text-danger">*</span></label>
                            <input type="text" name="instructor" class="form-control @error('instructor') is-invalid @enderror"
                                value="{{ old('instructor') }}" placeholder="Prof. / Dr. Full Name" required>
                            @error('instructor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Room <span class="text-danger">*</span></label>
                            <input type="text" name="room" class="form-control @error('room') is-invalid @enderror"
                                value="{{ old('room') }}" placeholder="e.g. Lab 301 / Room A-205" required>
                            @error('room')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Day <span class="text-danger">*</span></label>
                            <select name="day" class="form-select @error('day') is-invalid @enderror" required>
                                <option value="">Select Day</option>
                                @foreach($days as $d)
                                    <option value="{{ $d }}" {{ old('day') === $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                            @error('day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                value="{{ old('start_time') }}" required>
                            @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                value="{{ old('end_time') }}" required>
                            @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                <option value="">Select Semester</option>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem }}" {{ old('semester') === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                @endforeach
                            </select>
                            @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">School Year <span class="text-danger">*</span></label>
                            <input type="text" name="school_year" class="form-control @error('school_year') is-invalid @enderror"
                                value="{{ old('school_year', '2024-2025') }}" placeholder="e.g. 2024-2025" required>
                            @error('school_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Color picker -->
                    <div class="mb-4">
                        <label class="form-label">Label Color</label>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            @foreach($colors as $c)
                            <span class="color-swatch {{ old('color', '#2d6a4f') === $c ? 'selected' : '' }}"
                                  style="background:{{ $c }};"
                                  onclick="selectColor(this, '{{ $c }}')"></span>
                            @endforeach
                        </div>
                        <input type="hidden" name="color" id="colorInput" value="{{ old('color', '#2d6a4f') }}">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-calendar-check-fill me-2"></i>Save Schedule
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
