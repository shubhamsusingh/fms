@extends('layouts.app')
@section('title','Forgot Password')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#1a3c5e,#2d6a9f)">
  <div class="card shadow-lg border-0" style="width:420px;border-radius:16px;overflow:hidden">
    <div class="text-center py-4" style="background:#1a3c5e"><i class="fas fa-key fa-2x mb-2" style="color:#f0a500"></i><h5 class="text-white mb-0">Reset Password</h5></div>
    <div class="card-body p-4">
      @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
      <form method="POST" action="{{ route('password.email') }}">@csrf
        <div class="mb-3"><label class="form-label fw-semibold small">Email Address</label><input type="email" name="email" class="form-control" required></div>
        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        <a href="{{ route('login') }}" class="btn btn-link w-100 mt-1">Back to Login</a>
      </form>
    </div>
  </div>
</div>
@endsection
