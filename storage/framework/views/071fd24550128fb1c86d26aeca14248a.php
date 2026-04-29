<?php $__env->startSection('title','Add Student'); ?>
<?php $__env->startSection('content'); ?>
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-plus me-2 text-primary"></i>Add New Student</h6></div>
  <div class="card-body p-4">
    <form action="<?php echo e(route('admin.students.store')); ?>" method="POST"><?php echo csrf_field(); ?>
      <h6 class="text-muted mb-3 border-bottom pb-2">Account Details</h6>
      <div class="row g-3 mb-4">
        <div class="col-md-6"><label class="form-label fw-semibold small">Full Name *</label><input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Email *</label><input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Password *</label><input type="password" name="password" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold small">Confirm Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>
      </div>
      <h6 class="text-muted mb-3 border-bottom pb-2">Academic Details</h6>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold small">Enrollment No *</label><input type="text" name="enrollment_no" value="<?php echo e(old('enrollment_no')); ?>" class="form-control <?php $__errorArgs = ['enrollment_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="BTech-CSE-2022-001" required><?php $__errorArgs = ['enrollment_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Course *</label>
          <select name="course" class="form-select" required><option value="">Select</option><?php $__currentLoopData = ['B.Tech','M.Tech','BCA','MCA','MBA','B.Sc']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c); ?>" <?php echo e(old('course')==$c?'selected':''); ?>><?php echo e($c); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Branch *</label>
          <select name="branch" class="form-select" required><option value="">Select</option><?php $__currentLoopData = ['CSE','ECE','ME','CE','EE','IT','BCA','MCA','MBA']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($b); ?>" <?php echo e(old('branch')==$b?'selected':''); ?>><?php echo e($b); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Semester *</label>
          <select name="semester" class="form-select" required><?php for($i=1;$i<=8;$i++): ?><option value="<?php echo e($i); ?>" <?php echo e(old('semester')==$i?'selected':''); ?>>Semester <?php echo e($i); ?></option><?php endfor; ?></select></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Batch *</label><input type="text" name="batch" value="<?php echo e(old('batch')); ?>" class="form-control" placeholder="2022-2026" required></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Phone</label><input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="form-control"></div>
        <div class="col-12"><label class="form-label fw-semibold small">Address</label><textarea name="address" class="form-control" rows="2"><?php echo e(old('address')); ?></textarea></div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Save Student</button>
        <a href="<?php echo e(route('admin.students')); ?>" class="btn btn-outline-secondary px-4">Cancel</a>
      </div>
    </form>
  </div>
</div>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SUBHAM SINGH\Downloads\fee-management-system-FINAL (1)\fms\resources\views/admin/students/create.blade.php ENDPATH**/ ?>