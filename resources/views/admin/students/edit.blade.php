@extends('layouts.app')
@section('title','Edit Student')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-edit me-2 text-primary"></i>Edit – {{ $student->user->name }}</h6></div>
  <div class="card-body p-4">
    <form action="{{ route('admin.students.update',$student) }}" method="POST">@csrf @method('PUT')
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold small">Full Name</label><input type="text" name="name" value="{{ old('name',$student->user->name) }}" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Enrollment No</label><input type="text" value="{{ $student->enrollment_no }}" class="form-control" disabled></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Course</label>
          <select name="course" class="form-select" required>@foreach(['B.Tech','M.Tech','BCA','MCA','MBA','B.Sc'] as $c)<option value="{{ $c }}" {{ $student->course==$c?'selected':'' }}>{{ $c }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Branch</label>
          <select name="branch" class="form-select" required>@foreach(['CSE','ECE','ME','CE','EE','IT','BCA','MCA','MBA'] as $b)<option value="{{ $b }}" {{ $student->branch==$b?'selected':'' }}>{{ $b }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Semester</label>
          <select name="semester" class="form-select" required>@for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ $student->semester==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor</select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Batch</label><input type="text" name="batch" value="{{ old('batch',$student->batch) }}" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label fw-semibold small">Phone</label><input type="text" name="phone" value="{{ old('phone',$student->phone) }}" class="form-control"></div>
        <div class="col-12"><label class="form-label fw-semibold small">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address',$student->address) }}</textarea></div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Update</button>
        <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary px-4">Cancel</a>
      </div>
    </form>
  </div>
</div>
</div></div>
@endsection
