<div>
   <div wire:ignore.self class="modal fade" id="add-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Section Title</label>
                  <input type="text" wire:model.defer="title" class="form-control" required>
                  <?php $__errorArgs = ['title'];
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:loading.class="none">Close</button>
               <button type="button" class="btn btn-success" wire:click.prevent="store()" wire:loading.class="none">Add Section</button>
               <div wire:loading wire:target="store">
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" width="30%">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/sections.blade.php ENDPATH**/ ?>