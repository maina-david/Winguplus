<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr role="row" class="odd">
                  <td><?php echo e($crt+1); ?></td>
                  <td>
                     <b><?php echo e(Finance::invoice_settings()->prefix.$v->invoice_number); ?></b>
                  </td>
                  <td><?php echo number_format($v->total); ?> <?php echo Finance::currency($v->currencyID)->symbol; ?></td>
                  <td><?php echo number_format($v->paid); ?> <?php echo Finance::currency($v->currencyID)->symbol; ?></td>
                  <td class="v-align-middle">
                     <p>
                        <?php if( $v->statusID == 1 ): ?>
                           <span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span>
                        <?php else: ?>
                           <?php echo e(number_format(round($v->total - $v->paid))); ?> <?php echo Finance::currency($v->currencyID)->symbol; ?>

                        <?php endif; ?>
                     </p>
                  </td>
                  <td><p><?php echo date('F j, Y',strtotime($v->invoice_due)); ?></p></td>
                  <?php if($v->total - $v->paid < 0): ?>
                     <td><span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span></td>
                  <?php else: ?>
                     <td>
                        <?php if($v->statusID != ""): ?>
                           <span class="badge <?php echo Wingu::status($v->statusID)->name; ?>"><?php echo ucfirst(Wingu::status($v->statusID)->name); ?></span>
                        <?php endif; ?>
                     </td>
                  <?php endif; ?>
                  <td>
                     <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                        <ul class="dropdown-menu">
                           <li><a href="<?php echo e(route('finance.invoice.show', $v->id)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                           <?php if($v->invoice_type == 'Random'): ?>
                              <li><a href="<?php echo route('finance.invoice.random.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <?php endif; ?>
                           <?php if($v->invoice_type == 'Product'): ?>
                              <li><a href="<?php echo route('finance.invoice.product.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <?php endif; ?>
                           <?php if($v->invoice_type == 'Recurring'): ?>
                              <li><a href="<?php echo route('finance.invoice.recurring.edit', $v->id); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <?php endif; ?>
                           <li><a href="<?php echo route('finance.invoice.delete', $v->id); ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/customer/invoices.blade.php ENDPATH**/ ?>