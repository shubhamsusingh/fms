@extends('layouts.app')
@section('title','Pay Fees')
@section('content')
@if($student)
<h5 class="fw-semibold mb-4"><i class="fas fa-credit-card me-2 text-primary"></i>Available Fee Payments</h5>
@forelse($feeStructures as $fee)
@php $paid = $student->payments()->where('fee_structure_id',$fee->id)->where('status','completed')->exists(); @endphp
<div class="card border-0 shadow-sm mb-4">
  <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-semibold">{{ $fee->course }} / {{ $fee->branch }} &ndash; Semester {{ $fee->semester }} <span class="badge bg-light text-dark ms-2 border">{{ $fee->academic_year }}</span></h6>
    @if($paid)<span class="badge-completed fs-6 px-3 py-2"><i class="fas fa-check me-1"></i>Paid</span>
    @elseif($fee->isOverdue())<span class="badge-failed fs-6 px-3 py-2">Overdue</span>
    @else<span class="badge-pending fs-6 px-3 py-2"><i class="fas fa-clock me-1"></i>Due {{ $fee->due_date->format('d M Y') }}</span>@endif
  </div>
  <div class="card-body">
    <div class="row g-2 mb-4">
      @foreach(['Tuition'=>$fee->tuition_fee,'Exam'=>$fee->exam_fee,'Library'=>$fee->library_fee,'Lab'=>$fee->lab_fee,'Hostel'=>$fee->hostel_fee,'Other'=>$fee->other_fee] as $lbl=>$amt)
      <div class="col-md-2 col-4"><div class="text-center p-2 rounded" style="background:#f8fafc"><p class="mb-0 text-muted" style="font-size:.7rem">{{ $lbl }}</p><p class="mb-0 fw-semibold" style="font-size:.85rem">&#8377;{{ number_format($amt,0) }}</p></div></div>
      @endforeach
    </div>
    <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe)">
      <div><span class="text-muted small">Total Amount</span><h3 class="mb-0 fw-bold text-primary">&#8377;{{ number_format($fee->total_fee,2) }}</h3></div>
      @if(!$paid)
      <form action="{{ route('payment.create') }}" method="POST">@csrf
        <input type="hidden" name="fee_structure_id" value="{{ $fee->id }}">
        <button type="submit" class="btn btn-lg fw-semibold text-white px-5" style="background:#003087;border-radius:8px"><i class="fab fa-paypal me-2"></i>Pay with PayPal</button>
      </form>
      @else<div class="text-success fw-semibold"><i class="fas fa-check-circle fa-2x"></i></div>@endif
    </div>
  </div>
</div>
@empty
<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No fee structures found for your course and semester. Contact admin.</div>
@endforelse
@if($payments->count())
<h5 class="fw-semibold mt-5 mb-3"><i class="fas fa-history me-2 text-primary"></i>Transaction History</h5>
<div class="card border-0 shadow-sm"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-hover mb-0">
  <thead><tr><th>Receipt No</th><th>Semester</th><th>Amount</th><th>Status</th><th>Date</th><th></th></tr></thead>
  <tbody>
    @foreach($payments as $p)
    <tr>
      <td><code>{{ $p->receipt_no }}</code></td>
      <td>Semester {{ $p->feeStructure->semester }}</td>
      <td class="fw-semibold">&#8377;{{ number_format($p->amount,0) }}</td>
      <td><span class="badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
      <td>{{ $p->paid_at?->format('d M Y') ?? '&mdash;' }}</td>
      <td>@if($p->status==='completed')<a href="{{ route('payment.receipt',$p) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-pdf"></i> Receipt</a>@endif</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div></div></div>
@endif
@else
<div class="alert alert-warning">Student profile not found. Contact admin.</div>
@endif
@endsection
