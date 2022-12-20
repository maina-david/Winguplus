<div class="form-group form-group-default">
   <label for="end" class="text-danger">
      Income account *
      <a href="" class="pull-right" data-toggle="modal" data-target="#addIncomeCategory">Add Income Account</a>
      <span class="pull-right mr-1" data-toggle="tooltip" data-placement="top" title="This will help in categorising the invoice to specific income categories">
         <i class="fas fa-info-circle"></i>
      </span>
   </label>
   <select name="income_category" class="form-control select2" required>
      <?php if($editIncome): ?>
         <option selected value="<?php echo e($incomeCode); ?>"><?php echo Finance::income_category($incomeCode)->name; ?></option>
      <?php else: ?>
         <option value="">Choose category</option>
      <?php endif; ?>
      <?php $__currentLoopData = $incomeCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <option value="<?php echo $category->category_code; ?>"><?php echo $category->name; ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </select>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/income-list.blade.php ENDPATH**/ ?>