@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center"
        style="background:linear-gradient(135deg,#1a3c5e,#2d6a9f)">
        <div class="card shadow-lg border-0" style="width:420px;border-radius:16px;overflow:hidden">
            <div class="text-center py-4 px-4" style="background:#1a3c5e">
                <i class="fas fa-university fa-3x mb-2" style="color:#f0a500"></i>
                <h4 class="text-white mb-0 fw-bold">Fee Management System</h4>
                <small class="text-light opacity-75">College Semester Fee Portal</small>
            </div>
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-4 text-center text-muted">Sign in to your account</h6>
                @if ($errors->any())
                    <div class="alert alert-danger py-2 small"><i
                            class="fas fa-exclamation-triangle me-1"></i>{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">@csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="your@college.edu" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn w-100 fw-semibold text-white"
                        style="background:#1a3c5e;border-radius:8px;padding:11px">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
                {{-- <div class="mt-4 p-3 rounded" style="background:#f8fafc;border:1px dashed #cdd">
        <p class="mb-1 small fw-semibold text-muted"><i class="fas fa-info-circle me-1"></i>Demo Credentials</p>
        <p class="mb-0 small">Admin: <code>admin@college.edu</code> / <code>admin123</code></p>
        <p class="mb-0 small">Student: <code>student@college.edu</code> / <code>student123</code></p>
      </div> --}}
            </div>
        </div>
    </div>
@endsection
