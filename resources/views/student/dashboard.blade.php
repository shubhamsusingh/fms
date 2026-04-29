@extends('layouts.app')
@section('title','My Dashboard')
@section('content')
@if($student)
<div class="card border-0 shadow-sm mb-4" style="border-left:4px solid #1a3c5e!important">
  <div class="card-body">
    <div class="row align-items-center">
      <div class="col-auto">
        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width:60px;height:60px;background:#1a3c5e;font-size:1.5rem">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      </div>
      <div class="col">
        <h5 class="mb-0 fw-bold">{{ auth()->user()->name }}</h5>
        <p class="mb-0 text-muted small"><code>{{ $student->enrollment_no }}</code> &bull; {{ $student->course }}/{{ $student->branch }} &bull; Semester {{ $student->semester }} &bull; Batch {{ $student->batch }}</p>
      </div>
      <div class="col-auto">
        @if($student->hasPaidFee())<span class="badge-completed fs-6 px-3 py-2"><i class="fas fa-check-circle me-1"></i>Fee Paid</span>
        @else<span class="badge-pending fs-6 px-3 py-2"><i class="fas fa-clock me-1"></i>Fee Pending</span>@endif
      </div>
    </div>
  </div>
</div>
@if($pendingFee)
<div class="alert border-0 shadow-sm mb-4" style="background:linear-gradient(135deg,#fff3cd,#fff8e1);border-left:4px solid #f0a500!important">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h6 class="mb-1 fw-bold"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Fee Due – Semester {{ $pendingFee->semester }}</h6>
      <p class="mb-0 small text-muted">Total: <strong>&#8377;{{ number_format($pendingFee->total_fee,0) }}</strong> &bull; Due: {{ $pendingFee->due_date->format('d M Y') }}</p>
    </div>
    <a href="{{ route('payment.index') }}" class="btn btn-warning fw-semibold"><i class="fas fa-credit-card me-1"></i>Pay Now</a>
  </div>
</div>
@endif
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
    <h6 class="mb-0 fw-semibold"><i class="fas fa-history me-2 text-primary"></i>Payment History</h6>
    <a href="{{ route('payment.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Make Payment</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Receipt No</th><th>Semester</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
          @forelse($payments as $p)
          <tr>
            <td><code class="text-primary">{{ $p->receipt_no }}</code></td>
            <td>Semester {{ $p->feeStructure->semester }}</td>
            <td class="fw-semibold">&#8377;{{ number_format($p->amount,0) }}</td>
            <td>@if($p->payment_method==='paypal')<span class="badge" style="background:#003087;color:#fff"><i class="fab fa-paypal me-1"></i>PayPal</span>@else<span class="badge bg-secondary">Offline</span>@endif</td>
            <td><span class="badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            <td>{{ $p->paid_at?->format('d M Y') ?? '&mdash;' }}</td>
            <td>@if($p->status==='completed')<a href="{{ route('payment.receipt',$p) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>@endif</td>
          </tr>
          @empty<tr><td colspan="7" class="text-center text-muted py-4">No payments yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@else
<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>Student profile not found. Contact admin.</div>
@endif
@endsection
