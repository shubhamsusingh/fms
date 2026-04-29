@extends('layouts.app')
@section('title','All Payments')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-semibold mb-0"><i class="fas fa-receipt me-2 text-primary"></i>All Payments</h5>
  <form class="d-inline-flex gap-2" method="GET">
    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
      <option value="">All Status</option>
      @foreach(['pending','completed','failed','refunded'] as $s)
      <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </form>
</div>
<div class="mb-3">
  <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#offlineModal">
    <i class="fas fa-money-bill-wave me-1"></i>Record Offline Payment
  </button>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Receipt No</th><th>Student</th><th>Course/Sem</th><th>Amount</th><th>Method</th><th>Status</th><th>Txn ID</th><th>Paid At</th><th></th></tr></thead>
        <tbody>
          @forelse($payments as $p)
          <tr>
            <td><code>{{ $p->receipt_no }}</code></td>
            <td>{{ $p->student->user->name }}<br><small class="text-muted">{{ $p->student->enrollment_no }}</small></td>
            <td>{{ $p->feeStructure->course }} &ndash; Sem {{ $p->feeStructure->semester }}</td>
            <td class="fw-semibold">&#8377;{{ number_format($p->amount,0) }}</td>
            <td>@if($p->payment_method==='paypal')<span class="badge" style="background:#003087;color:#fff"><i class="fab fa-paypal me-1"></i>PayPal</span>@else<span class="badge bg-secondary">Offline</span>@endif</td>
            <td><span class="badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            <td><small class="text-muted">{{ $p->transaction_id ?? '&mdash;' }}</small></td>
            <td>{{ $p->paid_at?->format('d M Y') ?? '&mdash;' }}</td>
            <td>@if($p->status==='completed')<a href="{{ route('admin.payments.receipt',$p) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>@endif</td>
          </tr>
          @empty<tr><td colspan="9" class="text-center text-muted py-4">No payments found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $payments->links() }}</div>
  </div>
</div>
<!-- Offline Payment Modal -->
<div class="modal fade" id="offlineModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title fw-semibold">Record Offline Payment</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form action="{{ route('admin.payments.offline') }}" method="POST">@csrf
      <div class="modal-body">
        <div class="mb-3"><label class="form-label fw-semibold small">Student ID</label><input type="number" name="student_id" class="form-control" placeholder="Student DB id" required></div>
        <div class="mb-3"><label class="form-label fw-semibold small">Fee Structure ID</label><input type="number" name="fee_structure_id" class="form-control" placeholder="Fee Structure DB id" required></div>
        <div class="mb-3"><label class="form-label fw-semibold small">Notes</label><textarea name="notes" class="form-control" rows="2" placeholder="Cash receipt no, cheque details..."></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Record Payment</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div></div>
</div>
@endsection
