@extends('layouts.app')
@section('title','Add Student')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-plus me-2 text-primary"></i>Add New Student</h6></div>
  <div class="card-body p-4">
    <form action="{{ route('admin.students.store') }}" method="POST">@csrf
      <h6 class="text-muted mb-3 border-bottom pb-2">Account Details</h6>
      <div class="row g-3 mb-4">
        <div class="col-md-6"><label class="form-label fw-semibold small">Full Name *</label><input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Email *</label><input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Password *</label><input type="password" name="password" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Confirm Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>
      </div>
      <h6 class="text-muted mb-3 border-bottom pb-2">Academic Details</h6>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold small">Enrollment No *</label><input type="text" name="enrollment_no" value="{{ old('enrollment_no') }}" class="form-control @error('enrollment_no') is-invalid @enderror" placeholder="BTech-CSE-2022-001" required>@error('enrollment_no')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Course *</label>
          <select name="course" class="form-select" required><option value="">Select</option>@foreach(['B.Tech','M.Tech','BCA','MCA','MBA','B.Sc'] as $c)<option value="{{ $c }}" {{ old('course')==$c?'selected':'' }}>{{ $c }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Branch *</label>
          <select name="branch" class="form-select" required><option value="">Select</option>@foreach(['CSE','ECE','ME','CE','EE','IT','BCA','MCA','MBA'] as $b)<option value="{{ $b }}" {{ old('branch')==$b?'selected':'' }}>{{ $b }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Semester *</label>
          <select name="semester" class="form-select" required>@for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ old('semester')==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Batch *</label><input type="text" name="batch" value="{{ old('batch') }}" class="form-control" placeholder="2022-2026" required></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="form-control"></div>
        <div class="col-12"><label class="form-label fw-semibold small">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Save Student</button>
        <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary px-4">Cancel</a>
      </div>
    </form>
  </div>
</div>
</div></div>
@endsection
