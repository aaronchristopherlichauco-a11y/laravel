@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="row g-4">

    <!-- Left: Avatar + Stats -->
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <!-- Avatar display -->
                <div class="d-flex justify-content-center mb-3">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="avatar-circle" alt="Profile">
                    @else
                        <div class="avatar-initial mx-auto">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                </div>

                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3" style="font-size:.85rem;">{{ $user->email }}</p>

                @if($user->gender)
                    <span class="badge" style="background:var(--accent-soft);color:var(--primary);font-size:.78rem;">{{ $user->gender }}</span>
                @endif

                <hr class="my-3">

                <div class="text-start">
                    @if($user->phone)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-telephone-fill" style="color:var(--primary);"></i>
                        <span style="font-size:.85rem;">{{ $user->phone }}</span>
                    </div>
                    @endif
                    @if($user->address)
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-geo-alt-fill mt-1" style="color:var(--primary);"></i>
                        <span style="font-size:.85rem;">{{ $user->address }}</span>
                    </div>
                    @endif
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-calendar-event-fill" style="color:var(--primary);"></i>
                        <span style="font-size:.85rem;">Joined {{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Avatar Upload Form -->
                <hr class="my-3">
                <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label text-start d-block" style="font-size:.8rem;">Update Profile Picture</label>
                    <input type="file" name="avatar" accept="image/*" class="form-control form-control-sm mb-2 @error('avatar') is-invalid @enderror"
                           onchange="this.form.submit()">
                    @error('avatar')<div class="invalid-feedback" style="font-size:.75rem;">{{ $message }}</div>@enderror
                    <small class="text-muted d-block" style="font-size:.72rem;">JPG, PNG, WEBP — Max 2MB</small>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Edit Form -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-gear me-2" style="color:var(--primary);"></i>Edit Profile Information
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.update') }}" novalidate>
                    @csrf @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}" placeholder="e.g. 09XX-XXX-XXXX">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">Prefer not to say</option>
                                @foreach(['Male','Female','Prefer not to say'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $user->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                            rows="2" placeholder="Your home address...">{{ old('address', $user->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-3">
                    <p class="fw-bold mb-3" style="font-size:.875rem;color:var(--gray-500);">
                        <i class="bi bi-shield-lock me-1"></i>Change Password <span class="text-muted fw-normal">(leave blank to keep current)</span>
                    </p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" id="np" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Min 8 characters">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this,'np')">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" id="npc" name="password_confirmation"
                                    class="form-control" placeholder="Re-enter new password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this,'npc')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle-fill me-2"></i>Update Profile
                    </button>
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
