@extends('layouts.app')
@section('title','Payment Receipt')
@section('content')
<div class="mb-3 no-print d-flex gap-2">
  <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print me-1"></i>Print Receipt</button>
  <a href="{{ auth()->user()->isAdmin() ? route('admin.payments') : route('student.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
<div class="receipt-box">
  <div class="receipt-header d-flex justify-content-between align-items-center">
    <div><h3 class="fw-bold mb-1"><i class="fas fa-university me-2" style="color:#f0a500"></i>{{ config('app.name') }}</h3><p class="mb-0 opacity-75 small">Official Fee Payment Receipt</p></div>
    <div class="text-end">
      <div class="badge fs-6 px-3 py-2" style="background:#f0a500;color:#1a3c5e"><i class="fas fa-check-circle me-1"></i>PAID</div>
      <p class="mb-0 mt-1 small opacity-75">{{ $payment->paid_at?->format('d M Y, h:i A') }}</p>
    </div>
  </div>
  <div class="p-4">
    <div class="row mb-4">
      <div class="col-6">
        <table class="table table-borderless table-sm mb-0">
          <tr><td class="text-muted small fw-semibold">Receipt No</td><td class="fw-bold text-primary">{{ $payment->receipt_no }}</td></tr>
          <tr><td class="text-muted small fw-semibold">Transaction ID</td><td><code>{{ $payment->transaction_id ?? 'Offline' }}</code></td></tr>
          <tr><td class="text-muted small fw-semibold">Method</td><td>@if($payment->payment_method==='paypal')<i class="fab fa-paypal me-1" style="color:#003087"></i>PayPal@else<i class="fas fa-money-bill-wave me-1 text-success"></i>Cash/Offline@endif</td></tr>
        </table>
      </div>
      <div class="col-6 text-end">
        <div class="p-3 rounded d-inline-block" style="background:#f0fdf4;border:2px solid #16a34a">
          <p class="text-muted mb-0 small">Amount Paid</p>
          <h2 class="text-success fw-bold mb-0">&#8377;{{ number_format($payment->amount,2) }}</h2>
          <small class="text-muted">{{ $payment->currency }}</small>
        </div>
      </div>
    </div>
    <hr>
    <h6 class="fw-semibold mb-3 text-muted"><i class="fas fa-user-graduate me-2"></i>Student Details</h6>
    <div class="row mb-4">
      <div class="col-md-6">
        <table class="table table-borderless table-sm mb-0">
          <tr><td class="text-muted small">Name</td><td class="fw-semibold">{{ $payment->student->user->name }}</td></tr>
          <tr><td class="text-muted small">Enrollment No</td><td><code>{{ $payment->student->enrollment_no }}</code></td></tr>
          <tr><td class="text-muted small">Email</td><td>{{ $payment->student->user->email }}</td></tr>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-borderless table-sm mb-0">
          <tr><td class="text-muted small">Course</td><td class="fw-semibold">{{ $payment->student->course }} / {{ $payment->student->branch }}</td></tr>
          <tr><td class="text-muted small">Semester</td><td>Semester {{ $payment->student->semester }}</td></tr>
          <tr><td class="text-muted small">Batch</td><td>{{ $payment->student->batch }}</td></tr>
        </table>
      </div>
    </div>
    <hr>
    <h6 class="fw-semibold mb-3 text-muted"><i class="fas fa-list-alt me-2"></i>Fee Breakdown &ndash; Sem {{ $payment->feeStructure->semester }} ({{ $payment->feeStructure->academic_year }})</h6>
    <table class="table table-bordered table-sm">
      <tbody>
        @foreach(['Tuition Fee'=>$payment->feeStructure->tuition_fee,'Exam Fee'=>$payment->feeStructure->exam_fee,'Library Fee'=>$payment->feeStructure->library_fee,'Lab Fee'=>$payment->feeStructure->lab_fee,'Hostel Fee'=>$payment->feeStructure->hostel_fee,'Other Fee'=>$payment->feeStructure->other_fee] as $lbl=>$amt)
        @if($amt>0)<tr><td>{{ $lbl }}</td><td class="text-end">&#8377;{{ number_format($amt,2) }}</td></tr>@endif
        @endforeach
      </tbody>
      <tfoot><tr style="background:#1a3c5e;color:#fff"><th>Total</th><th class="text-end">&#8377;{{ number_format($payment->feeStructure->total_fee,2) }}</th></tr></tfoot>
    </table>
    <div class="mt-4 text-center text-muted small">
      <p class="mb-0"><i class="fas fa-shield-alt me-1"></i>This is a computer-generated receipt and does not require a signature.</p>
      <p class="mb-0">Generated on {{ now()->format('d M Y, h:i A') }}</p>
    </div>
  </div>
</div>
@endsection
