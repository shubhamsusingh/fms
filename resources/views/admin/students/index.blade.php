@extends('layouts.app')
@section('title','Manage Students')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="fw-semibold mb-0"><i class="fas fa-users me-2 text-primary"></i>All Students</h5>
  <a href="{{ route('admin.students.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Student</a>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>#</th><th>Name</th><th>Enrollment No</th><th>Course/Branch</th><th>Sem</th><th>Batch</th><th>Email</th><th>Fee Status</th><th>Actions</th></tr></thead>
        <tbody>
          @forelse($students as $i => $s)
          <tr>
            <td>{{ $students->firstItem()+$i }}</td>
            <td class="fw-semibold">{{ $s->user->name }}</td>
            <td><code>{{ $s->enrollment_no }}</code></td>
            <td>{{ $s->course }} / {{ $s->branch }}</td>
            <td><span class="badge bg-info text-dark">Sem {{ $s->semester }}</span></td>
            <td>{{ $s->batch }}</td>
            <td>{{ $s->user->email }}</td>
            <td>@if($s->hasPaidFee())<span class="badge-completed">Paid</span>@else<span class="badge-pending">Pending</span>@endif</td>
            <td>
              <a href="{{ route('admin.students.edit',$s) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
              <form action="{{ route('admin.students.delete',$s) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this student?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty<tr><td colspan="9" class="text-center text-muted py-4">No students found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $students->links() }}</div>
  </div>
</div>
@endsection
