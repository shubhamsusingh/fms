<?php $__env->startSection('title','All Payments'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-semibold mb-0"><i class="fas fa-receipt me-2 text-primary"></i>All Payments</h5>
  <form class="d-inline-flex gap-2" method="GET">
    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
      <option value="">All Status</option>
      <?php $__currentLoopData = ['pending','completed','failed','refunded']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </form>
</div>
<div class="mb-3">
  <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#offlineModal">
    <i class="fas fa-money-bill-wave me-1"></i>Record Offline Payment
  </button>
</div>
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Receipt No</th><th>Student</th><th>Course/Sem</th><th>Amount</th><th>Method</th><th>Status</th><th>Txn ID</th><th>Paid At</th><th></th></tr></thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><code><?php echo e($p->receipt_no); ?></code></td>
            <td><?php echo e($p->student->user->name); ?><br><small class="text-muted"><?php echo e($p->student->enrollment_no); ?></small></td>
            <td><?php echo e($p->feeStructure->course); ?> &ndash; Sem <?php echo e($p->feeStructure->semester); ?></td>
            <td class="fw-semibold">&#8377;<?php echo e(number_format($p->amount,0)); ?></td>
            <td><?php if($p->payment_method==='paypal'): ?><span class="badge" style="background:#003087;color:#fff"><i class="fab fa-paypal me-1"></i>PayPal</span><?php else: ?><span class="badge bg-secondary">Offline</span><?php endif; ?></td>
            <td><span class="badge-<?php echo e($p->status); ?>"><?php echo e(ucfirst($p->status)); ?></span></td>
            <td><small class="text-muted"><?php echo e($p->transaction_id ?? '&mdash;'); ?></small></td>
            <td><?php echo e($p->paid_at?->format('d M Y') ?? '&mdash;'); ?></td>
            <td><?php if($p->status==='completed'): ?><a href="<?php echo e(route('admin.payments.receipt',$p)); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a><?php endif; ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="9" class="text-center text-muted py-4">No payments found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="p-3"><?php echo e($payments->links()); ?></div>
  </div>
</div>
<!-- Offline Payment Modal -->
<div class="modal fade" id="offlineModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title fw-semibold">Record Offline Payment</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form action="<?php echo e(route('admin.payments.offline')); ?>" method="POST"><?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="mb-3"><label class="form-label fw-semibold small">Student ID</label><input type="number" name="student_id" class="form-control" placeholder="Student DB id" required></div>
        <div class="mb-3"><label class="form-label fw-semibold small">Fee Structure ID</label><input type="number" name="fee_structure_id" class="form-control" placeholder="Fee Structure DB id" required></div>
        <div class="mb-3"><label class="form-label fw-semibold small">Notes</label><textarea name="notes" class="form-control" rows="2" placeholder="Cash receipt no, cheque details..."></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Record Payment</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SUBHAM SINGH\Downloads\fee-management-system-FINAL (1)\fms\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>