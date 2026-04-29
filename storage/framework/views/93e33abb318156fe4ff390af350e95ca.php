<?php $__env->startSection('title','My Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<?php if($student): ?>
<div class="card border-0 shadow-sm mb-4" style="border-left:4px solid #1a3c5e!important">
  <div class="card-body">
    <div class="row align-items-center">
      <div class="col-auto">
        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width:60px;height:60px;background:#1a3c5e;font-size:1.5rem"><?php echo e(strtoupper(substr(auth()->user()->name,0,1))); ?></div>
      </div>
      <div class="col">
        <h5 class="mb-0 fw-bold"><?php echo e(auth()->user()->name); ?></h5>
        <p class="mb-0 text-muted small"><code><?php echo e($student->enrollment_no); ?></code> &bull; <?php echo e($student->course); ?>/<?php echo e($student->branch); ?> &bull; Semester <?php echo e($student->semester); ?> &bull; Batch <?php echo e($student->batch); ?></p>
      </div>
      <div class="col-auto">
        <?php if($student->hasPaidFee()): ?><span class="badge-completed fs-6 px-3 py-2"><i class="fas fa-check-circle me-1"></i>Fee Paid</span>
        <?php else: ?><span class="badge-pending fs-6 px-3 py-2"><i class="fas fa-clock me-1"></i>Fee Pending</span><?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php if($pendingFee): ?>
<div class="alert border-0 shadow-sm mb-4" style="background:linear-gradient(135deg,#fff3cd,#fff8e1);border-left:4px solid #f0a500!important">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h6 class="mb-1 fw-bold"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Fee Due – Semester <?php echo e($pendingFee->semester); ?></h6>
      <p class="mb-0 small text-muted">Total: <strong>&#8377;<?php echo e(number_format($pendingFee->total_fee,0)); ?></strong> &bull; Due: <?php echo e($pendingFee->due_date->format('d M Y')); ?></p>
    </div>
    <a href="<?php echo e(route('payment.index')); ?>" class="btn btn-warning fw-semibold"><i class="fas fa-credit-card me-1"></i>Pay Now</a>
  </div>
</div>
<?php endif; ?>
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
    <h6 class="mb-0 fw-semibold"><i class="fas fa-history me-2 text-primary"></i>Payment History</h6>
    <a href="<?php echo e(route('payment.index')); ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Make Payment</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Receipt No</th><th>Semester</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><code class="text-primary"><?php echo e($p->receipt_no); ?></code></td>
            <td>Semester <?php echo e($p->feeStructure->semester); ?></td>
            <td class="fw-semibold">&#8377;<?php echo e(number_format($p->amount,0)); ?></td>
            <td><?php if($p->payment_method==='paypal'): ?><span class="badge" style="background:#003087;color:#fff"><i class="fab fa-paypal me-1"></i>PayPal</span><?php else: ?><span class="badge bg-secondary">Offline</span><?php endif; ?></td>
            <td><span class="badge-<?php echo e($p->status); ?>"><?php echo e(ucfirst($p->status)); ?></span></td>
            <td><?php echo e($p->paid_at?->format('d M Y') ?? '&mdash;'); ?></td>
            <td><?php if($p->status==='completed'): ?><a href="<?php echo e(route('payment.receipt',$p)); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a><?php endif; ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7" class="text-center text-muted py-4">No payments yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php else: ?>
<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>Student profile not found. Contact admin.</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SUBHAM SINGH\Downloads\fee-management-system-FINAL (1)\fms\resources\views/student/dashboard.blade.php ENDPATH**/ ?>