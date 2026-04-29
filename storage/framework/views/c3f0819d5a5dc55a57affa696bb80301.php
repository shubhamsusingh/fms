<?php $__env->startSection('title','Pay Fees'); ?>
<?php $__env->startSection('content'); ?>
<?php if($student): ?>
<h5 class="fw-semibold mb-4"><i class="fas fa-credit-card me-2 text-primary"></i>Available Fee Payments</h5>
<?php $__empty_1 = true; $__currentLoopData = $feeStructures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php $paid = $student->payments()->where('fee_structure_id',$fee->id)->where('status','completed')->exists(); ?>
<div class="card border-0 shadow-sm mb-4">
  <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-semibold"><?php echo e($fee->course); ?> / <?php echo e($fee->branch); ?> &ndash; Semester <?php echo e($fee->semester); ?> <span class="badge bg-light text-dark ms-2 border"><?php echo e($fee->academic_year); ?></span></h6>
    <?php if($paid): ?><span class="badge-completed fs-6 px-3 py-2"><i class="fas fa-check me-1"></i>Paid</span>
    <?php elseif($fee->isOverdue()): ?><span class="badge-failed fs-6 px-3 py-2">Overdue</span>
    <?php else: ?><span class="badge-pending fs-6 px-3 py-2"><i class="fas fa-clock me-1"></i>Due <?php echo e($fee->due_date->format('d M Y')); ?></span><?php endif; ?>
  </div>
  <div class="card-body">
    <div class="row g-2 mb-4">
      <?php $__currentLoopData = ['Tuition'=>$fee->tuition_fee,'Exam'=>$fee->exam_fee,'Library'=>$fee->library_fee,'Lab'=>$fee->lab_fee,'Hostel'=>$fee->hostel_fee,'Other'=>$fee->other_fee]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lbl=>$amt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-2 col-4"><div class="text-center p-2 rounded" style="background:#f8fafc"><p class="mb-0 text-muted" style="font-size:.7rem"><?php echo e($lbl); ?></p><p class="mb-0 fw-semibold" style="font-size:.85rem">&#8377;<?php echo e(number_format($amt,0)); ?></p></div></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe)">
      <div><span class="text-muted small">Total Amount</span><h3 class="mb-0 fw-bold text-primary">&#8377;<?php echo e(number_format($fee->total_fee,2)); ?></h3></div>
      <?php if(!$paid): ?>
      <form action="<?php echo e(route('payment.create')); ?>" method="POST"><?php echo csrf_field(); ?>
        <input type="hidden" name="fee_structure_id" value="<?php echo e($fee->id); ?>">
        <button type="submit" class="btn btn-lg fw-semibold text-white px-5" style="background:#003087;border-radius:8px"><i class="fab fa-paypal me-2"></i>Pay with PayPal</button>
      </form>
      <?php else: ?><div class="text-success fw-semibold"><i class="fas fa-check-circle fa-2x"></i></div><?php endif; ?>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No fee structures found for your course and semester. Contact admin.</div>
<?php endif; ?>
<?php if($payments->count()): ?>
<h5 class="fw-semibold mt-5 mb-3"><i class="fas fa-history me-2 text-primary"></i>Transaction History</h5>
<div class="card border-0 shadow-sm"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-hover mb-0">
  <thead><tr><th>Receipt No</th><th>Semester</th><th>Amount</th><th>Status</th><th>Date</th><th></th></tr></thead>
  <tbody>
    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td><code><?php echo e($p->receipt_no); ?></code></td>
      <td>Semester <?php echo e($p->feeStructure->semester); ?></td>
      <td class="fw-semibold">&#8377;<?php echo e(number_format($p->amount,0)); ?></td>
      <td><span class="badge-<?php echo e($p->status); ?>"><?php echo e(ucfirst($p->status)); ?></span></td>
      <td><?php echo e($p->paid_at?->format('d M Y') ?? '&mdash;'); ?></td>
      <td><?php if($p->status==='completed'): ?><a href="<?php echo e(route('payment.receipt',$p)); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-pdf"></i> Receipt</a><?php endif; ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
</div></div></div>
<?php endif; ?>
<?php else: ?>
<div class="alert alert-warning">Student profile not found. Contact admin.</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SUBHAM SINGH\Downloads\fee-management-system-FINAL (1)\fms\resources\views/payments/index.blade.php ENDPATH**/ ?>