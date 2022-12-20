<div>
   <div class="card">
      <div class="card-body">
         <div class="row mb-3">
            <div class="col-md-5">
               <input type="text" class="form-control" wire:model="search" placeholder="Search by customer name">
            </div>
            <div class="col-md-7">
               <?php if($event->type == 'Free'): ?>
                  <a href="#" class="btn btn-success float-right" data-toggle="modal" data-target="#checkInCustomer"><i class="fal fa-sign-in"></i> CheckIn</a>
               <?php endif; ?>
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Customer</th>
               <th>Phone Number</th>
               <th>Email</th>
               <th>Checked in at</th>
               <th>Checked in by</th>
               <th width="10%">Action</th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $checkIns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$checkIn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($checkIn->business_code ==  Auth::user()->business_code): ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo $checkIn->names; ?></td>
                        <td><?php echo $checkIn->phone_number; ?></td>
                        <td><?php echo $checkIn->email; ?></td>
                        <td><?php echo date('F jS, Y', strtotime($checkIn->created_at)); ?> @ <?php echo e(date('g:i A', strtotime($checkIn->created_at))); ?></td>
                        <td>
                           <?php if($checkIn->created_by): ?>
                              <?php
                                 $user = Wingu::user($checkIn->created_by)->getData();
                              ?>
                              <?php if($user->check == 1): ?>
                                 <b>Checked in by:</b> <span class="text-warning"><?php echo $user->user->name; ?></span><br>
                              <?php endif; ?>
                           <?php else: ?>
                              Self check in
                           <?php endif; ?>
                        </td>
                        <td>
                           <a href="" class="btn btn-danger btn-sm"  wire:click="confirm_delete(<?php echo e($checkIn->id); ?>)"  data-toggle="modal" data-target="#delete"><i class="far fa-trash-alt"></i> Delete</a>
                        </td>
                     </tr>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>

   <!-- check-in -->
   <div wire:ignore.self class="modal fade" id="checkInCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Check-in Customer</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Customer Name</label>
                  <input type="text" wire:model.defer="names" class="form-control" required>
                  <?php $__errorArgs = ['names'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Customer Email</label>
                  <input type="email" wire:model.defer="email" class="form-control">
                  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Phone number</label>
                  <input type="number" wire:model.defer="phone_number" class="form-control" required>
                  <?php $__errorArgs = ['phone_number'];
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
               <div wire:click="check_in" wire:loading.class="none">
                  <a href="" class="btn btn-secondary" wire:click="close()">Close</a>
                  <a href="" class="btn btn-success" wire:click.prevent="check_in()">Submit Information</a>
               </div>
               <div wire:loading wire:target="check_in">
                  <center> <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" alt="loader" width="25%"></center>
               </div>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/attendance-free.blade.php ENDPATH**/ ?>