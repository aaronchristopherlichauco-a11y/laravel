@extends('layouts.app')
@section('title', 'Add User')
@section('page-title', 'Add User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" style="color:var(--primary);">Users</a></li>
    <li class="breadcrumb-item active">Add User</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="page-header">
            <h1><i class="bi bi-person-plus-fill me-2" style="color:var(--primary);"></i>Add New User</h1>
        </div>

        <div class="card">
            <div class="card-header">User Information</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('users.store') }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Juan Dela Cruz" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="user@example.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="pw1" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimum 8 characters" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this,'pw1')">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="pw2" name="password_confirmation"
                                class="form-control" placeholder="Re-enter password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this,'pw2')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-person-check-fill me-2"></i>Add User
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePwd(btn, id) {
    const inp = document.getElementById(id);
    const icon = btn.querySelector('i');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush
