<div class="row">
   <div class="col-md-7">
      <div class="row">
         <div class="col-md-12 mb-lg-3">
            <a href="" class="btn btn-warning btn-small float-right" data-toggle="modal" data-target="#addSession"><i class="fas fa-plus-circle"></i> Add Session</a>
         </div>
      </div>
      <div class="card">
         <div class="card-header">Sessions</div>
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th width="1%">#</th>
                  <th>Title</th>
                  <th width="16%">Action</th>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td>
                           <p class="font-bold"><?php echo $session->title; ?></p>
                           <p><i class="fal fa-calendar-day"></i> <?php echo date('F jS, Y', strtotime($schedule->start_date)); ?></p>
                           <p><i class="fal fa-history"></i> <?php echo date('g:i a', strtotime($session->start_time)); ?> to <?php echo date('g:i a', strtotime($session->end_time)); ?></p>
                           <hr>
                           <?php echo nl2br($session->details); ?>

                        </td>
                        <td>
                           <?php
                              $getcode = json_encode($session->schedule_code);
                           ?>
                           <a href="" class="btn btn-sm btn-primary" wire:click="edit(<?php echo e($getcode); ?>)" data-toggle="modal" data-target="#addSession"><i class="fa fa-edit"></i></a>
                           <a href="" class="btn btn-sm btn-danger" wire:click="confirm_delete(<?php echo e($getcode); ?>)" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-5">
      <div class="panel">
         <div class="panel-heading text-center"><h3>Schedule</h3></div>
         <div class="panel-body">
            <h4 class="font-bold"> <?php echo $schedule->title; ?></h4>
            <h5><i class="fal fa-calendar-day"></i> <?php echo date('F jS, Y', strtotime($schedule->start_date)); ?></h5>
            <h5><i class="fal fa-history"></i> <?php echo date('g:i a', strtotime($schedule->start_time)); ?> to <?php echo date('g:i a', strtotime($schedule->end_time)); ?></h5>
            <h5><i class="fal fa-map-marker-alt"></i> <?php echo $schedule->location; ?></h5>
            <hr>
            <?php echo nl2br($schedule->details); ?>

         </div>
      </div>
   </div>

   <!-- The Modal -->
   <div wire:ignore.self class="modal" id="addSession">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <?php if($this->editCode): ?>
                  <h4 class="modal-title">Edit Session Details</h4>
               <?php else: ?>
                  <h4 class="modal-title">Add Session Details</h4>
               <?php endif; ?>
               <button type="button" class="close" wire:click="close()">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label for="">Session Title</label>
                     <input type="text" class="form-control" wire:model.defer="title" required>
                     <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="">Start Time</label>
                     <input type="time" class="form-control" wire:model.defer="start_time" required>
                     <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="">End Time</label>
                     <input type="time" class="form-control" wire:model.defer="end_time" required>
                     <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="">Details</label>
                     <textarea type="text" class="form-control" wire:model.defer="details" rows="13" required></textarea>
                     <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
               </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
               <button type="button" class="btn btn-default" wire:click="close()">Close</button>
               <?php if($this->editCode): ?>
                  <button type="submit" class="btn btn-primary" wire:click="update()"><i class="fas fa-save"></i> Update Information</button>
               <?php else: ?>
                  <button type="submit" class="btn btn-success" wire:click="store()"><i class="fas fa-save"></i> Save Information</button>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/sessions.blade.php ENDPATH**/ ?>