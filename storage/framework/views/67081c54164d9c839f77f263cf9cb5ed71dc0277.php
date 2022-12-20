<select name="product_code[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
   <?php if($editProduct): ?>
      <option value="<?php echo e($productCode); ?>"><?php echo Finance::product($productCode)->product_name; ?></option>
   <?php else: ?>
      <option value="">Choose Product</option>
   <?php endif; ?>
   <?php $__currentLoopData = $Itemproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($prod->productCode); ?>">
         <?php echo e(substr($prod->product_name, 0, 100)); ?> <?php echo e(strlen($prod->product_name) > 100 ? '...' : ''); ?>

         <?php if($prod->track_inventory == 'Yes'): ?>
            <?php if($prod->type == 'product' && $prod->current_stock <= 0 ): ?>***** OUT OF STOCK ***** <?php endif; ?>
         <?php endif; ?>
      </option>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php $__currentLoopData = $Itemservice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($service->productCode); ?>">
         <?php echo e(substr($service->product_name, 0, 100)); ?> <?php echo e(strlen($service->product_name) > 100 ? '...' : ''); ?>

      </option>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/product-list.blade.php ENDPATH**/ ?>