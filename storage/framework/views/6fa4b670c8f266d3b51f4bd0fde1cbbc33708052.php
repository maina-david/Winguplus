<div wire:ignore.self class="modal fade" id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Supplier</h5>
            <button type="button" class="close" wire:click="close()">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label for="">Supplier Name</label>
               <input type="text" wire:model="supplier_name" class="form-control">
               <?php $__errorArgs = ['supplier_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
               <label for="">Phone Number</label>
               <input type="number" wire:model="phone_number" class="form-control">
            </div>
            <div class="form-group">
               <label for="">Email</label>
               <input type="text" wire:model="email" class="form-control">
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-danger" wire:click="close()">Close</button>
            <button class="btn btn-success" wire:click.prevent="save_supplier()">Save changes</button>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/assets/assets/add-supplier.blade.php ENDPATH**/ ?>