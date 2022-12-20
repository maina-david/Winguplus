<div wire:ignore.self class="modal fade" id="addProducts" tabindex="-1" role="dialog" aria-labelledby="addProducts" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expressCustomerForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addExpressCustomer">Add Product</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Product Type</label>
                  <select wire:model="type" class="form-control" required>
                     <option value="">Choose Product Type</option>
                     <option value="product" selected>Standard Product</option>
                     <option value="service">Service</option>
                  </select>
                  <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Product Name</label>
                  <input type="text" class="form-control" wire:model="product_name" placeholder="Enter product name" required>
                  <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Price</label>
                  <input type="number" class="form-control" wire:model="price" placeholder="Enter price">
                  <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Quantity</label>
                  <input type="number" class="form-control" wire:model="quantity" placeholder="Enter quantity" required>
                  <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" wire:click.prevent="AddProduct()" class="btn btn-success">Add Product</button>
            </div>
         </div>
      </form>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/product-create.blade.php ENDPATH**/ ?>