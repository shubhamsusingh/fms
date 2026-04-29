<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Fee Management') - {{ config('app.name') }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root{--primary:#1a3c5e;--accent:#f0a500}
body{background:#f4f6fb;font-family:'Segoe UI',sans-serif}
.sidebar{width:250px;min-height:100vh;background:var(--primary);position:fixed;top:0;left:0;z-index:100;display:flex;flex-direction:column}
.sidebar .brand{padding:22px 20px;background:rgba(0,0,0,.15)}
.sidebar .brand h5{margin:0;font-size:.95rem;color:var(--accent);font-weight:700}
.sidebar nav a{display:flex;align-items:center;gap:10px;padding:13px 22px;color:#ccd;text-decoration:none;font-size:.88rem;transition:all .2s}
.sidebar nav a:hover,.sidebar nav a.active{background:rgba(255,255,255,.1);color:#fff;border-left:3px solid var(--accent)}
.sidebar nav a i{width:18px}
.main-content{margin-left:250px}
.topbar{background:#fff;padding:14px 28px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;position:sticky;top:0;z-index:99}
.topbar .page-title{font-size:1.15rem;font-weight:600;color:var(--primary)}
.page-body{padding:28px}
.stat-card{border-radius:12px;padding:22px;color:#fff;position:relative;overflow:hidden}
.stat-card .icon{position:absolute;right:18px;top:50%;transform:translateY(-50%);font-size:3rem;opacity:.2}
.stat-card h3{font-size:1.9rem;font-weight:700;margin:0}
.stat-card p{margin:4px 0 0;font-size:.85rem;opacity:.85}
.table thead th{background:var(--primary);color:#fff;font-weight:500;border:0}
.table-hover tbody tr:hover{background:#eef3ff}
.badge-completed{background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:20px;font-size:.78rem;font-weight:600}
.badge-pending{background:#fef9c3;color:#92400e;padding:4px 10px;border-radius:20px;font-size:.78rem;font-weight:600}
.badge-failed{background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:20px;font-size:.78rem;font-weight:600}
.receipt-box{max-width:700px;margin:0 auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
.receipt-header{background:var(--primary);color:#fff;padding:30px}
@media print{.sidebar,.topbar,.no-print{display:none!important}.main-content{margin-left:0!important}.page-body{padding:0!important}}
</style>
@stack('styles')
</head>
<body>
@auth
<div class="sidebar">
  <div class="brand">
    <h5><i class="fas fa-university me-2"></i>FeeManager</h5>
    <small style="color:#aac;font-size:.75rem">College Fee System</small>
  </div>
  <nav class="mt-2">
    @if(auth()->user()->isAdmin())
      <a href="{{ route('admin.dashboard') }}"    class="{{ request()->routeIs('admin.dashboard')?'active':'' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
      <a href="{{ route('admin.students') }}"     class="{{ request()->routeIs('admin.students*')?'active':'' }}"><i class="fas fa-users"></i> Students</a>
      <a href="{{ route('admin.fee_structures') }}" class="{{ request()->routeIs('admin.fee_structures*')?'active':'' }}"><i class="fas fa-tags"></i> Fee Structures</a>
      <a href="{{ route('admin.payments') }}"     class="{{ request()->routeIs('admin.payments*')?'active':'' }}"><i class="fas fa-receipt"></i> Payments</a>
    @else
      <a href="{{ route('student.dashboard') }}"  class="{{ request()->routeIs('student.dashboard')?'active':'' }}"><i class="fas fa-home"></i> Dashboard</a>
      <a href="{{ route('payment.index') }}"      class="{{ request()->routeIs('payment.*')?'active':'' }}"><i class="fas fa-credit-card"></i> Pay Fees</a>
    @endif
  </nav>
  <div class="mt-auto p-3">
    <small class="d-block text-center" style="color:#aac;font-size:.75rem">
      {{ auth()->user()->name }}<br>
      <span class="badge bg-warning text-dark mt-1">{{ ucfirst(auth()->user()->role) }}</span>
    </small>
    <form action="{{ route('logout') }}" method="POST" class="mt-3">
      @csrf
      <button class="btn btn-outline-light btn-sm w-100"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
    </form>
  </div>
</div>
<div class="main-content">
  <div class="topbar">
    <span class="page-title">@yield('title','Dashboard')</span>
    <span class="text-muted small">{{ now()->format('D, d M Y') }}</span>
  </div>
  <div class="page-body">
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    @yield('content')
  </div>
</div>
@else
@yield('content')
@endauth
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>