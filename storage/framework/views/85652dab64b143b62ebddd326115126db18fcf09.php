<div class="panel">
   <div class="panel panel-default mt-3">
      <div class="panel-body">
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <label for="">Search</label>
                  <input type="text" class="form-control" wire:model="search" placeholder="Search by title">
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="">Status</label>
                  <select wire:model="status" class="form-control">
                     <option value="">Choose status</option>
                     <option value="1">Paid</option>
                     <option value="2">Unpaid</option>
                     <option value="18">Dept</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="">Category</label>
                  <select wire:model="category" class="form-control">
                     <option value="">Choose Category</option>
                     <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo $cat->category_code; ?>"><?php echo $cat->name; ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="">Month</label>
                  <select wire:model="month" class="form-control">
                     <option value="">Choose Month</option>
                     <option value="01">January</option>
                     <option value="02">February</option>
                     <option value="03">March</option>
                     <option value="04">April</option>
                     <option value="05">May</option>
                     <option value="06">June</option>
                     <option value="07">July</option>
                     <option value="08">August</option>
                     <option value="09">September</option>
                     <option value="10">October</option>
                     <option value="11">November</option>
                     <option value="12">December</option>
                  </select>
               </div>
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="10%">Date</th>
                  <th>Expense Category</th>
                  <th>Reference#</th>
                  <th>Expense Title</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th width="14%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($exp->business_code == Auth::user()->business_code): ?>
                     <?php
                        $expenseInfo = Finance::expense_category($exp->category)->getData();
                     ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo date('M j, Y',strtotime($exp->expense_date)); ?></td>
                        <td>
                           <?php if($expenseInfo->check == 1): ?>
                              <?php echo $expenseInfo->expense->name; ?>

                           <?php else: ?>
                              <i>Un allocated</i>
                           <?php endif; ?>
                        </td>
                        <td><b><?php echo $exp->reference_number; ?></b></td>
                        <td><?php echo $exp->expense_name; ?></td>
                        <td>
                           <span class="badge <?php echo $exp->statusName; ?>">
                              <?php echo $exp->statusName; ?>

                           </span>
                         </td>
                        <td><b><?php echo $exp->currency; ?> <?php echo number_format($exp->amount); ?></b></td>
                        <td>
                           <a href="<?php echo e(route('finance.expense.edit', $exp->expenseCode)); ?>" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>
                           <a href="<?php echo route('finance.expense.destroy', $exp->expenseCode); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a></li>
                        </td>
                     </tr>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $expense->links('pagination.custom'); ?>

       </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/expenses/expenses.blade.php ENDPATH**/ ?>