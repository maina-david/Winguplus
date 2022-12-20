<div class="form-group form-group-default">
   <label for="customer" class="text-danger">
      Choose Customer *
      <a href="" class="pull-right" data-toggle="modal" data-target="#addCustomer">Add Customer</a>
   </label>
   <select name="customer" class="form-control select2" required>
      <?php if($editCustomer=='True'): ?>
         <option value="<?php echo $customerCode; ?>" selected><?php echo Finance::client($customerCode)->customer_name; ?></option>
      <?php else: ?>
         <option value="">Choose customer</option>
      <?php endif; ?>
      <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <option value="<?php echo $client->customer_code; ?>"><?php echo $client->customer_name; ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </select>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/customer-list.blade.php ENDPATH**/ ?>