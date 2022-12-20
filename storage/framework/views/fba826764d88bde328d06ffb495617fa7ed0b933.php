<div>
   <div class="row">
      <div class="col-md-12 mt-2">
         <div class="row">
            <div class="col-md-10">
               <h4 class="font-weight-bold"><i class="fal fa-sticky-note"></i> Notes</h4>
            </div>
            <div class="col-md-2">
               <button data-toggle="modal" data-target="#addNote" class="btn btn-block btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add Note</button>
            </div>
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-6">
                     <input type="text" class="form-control" wire:model="search" wire:model="search" placeholder="Search here .... ">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-3">
      <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <?php
            $getcode = json_encode($note->note_code);
         ?>
         <div class="col-md-4">
            <div class="panel <?php if($note->label): ?>text-white <?php else: ?> panel-default <?php endif; ?>">
               <div class="panel-heading <?php if($note->label): ?><?php echo e($note->label); ?>-700 <?php endif; ?>">
                  <h4 class="panel-title"><?php echo e($note->title); ?></h4>
                  <div class="panel-heading-btn">
                     <a href="<?php echo route('job.notes.edit',[$jobCode,$note->note_code]); ?>" class="badge badge-primary"><i class="fa fa-edit"></i> Edit</a>
                     <a href="#" wire:click="delete_note(<?php echo e($getcode); ?>)" class="badge badge-danger delete"><i class="fa fa-trash-alt"></i> Delete</a>
                  </div>
               </div>
               <div class="panel-body <?php if($note->label): ?><?php echo e($note->label); ?> <?php else: ?> <?php endif; ?>" style="min-height: 230px">
                  <p><?php echo e($note->brief); ?></p>
               </div>
            </div>
         </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </div>

   
   <div wire:ignore.self class="modal fade" id="addNote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog">
         <!--begin::Modal content-->
         <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header no-border">
               <h5 class="modal-title" id="exampleModalLongTitle">Create Note</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row mb-5">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" placeholder="Enter title" wire:model="title" />
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="form-group">
                        <label for="">Brief</label>
                        <textarea type="text" class="form-control" placeholder="Enter title" rows="4" wire:model="brief"/></textarea>
                     </div>
                     <div class="form-group">
                        <label for="">Label</label>
                        <select wire:model="label" class="form-control">
                           <option value="">Choose Label</option>
                           
                           <option value="bg-blue">Blue</option>
                           <option value="bg-orange">Orange</option>
                           <option value="bg-red">Red</option>
                           <option value="bg-cyan">Cyan / Aqua</option>
                           <option value="bg-gray">Gray</option>
                           <option value="bg-teal">Teal</option>
                        </select>
                     </div>
                     <button class="btn btn-success btn-sm mt-4" wire:click="create_note()"><i class="fal fa-save"></i> Create Note</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/notes.blade.php ENDPATH**/ ?>