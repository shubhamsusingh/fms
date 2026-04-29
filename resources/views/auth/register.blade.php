@extends('layouts.app')
@section('title','Register')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#1a3c5e,#2d6a9f)">
  <div class="card shadow-lg border-0 text-center p-5" style="width:400px;border-radius:16px">
    <i class="fas fa-lock fa-3x mb-3 text-muted"></i>
    <h5 class="fw-bold">Self-Registration Disabled</h5>
    <p class="text-muted">Student accounts are created by the admin only.</p>
    <a href="{{ route('login') }}" class="btn btn-primary mt-2">Go to Login</a>
  </div>
</div>
@endsection
