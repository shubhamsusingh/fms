<?php $__env->startSection('title','Fee Structures'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="fw-semibold mb-0"><i class="fas fa-tags me-2 text-primary"></i>Fee Structures</h5>
  <a href="<?php echo e(route('admin.fee_structures.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Structure</a>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>#</th><th>Course</th><th>Branch</th><th>Sem</th><th>Year</th><th>Tuition</th><th>Exam</th><th>Lab</th><th>Total</th><th>Due Date</th><th></th></tr></thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $structures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($structures->firstItem()+$i); ?></td>
            <td><?php echo e($f->course); ?></td><td><?php echo e($f->branch); ?></td>
            <td><span class="badge bg-info text-dark"><?php echo e($f->semester); ?></span></td>
            <td><?php echo e($f->academic_year); ?></td>
            <td>&#8377;<?php echo e(number_format($f->tuition_fee,0)); ?></td>
            <td>&#8377;<?php echo e(number_format($f->exam_fee,0)); ?></td>
            <td>&#8377;<?php echo e(number_format($f->lab_fee,0)); ?></td>
            <td class="fw-bold text-success">&#8377;<?php echo e(number_format($f->total_fee,0)); ?></td>
            <td><?php if($f->isOverdue()): ?><span class="badge-failed"><?php echo e($f->due_date->format('d M Y')); ?></span><?php else: ?><span class="badge-completed"><?php echo e($f->due_date->format('d M Y')); ?></span><?php endif; ?></td>
            <td><a href="<?php echo e(route('admin.fee_structures.edit',$f)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="11" class="text-center text-muted py-4">No fee structures yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="p-3"><?php echo e($structures->links()); ?></div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SUBHAM SINGH\Downloads\fee-management-system-FINAL (1)\fms\resources\views/admin/fee_structures/index.blade.php ENDPATH**/ ?>