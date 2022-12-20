<div class="row">
   <div class="col-md-12 mb-lg-3">
      <a href="" class="btn btn-pink btn-small float-right" data-toggle="modal" data-target="#addSchedule"><i class="fas fa-plus-circle"></i> Add Schedule</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th width="1%">#</th>
                  <th>Title</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Location</th>
                  <th>Sessions</th>
                  <th width="16%">Action</th>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php
                        $data = Events::get_schedule_sessions($schedule->schedule_code)->getData();
                     ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo $schedule->title; ?></td>
                        <td><?php echo date('F jS, Y', strtotime($schedule->start_date)); ?></td>
                        <td><?php echo date('g:i a', strtotime($schedule->start_time)); ?> to <?php echo date('g:i a', strtotime($schedule->end_time)); ?></td>
                        <td><?php echo $schedule->location; ?></td>
                        <td><?php echo $data->count; ?></td>
                        <td>
                           <?php
                              $getCode = json_encode($schedule->schedule_code);
                           ?>
                           <a href="" class="btn btn-sm btn-primary" wire:click="edit(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#addSchedule">Edit</a>
                           <a href="<?php echo route('events.schedule.sessions',[$this->eventCode,$schedule->schedule_code]); ?>" class="btn btn-sm btn-warning">View</a>
                           <a href="" wire:click="confirm_delete(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#delete" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <!-- The Modal -->
   <div wire:ignore.self class="modal" id="addSchedule">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <?php if($this->editCode): ?>
                  <h4 class="modal-title">Edit Schedule Details</h4>
               <?php else: ?>
                  <h4 class="modal-title">Schedule Details</h4>
               <?php endif; ?>
               <button type="button" class="close" wire:click="close()">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label for="">Schedule Title</label>
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
                     <label for="">Date</label>
                     <input type="date" class="form-control" wire:model.defer="start_date" required>
                     <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-3 mb-3">
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
                  <div class="col-md-3 mb-3">
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
                     <label for="">Location</label>
                     <input type="text" class="form-control" wire:model.defer="location" required>
                     <?php $__errorArgs = ['location'];
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/schedules.blade.php ENDPATH**/ ?>