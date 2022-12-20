<div class="panel panel-default mt-2">
   <div class="panel-body">
      <div class="row mb-3">
         <div class="col-md-8">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Search by customer or Reference number">
         </div>
         <div class="col-md-2">
            <label for="">Payment Method</label>
            <select wire:model="paymentMethod" class="form-control">
               <option value="">All Payment Methods</option>
               <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo $method->method_code; ?>"><?php echo $method->name; ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
         </div>
         <div class="col-md-2">
            <label for="">Per Page</label>
            <select wire:model="perPage" class="form-control">
               <option value="25" selected>25</option>
               <option value="50">50</option>
               <option value="75">75</option>
               <option value="100">100</option>
            </select>
         </div>
      </div>
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr role="row">
               <th width="1%">#</th>
               <th>Date</th>
               <th width="10%">Reference</th>
               <th width="15%">Customer Name</th>
               <th>Invoice#</th>
               <th>Payment Method</th>
               <th>Amount Paid</th>
               <th width="3%">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if($pay->business_code == Auth::user()->business_code): ?>
                  <tr role="row" class="odd">
                     <td><?php echo $count+1; ?></td>
                     <td><?php if($pay->payment_date != ""): ?><?php echo date('d F, Y',strtotime($pay->payment_date)); ?><?php endif; ?></td>
                     <td><p class="font-weight-bold"><?php echo $pay->reference_number; ?></p></td>
                     <td>
                        <?php echo $pay->customer_name; ?>

                     </td>
                     <td>
                        <?php echo $pay->invoice_prefix; ?><?php echo $pay->invoice_number; ?>

                     </td>
                     <td>
                        <?php if(Finance::check_payment_method($pay->payment_method) == 1): ?>
                           <?php echo Finance::payment_method($pay->payment_method)->name; ?>

                        <?php endif; ?>
                     </td>
                     <td>
                        <b><?php echo $pay->currency; ?><?php echo number_format($pay->amount); ?></b>
                     </td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                           <ul class="dropdown-menu">
                              <?php if($pay->payment_category == 'Received'): ?>
                              <li><a href="<?php echo e(route('finance.payments.edit', $pay->payment_code)); ?>"><i class="far fa-edit"></i> Edit</a></li>
                              <?php endif; ?>
                              <?php if($pay->payment_category == 'Credited'): ?>
                              <li><a href="<?php echo e(route('finance.creditnote.edit', $pay->creditnote_code)); ?>" target="_blank"><i class="far fa-edit"></i> Edit</a></li>
                              <?php endif; ?>
                              <li><a href="<?php echo e(route('finance.payments.show', $pay->payment_code)); ?>"><i class="fas fa-eye"></i> View</a></li>
                              <li><a href="<?php echo e(route('finance.payments.delete', $pay->payment_code)); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
      <?php echo $payments->links(); ?>

   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/payments.blade.php ENDPATH**/ ?>