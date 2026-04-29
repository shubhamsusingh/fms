@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
<div class="row g-4 mb-4">
  <div class="col-md-3"><div class="stat-card" style="background:linear-gradient(135deg,#1a3c5e,#2d6a9f)"><p>Total Students</p><h3>{{ $stats['total_students'] }}</h3><i class="fas fa-users icon"></i></div></div>
  <div class="col-md-3"><div class="stat-card" style="background:linear-gradient(135deg,#065f46,#059669)"><p>Total Collected</p><h3>&#8377;{{ number_format($stats['total_collected'],0) }}</h3><i class="fas fa-rupee-sign icon"></i></div></div>
  <div class="col-md-3"><div class="stat-card" style="background:linear-gradient(135deg,#92400e,#d97706)"><p>Pending Payments</p><h3>{{ $stats['pending_payments'] }}</h3><i class="fas fa-clock icon"></i></div></div>
  <div class="col-md-3"><div class="stat-card" style="background:linear-gradient(135deg,#5b21b6,#7c3aed)"><p>Completed Payments</p><h3>{{ $stats['total_payments'] }}</h3><i class="fas fa-check-circle icon"></i></div></div>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
    <h6 class="mb-0 fw-semibold"><i class="fas fa-history me-2 text-primary"></i>Recent Payments</h6>
    <a href="{{ route('admin.payments') }}" class="btn btn-sm btn-outline-primary">View All</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Receipt No</th><th>Student</th><th>Course/Sem</th><th>Amount</th><th>Method</th><th>Paid At</th><th></th></tr></thead>
        <tbody>
          @forelse($recentPayments as $p)
          <tr>
            <td><code class="text-primary">{{ $p->receipt_no }}</code></td>
            <td>{{ $p->student->user->name }}<br><small class="text-muted">{{ $p->student->enrollment_no }}</small></td>
            <td>{{ $p->feeStructure->course }} &ndash; Sem {{ $p->feeStructure->semester }}</td>
            <td class="fw-semibold">&#8377;{{ number_format($p->amount,0) }}</td>
            <td>@if($p->payment_method==='paypal')<span class="badge" style="background:#003087;color:#fff"><i class="fab fa-paypal me-1"></i>PayPal</span>@else<span class="badge bg-secondary">Offline</span>@endif</td>
            <td>{{ $p->paid_at?->format('d M Y, h:i A') }}</td>
            <td><a href="{{ route('admin.payments.receipt',$p) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-alt"></i></a></td>
          </tr>
          @empty<tr><td colspan="7" class="text-center text-muted py-4">No payments yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
