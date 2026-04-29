<?php $__env->startSection('title','Manage Students'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="fw-semibold mb-0"><i class="fas fa-users me-2 text-primary"></i>All Students</h5>
  <a href="<?php echo e(route('admin.students.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Student</a>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>#</th><th>Name</th><th>Enrollment No</th><th>Course/Branch</th><th>Sem</th><th>Batch</th><th>Email</th><th>Fee Status</th><th>Actions</th></tr></thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($students->firstItem()+$i); ?></td>
            <td class="fw-semibold"><?php echo e($s->user->name); ?></td>
            <td><code><?php echo e($s->enrollment_no); ?></code></td>
            <td><?php echo e($s->course); ?> / <?php echo e($s->branch); ?></td>
            <td><span class="badge bg-info text-dark">Sem <?php echo e($s->semester); ?></span></td>
            <td><?php echo e($s->batch); ?></td>
            <td><?php echo e($s->user->email); ?></td>
            <td><?php if($s->hasPaidFee()): ?><span class="badge-completed">Paid</span><?php else: ?><span class="badge-pending">Pending</span><?php endif; ?></td>
            <td>
              <a href="<?php echo e(route('admin.students.edit',$s)); ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
              <form action="<?php echo e(route('admin.students.delete',$s)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this student?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="9" class="text-center text-muted py-4">No students found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="p-3"><?php echo e($students->links()); ?></div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SUBHAM SINGH\Downloads\fee-management-system-FINAL (1)\fms\resources\views/admin/students/index.blade.php ENDPATH**/ ?>