@extends('layouts.app')
@section('title','Edit Fee Structure')
@section('content')
<div class="row justify-content-center"><div class="col-lg-9">
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold"><i class="fas fa-edit me-2 text-primary"></i>Edit – {{ $feeStructure->course }}/{{ $feeStructure->branch }}/Sem{{ $feeStructure->semester }}</h6></div>
  <div class="card-body p-4">
    <form action="{{ route('admin.fee_structures.update',$feeStructure) }}" method="POST">@csrf @method('PUT')
      <div class="row g-3">
        <div class="col-md-3"><label class="form-label fw-semibold small">Course</label><input class="form-control" value="{{ $feeStructure->course }}" disabled><input type="hidden" name="course" value="{{ $feeStructure->course }}"></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Branch</label><input class="form-control" value="{{ $feeStructure->branch }}" disabled><input type="hidden" name="branch" value="{{ $feeStructure->branch }}"></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Semester</label><input class="form-control" value="Sem {{ $feeStructure->semester }}" disabled><input type="hidden" name="semester" value="{{ $feeStructure->semester }}"></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Academic Year</label><input type="text" name="academic_year" value="{{ $feeStructure->academic_year }}" class="form-control" required></div>
        <div class="col-12"><hr class="my-1"><p class="text-muted small fw-semibold mb-0">Fee Breakdown (&#8377;)</p></div>

        @php $feeFields = ['tuition_fee'=>'Tuition Fee','exam_fee'=>'Exam Fee','library_fee'=>'Library Fee','lab_fee'=>'Lab Fee','hostel_fee'=>'Hostel Fee','other_fee'=>'Other Fee']; @endphp
        @foreach($feeFields as $field => $label)
        <div class="col-md-4">
          <label class="form-label fw-semibold small">{{ $label }} *</label>
          <div class="input-group"><span class="input-group-text">&#8377;</span>
          <input type="number" name="{{ $field }}" value="{{ old($field, isset($feeStructure) ? $feeStructure->$field : 0) }}" class="form-control fee-input" min="0" step="0.01" required></div>
        </div>
        @endforeach
        <div class="col-md-4">
          <label class="form-label fw-semibold small">Total Fee (auto)</label>
          <div class="input-group"><span class="input-group-text bg-success text-white">&#8377;</span>
          <input type="text" id="total_display" class="form-control fw-bold text-success" readonly></div>
        </div>

        <div class="col-md-4"><label class="form-label fw-semibold small">Due Date</label><input type="date" name="due_date" value="{{ $feeStructure->due_date->format('Y-m-d') }}" class="form-control" required></div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Update</button>
        <a href="{{ route('admin.fee_structures') }}" class="btn btn-outline-secondary px-4">Cancel</a>
      </div>
    </form>
  </div>
</div>
</div></div>
@push('scripts')
<script>
function calcTotal(){let t=0;document.querySelectorAll('.fee-input').forEach(f=>t+=parseFloat(f.value)||0);document.getElementById('total_display').value=t.toLocaleString('en-IN');}
document.querySelectorAll('.fee-input').forEach(f=>f.addEventListener('input',calcTotal));calcTotal();
</script>
@endpush
@endsection
