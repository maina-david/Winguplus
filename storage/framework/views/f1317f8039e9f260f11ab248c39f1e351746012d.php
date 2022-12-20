<div class="row mt-3">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <table class="table table-bordered table-striped">
               <thead>
                  <th width="1%">#</th>
                  <th>Invoice #</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Balance</th>
                  <th>Paid</th>
                  <th>Status</th>
                  <th>Action</th>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><b><?php echo e($invoice->prefix); ?><?php echo e($invoice->invoice_number); ?></b></td>
                        <td><?php echo date('M j, Y',strtotime($invoice->invoice_date)); ?></td>
                        <td><b class="text-info"><?php echo $invoice->symbol; ?> <?php echo number_format((float)$invoice->total); ?> </b></td>
                        <td class="v-align-middle">
                           <?php if($invoice->statusID == 1 ): ?>
                              <span class="badge <?php echo $invoice->statusName; ?>"><?php echo ucfirst($invoice->statusName); ?></span>
                           <?php else: ?>
                              <b class="text-primary"> <?php echo $invoice->symbol; ?> <?php if($invoice->balance < 0): ?>0 <?php else: ?><?php echo e(number_format(round($invoice->balance))); ?><?php endif; ?></b>
                           <?php endif; ?>
                        </td>
                        <td><b class="text-info"><?php echo $invoice->symbol; ?> <?php echo number_format((float)$invoice->paid); ?> </b></td>
                        <?php if((int)$invoice->total - (int)$invoice->paid < 0): ?>
                           <td><span class="badge <?php echo $invoice->statusName; ?>"><?php echo ucfirst($invoice->statusName); ?></span></td>
                        <?php else: ?>
                           <td>
                              <span class="badge <?php echo Helper::seoUrl($invoice->statusName); ?>"><?php echo ucfirst($invoice->statusName); ?></span>
                           </td>
                        <?php endif; ?>
                        <td><a href="<?php echo route('finance.invoice.show', $invoice->invoiceID); ?>" class="btn btn-sm btn-success btn-block" target="_blank"><i class="fal fa-eye"></i> view</a></td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/subscriptions/invoices.blade.php ENDPATH**/ ?>