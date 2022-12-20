<div class="row">
   <div class="col-md-12 mb-3">
      <a href="" class="btn btn-primary btn-small float-right" data-toggle="modal" data-target="#speakerModal"><i class="fas fa-plus-circle"></i> Add Speaker</a>
   </div>
   <?php $__currentLoopData = $speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-2">
         <div class="card border-0">
            <?php if($speaker->image): ?>
               <img class="card-img-top" src="<?php echo asset('storage/account/businesses/'.Wingu::business()->business_code.'/events/'.$speaker->image); ?>" alt="">
            <?php else: ?>
               <img class="card-img-top" src="<?php echo asset('assets/img/placeholder-image.png'); ?>" alt="">
            <?php endif; ?>
            <div class="card-body">
               <p class="card-text"><?php echo $speaker->name; ?></p>
               <?php
                  $getCode = json_encode($speaker->speaker_code);
               ?>
               <a href="" class="btn btn-sm btn-primary bt-xs" data-toggle="modal" data-target="#speakerModal" wire:click="edit(<?php echo e($getCode); ?>)"><i class="fa fa-edit"></i> Edit</a>
               <a href="" class="btn btn-sm btn-danger bt-xs" wire:click="confirm_delete(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#delete" ><i class="fa fa-trash-alt"></i> Delete</a>
            </div>
         </div>
      </div>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

   <!-- The Modal -->
   <div wire:ignore.self class="modal" id="speakerModal">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <?php if($this->editCode): ?>
                  <h4 class="modal-title">Edit Speakers Details</h4>
               <?php else: ?>
                  <h4 class="modal-title">Speakers Details</h4>
               <?php endif; ?>
               <button type="button" class="close" wire:click="close()">&times;</button>
            </div>
            <form enctype="multipart/form-data">
               <!-- Modal body -->
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6 mb-2">
                        <label for="">Speakers Name</label>
                        <input type="text" wire:model="name" class="form-control">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Designations</label>
                        <input type="text" wire:model="designation" class="form-control">
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Speakers Image</label>
                        <input type="file" wire:model="speaker_image" class="form-control">
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Bio</label>
                        <textarea type="text" wire:model="bio" class="form-control" rows="10"></textarea>
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Linkedin Link</label>
                        <input type="text" class="form-control" wire:model="linkedin">
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Twitter Link</label>
                        <input type="text" class="form-control" wire:model="twitter">
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Instagram Link</label>
                        <input type="text" class="form-control" wire:model="instagram">
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Youtube Link</label>
                        <input type="text" class="form-control" wire:model="youtube">
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Medium Link</label>
                        <input type="text" class="form-control" wire:model="medium">
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Facebook Link</label>
                        <input type="text" class="form-control" wire:model="facebook">
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  <?php if($this->editCode): ?>
                     <button type="submit" class="btn btn-primary" wire:click.prevent="update()"><i class="fas fa-save"></i> Update Information</button>
                  <?php else: ?>
                     <button type="submit" class="btn btn-danger" wire:click.prevent="add_speaker()"><i class="fas fa-save"></i> Save Information</button>
                  <?php endif; ?>
               </div>
            </form>
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
               <button type="button" class="btn btn-secondary" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/speakers.blade.php ENDPATH**/ ?>