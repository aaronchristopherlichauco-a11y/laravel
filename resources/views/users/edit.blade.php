@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" style="color:var(--primary);">Users</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="page-header">
            <h1><i class="bi bi-pencil-fill me-2" style="color:var(--primary);"></i>Edit User</h1>
        </div>

        <div class="card">
            <div class="card-header">Edit — {{ $user->name }}</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('users.update', $user) }}" novalidate>
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle-fill me-2"></i>Save Changes
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
