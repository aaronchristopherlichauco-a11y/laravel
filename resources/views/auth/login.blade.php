@extends('layouts.guest')
@section('title', 'Login')

@section('content')
    <h3>Welcome back!</h3>
    <p class="subtitle">Sign in to your EduTrack account to continue.</p>

    <form method="POST" action="{{ route('login.post') }}" novalidate>
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    autofocus
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter your password"
                    required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this, 'password')">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Remember me -->
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="font-size:.83rem;">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-4">
            <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
        </button>

        <p class="text-center mb-0" style="font-size:.875rem;color:#6b7280;">
            Don't have an account?
            <a href="{{ route('register') }}" class="auth-link">Create one</a>
        </p>
    </form>
@endsection

@push('scripts')
<script>
function togglePwd(btn, id) {
    const inp = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        inp.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endpush
