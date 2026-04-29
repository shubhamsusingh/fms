@extends('layouts.app')
@section('title','Fee Structures')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="fw-semibold mb-0"><i class="fas fa-tags me-2 text-primary"></i>Fee Structures</h5>
  <a href="{{ route('admin.fee_structures.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Structure</a>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>#</th><th>Course</th><th>Branch</th><th>Sem</th><th>Year</th><th>Tuition</th><th>Exam</th><th>Lab</th><th>Total</th><th>Due Date</th><th></th></tr></thead>
        <tbody>
          @forelse($structures as $i => $f)
          <tr>
            <td>{{ $structures->firstItem()+$i }}</td>
            <td>{{ $f->course }}</td><td>{{ $f->branch }}</td>
            <td><span class="badge bg-info text-dark">{{ $f->semester }}</span></td>
            <td>{{ $f->academic_year }}</td>
            <td>&#8377;{{ number_format($f->tuition_fee,0) }}</td>
            <td>&#8377;{{ number_format($f->exam_fee,0) }}</td>
            <td>&#8377;{{ number_format($f->lab_fee,0) }}</td>
            <td class="fw-bold text-success">&#8377;{{ number_format($f->total_fee,0) }}</td>
            <td>@if($f->isOverdue())<span class="badge-failed">{{ $f->due_date->format('d M Y') }}</span>@else<span class="badge-completed">{{ $f->due_date->format('d M Y') }}</span>@endif</td>
            <td><a href="{{ route('admin.fee_structures.edit',$f) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a></td>
          </tr>
          @empty<tr><td colspan="11" class="text-center text-muted py-4">No fee structures yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $structures->links() }}</div>
  </div>
</div>
@endsection
