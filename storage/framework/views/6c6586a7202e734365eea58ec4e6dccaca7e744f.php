<div class="row">
   <div class="col-md-12 mb-2">
      <a href="" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#sponsorModal"><i class="fas fa-plus-circle"></i> Add Sponsor</a>
   </div>
   <?php $__currentLoopData = $sponsors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-3 mb-2">
         <a href="#" class="widget-card rounded mb-20px" data-id="widget">
            <div class="widget-card-cover rounded" style="background-image: url(<?php echo asset('storage/account/businesses/'.Wingu::business()->business_code.'/events/'.$logo->file_name); ?>);height:150px"></div>
            <div class="widget-card-content"></div>
            <div class="widget-card-content bottom">
               <h4 class="text-white mt-5"><b><br></b></h4>
            </div>
            <h4 class="mt-4"><?php echo $logo->name; ?></h4>
            <a href="" class="btn btn-sm btn-primary" wire:click="edit(<?php echo e($logo->id); ?>)"  data-toggle="modal" data-target="#sponsorModal"><i class="fas fa-edit"></i> Edit</a>
            <a href="" class="btn btn-sm btn-danger" wire:click="confirm_delete(<?php echo e($logo->id); ?>)"  data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i> Delete</a>
         </a>
      </div>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

   <!-- Modal -->
   <div wire:ignore.self class="modal fade" id="sponsorModal" tabindex="-1" role="dialog" aria-labelledby="sponsorLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <?php if($this->editCode): ?>
                  <h5 class="modal-title" id="sponsorLabel">Edit Sponsor</h5>
               <?php else: ?>
                  <h5 class="modal-title" id="sponsorLabel">Add Sponsor</h5>
               <?php endif; ?>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" wire:model="sponsor_name" class="form-control" required>
                  <?php $__errorArgs = ['sponsor_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Logo <span class="font-bold text-warning">(Recommended size 315px x 150px)</span></label>
                  <input type="file" wire:model="logo" class="form-control" required>
                  <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" wire:click="close()">Close</button>
               <?php if($this->editCode): ?>
                  <button type="submit" class="btn btn-primary" wire:click="update()"><i class="fas fa-save"></i> Edit Information</button>
               <?php else: ?>
                  <button type="submit" class="btn btn-success" wire:click="save_sponsor()"><i class="fas fa-save"></i> Save Information</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         <div class="modal-content">
            <div class="modal-header flex-column">
               <div class="icon-box">
                  <i class="fal fa-times"></i>
               </div>
               <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
               <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/sponsors.blade.php ENDPATH**/ ?>