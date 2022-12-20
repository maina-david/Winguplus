<div class="panel panel-default">
   <div class="panel-body">
      <div class="row">
         <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Search by customer name, email or phone number">
         </div>
         <div class="col-md-2">
            <div class="form-group">
               <?php
                  $currentYear = date("Y");
               ?>
               <label for="">Year</label>
               <select wire:model="year" class="form-control">
                  <option value="<?php echo $currentYear; ?>"><?php echo $currentYear; ?></option>
                  <option value="<?php echo $currentYear-1; ?>"><?php echo $currentYear-1; ?></option>
                  <option value="<?php echo $currentYear-2; ?>"><?php echo $currentYear-2; ?></option>
                  <option value="<?php echo $currentYear-3; ?>"><?php echo $currentYear-3; ?></option>
                  <option value="<?php echo $currentYear-4; ?>"><?php echo $currentYear-4; ?></option>
                  <option value="<?php echo $currentYear-5; ?>"><?php echo $currentYear-5; ?></option>
               </select>
            </div>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="10%">Invoice #</th>
               <th width="21%">Customer</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Issue Date</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if($invoice->business_code == Auth::user()->business_code): ?>
                  <tr role="row" class="odd">
                     <td><?php echo e($count+1); ?></td>
                     <td>
                        <?php if($invoice->invoice_prefix == ""): ?><?php echo e($invoice->prefix); ?><?php else: ?><?php echo e($invoice->invoice_prefix); ?><?php endif; ?><?php echo e($invoice->invoice_number); ?>

                     </td>
                     <td>
                        <?php echo $invoice->customer_name; ?>

                     </td>
                     <td>
                        <?php if( $invoice->paid < 0 ): ?>
                           <b class="text-info"><?php echo $invoice->currency; ?><?php echo number_format((float)$invoice->main_amount); ?> </b>
                        <?php else: ?>
                           <b class="text-info"><?php echo $invoice->currency; ?><?php echo number_format((float)$invoice->paid); ?> </b>
                        <?php endif; ?>
                     </td>
                     <td>
                        <?php if( $invoice->statusID == 1 ): ?>
                           <span class="badge <?php echo $invoice->statusName; ?>"><?php echo ucfirst($invoice->statusName); ?></span>
                        <?php else: ?>
                           <?php if($invoice->balance < 0): ?>
                              <b class="text-primary">0 <?php echo $invoice->currency; ?></b>
                           <?php else: ?>
                              <b class="text-primary"><?php echo $invoice->currency; ?><?php echo e(number_format(round($invoice->balance))); ?></b>
                           <?php endif; ?>
                        <?php endif; ?>
                     </td>
                     <td><?php if($invoice->invoice_date != ""): ?><?php echo date('M j, Y',strtotime($invoice->invoice_date)); ?><?php endif; ?></td>
                     <td><?php if($invoice->invoice_due != ""): ?><?php echo date('M j, Y',strtotime($invoice->invoice_due)); ?><?php endif; ?></td>
                     <?php if((int)$invoice->total - (int)$invoice->paid < 0): ?>
                        <td><span class="badge <?php echo $invoice->statusName; ?>"><?php echo ucfirst($invoice->statusName); ?></span></td>
                     <?php else: ?>
                        <td>
                           <span class="badge <?php echo Helper::seoUrl($invoice->statusName); ?>"><?php echo ucfirst($invoice->statusName); ?></span>
                        </td>
                     <?php endif; ?>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                           <ul class="dropdown-menu">
                              <li><a href="<?php echo e(route('finance.invoice.show', $invoice->invoiceCode)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                              <li><a href="<?php echo route('finance.invoice.product.edit', $invoice->invoiceCode); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                              
                              <li><a href="<?php echo route('finance.invoice.delete', $invoice->invoiceCode); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/due.blade.php ENDPATH**/ ?>