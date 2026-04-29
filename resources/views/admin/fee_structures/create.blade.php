@extends('layouts.app')
@section('title','Add Fee Structure')
@section('content')
<div class="row justify-content-center"><div class="col-lg-9">
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold"><i class="fas fa-tags me-2 text-primary"></i>Add Fee Structure</h6></div>
  <div class="card-body p-4">
    <form action="{{ route('admin.fee_structures.store') }}" method="POST">@csrf
      <div class="row g-3">
        <div class="col-md-3"><label class="form-label fw-semibold small">Course *</label>
          <select name="course" class="form-select" required><option value="">Select</option>@foreach(['B.Tech','M.Tech','BCA','MCA','MBA','B.Sc'] as $c)<option value="{{ $c }}" {{ old('course')==$c?'selected':'' }}>{{ $c }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Branch *</label>
          <select name="branch" class="form-select" required><option value="">Select</option>@foreach(['CSE','ECE','ME','CE','EE','IT','BCA','MCA','MBA'] as $b)<option value="{{ $b }}" {{ old('branch')==$b?'selected':'' }}>{{ $b }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Semester *</label>
          <select name="semester" class="form-select" required>@for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ old('semester')==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Academic Year *</label>
          <input type="text" name="academic_year" value="{{ old('academic_year','2024-25') }}" class="form-control" placeholder="2024-25" required></div>
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

        <div class="col-md-4"><label class="form-label fw-semibold small">Due Date *</label><input type="date" name="due_date" value="{{ old('due_date') }}" class="form-control" required></div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Save</button>
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
