@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#1a3c5e,#2d6a9f)">
  <div class="card shadow-lg border-0" style="width:420px;border-radius:16px;overflow:hidden">
    <div class="text-center py-4" style="background:#1a3c5e"><h5 class="text-white mb-0">Set New Password</h5></div>
    <div class="card-body p-4">
      <form method="POST" action="{{ route('password.update') }}">@csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label small">New Password</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3"><label class="form-label small">Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
      </form>
    </div>
  </div>
</div>
@endsection
